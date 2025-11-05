<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\BusinessLoanScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\BusinessLoanApplication;
use App\Models\Calculator;
use App\Models\BusinessLoanCredit;
use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;


class BusinessLoan extends Controller
{
    
    public function index()
    {       
        //$schemes = BusinessLoanScheme::all();
        $schemes = BusinessLoanScheme::orderBy('id', 'desc')->paginate(10);
        return view("bussiness.schemes.index", compact('schemes'));
    } 
  
    public function create()
    {
        return view("bussiness.schemes.create");
    }
   
    public function store(Request $request)
    {
        Log::info('--- Business Loan Scheme Store Started ---', [
            'user_id' => auth()->id(),
            'input'   => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            try {
                // Basic validation
                $validated = $request->validate([
                    'scheme_name' => 'required|string|max:255',
                    'scheme_code' => 'required|string|max:50|unique:business_loan_schemes,scheme_code',
                    'charge_per_emi' => 'required|in:0,1',
                    'max_loan_amount' => 'required|numeric|min:1|max:200000',
                    'tenure' => 'required|integer|min:1',
                    'annual_interest_rate' => 'required|numeric|min:0',
                    'overdue_interest_rate' => 'required|numeric|min:0',
                    'is_active' => 'required|in:0,1',
                ], [
                    'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
                ]);

            // Merge other optional fields
            $data = array_merge($validated, $request->only([
                'processing_fee',
                'stamp_duty_charge',
                'insurance_fee',
                'gold_loan_setting',
                'penalty_charge',
                'fore_closer_charge',
                'credit_period',
                'sms_charge',
                'fuel_charge',
                'stationary_charge',
                'maintenance_charge',
                'collection',
            ]));

            } catch (ValidationException $e) {
                Log::warning('Validation Failed in BusinessLoanScheme', [
                    'errors' => $e->errors(),
                    'input'  => $request->all(),
                ]);

                return back()->withErrors($e->errors())->withInput();
            }

                // Store data in DB
                $scheme = BusinessLoanScheme::create($data);

                DB::commit();

                Log::info('Business Loan Scheme Created Successfully', [
                    'scheme_id' => $scheme->id,
                ]);

                return redirect()
                    ->route('bussiness.schemes.index')
                    ->with('success', 'Scheme created successfully!');

            } catch (Exception $e) {
                DB::rollBack();
                Log::error('Error while storing Business Loan Scheme', [
                    'message' => $e->getMessage(),
                ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }

    public function show($id)
    {
        $scheme = BusinessLoanScheme::findOrFail($id);
        return view('bussiness.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = BusinessLoanScheme::findOrFail($id);
        return view('bussiness.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = BusinessLoanScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('bussiness.schemes.index')
                        ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = BusinessLoanScheme::findOrFail($id);
        return view("bussiness.schemes.view", compact('scheme'));
    }


///////////////////////////////////////////////////////////////////////////////////////


    public function calculator()
    {
        $scheme = BusinessLoanScheme::all();
        return view("bussiness.calculator.index", compact('scheme'));
    }

    public function calculateResult(Request $request)
    {
        $isManual = $request->has('manual_interest_rate') && $request->manual_interest_rate != '';

        // ---------------------------------------------
        // STEP 1: BASIC VALIDATION & SETUP
        // ---------------------------------------------
        if ($isManual) {
            $request->validate([
                'loan_amount' => 'required|numeric|min:1',
                'max_tenure' => 'required|integer|min:1',
                'manual_interest_rate' => 'required|numeric|min:0',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly',
            ]);

            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->max_tenure;
            $annualRate = (float) $request->manual_interest_rate;
            $payout = $request->payout;
            $interestType = strtolower($request->interest_type ?? 'flat_interest');

            $processingFee = (float) ($request->manual_processing_fee ?? 0);
            $stampAmount = round($loan * ((float) ($request->manual_stamp ?? 0)) / 100, 2);
            $insuranceAmount = round($loan * ((float) ($request->manual_insurance ?? 0)) / 100, 2);
            $processing_incl_gst = round($processingFee + ($processingFee * 0.18), 2);
            $stamp_incl_gst = round($stampAmount + ($stampAmount * 0.18), 2);
            $total_emi_paid = 0;

            // Pick user-selected charge type
            $charge_per_emi_type = strtoupper($request->input('manual_charge_per_emi_type', 'ON PRINCIPAL'));

            // Optional safety check (if blank or invalid)
            if (!in_array($charge_per_emi_type, ['ON EMI', 'ON PRINCIPAL'])) {
                $charge_per_emi_type = 'ON PRINCIPAL';
            }

            $scheme = null;

        } 
        else 
        {
            $request->validate([
                'scheme_id' => 'required|exists:business_loan_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'tenure_months' => 'required|integer|min:1',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly',
            ]);

            $scheme = BusinessLoanScheme::findOrFail($request->scheme_id);
            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->tenure_months;
            $annualRate = (float) ($scheme->annual_interest_rate ?? 0);
            $payout = $request->payout;

            //$charge_per_emi_type = strtoupper(trim($scheme->charge_per_emi_type ?? 'ON PRINCIPAL'));
            // Determine charge_per_emi_type
            $charge_per_emi_type = is_numeric($scheme->charge_per_emi_type)
                ? ((int)$scheme->charge_per_emi_type === 1 ? 'ON EMI' : 'ON PRINCIPAL')
                : strtoupper(trim($scheme->charge_per_emi_type ?? 'ON PRINCIPAL'));

            // Override logic based on gold_loan_setting
            $setting = strtolower(trim($scheme->gold_loan_setting));

            switch ($setting) 
            {
                case 'flat_advanced_interest':
                case 'flat advance interest':
                    $interestType = 'flat_advanced_interest';
                    $charge_per_emi_type = 'ON PRINCIPAL'; // force override for flat_advanced_interest
                    break;

                case 'flat_interest':
                case 'flat interest':
                    $interestType = 'flat_interest';
                    $charge_per_emi_type = 'ON EMI'; // force override for flat_interest
                    break;

                case 'reducing_balance':
                case 'reducing emi':
                case 'reducing_emi':
                    $interestType = 'reducing_balance';
                    $charge_per_emi_type = 'ON EMI'; // force override for reducing_balance
                    break;

                default:
                    $interestType = 'flat_interest';
            }


            $processingFee = (float) ($scheme->processing_fee ?? 0);
            $processing_incl_gst = round($processingFee + ($processingFee * 0.18), 2); // 18% GST include
            
            $stampAmount = round($loan * ($scheme->stamp_duty_charge ?? 0) / 100, 2);
            $insuranceAmount = round($loan * ($scheme->insurance_fee ?? 0) / 100, 2);
            $stamp_incl_gst = round($stampAmount + ($stampAmount * 0.18), 2);
            $total_emi_paid = 0;

        }

        // ---------------------------------------------
        // STEP 2: DETERMINE EMI GAP (MONTHLY, QUARTERLY, ETC.)
        // ---------------------------------------------
        $monthsPerInstallment = match ($payout) {
            'quarterly' => 3,
            'half-yearly' => 6,
            'yearly' => 12,
            default => 1,
        };
        $installments = (int) ceil($tenureMonths / $monthsPerInstallment);

        // ---------------------------------------------
        // STEP 3: PREPARE TOTAL INTEREST & EMI FORMULA
        // ---------------------------------------------
        $monthlyRate = ($annualRate / 100) / 12;
        $totalInterest = 0;
        $emi = 0;
        $schedule = [];
        $totalCharges = 0;

        // ---------------------------------------------
        // STEP 4: EMI CALCULATION LOGIC
        // ---------------------------------------------
        if ($interestType === 'reducing_balance') {
            // Reducing balance EMI formula
            $emi = round(($loan * $monthlyRate * pow(1 + $monthlyRate, $installments)) / (pow(1 + $monthlyRate, $installments) - 1), 2);
            $outstanding = $loan;

            for ($i = 1; $i <= $installments; $i++) 
            {
                $emiDate = now()->copy()->addMonths($i);
                $dueDate = $emiDate->copy()->addDay();

                $interest = round($outstanding * $monthlyRate, 2);
                $principal = round($emi - $interest, 2);
                $outstanding -= $principal;
                $balance = max(round($outstanding, 2), 0);

                $charges = ($charge_per_emi_type === 'ON EMI')
                    ? 207
                    : round(($loan * (2.549 / 100)) / $installments, 2);

                $emiTotal = round($principal + $interest + $charges, 2);
                $totalInterest += $interest;
                $totalCharges += $charges;

                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $emiDate->format('d/m/Y'),
                    'due_date' => $dueDate->format('d/m/Y'),
                    'principal' => $principal,
                    'interest' => $interest,
                    'charges' => $charges,
                    'emi' => $emiTotal,
                    'balance' => $balance,
                ];
            }
            // Precision Fix for Last EMI
            if (!empty($schedule)) 
            {
                $lastIndex = count($schedule) - 1;
                $schedule[$lastIndex]['balance'] = 0.00;
                $totalPrincipalNow = array_sum(array_column($schedule, 'principal'));
                $diff = round($loan - $totalPrincipalNow, 2);
                $schedule[$lastIndex]['principal'] += $diff;
            }
        } 
        elseif ($interestType === 'flat_advanced_interest') 
        {
            // Flat Advanced Interest (Single EMI)
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
            $principal = $loan;
            $charges = ($charge_per_emi_type === 'ON EMI')
                ? 207
                : round(($loan * (2.549 / 100)), 2);

            $emiTotal = round($principal + $charges, 2);

            $emiDate = now()->copy()->addMonths($tenureMonths);
            $dueDate = $emiDate->copy()->addDay();

            $schedule = [[
                'no' => 1,
                'emi_date' => $emiDate->format('d/m/Y'),
                'due_date' => $dueDate->format('d/m/Y'),
                'principal' => $principal,
                'interest' => 0.00, // already deducted in disbursal
                'charges' => $charges,
                'emi' => $emiTotal,
                'balance' => 0.00,
            ]];

            // Totals
            $totalPrincipal = $principal;
            $totalInterest = 0.00;
            $totalCharges = $charges;
            $totalEmiSum = $emiTotal;
        }
        else 
        {
            // Flat Interest
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
            $principalPerMonth = round($loan / $installments, 2);
            $interestPerMonth = round($totalInterest / $installments, 2);
            $outstanding = $loan;

            for ($i = 1; $i <= $installments; $i++) 
            {
                $emiDate = now()->copy()->addMonths($i);
                $dueDate = $emiDate->copy()->addDay();

                $principal = $principalPerMonth;
                $interest = $interestPerMonth;
                $outstanding -= $principal;
                $balance = max(round($outstanding, 2), 0);

                $charges = ($charge_per_emi_type === 'ON EMI')
                    ? 207
                    : round(($loan * (2.549 / 100)) / $installments, 2);

                $emiTotal = round($principal + $interest + $charges, 2);
                $totalCharges += $charges;

                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $emiDate->format('d/m/Y'),
                    'due_date' => $dueDate->format('d/m/Y'),
                    'principal' => $principal,
                    'interest' => $interest,
                    'charges' => $charges,
                    'emi' => $emiTotal,
                    'balance' => $balance,
                ];
            }
            // Precision Fix for Last EMI
            if (!empty($schedule)) 
            {
                $lastIndex = count($schedule) - 1;
                $schedule[$lastIndex]['balance'] = 0.00;
                $totalPrincipalNow = array_sum(array_column($schedule, 'principal'));
                $diff = round($loan - $totalPrincipalNow, 2);
                $schedule[$lastIndex]['principal'] += $diff;
            }
        }

        // ---------------------------------------------
        // STEP 5: TOTALS
        // ---------------------------------------------
        //$totalEmiSum = array_sum(array_column($schedule, 'emi'));
        $totalPrincipal = array_sum(array_column($schedule, 'principal'));
        $totalInterest = array_sum(array_column($schedule, 'interest'));
        $totalCharges = array_sum(array_column($schedule, 'charges'));

        $totalEmiSum = round($totalPrincipal + $totalInterest + $totalCharges, 2);

        $total_emi_paid = round($totalEmiSum, 2);

        $grandTotalPayable = round($loan + $totalInterest + $totalCharges + $processingFee + $stampAmount + $insuranceAmount, 2);

        $disbursedAmount = ($interestType === 'flat_advanced_interest')
            ? $loan - $totalInterest
            : $loan;

        // ---------------------------------------------
        // STEP 6: RETURN VIEW
        // ---------------------------------------------
        return view('bussiness.calculator.result', [
        'scheme' => $scheme,
        'is_manual' => $isManual,
        'loan' => $loan,
        'tenure_months' => $tenureMonths,
        'payout' => $payout,
        'installments' => $installments,
        'interest_type' => ucfirst(str_replace('_', ' ', $interestType)),
        'annual_rate' => $annualRate,
        'charge_per_emi' => $charge_per_emi_type,
        'disburse_date' => now(),
        'processing_fee' => $processingFee,
        'processing_incl_gst' => $processing_incl_gst,
        'stamp_amount' => $stampAmount,
        'stamp_incl_gst' => $stamp_incl_gst,
        'insurance_amount' => $insuranceAmount,
        'schedule' => $schedule,
        'total_interest' => round($totalInterest, 2),
        'total_principal' => round($loan, 2),
        'total_charges' => round($totalCharges, 2),
        'total_emi_sum' => round($totalEmiSum, 2),
        'total_emi_paid' => $total_emi_paid,
        'grand_total_payable' => $grandTotalPayable,
        'disbursed_amount' => $disbursedAmount,
    ]);

    }


/////////////////////////////////////////////////////////////////////////////////////////


    public function appindex()
    {
        // loan applications fetch with pagination
        $applications = BusinessLoanApplication::with(['creditScores'])
            ->latest()
            ->paginate(10); // 10 records

        return view("bussiness.applications.index", compact('applications'));
    }

    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no','general_branch')->get();
        $branch = Branch::all();
        $scheme = BusinessLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("bussiness.applications.create", compact('members','branch','scheme','banks'));
    }
   
    public function storeLoanApplication(Request $request)
    {
        Log::info('--- Business Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        // Validation (Security fields removed)
        try {
            $validated = $request->validate([
                'application_date'   => 'required|date',
                'member_id'          => 'required|exists:members,id',
                'branch_id'          => 'required|exists:branches,id',
                'scheme_id'          => 'required|exists:loan_against_schemes,id',
                'loan_amount'        => 'required|numeric|min:1',
                'purpose_of_loan'    => 'required|string|max:255',
                'tenure_type'        => 'required|string',
                'net_loan_amount'    => 'required|numeric|min:1',
                'insurance_amount'   => 'required|numeric|min:0',
                'credit_period'      => 'required|numeric|min:1',
                'emi_collection'     => 'required|string',
                'tenure_value'       => 'required|numeric|min:1',
                'charge_per_emi' => 'required|in:0,1',
            ], [
            'application_date.required' => 'Please select the application date.',
            'member_id.required'        => 'Please select a member.',
            'branch_id.required'        => 'Please select a branch.',
            'scheme_id.required'        => 'Please select a loan scheme.',
            'loan_amount.required'      => 'Please enter the loan amount.',
            'loan_amount.numeric'       => 'Loan amount must be a number.',
            'tenure_value.numeric'      => 'Tenure value must be a number.',
            'purpose_of_loan.required'  => 'Please enter the purpose of the loan.',
            'tenure_type.required'      => 'Please select the tenure type.',
            'emi_collection.required'   => 'Please select the EMI collection.',
            'net_loan_amount.required'  => 'Please enter Net Loan Amount.',
            'insurance_amount.required' => 'Please enter Insurance Amount.',
            'credit_period.required'    => 'Please enter Credit Period.',
        ]);

         // Validate CIBIL scores (each must be 3 digits between 300–900)
            if ($request->has('cibil_score')) {
                foreach ($request->cibil_score as $index => $score) {
                    if (!empty($score)) {
                        if (!preg_match('/^\d{3}$/', $score) || $score < 300 || $score > 900) {
                            return back()
                                ->withInput()
                                ->with('error', "CIBIL Score at row " . ($index + 1) . " must be a 3-digit number between 300 and 900.");
                        }
                    }
                }
            }

            Log::info('Validation passed successfully.');
        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
            ]);

            return back()->withErrors($e->errors())->withInput();
        }

        try {
            // Create record (Security fields removed, null sent instead)
            $loanApplication = BusinessLoanApplication::create([
                'application_date'              => $request->application_date,
                'member_id'                     => $request->member_id,
                'co_applicant_1_id'             => $request->co_applicant_1_id,
                'co_applicant_2_id'             => $request->co_applicant_2_id,
                'branch_id'                     => $request->branch_id,
                'advisor_id'                    => $request->advisor_id,
                'guarantor_1_id'                => $request->guarantor_1_id,
                'guarantor_2_id'                => $request->guarantor_2_id,
                'guarantor_3_id'                => $request->guarantor_3_id,
                'guarantor_4_id'                => $request->guarantor_4_id,
                'scheme_id'                     => $request->scheme_id,
                'tenure_type'                   => $request->tenure_type,
                'tenure_value'                  => $request->tenure_value,
                'emi_collection'                => $request->emi_collection,
                'credit_period'                 => $request->credit_period,
                'loan_amount'                   => $request->loan_amount,
                'insurance_amount'              => $request->insurance_amount,
                'net_loan_amount'               => $request->net_loan_amount,
                'purpose_of_loan'               => $request->purpose_of_loan,
                'charge_per_emi'                => $request->charge_per_emi,
                'processing_fee_value'          => $request->processing_fee_value ?? 0,
                'processing_fee_gst'            => $request->processing_fee_gst,
                'processing_fee_sgst'           => $request->processing_fee_sgst,
                'processing_fee_cgst'           => $request->processing_fee_cgst,
                'processing_fee_igst'           => $request->processing_fee_igst,
                'processing_fee_total'          => $request->processing_fee_total,
                'fee_mode'                      => $request->fee_mode,
                'bank_id'                       => $request->bank_id,
                'cheque_no'                     => $request->cheque_no,
                'cheque_date'                   => $request->cheque_date,
                'transfer_date'                 => $request->transfer_date,
                'utr_no'                        => $request->utr_no,
                'transfer_mode'                 => $request->transfer_mode,
                'credited' => ($request->credited === 'yes' || $request->credited == 1) ? 1 : 0,
                'collect_principal_as_emi'      => $request->collect_principal_as_emi ?? 0,
                'collect_advance_processing_fee'=> $request->collect_advance_processing_fee ?? 0,
                'max_loan_amount'               => $request->max_loan_amount ?? 0,
                'maximum_approvable_amount'     => $request->maximum_approvable_amount ?? 0,
                'approved_loan_amount'          => $request->approved_loan_amount ?? 0,
                // Security fields set to null (since removed from form)
                'security_type'                 => null,
                'security_amount'               => null,
            ]);

            Log::info('Business Loan Application created successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            // ==== Credit Score Details Save (Dynamic Rows) ====
            if ($request->has('cibil_type')) {
                Log::info('CIBIL block triggered', [
                    'cibil_type_count' => count($request->cibil_type),
                ]);

                foreach ($request->cibil_type as $index => $type) {
                    try {
                        $filePath = null;
                        if ($request->hasFile('report_file') && isset($request->file('report_file')[$index])) {
                            $filePath = $request->file('report_file')[$index]->store('cibil_reports', 'public');
                        }

                        $loanApplication->creditScores()->create([
                            'cibil_type'       => $type,
                            'cibil_score'      => $request->cibil_score[$index] ?? null,
                            'report_date'      => isset($request->report_date[$index])
                                ? Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d')
                                : null,
                            'report_file_path' => $filePath,
                        ]);
                    } catch (Exception $e) {
                        Log::error('Error while saving credit score entry', [
                            'index' => $index,
                            'error_message' => $e->getMessage(),
                        ]);
                    }
                }
            } else {
                Log::warning('CIBIL block skipped — no cibil_type found in request.');
            }

            return redirect()->route('bussiness.applications.index')
                ->with('success', 'Business Loan Application + Credit Scores saved successfully!');
        } catch (Exception $e) {
            Log::error('❌ Error while storing Business Loan Application', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while saving loan application.');
        }
    }

    public function getMemberInfo($id)
    {
        $member = Member::select('id', 'member_info_first_name', 'member_info_mobile_no')
            ->find($id);

        if ($member) {
            return response()->json([
                'status' => true,
                'data' => $member
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Member not found'
            ]);
        }
    }

    public function appview($id)
    {
        $application = BusinessLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme'   // <-- add scheme here
        ])->findOrFail($id);

        return view("bussiness.applications.view", compact('application'));
    }

    public function appedit($id)
    {
        $application = BusinessLoanApplication::with([
            'member',
            'scheme',
            'branch',
            'creditScores', // relation
            'guarantor1',
            'guarantor2',
            'guarantor3',
            'guarantor4',
        ])->findOrFail($id);

        // Dropdowns
        $members = Member::all();
        $scheme = BusinessLoanScheme::all();
        $branch = Branch::all();
        $banks = Bank::pluck('name', 'id');

        return view('bussiness.applications.create', compact(
            'application', 'members', 'scheme', 'branch', 'banks'
        ));
    }
   
    public function appupdate(Request $request, $id)
    {
        Log::info('--- Loan Application Update Started ---', [
            'user_id' => auth()->id(),
            'application_id' => $id,
            'input_data' => $request->all(),
        ]);

        DB::beginTransaction();

        try {
            // Step 1: Validation
            $request->validate([
                'application_date' => 'required|date',
                'member_id'        => 'required|exists:members,id',
                'scheme_id'        => 'required|exists:gold_loan_schemes,id',
                'loan_amount'      => 'required|numeric',
            ]);

            // Step 2: Fetch record
            $application = BusinessLoanApplication::find($id);
            if (!$application) {
                Log::warning('Loan Application not found', ['application_id' => $id]);
                return back()->with('error', 'Loan application not found!');
            }

            // Step 3: Log old data before update
            Log::info('Existing Loan Application Data Before Update', [
                'old_data' => $application->toArray(),
            ]);

            // Step 4: Update main table
            Log::info('Attempting to update Loan Application...', [
                'update_data' => $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']),
            ]);

            // $updated = $application->update(
            //     $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file'])
            // );
            // Convert 'credited' value ('yes'/'no') to integer (1/0)
            $inputData = $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']);

            if (isset($inputData['credited'])) {
                $inputData['credited'] = ($inputData['credited'] === 'yes' || $inputData['credited'] === '1') ? 1 : 0;
            }

            $updated = $application->update($inputData);


            if (!$updated) {
                Log::error('Loan Application update failed', [
                    'application_id' => $id,
                ]);
                throw new Exception('Loan application update failed.');
            }

            // Step 5: Delete old CIBIL scores
            Log::info('Deleting old CIBIL entries...', [
                'application_id' => $id,
            ]);
            $application->creditScores()->delete();

            // Step 6: Insert new CIBIL scores
            $cibilTypes  = $request->input('cibil_type', []);
            $cibilScores = $request->input('cibil_score', []);
            $reportDates = $request->input('report_date', []);
            $reportFiles = $request->file('report_file', []);

            Log::info('CIBIL Data Received', [
                'count' => count($cibilTypes),
                'cibilTypes' => $cibilTypes,
            ]);

            foreach ($cibilTypes as $index => $type) {
                try {
                    $filePath = null;
                    if (isset($reportFiles[$index])) {
                        $filePath = $reportFiles[$index]->store('uploads/cibil_reports', 'public');
                    }

                    // Convert date DD/MM/YYYY → YYYY-MM-DD
                    $rawDate = $reportDates[$index] ?? null;
                    $formattedDate = null;
                    if (!empty($rawDate)) {
                        $dateObj = \DateTime::createFromFormat('d/m/Y', $rawDate);
                        if ($dateObj) {
                            $formattedDate = $dateObj->format('Y-m-d');
                        }
                    }

                    $application->creditScores()->create([
                        'cibil_type'   => $type,
                        'cibil_score'  => $cibilScores[$index] ?? null,
                        'report_date'  => $formattedDate,
                        'report_file'  => $filePath,
                    ]);

                    Log::info('CIBIL Entry Added', [
                        'application_id' => $id,
                        'index' => $index,
                        'type' => $type,
                    ]);
                } catch (Exception $ex) {
                    Log::error('❌ Error while saving individual CIBIL entry', [
                        'index' => $index,
                        'message' => $ex->getMessage(),
                    ]);
                }
            }

            //  Step 7: Commit transaction
            DB::commit();

            Log::info('Loan Application Updated Successfully', [
                'application_id' => $application->id,
            ]);

            return redirect()
                ->route('bussiness.applications.view', $application->id)
                ->with('success', 'Application and credit scores updated successfully!');

        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Loan Application Update Failed', [
                'application_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong while updating the application.');
        }
    }


//////////////////////////////////////////////////////////////////////////////////


    public function emiChart($id)
    {
        $application = BusinessLoanApplication::with(['scheme', 'member', 'branch'])->findOrFail($id);
        $scheme = $application->scheme;

        // ------------------------------------
    // STEP 1: Identify Interest Type & Charge Type
    // ------------------------------------
    $setting = strtolower(trim($scheme->gold_loan_setting ?? 'flat_interest'));
    $chargeTypeValue = intval($scheme->charge_per_emi ?? 0); // 1 = ON EMI, 0 = ON PRINCIPAL

    // by default, jo DB me hai wahi rakho
    $chargePerEmiType = ($chargeTypeValue === 1) ? 'ON EMI' : 'ON PRINCIPAL';

    switch ($setting) {
        case 'flat_advanced_interest':
            $interestType = 'Flat Advanced Interest';
            // flat advanced me charge always on principal hota hai
            $chargePerEmiType = 'ON PRINCIPAL';
            break;

        case 'reducing_balance':
        case 'reducing emi':
        case 'reducing_emi':
            $interestType = 'Reducing EMI';
            // reducing case me charge always on EMI hota hai
            $chargePerEmiType = 'ON EMI';
            break;

        default:
            $interestType = 'Flat EMI';
            // keep DB-based charge type
            break;
    }


        // ------------------------------------
        // STEP 2: Base Inputs
        // ------------------------------------
        $loanAmount = floatval($application->approved_loan_amount ?? 0);
        $tenure = intval($application->tenure_value ?? $scheme->no_of_emi ?? 1);
        if ($tenure <= 0) $tenure = 1;

        $disburseDate = $application->disbursal_date
            ? Carbon::parse($application->disbursal_date)
            : Carbon::now();

        // ------------------------------------
        // STEP 3: Charges (Total Only)
        // ------------------------------------
        $processingFeeInc = floatval($application->processing_fee ?? $scheme->processing_fee ?? 0);
        $stampDutyInc     = floatval($application->stamp_duty ?? $scheme->stamp_duty_charge ?? 0);
        $insuranceInc     = floatval($application->insurance_fee ?? $scheme->insurance_fee ?? 0);
        $fitnessInc       = floatval($application->fitness_fee ?? $scheme->maintenance_charge ?? 0);

        // Keep total, don't divide yet
        $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;

        // ------------------------------------
        // STEP 4: Interest Rate / Frequency
        // ------------------------------------
        $annualRate = floatval($scheme->annual_interest_rate ?? 0);
        $collection = strtolower($application->emi_collection ?? 'monthly');

        switch ($collection) {
            case 'daily':
                $periodIncrement = 'addDay';
                $periodsPerYear = 365;
                $periodName = 'Daily';
                break;
            case 'weekly':
                $periodIncrement = 'addWeek';
                $periodsPerYear = 52;
                $periodName = 'Weekly';
                break;
            default:
                $periodIncrement = 'addMonth';
                $periodsPerYear = 12;
                $periodName = 'Monthly';
                break;
        }

        $periodicRate = ($annualRate / 100) / $periodsPerYear;
        $principalPerEmi = round($loanAmount / $tenure, 2);

        // ------------------------------------
        // STEP 5: EMI Schedule Calculation
        // ------------------------------------
        $schedule = [];
        $remainingPrincipal = $loanAmount;

        // ---------- CASE: REDUCING EMI ----------
        if ($interestType === 'Reducing EMI') {
            $r = $periodicRate;
            $n = $tenure;
            $P = $loanAmount;

            // EMI formula
            $emiAmount = ($r > 0)
                ? round(($P * $r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1), 2)
                : round($P / $n, 2);

            for ($i = 1; $i <= $tenure; $i++) {
                $emiDate = $disburseDate->copy()->{$periodIncrement}($i);
                $dueDate = $emiDate->copy()->addDay();

                $interestForPeriod = round($remainingPrincipal * $r, 2);
                $principalThis = round($emiAmount - $interestForPeriod, 2);

                // Correct Charges Per EMI Logic
                if ($chargePerEmiType === 'ON EMI') {
                    // Fixed per EMI
                    $chargesPerEmiFinal = round($totalChargesInc / $tenure, 2);
                } else {
                    // Proportional to principal part
                    $chargesPerEmiFinal = round(($principalThis / $loanAmount) * $totalChargesInc, 2);
                }

                $emiTotal = round($emiAmount + $chargesPerEmiFinal, 2);
                $remainingPrincipal = round($remainingPrincipal - $principalThis, 2);

                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $emiDate->format('d/m/Y'),
                    'due_date' => $dueDate->format('d/m/Y'),
                    'principal' => number_format($principalThis, 2, '.', ''),
                    'interest' => number_format($interestForPeriod, 2, '.', ''),
                    'charges_per_emi' => number_format($chargesPerEmiFinal, 2, '.', ''),
                    'emi' => number_format($emiTotal, 2, '.', ''),
                    'bal_principal' => number_format($remainingPrincipal, 2, '.', ''),
                ];
            }
        }

        // ---------- CASE: FLAT EMI ----------
        else {
            for ($i = 1; $i <= $tenure; $i++) {
                $emiDate = $disburseDate->copy()->{$periodIncrement}($i);
                $dueDate = $emiDate->copy()->addDay();

                $interestForPeriod = round($loanAmount * $periodicRate, 2);
                $principalThis = ($i == $tenure)
                    ? round($remainingPrincipal, 2)
                    : $principalPerEmi;

                $chargesPerEmiFinal = round($totalChargesInc / $tenure, 2);
                $emiTotal = round($principalThis + $interestForPeriod + $chargesPerEmiFinal, 2);
                $remainingPrincipal = round($remainingPrincipal - $principalThis, 2);

                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $emiDate->format('d/m/Y'),
                    'due_date' => $dueDate->format('d/m/Y'),
                    'principal' => number_format($principalThis, 2, '.', ''),
                    'interest' => number_format($interestForPeriod, 2, '.', ''),
                    'charges_per_emi' => number_format($chargesPerEmiFinal, 2, '.', ''),
                    'emi' => number_format($emiTotal, 2, '.', ''),
                    'bal_principal' => number_format($remainingPrincipal, 2, '.', ''),
                ];
            }
        }

