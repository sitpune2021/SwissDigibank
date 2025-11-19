<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\GoldLoanScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\LoanApplication;
use App\Models\LoanOrnament;
use App\Models\Calculator;
use App\Models\LoanCreditScore;
use App\Models\GoldloanProcessingFee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Exception;

class GoldLoanController extends Controller
{
    
    public function index()
    {       
        //$schemes = GoldLoanScheme::all();
        // paginate(10) => 10 records per page
        $schemes = GoldLoanScheme::orderBy('id', 'desc')->paginate(10);
        return view("gold-loan.schemes.index", compact('schemes'));
    }

    public function create()
    {
        return view("gold-loan.schemes.create");
    }

    public function store(Request $request)
    {
        try {
            Log::info('Store function started', ['request' => $request->all()]);

            $validated = $request->validate([
                'scheme_name' => 'required|string|max:255',
                'scheme_code' => 'required|string|max:50|unique:gold_loan_schemes,scheme_code',
                'min_loan_amount' => 'required|numeric|min:1',
                'max_loan_amount' => 'required|numeric|min:1|max:200000',
                'tenure' => 'required|integer|min:1',
                'annual_interest_rate' => 'required|numeric|min:0',
                'processing_fee' => 'nullable|numeric|min:0',
                'stamp_duty_charge' => 'nullable|numeric|min:0',
                'insurance_fee' => 'nullable|numeric|min:0',
                'gold_loan_setting' => 'nullable|string',
                'max_loan_limit' => 'required|numeric|max:100',
                'overdue_interest_rate' => 'nullable|numeric|min:0',
                'overdue_interest_type' => 'nullable|string|in:TYPE_1,TYPE_2',
                'penalty_charge' => 'nullable|numeric|min:0',
                'fore_closer_charge' => 'nullable|numeric|min:0',
                'credit_period' => 'nullable|numeric|min:0',
                'sms_charge' => 'nullable|numeric|min:0',
                'fuel_charge' => 'nullable|numeric|min:0',
                'stationary_charge' => 'nullable|numeric|min:0',
                'maintenance_charge' => 'nullable|numeric|min:0',
                'collection' => 'nullable|numeric|min:0',
                'is_active' => 'required|in:0,1',
                'charge_floting' => 'nullable|in:0,1',
                'no_emi' => 'nullable|array|max:12',
                'no_emi.*.from_date' => 'nullable|numeric|min:1',
                'no_emi.*.to_date' => 'nullable|numeric|min:1',
                'no_emi.*.penal_rate_interest' => 'nullable|numeric|min:0|max:100',
                'no_emi.*.annual_rate_interest' => 'nullable|numeric|min:0|max:100',
            ]);

            Log::info('Validation Passed', ['validated' => $validated]);

            // Always prepare 12 entries (filled or null)
            $noEmiData = [];
            for ($i = 0; $i < 12; $i++) {
                $noEmiData[] = [
                    'to_date' => $request->input("no_emi.$i.to_date") ?: null,
                    'from_date' => $request->input("no_emi.$i.from_date") ?: null,
                    'penal_rate_interest' => $request->input("no_emi.$i.penal_rate_interest") ?: null,
                    'annual_rate_interest' => $request->input("no_emi.$i.annual_rate_interest") ?: null,
                ];
            }

            if ($request->gold_loan_setting === 'no_emi') {
                // Store as pure JSON array (no extra escaping)
                $validated['no_emi_slabs'] = $noEmiData;
                $validated['charge_floting'] = $request->charge_floting;
            } else {
                $validated['no_emi_slabs'] = null;
            }

            GoldLoanScheme::create($validated);

            return redirect()
                ->route('gold-loan.schemes.index')
                ->with('success', 'Scheme created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->validator)->withInput();

        } catch (\Throwable $e) {
            Log::error('Error while storing Scheme', [
                'error_message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()
                ->back()
                ->with('error', 'Something went wrong! Please check logs.')
                ->withInput();
        }
    }

    public function show($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view('gold-loan.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view('gold-loan.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);

        // Validate required fields only
        $request->validate([
            'scheme_name' => 'required|string|max:255',
            'scheme_code' => 'required|string|max:50|unique:gold_loan_schemes,scheme_code,' . $id,
            'gold_loan_setting' => 'required|string',
        ]);

        // Take all fields except no_emi_slabs (we will process manually)
        $input = $request->except(['no_emi']);

        // If No-EMI selected — store array directly
        if ($request->gold_loan_setting == 'no_emi') {
            $input['no_emi_slabs'] = $request->no_emi;
            $input['charge_floting'] = $request->charge_floting ?? 0;
        } else {
            $input['no_emi_slabs'] = null;
            $input['charge_floting'] = null;
        }

        $scheme->update($input);

        return redirect()->route('gold-loan.schemes.index')
            ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view("gold-loan.schemes.view", compact('scheme'));
    }


//////////////////////////////////////////////////////////////////////////////////


    public function calculator()
    {
        $scheme = GoldLoanScheme::all();
        return view("gold-loan.calculator.index", compact('scheme'));
    }

    public function calculateResult(Request $request)
    {
        /* -------------------------------------------------------
            1. BASIC INPUT HANDLING
        ---------------------------------------------------------*/
        $isManual = $request->has('manual_interest_rate') && $request->manual_interest_rate != '';

        //  ADD HERE (Correct Location)
            $interestAsEmi = $request->has('option_interest_emi') ? 'Yes' : 'No';
            $interestAsFirst = $request->has('option_interest_first') ? 'Yes' : 'No';
        //  END
        

        if ($isManual) {

            $request->validate([
                'loan_amount' => 'required|numeric|min:1',
                'max_tenure' => 'required|integer|min:1',
                'manual_interest_rate' => 'required|numeric|min:0',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly'
            ]);

            $loan         = (float) $request->loan_amount;
            $tenureMonths = (int) $request->max_tenure;
            $annualRate   = (float) $request->manual_interest_rate;
            $payout       = $request->payout;

            // FIX — interest type manual mode me same ka same
            $interestTypeRaw = strtolower(trim($request->interest_type ?? 'flat_emi'));

            $interestType = match ($interestTypeRaw) {
                'reducing', 'reducing_emi' => 'reducing',
                'flat_advanced', 'flat_advance_interest' => 'flat_advanced',
                'flat_interest', 'flat_emi' => 'flat_emi',
                'no_emi' => 'no_emi',
                default => 'flat_emi',
            };

            $processingFee  = (float) ($request->manual_processing_fee ?? 0);
            $stampAmount    = round($loan * ($request->manual_stamp ?? 0) / 100, 2);
            $insuranceAmount= round($loan * ($request->manual_insurance ?? 0) / 100, 2);

            $scheme         = null;

        } else {

            $request->validate([
                'scheme_id' => 'required|exists:gold_loan_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'tenure_months' => 'required|integer|min:1',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly'
            ]);

            $scheme = GoldLoanScheme::findOrFail($request->scheme_id);

            $loan         = (float) $request->loan_amount;
            $tenureMonths = (int) $request->tenure_months;
            $annualRate   = (float) $scheme->annual_interest_rate;
            $payout       = $request->payout;

            // FIX — Mapping cleaned
            $setting = strtolower($scheme->gold_loan_setting);

            $interestType = match ($setting) {
                'reducing_balance', 'reducing', 'reducing_emi' => 'reducing',
                'flat_advance_interest', 'flat_advanced_interest' => 'flat_advanced',
                'flat_interest' => 'flat_emi',
                'no_emi' => 'no_emi',
                default => 'flat_emi',
            };

            $processingFee   = (float) ($scheme->processing_fee ?? 0);
            $stampAmount     = round($loan * ($scheme->stamp_duty_charge ?? 0) / 100, 2);
            $insuranceAmount = round($loan * ($scheme->insurance_fee ?? 0) / 100, 2);
        }

        /* -------------------------------------------------------
            2. INSTALLMENT COUNT
        ---------------------------------------------------------*/
        $monthsPerInstallment = match ($payout) {
            'monthly' => 1,
            'quarterly' => 3,
            'half-yearly' => 6,
            'yearly' => 12,
            default => 1,
        };

        //$installments = ceil($tenureMonths / $monthsPerInstallment);
        // FLAT ADVANCED → Only 1 EMI
        if ($interestType === 'flat_advanced') {
            $installments = 1;
        } else {
            $installments = ceil($tenureMonths / $monthsPerInstallment);
        }

        $schedule = [];
        $startDate = now();
        $outstanding = $loan;


        /* -------------------------------------------------------
            3. INTEREST CALCULATION
            IMPORTANT FIX:
            - Flat EMI, Flat Advanced, NO EMI → Pre-calculated Total Interest
            - Reducing EMI → Total Interest = SUM(schedule interest)
        ---------------------------------------------------------*/

        if ($interestType !== 'reducing') {
            $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12), 2);
        } else {
            $totalInterest = 0; // Final total interest later calculated from schedule
        }


        /* -------------------------------------------------------
            4(A). FLAT ADVANCED → ONLY ONE EMI
        ---------------------------------------------------------*/
        if ($interestType === 'flat_advanced') {

            $emiDate = $startDate->copy()->addMonths($monthsPerInstallment);
            $dueDate = $emiDate->copy()->addDay();

            $schedule[] = [
                'no' => 1,
                'emi_date'  => $emiDate->format('d/m/Y'),
                'due_date'  => $dueDate->format('d/m/Y'),
                'principal' => round($loan, 2),
                'interest'  => 0,
                'charges'   => 0,
                'emi'       => round($loan, 2),
                'balance'   => 0
            ];
        }


        /* -------------------------------------------------------
             4(B). FLAT EMI
        ---------------------------------------------------------*/
        elseif ($interestType === 'flat_emi') {

            $principalPerEmi = round($loan / $installments, 2);
            $interestPerEmi  = round($totalInterest / $installments, 2);

            for ($i = 1; $i <= $installments; $i++) {

                $emiDate = $startDate->copy()->addMonths($i * $monthsPerInstallment);
                $dueDate = $emiDate->copy()->addDay();

                $principal = ($i == $installments) ? $outstanding : $principalPerEmi;

                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $emiDate->format('d/m/Y'),
                    'due_date' => $dueDate->format('d/m/Y'),
                    'principal' => $principal,
                    'interest' => $interestPerEmi,
                    'charges' => 0,
                    'emi' => $principal + $interestPerEmi,
                    'balance' => max($outstanding - $principal, 0),
                ];

                $outstanding -= $principal;
            }
        }

        /* -------------------------------------------------------
             4(C). REDUCING EMI — FULLY FIXED 
        ---------------------------------------------------------*/
        elseif ($interestType === 'reducing') {

            $monthlyRate = ($annualRate / 12) / 100;

            $emi = round(($loan * $monthlyRate) / (1 - pow(1 + $monthlyRate, -$tenureMonths)), 2);

            for ($i = 1; $i <= $tenureMonths; $i++) {

                $emiDate = $startDate->copy()->addMonths($i);
                $dueDate = $emiDate->copy()->addDay();

                $interest  = round($outstanding * $monthlyRate, 2);
                $principal = round($emi - $interest, 2);

                $schedule[] = [
                    'no' => $i,
                    'emi_date'  => $emiDate->format('d/m/Y'),
                    'due_date'  => $dueDate->format('d/m/Y'),
                    'principal' => $principal,
                    'interest'  => $interest,
                    'charges'   => 0,
                    'emi'       => $emi,
                    'balance'   => max($outstanding - $principal, 0),
                ];

                $outstanding -= $principal;
                $totalInterest += $interest;   //  FIX – total interest recalc
            }

            $installments = $tenureMonths; //  Reducing EMI always monthly
        }

        /* -------------------------------------------------------
             4(D). NO EMI
        ---------------------------------------------------------*/
        elseif ($interestType === 'no_emi') {

            $interestPerInstallment = round($totalInterest / $installments, 2);

            for ($i = 1; $i <= $installments; $i++) {

                $emiDate = $startDate->copy()->addMonths($i * $monthsPerInstallment);
                $dueDate = $emiDate->copy()->addDay();

                $schedule[] = [
                    'no' => $i,
                    'emi_date' => $emiDate->format('d/m/Y'),
                    'due_date' => $dueDate->format('d/m/Y'),
                    'principal' => round($loan, 2),
                    'charges'   => 0,
                    'interest' => $interestPerInstallment,
                    'emi' => $interestPerInstallment,
                    'balance' => $loan
                ];
            }
        }

        /* -------------------------------------------------------
            4(E). INTEREST AS EMI LOGIC (PRINCIPAL ZERO)
        ---------------------------------------------------------*/
        if ($interestAsEmi === 'Yes') {

            foreach ($schedule as $k => $row) {

                // LAST EMI - full principal
                if ($row['no'] == $installments) {
                    $schedule[$k]['principal'] = $loan;
                    $schedule[$k]['balance'] = 0;
                } 
                // All other EMI - principal ZERO
                else {
                    $schedule[$k]['principal'] = 0;
                    $schedule[$k]['balance'] = $loan;
                }

                // EMI = interest only
                $schedule[$k]['emi'] = $schedule[$k]['principal'] + $schedule[$k]['interest'];
            }
        }

        /* -------------------------------------------------------
            4(F). INTEREST AS FIRST EMI LOGIC
        ---------------------------------------------------------*/
        if ($interestAsFirst === 'Yes') {

            // Total interest divided: first EMI full interest, remaining interest spread?
            $firstEmiInterest = round($totalInterest - ($interestPerEmi ?? 0), 2); 
            // But flat EMI case me interestPerEmi available hota hai

            foreach ($schedule as $k => $row) {

                // EMI 1 → ONLY INTEREST
                if ($row['no'] == 1) {
                    $schedule[$k]['principal'] = 0;
                    $schedule[$k]['interest'] = $firstEmiInterest;
                    $schedule[$k]['emi'] = $firstEmiInterest;
                    $schedule[$k]['balance'] = $loan;
                }

                // EMI 2 → Original interestPerEmi (ex: 417), principal portion normal
                elseif ($row['no'] == 2) {
                    // interest remains normal
                    // principal is original
                    $schedule[$k]['emi'] = $schedule[$k]['principal'] + $schedule[$k]['interest'];
                }

                // EMI ≥ 3 → Interest = 0 (Full principal)
                elseif ($row['no'] >= 3 && $row['no'] < $installments) {
                    $schedule[$k]['interest'] = 0;

                    // normal principal
                    $schedule[$k]['emi'] = $schedule[$k]['principal'];
                    $schedule[$k]['balance'] = $schedule[$k]['balance'];
                }

                // LAST EMI → Whatever principal remains
                if ($row['no'] == $installments) {
                    $schedule[$k]['interest'] = 0;
                    $schedule[$k]['principal'] = $schedule[$k]['balance'];
                    $schedule[$k]['emi'] = $schedule[$k]['principal'];
                    $schedule[$k]['balance'] = 0;
                }
            }
        }
        

        /* -------------------------------------------------------
             5. TOTAL PAYABLE
        ---------------------------------------------------------*/
        $grandTotalPayable = $loan + $totalInterest + $processingFee + $stampAmount + $insuranceAmount;


        /* -------------------------------------------------------
             6. RETURN VIEW
        ---------------------------------------------------------*/
        return view('gold-loan.calculator.result', [
            'scheme' => $scheme,
            'is_manual' => $isManual,
            'loan' => $loan,
            'tenure_months' => $tenureMonths,
            'payout' => $payout,
            'installments' => $installments,
            'interest_type' => ucfirst(str_replace('_', ' ', $interestType)),
            'annual_rate' => $annualRate,

            'disburse_date' => now(),
            'processing_fee' => $processingFee,
            'stamp_amount' => $stampAmount,
            'insurance_amount' => $insuranceAmount,

            'schedule' => $schedule,

            'interest_as_emi' => $interestAsEmi,
            'interest_as_first' => $interestAsFirst,

            //'ratio_enabled' => $request->has('ratio_enabled') ? 'Yes' : 'No',
            'ratio_enabled' => $request->ratio_enabled === 'Yes' ? 'Yes' : 'No',
            'ratio_first_emi' => $request->ratio_first_emi ?? null,
            'ratio_first_percentage' => $request->ratio_first_percentage ?? null,


            'total_interest' => round($totalInterest, 2),
            'total_principal' => $loan,
            'total_emi_paid' => round(($interestType == 'flat_advanced' ? $loan : $loan + $totalInterest), 2),
            'grand_total_payable' => round($grandTotalPayable, 2),
        ]);
    }


//////////////////////////////////////////////////////////////////////////////////


