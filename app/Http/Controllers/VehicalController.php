<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\VehicalScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\VehicalApplication;
use App\Models\Calculator;
use App\Models\VehicalProcessingFee;
use App\Models\VehicalCreditScore;
use Carbon\Carbon;
use App\Exports\LinePropertExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\VehicleDistributor;


class VehicalController extends Controller
{
    
    public function index()
    {       
        $schemes = VehicalScheme::orderBy('id', 'desc')->paginate(10);
        return view("vehical.schemes.index", compact('schemes'));
    } 
  
    public function create()
    {
        return view("vehical.schemes.create");
    }

    public function store(Request $request)
    {
        Log::info('vehical Scheme Store Started', [
            'input' => $request->all(),
            'user_id' => Auth::id(),
        ]);

        $validated = $request->validate([
            'scheme_name' => 'required|string|max:255',
            'tenure' => 'required|string|max:255',
            'scheme_code' => 'required|string|max:50|unique:vehical_schemes,scheme_code',
            'max_loan_limit' => 'required|numeric|min:1',
            'max_loan_amount' => 'required|numeric|min:1|max:200000',
            'annual_interest_rate' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1',

            // optional numeric fields
            //'overdue_interest_rate' => 'nullable|numeric',
            'overdue_type' => 'nullable|string|max:50',
            'overdue_interest_rate' => 'required_if:overdue_type,TYPE_1,TYPE_2|numeric|min:0',
            'penalty_charge' => 'nullable|numeric',
            'processing_fee' => 'nullable|numeric',
            'stamp_duty_charge' => 'nullable|numeric',
            'insurance_fee' => 'nullable|numeric',
            'fore_closer_charge' => 'nullable|numeric',
            'credit_period' => 'nullable|integer',
            'gold_loan_setting' => 'nullable|string',
            'sms_charge' => 'nullable|integer',
            'fuel_charge' => 'nullable|integer',
            'stationary_charge' => 'nullable|integer',
            'maintenance_charge' => 'nullable|integer',
            'collection' => 'nullable|integer',
        ], [
            'scheme_name.required' => 'Please enter scheme name.',
            'scheme_code.required' => 'Scheme code is required.',
            'max_loan_limit.required' => 'Max loan limit is required.',
            'tenure.required' => 'Tenure type is required.',
            'annual_interest_rate.required' => 'Annual interest rate is required.',
            'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
        ]);

        try {
            DB::beginTransaction();

            // Convert null numeric fields to 0 to avoid integrity constraint error
            $numericDefaults = [
                'overdue_interest_rate', 'penalty_charge', 'processing_fee',
                'stamp_duty_charge', 'insurance_fee', 'fore_closer_charge',
                'credit_period', 'sms_charge', 'fuel_charge', 'stationary_charge',
                'maintenance_charge', 'collection'
            ];

            foreach ($numericDefaults as $field) {
                if (!isset($validated[$field]) || $validated[$field] === null) {
                    $validated[$field] = 0;
                }
            }

            // Save
            $scheme = VehicalScheme::create($validated);

            DB::commit();

            Log::info('vehical Scheme Created Successfully', [
                'scheme_id' => $scheme->id,
            ]);

            return redirect()
                ->route('vehical.schemes.index')
                ->with('success', 'Scheme created successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error While Storing Vehical Scheme', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }

    public function show($id)
    {
        $scheme = VehicalScheme::findOrFail($id);
        return view('vehical.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = VehicalScheme::findOrFail($id);
        return view('vehical.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = VehicalScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('vehical.schemes.index')
                        ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = VehicalScheme::findOrFail($id);
        return view("vehical.schemes.view", compact('scheme'));
    }


//////////////////////////////////////////////////////////////////////////////////////


    public function calculator()
    {
        $scheme = VehicalScheme::all();
        return view("vehical.calculator.index", compact('scheme'));
    }

    public function calculateResult(Request $request)
    {
        $isManual = $request->has('manual_interest_rate') && $request->manual_interest_rate != '';

        if ($isManual) {
            //  Manual Entry Mode
            $request->validate([
                'loan_amount' => 'required|numeric|min:1',
                'max_tenure' => 'required|integer|min:1',
                'manual_interest_rate' => 'required|numeric|min:0',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly',
            ]);

            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->max_tenure;
            $payout = $request->payout;
           // $interestType = 'flat';
           $interestType = $request->interest_type ?? 'flat_emi';

            $annualRate = (float) $request->manual_interest_rate;

            $processingFee = (float) ($request->manual_processing_fee ?? 0);
            $stampAmount = round($loan * ((float) ($request->manual_stamp ?? 0)) / 100, 2);
            $insuranceAmount = round($loan * ((float) ($request->manual_insurance ?? 0)) / 100, 2);
            $scheme = null;
        } 
        else 
        {
            //  Scheme Mode
            $request->validate([
                'scheme_id' => 'required|exists:vehical_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'tenure_months' => 'required|integer|min:1',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly',
            ]);

            $scheme = VehicalScheme::findOrFail($request->scheme_id);

            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->tenure_months;
            $payout = $request->payout;
            //$interestType = 'flat';
            //$interestType = strtolower($scheme->gold_loan_setting) === 'no_emi' ? 'no_emi' : 'flat';
            $setting = strtolower($scheme->gold_loan_setting);

            switch ($setting) {
                case 'flat_advanced_interest':
                    $interestType = 'Flat Advanced Interest';
                    break;
                case 'flat_advance_interest':
                    $interestType = 'Flat Advance Interest';
                    break;
                case 'flat_interest':
                    $interestType = 'Flat Interest';
                    break;
                case 'reducing_balance':
                    $interestType = 'Reducing Balance';
                    break;
                case 'no_emi':
                    $interestType = 'No EMI';
                    break;
                default:
                    $interestType = ucfirst($setting); // fallback
            }

            $annualRate = (float) ($request->annual_interest_rate ?? $scheme->annual_interest_rate ?? 0);

            $processingFee = (float) ($scheme->processing_fee ?? 0);
            $stampAmount = round($loan * ($scheme->stamp_duty_charge ?? 0) / 100, 2);
            $insuranceAmount = round($loan * ($scheme->insurance_fee ?? 0) / 100, 2);
        }

        //  Determine months per EMI payout
        switch ($payout) {
            case 'monthly':
                $monthsPerInstallment = 1;
                break;
            case 'quarterly':
                $monthsPerInstallment = 3;
                break;
            case 'half-yearly':
                $monthsPerInstallment = 6;
                break;
            case 'yearly':
                $monthsPerInstallment = 12;
                break;
            default:
                $monthsPerInstallment = 1;
        }

        //  Total Installments & Interest
        $installments = (int) ceil($tenureMonths / $monthsPerInstallment);
        $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
        $emi = round(($loan + $totalInterest) / $installments, 2);

        // EMI Schedule Generation
        $lowerType = strtolower($interestType);

        if (in_array($lowerType, ['reducing_emi', 'reducing balance', 'reducing_balance'])) 
        {
            // Reducing Balance EMI (Declining interest each month)
            $monthlyRate = ($annualRate / 100) / 12;
            $emi = round(($loan * $monthlyRate * pow(1 + $monthlyRate, $installments)) / (pow(1 + $monthlyRate, $installments) - 1), 2);

            // recompute total interest dynamically
            $balance = $loan;
            $totalInterest = 0;
            for ($i = 1; $i <= $installments; $i++) {
                $interestForMonth = $balance * $monthlyRate;
                $principalPaid = $emi - $interestForMonth;
                $balance -= $principalPaid;
                $totalInterest += $interestForMonth;
            }
            $totalInterest = round($totalInterest, 2);
        }
        elseif (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) 
        {
            // Flat Advanced Interest: interest deducted upfront, not added to EMIs
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
            $emi = round($loan / $installments, 2); // Only principal EMIs
        }
        else 
        {
            // Flat EMI
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12.0), 2);
            $emi = round(($loan + $totalInterest) / $installments, 2);
        }

        $outstanding = $loan;
        $startDate = now();

        for ($i = 1; $i <= $installments; $i++) 
        {

            $emiDate = $startDate->copy()->addMonths($monthsPerInstallment * $i);
            //$dueDate = $emiDate->copy()->addDays(10);
            $dueDate = $emiDate->copy()->addDay();

            if ($interestType === 'No EMI') 
            {
                // No EMI Logic
                if ($i == $installments) {
                    $principal = round($loan, 2);
                } else {
                    $principal = 0;
                }

                $interest = null;
                $charges = null;
                $emiTotal = null;
                $balance = null;

            } 
            else 
            {
                    // Normal EMI Logic
                if (in_array($lowerType, ['reducing_emi', 'reducing balance', 'reducing_balance'])) 
                {
                    $monthlyRate = ($annualRate / 100) / 12;

                    // Define fixed or percentage-based charge per EMI
                    $chargePerEmi = 2.00; // You can later make this dynamic from scheme if needed

                    if ($i < $installments) {
                        // Normal months
                        $interest = round($outstanding * $monthlyRate, 2);
                        $principal = round($emi - $interest, 2);
                        $charges = round($chargePerEmi, 2);
                        $emiTotal = round($principal + $interest + $charges, 2);

                        $outstanding -= $principal;
                        $balance = max(round($outstanding, 2), 0);
                    } 
                    else 
                    {
                        // Last installment adjustment (remove rounding residue)
                        $interest = round($outstanding * $monthlyRate, 2);
                        $principal = round($outstanding, 2);
                        $charges = round($chargePerEmi, 2);
                        $emiTotal = round($principal + $interest + $charges, 2);

                        $outstanding = 0;
                        $balance = 0;
                    }
                }
                else 
                {
                    // Flat / Fixed EMI logic
                    if ($i == $installments) {
                        $principal = round($outstanding, 2);
                    } else {
                        $principal = round($loan / $installments, 2);
                    }

                    $interest = round($totalInterest / $installments, 2);
                    $charges = 0;
                    $emiTotal = round($principal + $interest, 2);

                    $outstanding -= $principal;
                    $balance = max(round($outstanding, 2), 0);
                }
            }


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


        //  Grand Total (Loan + Interest + Charges)
        //  Grand Total (Loan + Interest + Charges)
        if (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) 
        {
            // Interest deducted upfront, EMIs = only principal, total payable = loan amount
            $totalInterest = 0;
            $totalEmiPaid = $loan;
            $grandTotalPayable = round($loan + $processingFee + $stampAmount + $insuranceAmount, 2);
        } else {
            // Flat / Reducing EMI = normal interest added
            $totalEmiPaid = $loan + $totalInterest;
            $grandTotalPayable = round($loan + $totalInterest + $processingFee + $stampAmount + $insuranceAmount, 2);
        }


        $disbursedAmount = $loan;
        if (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) {
            $disbursedAmount = $loan - $totalInterest;
        }

        // Calculate totals for table footer
        $total_principal = array_sum(array_column($schedule, 'principal'));
        $total_interest  = array_sum(array_column($schedule, 'interest'));
        $total_charges   = array_sum(array_column($schedule, 'charges'));
        $total_emi_paid  = array_sum(array_column($schedule, 'emi'));


        // If Flat Advanced Interest, show only one EMI row
        if (in_array($lowerType, ['flat advanced interest', 'flat advance interest', 'flat_advanced_interest'])) {
            $schedule = [];

            $emiDate = now()->addMonth(); // or your logic for date
            $dueDate = $emiDate->copy()->addDay();

            $schedule[] = [
                'no' => 1,
                'emi_date' => $emiDate->format('d/m/Y'),
                'due_date' => $dueDate->format('d/m/Y'),
                'principal' => round($loan, 2),
                'interest' => 0.0,
                'charges' => 0.0,
                'emi' => round($loan, 2),
                'balance' => 0.0,
            ];

            // Recalculate totals for single-row chart
            $total_principal = $loan;
            $total_interest = 0;
            $total_charges = 0;
            $total_emi_paid = $loan;
        }

        //  Return to view
        return view('vehical.calculator.result', [
            'scheme' => $scheme,
            'is_manual' => $isManual,
            'loan' => $loan,
            'tenure_months' => $tenureMonths,
            'payout' => $payout,
            'installments' => $installments,
            'interest_type' => ucfirst($interestType),
            'annual_rate' => $annualRate,
            'disburse_date' => now(),
            'processing_fee' => $processingFee,
            'processing_incl_gst' => $processingFee,
            'stamp_amount' => $stampAmount,
            'stamp_incl_gst' => $stampAmount,
            'insurance_amount' => $insuranceAmount,
            'schedule' => $schedule,
            // Add these total values for footer
            'total_principal' => $total_principal,
            'total_interest' => $total_interest,
            'total_charges' => $total_charges,
            'total_emi_paid' => $total_emi_paid,
            'grand_total_payable' => $grandTotalPayable,
            'disbursed_amount' => $disbursedAmount,
        ]);
    }


////////////////////////////////////////////////////////////////////////////////////////


    public function appindex()
    {
        //  loan applications fetch 
        $applications = VehicalApplication::with(['creditScores'])->latest()->paginate(10);

        return view("vehical.applications.index", compact('applications'));
    }

    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no','general_branch')->get();
        $branch = Branch::all();
        $scheme = VehicalScheme::all();
        $banks = Bank::pluck('name', 'id'); 
        $distributors = VehicleDistributor::all();
        return view("vehical.applications.create", compact('members','branch','scheme','banks','distributors'));
    }
   
    public function storeLoanApplication(Request $request)
    {
        Log::info('--- vehical Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        // Step 1: Validation (Removed security_amount)
        $validated = $request->validate([
            'application_date' => 'required|date_format:d-m-Y',
            'member_id'        => 'required|exists:members,id',
            'branch_id'        => 'required|exists:branches,id',
            'scheme_id'        => 'required|exists:vehical_schemes,id',
            'loan_amount'      => 'required|numeric|min:1',
            'tenure_type'      => 'required',
            'tenure_value'     => 'required',
            'emi_collection'   => 'required',
            'credit_period'    => 'required',
            'insurance_amount' => 'required',
            'net_loan_amount'  => 'required',
            'purpose_of_loan'  => 'required',
            'distributor_id'   => 'required',
            'vehicle_type'     => 'required',
            'vehicle_segment'  => 'required',
            'vehicle_category' => 'required',
            'vehicle_brand'    => 'required',
            'vehicle_model'    => 'required',
            'vehicle_color'    => 'required',
            'manufacture_year' => 'required',
            'vehicle_price'    => 'required|numeric|min:1',
            'down_payment'     => 'required|numeric|min:0',
        ]);

        try {
            // Step 2: Convert Date Format
            if ($request->filled('application_date')) {
                try {
                    $formattedDate = Carbon::createFromFormat('d-m-Y', $request->application_date)->format('Y-m-d');
                    $request->merge(['application_date' => $formattedDate]);
                    Log::info('Converted application_date', ['formatted' => $formattedDate]);
                } catch (Exception $e) {
                    Log::warning('Invalid application_date format', ['value' => $request->application_date]);
                }
            }

            // Step 3: Create Loan Application
            $loanApplication = VehicalApplication::create([
                'application_date' => $request->application_date,
                'member_id'        => $request->member_id,
                'branch_id'        => $request->branch_id,
                'scheme_id'        => $request->scheme_id,
                'co_applicant_1_id' => $request->co_applicant_1_id,
                'co_applicant_2_id' => $request->co_applicant_2_id,
                'guarantor_1_id'   => $request->guarantor_1_id,
                'guarantor_2_id'   => $request->guarantor_2_id,
                'guarantor_3_id'   => $request->guarantor_3_id,
                'guarantor_4_id'   => $request->guarantor_4_id,
                'tenure_type'      => $request->tenure_type,
                'tenure_value'     => $request->tenure_value,
                'emi_collection'   => $request->emi_collection,
                'credit_period'    => $request->credit_period,

                'distributor_id'   => $request->distributor_id,
                'vehicle_type'     => $request->vehicle_type,
                'vehicle_segment'  => $request->vehicle_segment,
                'vehicle_category' => $request->vehicle_category,
                'vehicle_brand'    => $request->vehicle_brand,
                'vehicle_model'    => $request->vehicle_model,
                'vehicle_color'    => $request->vehicle_color,
                'manufacture_year' => $request->manufacture_year,
                'vehicle_no'       => $request->vehicle_no,
                'chassis_no'       => $request->chassis_no,
                'engine_no'        => $request->engine_no,
                'registration_no'  => $request->registration_no,
                'vehicle_delivery_date' => $request->vehicle_delivery_date,
                'insurance_policy_no'   => $request->insurance_policy_no,
                'insurance_expiry_date' => $request->insurance_expiry_date,
                'motor_power'      => $request->motor_power,
                'battery_capacity' => $request->battery_capacity,
                'battery_warranty' => $request->battery_warranty,
                'current_valuation'=> $request->current_valuation,

                // New important fields
                'vehicle_price'    => $request->vehicle_price,
                'down_payment'     => $request->down_payment,

                'loan_amount'              => $request->loan_amount,
                'insurance_amount'         => $request->insurance_amount,
                'net_loan_amount'          => $request->net_loan_amount,
                'purpose_of_loan'          => $request->purpose_of_loan,
                'max_loan_amount'          => $request->max_loan_amount,
                'max_loan_limit'           => $request->max_loan_limit,
                'maximum_approvable_amount'=> $request->maximum_approvable_amount,
                'approved_loan_amount'     => $request->approved_loan_amount,
                'fee_mode'     => $request->fee_mode,        
                'bank_id'     => $request->bank_id,        
                'cheque_no'     => $request->cheque_no,        
                'cheque_date'     => $request->cheque_date,        
                'transfer_date'     => $request->transfer_date,        
                'utr_no'     => $request->utr_no,        
                'transfer_mode'     => $request->transfer_mode,        
                'credited'     => $request->credited ?? 0,        
                'created_by'               => Auth::id(),
            ]);

            Log::info('vehical Loan Application Inserted Successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            // Step 4: CIBIL Data (no change)
            if ($request->has('cibil_type') && is_array($request->cibil_type)) {
                foreach ($request->cibil_type as $index => $type) {
                    if (empty($type)) continue;

                    try {
                        $reportDate = null;
                        if (!empty($request->report_date[$index])) {
                            $reportDate = Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d');
                        }

                        $filePath = null;
                        if ($request->hasFile("report_file.$index")) {
                            $filePath = $request->file("report_file.$index")
                                ->store('uploads/cibil_reports', 'public');
                        }

                        VehicalCreditScore::create([
                            'loan_application_id' => $loanApplication->id,
                            'cibil_type' => $type,
                            'cibil_score' => $request->cibil_score[$index] ?? null,
                            'report_date' => $reportDate,
                            'report_file_path' => $filePath,
                        ]);

                        Log::info('CIBIL Record Inserted', [
                            'type' => $type,
                            'score' => $request->cibil_score[$index] ?? null,
                        ]);
                    } catch (Exception $e) {
                        Log::warning('Failed to insert CIBIL record', [
                            'index' => $index,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            }

            return redirect()->route('vehical.applications.index')
                ->with('success', 'vehical Loan, Credit Score details saved successfully.');

        } catch (Exception $e) {
            Log::error('Error while storing Loan Application', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()->with('error', 'Something went wrong while saving the loan application.');
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
        $application = VehicalApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',  // <-- add scheme here
            'creditScores'
        ])->findOrFail($id);

        return view("vehical.applications.view", compact('application'));
    }

    public function appedit($id)
    {
        $application = VehicalApplication::with(['member', 'scheme', 'creditScores'])->findOrFail($id);

        $members = Member::all();
        $schemes = VehicalScheme::all();
        $scheme  = VehicalScheme::all();
        $branch  = Branch::all();
        $banks   = Bank::pluck('name', 'id');
        $distributors = VehicleDistributor::all();

        return view('vehical.applications.create', compact('application', 'members', 'schemes', 'branch', 'scheme', 'banks','distributors'));
    }

    public function appupdate(Request $request, $id)
    {
        $request->validate([
            'application_date' => 'required|date',
            'member_id'        => 'required|exists:members,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric',
        ]);

        $application = VehicalApplication::findOrFail($id);
        //$application->update($request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']));
        // Convert date format before update
        $data = $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file']);

        // Convert application_date from d-m-Y → Y-m-d
        if (!empty($data['application_date'])) {
            $data['application_date'] = Carbon::createFromFormat('d-m-Y', $data['application_date'])->format('Y-m-d');
        }

        // Convert cheque_date if it exists and not already in Y-m-d
        if (!empty($data['cheque_date']) && strpos($data['cheque_date'], '-') === 2) {
            $data['cheque_date'] = Carbon::createFromFormat('d-m-Y', $data['cheque_date'])->format('Y-m-d');
        }

        // Convert transfer_date if exists
        if (!empty($data['transfer_date']) && strpos($data['transfer_date'], '-') === 2) {
            $data['transfer_date'] = Carbon::createFromFormat('d-m-Y', $data['transfer_date'])->format('Y-m-d');
        }

        if (empty($data['processing_fee_total'])) {
            $data['processing_fee_total'] = 0;
        }

        // Now safely update
        $application->update($data);

        // Delete old CIBIL reports (if editing)
        $application->creditScores()->delete();

        // Insert new/updated CIBIL rows
        if ($request->has('cibil_type')) {
            foreach ($request->cibil_type as $index => $type) {
                $filePath = null;
                if ($request->hasFile("report_file.$index")) {
                    $filePath = $request->file("report_file.$index")->store('cibil_reports', 'public');
                }

                $application->creditScores()->create([
                    'cibil_type' => $type,
                    'cibil_score' => $request->cibil_score[$index],
                    'report_date' => Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d'),
                    'report_file_path' => $filePath,
                ]);
            }
        }


        return redirect()
            ->route('vehical.applications.view', $application->id)
            ->with('success', 'Application updated successfully');
    }


//////////////////////////////////////////////////////////////////////////////////////


    public function emiChart($id)
    {
        $application = VehicalApplication::with(['scheme', 'member', 'branch'])->findOrFail($id);

        /* Detect Interest Type */
        $interestTypeRaw = strtolower(trim($application->scheme->gold_loan_setting ?? ''));

        if (str_contains($interestTypeRaw, 'no')) {
            $interestType = 'no_emi';
        } elseif (str_contains($interestTypeRaw, 'advanced')) {
            $interestType = 'flat_advanced';
        } elseif (
            str_contains($interestTypeRaw, 'reducing') ||
            str_contains($interestTypeRaw, 'reduce') ||
            str_contains($interestTypeRaw, 'balance') ||
            str_contains($interestTypeRaw, 'rb')
        ) {
            $interestType = 'reducing';
        } else {
            $interestType = 'flat_emi';
        }

        /* Basic Inputs */
        $disburseDate = $application->disbursal_date
            ? Carbon::parse($application->disbursal_date)
            : Carbon::now();

        $loanAmount = floatval($application->approved_loan_amount ?? $application->loan_amount ?? 0);
        $tenure = intval($application->tenure_value ?? ($application->scheme->no_of_emi ?? 1));
        if ($tenure <= 0) $tenure = 1;

        /* Charges */
        $processingFeeInc = floatval($application->processing_fee ?? 0);
        $stampDutyInc     = floatval($application->stamp_duty ?? 0);
        $insuranceInc     = floatval($application->insurance_fee ?? 0);
        $fitnessInc       = floatval($application->fitness_fee ?? 0);

        $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;
        $chargesPerEmi = $tenure ? round($totalChargesInc / $tenure, 2) : 0;

        /* Interest Rate */
        $annualRate = floatval($application->scheme->annual_interest_rate ?? 0);

        /* Collection Frequency */
        $collection = strtolower($application->emi_collection ?? 'monthly');
        switch ($collection) {
            case 'daily':    $periodIncrement = 'addDay';  $periodName = 'DAILY';   $periodsPerYear = 365; break;
            case 'weekly':   $periodIncrement = 'addWeek'; $periodName = 'WEEKLY';  $periodsPerYear = 52; break;
            default:         $periodIncrement = 'addMonth';$periodName = 'MONTHLY'; $periodsPerYear = 12;
        }

        $periodicRate = ($annualRate / 100) / $periodsPerYear;
        $principalPerEmi = round($loanAmount / $tenure, 2);

        /* FLAT EMI fixed interest */
        if ($interestType === 'flat_emi') {
            $totalFlatInterest = ($loanAmount * ($annualRate / 100) * ($tenure / 12));
            $fixedInterest = round($totalFlatInterest / $tenure, 2);

            $roundingDiff = round($totalFlatInterest - ($fixedInterest * $tenure), 2);
        }

        $schedule = [];
        $remainingPrincipal = $loanAmount;
        $emiDate = $disburseDate->copy();

        /*  SPECIAL CASE — **ONLY 1 ROW** (Flat Advanced) */
        if ($interestType == 'flat_advanced') {

        $emiDate = $emiDate->copy()->{$periodIncrement}(1);
        $formattedEmiDate = $emiDate->format('d-m-Y');
        $dueDate = $emiDate->copy()->addDay()->format('d-m-Y');

            $schedule[] = [
                'no' => 1,
                'emi_date' => $formattedEmiDate,
                'due_date' => $dueDate,
                'principal' => number_format($loanAmount, 2),
                'interest' => "0.00",
                'charges_per_emi' => "0.00",
                'emi' => number_format($loanAmount, 2),
                'bal_principal' => "0.00",
            ];

            //  ADD THESE TOTALS
            $totalPrincipal = $loanAmount;
            $totalInterest = 0;
            $totalCharges = 0;
            $totalEmi = $loanAmount;

            return view('vehical.applications.view-buttons.show-emi-chart', compact(
                'application','loanAmount','disburseDate',
                'processingFeeInc','stampDutyInc','insuranceInc','fitnessInc',
                'tenure','chargesPerEmi','schedule',
                'totalPrincipal','totalInterest','totalCharges','totalEmi',
                'annualRate','interestType','periodName'
            ));
        }


        /*  Generate EMI Rows */
        for ($i = 1; $i <= $tenure; $i++) {

            $emiDate = $emiDate->copy()->{$periodIncrement}(1);
            $formattedEmiDate = $emiDate->format('d-m-Y');
            $dueDate = $emiDate->copy()->addDay()->format('d-m-Y');

            /*  NO-EMI CASE — every row principal = loanAmount */
            if ($interestType == 'no_emi') {
                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $formattedEmiDate,
                    'due_date' => $dueDate,
                    'principal' => number_format($loanAmount, 2),
                    'interest' => "",
                    'charges_per_emi' => "",
                    'emi' => "",
                    'bal_principal' => "",
                ];
                continue;
            }

            /*  Flat EMI */
            if ($interestType == 'flat_emi') {
                $interestForPeriod = ($i == $tenure) ? $fixedInterest + $roundingDiff : $fixedInterest;
            } else {
                /*  Reducing */
                $interestForPeriod = round($remainingPrincipal * $periodicRate, 2);
            }

            if ($i == $tenure) {
                $principalThis = round($remainingPrincipal, 2);
            } else {
                $principalThis = $principalPerEmi;
            }

            $emiTotal = round($principalThis + $interestForPeriod + $chargesPerEmi, 2);
            $remainingPrincipal = round($remainingPrincipal - $principalThis, 2);

            // $schedule[] = [
            //     'no' => $i,
            //     'emi_date' => $formattedEmiDate,
            //     'due_date' => $dueDate,
            //     'principal' => number_format($principalThis, 2),
            //     'interest' => number_format($interestForPeriod, 2),
            //     'charges_per_emi' => number_format($chargesPerEmi, 2),
            //     'emi' => number_format($emiTotal, 2),
            //     'bal_principal' => number_format($remainingPrincipal, 2),
            // ];
            $schedule[] = [
                'no' => $i,
                'emi_date' => $formattedEmiDate,
                'due_date' => $dueDate,
                'principal' => $principalThis,         
                'interest' => $interestForPeriod,      
                'charges_per_emi' => $chargesPerEmi,   
                'emi' => $emiTotal,                    
                'bal_principal' => $remainingPrincipal 
            ];

        }

        /* Totals */
        $totalPrincipal = array_sum(array_map(fn($r)=>floatval($r['principal']), $schedule));
        $totalInterest  = array_sum(array_map(fn($r)=>floatval($r['interest']), $schedule));
        $totalCharges   = array_sum(array_map(fn($r)=>floatval($r['charges_per_emi']), $schedule));
        $totalEmi       = array_sum(array_map(fn($r)=>floatval($r['emi']), $schedule));
        if ($interestType === 'no_emi') {
            $totalPrincipal = 0;
            $totalInterest  = 0;
            $totalCharges   = 0;
            $totalEmi       = 0;
        }
        return view('vehical.applications.view-buttons.show-emi-chart', compact(
            'application','loanAmount','disburseDate',
            'processingFeeInc','stampDutyInc','insuranceInc','fitnessInc',
            'tenure','chargesPerEmi','schedule',
            'totalPrincipal','totalInterest','totalCharges','totalEmi',
            'annualRate','interestType','periodName'
        ));
    }


    public function vehical_col_process_fee($id)
    {
        $application = VehicalApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view("vehical.applications.view-buttons.col_process_fee", compact('application','banks'));
    }

    public function VehicalstoreProcessFee(Request $request, $id)
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

        VehicalProcessingFee::create($data);

        return redirect()->route('vehical.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }


    
}