        // ------------------------------------
        // STEP 6: Totals
        // ------------------------------------
        $totalPrincipal = array_sum(array_map(fn($r) => floatval($r['principal']), $schedule));
        $totalInterest  = array_sum(array_map(fn($r) => floatval($r['interest']), $schedule));
        $totalCharges   = array_sum(array_map(fn($r) => floatval($r['charges_per_emi']), $schedule));
        $totalEmi       = array_sum(array_map(fn($r) => floatval($r['emi']), $schedule));

        // ------------------------------------
        // STEP 7: Return View
        // ------------------------------------
        return view('bussiness.applications.view-buttons.show-emi-chart', compact(
            'application',
            'loanAmount',
            'disburseDate',
            'processingFeeInc',
            'stampDutyInc',
            'insuranceInc',
            'fitnessInc',
            'tenure',
            'periodName',
            'schedule',
            'totalPrincipal',
            'totalInterest',
            'totalCharges',
            'totalEmi',
            'chargePerEmiType',
            'interestType',
            'annualRate',
            'scheme'
        ));
    }


    public function loanagainst_process_fee($id)
    {
        $application = LoanAgainstApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view("loanagainst.applications.view-buttons.col_process_fee", compact('application','banks'));
    }

    public function loanagainststoreProcessFee(Request $request, $id)
    {
        $request->validate([
            'total' => 'required|numeric|min:0',
            'fee_mode' => 'required|in:cash,cheque,online'
        ]);

        $data = $request->all();
        $data['application_id'] = $id;

        if ($request->fee_mode == 'cheque') {
            $request->validate([
                'bank_id' => 'required',
                'cheque_no' => 'required',
                'cheque_date' => 'required|date',
            ]);
        }

        if ($request->fee_mode == 'online') {
            $request->validate([
                'transfer_date' => 'required|date',
                'utr_no' => 'required',
                'transfer_mode' => 'required|in:imps,vpa,neft_rtgs',
                'credited' => 'required|in:yes,no',
            ]);
        }

        LoanagainstProcessingFee::create($data);

        return redirect()->route('loanagainst.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }


    
}