    public function appindex()
    {
        //  loan applications fetch 
        $applications = LoanApplication::with(['creditScores'])->latest()->paginate(10);

        return view("gold-loan.applications.index", compact('applications'));
    }

    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name', 'member_info_mobile_no', 'general_branch')->get();
        $branch = Branch::all();
        $scheme = GoldLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("gold-loan.applications.create", compact('members', 'branch', 'scheme', 'banks'));
    }
   
    public function storeLoanApplication(Request $request)
    {
        //dd('ghf');
        Log::info('--- Loan Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        $validated = $request->validate([
            'application_date' => 'required|date_format:d-m-Y',
            'member_id'        => 'required|exists:members,id',
            'branch_id'        => 'required|exists:branches,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric|min:1',
            'tenure_type'      => 'required',
            'tenure_value'     => 'required',
            'emi_collection'   => 'required',
            'credit_period'    => 'required',
            'insurance_amount' => 'required',
            'net_loan_amount'  => 'required',
            'purpose_of_loan'  => 'required',
            'max_loan_amount'  => 'nullable|numeric|min:1',
        ], [
            'max_loan_amount.gt' => 'Maximum loan amount must be greater than minimum loan amount.',
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

        Log::info('Validation passed successfully');

        try {

            // 🩵 Fix date format
            if ($request->filled('application_date')) {
                $request->merge([
                    'application_date' => Carbon::createFromFormat('d-m-Y', $request->application_date)->format('Y-m-d'),
                ]);
            }
            // Loan Application Save
            $loanApplication = LoanApplication::create($request->only([
                'application_date',
                'member_id',
                'co_applicant_1_id',
                'co_applicant_2_id',
                'branch_id',
                'advisor_id',
                'guarantor_1_id',
                'guarantor_2_id',
                'guarantor_3_id',
                'guarantor_4_id',
                'scheme_id',
                'tenure_type',
                'tenure_value',
                'emi_collection',
                'credit_period',
                'loan_amount',
                'insurance_amount',
                'net_loan_amount',
                'purpose_of_loan',
                'processing_fee_value',
                'processing_fee_gst',
                'processing_fee_sgst',
                'processing_fee_cgst',
                'processing_fee_igst',
                'processing_fee_total',
                'fee_mode',
                'bank_id',
                'cheque_no',
                'cheque_date',
                'transfer_date',
                'utr_no',
                'transfer_mode',
                'credited',
                'collect_principal_as_emi',
                'collect_advance_processing_fee',
                'security_value',
                'max_loan_amount',
                'max_loan_limit',
                'maximum_approvable_amount',
                'approved_loan_amount',
            ]));

            Log::info('Loan Application created successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            // ==== Credit Score Details Save (Dynamic Rows) ====
            if ($request->has('cibil_type')) {
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
                            'trace' => $e->getTraceAsString(),
                        ]);
                    }
                }
            }

            //  Save Ornaments (Dynamic Rows)
            $itemTypes = $request->input('item_type', []);
            $itemNames = $request->input('item_name', []);
            $noOfItems = $request->input('no_of_items', []);
            $valuePerGram = $request->input('value_per_gram', []);
            $grossWeight = $request->input('gross_weight', []);
            $netWeight = $request->input('net_weight', []);
            $tunch = $request->input('tunch', []);
            $fineWeight = $request->input('fine_weight', []);
            $totalValue = $request->input('total_value', []);

            if (!empty($itemTypes)) {
                foreach ($itemTypes as $index => $type) {
                    $loanOrnament = LoanOrnament::create([
                        'application_id'=> $loanApplication->id,
                        'item_type' => $type,
                        'item_name' => $itemNames[$index] ?? null,
                        'no_of_items' => $noOfItems[$index] ?? 0,
                        'value_per_gram' => $valuePerGram[$index] ?? 0,
                        'gross_weight' => $grossWeight[$index] ?? 0,
                        'net_weight' => $netWeight[$index] ?? 0,
                        'tunch' => $tunch[$index] ?? 0,
                        'fine_weight' => $fineWeight[$index] ?? 0,
                        'total_value' => $totalValue[$index] ?? 0,
                        'status'=>1
                    ]);
                }
            }


            Log::info('--- Loan Application Store Completed Successfully ---', [
                'loan_application_id' => $loanApplication->id,
            ]);

            return redirect()->route('gold-loan.applications.index')
                ->with('success', 'Loan Application + Credit Scores + Ornaments saved successfully!');
        } catch (Exception $e) {
            Log::error('Error while storing Loan Application', [
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
        $application = LoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',   
            'branch' ,
            'creditScores',
            'loanOrnaments'
        ])->findOrFail($id);

         // Generate EMI Chart
    $emiChart = $this->generateEmiChart($application);

        return view("gold-loan.applications.view", compact('application', 'emiChart'));
    }

    public function appedit($id)
    {
        $application = LoanApplication::with(['member', 'scheme'])->findOrFail($id);

        //  Fetch all related CIBIL records for this loan application
        $creditScores = LoanCreditScore::where('loan_application_id', $id)->get();

        $ornaments = LoanOrnament::where('application_id', $id)->get();

        // Dropdown data
        $members = Member::all();
        $schemes = GoldLoanScheme::all();
        $branch = Branch::all();
        $scheme = GoldLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view('gold-loan.applications.create', compact(
            'application',
            'members',
            'schemes',
            'branch',
            'scheme',
            'banks',
            'creditScores', //  Pass it to view
            'ornaments'
        ));
    }

    public function appupdate(Request $request, $id)
    {
        $request->validate([
            'application_date' => 'required|date',
            'member_id'        => 'required|exists:members,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric',
        ]);

        $application = LoanApplication::findOrFail($id);
        $request->merge([
            'application_date' => date('Y-m-d', strtotime(str_replace('/', '-', $request->application_date)))
        ]);
        $application->update($request->all());

        /* -----------------------------------------------
        🟡 STEP 1: Purane ornaments delete karo
        ------------------------------------------------*/
        DB::table('loan_ornaments')->where('application_id', $application->id)->delete();

        /* -----------------------------------------------
        🟢 STEP 2: Naye ornaments insert karo
        ------------------------------------------------*/
        if ($request->has('item_type')) {
            foreach ($request->item_type as $index => $type) {
                DB::table('loan_ornaments')->insert([
                    'application_id' => $application->id,
                    'item_type'      => $type ?? null,
                    'item_name'      => $request->item_name[$index] ?? null,
                    'no_of_items'    => $request->no_of_items[$index] ?? null,
                    'value_per_gram' => $request->value_per_gram[$index] ?? null,
                    'gross_weight'   => $request->gross_weight[$index] ?? null,
                    'net_weight'     => $request->net_weight[$index] ?? null,
                    'tunch'          => $request->tunch[$index] ?? null,
                    'fine_weight'    => $request->fine_weight[$index] ?? null,
                    'total_value'    => $request->total_value[$index] ?? null,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
            }
        }

            /* -----------------------------------------------
            🟢 STEP 3: Credit Score Details Update karo
            ------------------------------------------------*/
            DB::table('loan_credit_scores')->where('loan_application_id', $application->id)->delete();

            if ($request->has('cibil_type')) {
                foreach ($request->cibil_type as $index => $type) {
            // Convert report_date to proper MySQL format
            $report_date = null;
            if (!empty($request->report_date[$index])) {
                $report_date = date('Y-m-d', strtotime(str_replace('/', '-', $request->report_date[$index])));
            }

            DB::table('loan_credit_scores')->insert([
                'loan_application_id' => $application->id,
                'cibil_type'          => $type ?? null,
                'cibil_score'         => $request->cibil_score[$index] ?? null,
                'report_date'         => $report_date,
                'report_file_path'    => isset($request->report_file[$index])
                                        ? $request->report_file[$index]->store('uploads/cibil_reports', 'public')
                                        : null,
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }

        }

        return redirect()
            ->route('gold-loan.applications.view', $application->id)
            ->with('success', 'Application updated successfully with ornaments & credit score');
    }


////////////////////////////////////////////////////////////////////////////////


    public function showdisbursesetting($id)
    {
        $application = LoanApplication::with(['member','scheme','branch'])->findOrFail($id);

        $emiChart = $this->generateEmiChart($application);

        return view("gold-loan.applications.view-buttons.disburse-setting", compact('application', 'emiChart'));
    }


    public function generateEmiChart($application)
    {
        $principalAmount = $application->approved_loan_amount;
        $months = $application->tenure;
        $annualInterest = $application->scheme->annual_interest_rate;

        $monthlyInterestRate = ($annualInterest / 12) / 100;

        // Other Charges Per EMI (set your correct field)
        $otherPerEmi = $application->scheme->other_charge_per_emi ?? 0;

        // EMI Formula
        $emi = ($principalAmount * $monthlyInterestRate * pow(1 + $monthlyInterestRate, $months))
            / (pow(1 + $monthlyInterestRate, $months) - 1);

        $balance = $principalAmount;
        $schedule = [];

        $totalInterest = 0;

        for ($i = 1; $i <= $months; $i++) {

            $interest = $balance * $monthlyInterestRate;
            $principal = $emi - $interest;

            $balance -= $principal;

            $totalInterest += $interest;

            $schedule[] = [
                'no'         => $i,
                'principal'  => round($principal, 2),
                'interest'   => round($interest, 2),
                'other_charges' => round($otherPerEmi, 2),
                'emi'        => round($emi + $otherPerEmi, 2),
                'start_date' => now()->format('d/m/Y'),
                'date'       => now()->addMonths($i)->format('d/m/Y'),
                'due_date'   => now()->addMonths($i)->addDay()->format('d/m/Y'),
                'due_principal' => round(max($balance, 0), 2),
            ];
        }

        return [
            "rows" => $schedule,
            "total_interest" => round($totalInterest, 2),
            "total_other" => round($months * $otherPerEmi, 2),
        ];
    }


    public function upload_cibil_score()
    {

        return view("gold-loan.applications.upload-cibil-score");
    }

    public function col_process_fee($id)
    {
         $application = LoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        // Approved Loan Amount
        $loan = (float) $application->approved_loan_amount;

        // Annual Rate
        $annualRate = (float) ($application->scheme->annual_interest_rate ?? 0);

        // Tenure (months)
        $tenure = (int) ($application->tenure_months ?? 12);

        // Monthly Rate
        $monthlyRate = $annualRate / 12 / 100;

        // EMI Calculation
        if ($monthlyRate > 0) {
            $emi = round(
                ($loan * $monthlyRate * pow(1 + $monthlyRate, $tenure)) /
                (pow(1 + $monthlyRate, $tenure) - 1),
                2
            );
        } else {
            // If interest is 0%
            $emi = round($loan / $tenure, 2);
        }

        // Total Interest
        $totalInterest = round(($emi * $tenure) - $loan, 2);

        // Total Recover Amount
        $totalRecover = round($loan + $totalInterest, 2);


            return view("gold-loan.applications.view-buttons.col_process_fee", compact('application','banks', 'totalRecover','emi'));
    }

    public function storeProcessFee(Request $request, $id)
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

        GoldloanProcessingFee::create($data);

        return redirect()->route('gold-loan.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }

    public function emiChart($id)
    {
        $application = LoanApplication::with(['scheme', 'member', 'branch'])->findOrFail($id);

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

            return view('gold-loan.applications.view-buttons.show-emi-chart', compact(
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
        return view('gold-loan.applications.view-buttons.show-emi-chart', compact(
            'application','loanAmount','disburseDate',
            'processingFeeInc','stampDutyInc','insuranceInc','fitnessInc',
            'tenure','chargesPerEmi','schedule',
            'totalPrincipal','totalInterest','totalCharges','totalEmi',
            'annualRate','interestType','periodName'
        ));
    }
    
    public function disbursment($id)
    {
        $application = LoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);       

        return view("gold-loan.applications.view-buttons.disburse-setting", compact('application'));
    }

    public function submitForApproval($id)
    {
        // Fetch the relevant model — change LoanApplication to appropriate model if many models share same button.
        $application = LoanApplication::findOrFail($id);

        // Do NOT change status. Only update updated_at to current time so it becomes "latest"
        // Option A: touch() updates updated_at automatically
        $application->touch();
        
        return redirect()->route('loans')
        ->with('success', 'Submitted for approval!');      
        
    }


}
