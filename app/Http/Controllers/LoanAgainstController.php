<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\LoanAgainstScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\LoanAgainstApplication;
use App\Models\Calculator;
use App\Models\LoanCreditScore;
use App\Models\LoanagainstProcessingFee;
use Carbon\Carbon;
use App\Exports\LoanAgainstExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Validation\ValidationException;


class LoanAgainstController extends Controller
{
    
    public function index()
    {       
        //$schemes = LoanAgainstScheme::all();
        // paginate(10) => 10 records per page
        $schemes = LoanAgainstScheme::orderBy('id', 'desc')->paginate(10);
        return view("loanagainst.schemes.index", compact('schemes'));
    } 
  
    public function create()
    {
        return view("loanagainst.schemes.create");
    }

    public function store(Request $request)
    {
        Log::info('--- Loan Against Scheme Store Started ---', [
            'user_id' => auth()->id(),
            'input'   => $request->all(),
        ]);

        try {
            DB::beginTransaction();

            try {
                $validated = $request->validate([
                    'scheme_name' => 'required|string|max:255',
                    'scheme_code' => 'required|string|max:50|unique:loan_against_schemes,scheme_code',
                    'security_type' => 'required|string',
                    'max_loan_limit' => 'required|numeric|min:1',
                    'max_loan_amount' => 'required|numeric|min:1|max:200000',
                    'tenure' => 'required|integer|min:1',
                    'annual_interest_rate' => 'required|numeric|min:0',
                    'overdue_interest_rate' => 'required|numeric|min:0',
                    'is_active' => 'required|in:0,1',
                     // New fields (optional)
                    'penalty_charge' => 'nullable|numeric|min:0',
                    'processing_fee' => 'nullable|numeric|min:0',
                    'stamp_duty_charge' => 'nullable|numeric|min:0',
                    'insurance_fee' => 'nullable|numeric|min:0',
                    'fore_closer_charge' => 'nullable|numeric|min:0',
                    'credit_period' => 'nullable|integer|min:0',
                    'sms_charge' => 'nullable|numeric|min:0',
                    'fuel_charge' => 'nullable|numeric|min:0',
                    'stationary_charge' => 'nullable|numeric|min:0',
                    'gold_loan_setting' => 'nullable|string|max:255',
                    'maintenance_charge' => 'nullable|numeric|min:0',
                    'collection' => 'nullable|numeric|min:0',
                ], [
                    'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
                ]);

            } catch (ValidationException $e) {
                Log::warning('❌ Validation Failed in LoanAgainstScheme', [
                    'errors' => $e->errors(),
                    'input'  => $request->all(),
                ]);

                // ✅ Ye line Laravel ko redirect + error flash karne dega
                return back()->withErrors($e->errors())->withInput();
            }

            // ✅ Data store
            $scheme = LoanAgainstScheme::create($validated);

            DB::commit();

            Log::info('✅ Loan Against Scheme Created Successfully', [
                'scheme_id' => $scheme->id,
            ]);

            return redirect()
                ->route('loanagainst.schemes.index')
                ->with('success', 'Scheme created successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('❌ Error while storing Loan Against Scheme', [
                'message' => $e->getMessage(),
            ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }

    public function show($id)
    {
        $scheme = LoanAgainstScheme::findOrFail($id);
        return view('loanagainst.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = LoanAgainstScheme::findOrFail($id);
        return view('loanagainst.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = LoanAgainstScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('loanagainst.schemes.index')
                        ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = LoanAgainstScheme::findOrFail($id);
        return view("loanagainst.schemes.view", compact('scheme'));
    }


//////////////////////////////////////////////////////////////////////////////////


    public function calculator()
    {
        $scheme = LoanAgainstScheme::all();
        return view("loanagainst.calculator.index", compact('scheme'));
    }

    public function calculateResult(Request $request)
    {

        // Store raw user tenure selection for display (before conversion)
        $rawTenureValue = $request->tenure_months;
        $rawTenureType = $request->tenure_type;

        /* -------------------------------------------------------
            1. BASIC INPUT HANDLING
        ---------------------------------------------------------*/
        $isManual = $request->has('manual_interest_rate') && $request->manual_interest_rate != '';

       //  ADD HERE (Correct Location)
        $interestType = $request->interest_type;
        $interestAsEmi = $request->has('option_interest_emi') ? 'Yes' : 'No';
        $interestAsFirst = $request->has('option_interest_first') ? 'Yes' : 'No';
        //  END

        //  EMI Ratio Handling
        $ratioEnabled = $request->has('ratio_enabled') ? 'Yes' : 'No';
        $ratioFirstEmi = $request->ratio_first_emi ?? null;
        $ratioFirstPercentage = $request->ratio_first_percentage ?? null;

        $isReducingWithRatio = ($interestType === 'reducing' && $ratioEnabled === 'Yes');

        

        if ($isManual) 
        {

            $request->validate([
                'loan_amount' => 'required|numeric|min:1',
                'max_tenure' => 'required|numeric|min:1',
                'tenure_type' => 'required|in:DAYS,WEEKS,MONTHS',
                'manual_interest_rate' => 'required|numeric|min:0',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly,WEEKLY,BI_WEEKLY,4_WEEKLY,DAILY'
            ]);

            $loan         = (float) $request->loan_amount;
            $tenureMonths = (int) $request->max_tenure;
            // Convert Tenure (Days / Weeks / Months)
            $tenureType = $request->tenure_type ?? 'MONTHS';
            if ($tenureType === 'DAYS') {
                $tenureMonths = round($tenureMonths / 30, 2);
            } elseif ($tenureType === 'WEEKS') {
                $tenureMonths = round(($tenureMonths * 7) / 30, 2);
            }

            // Create Display Format (Human Friendly)
            $tenureDisplay = match($rawTenureType) {
                'DAYS' => $rawTenureValue . ' Days',
                'WEEKS' => $rawTenureValue . ' Weeks',
                'MONTHS' => $rawTenureValue . ' Months',
                default => $rawTenureValue . ' Months'
            };

            $annualRate   = (float) $request->manual_interest_rate;
            $payout       = $request->payout;

            // FIX — interest type manual mode me same ka same
            $interestTypeRaw = strtolower(trim($request->interest_type ?? 'flat_emi'));

            $interestType = match ($interestTypeRaw) {
                'reducing', 'reducing_emi' => 'reducing',
                'flat_advanced', 'flat_advance_interest' => 'flat_advanced',
                'flat_interest', 'flat_emi' => 'flat_emi',
                default => 'flat_emi',
            };


            $processingFee  = (float) ($request->manual_processing_fee ?? 0);
            $stampAmount    = round($loan * ($request->manual_stamp ?? 0) / 100, 2);
            $insuranceAmount= round($loan * ($request->manual_insurance ?? 0) / 100, 2);

            $scheme         = null;

        } 
        else 
        {

            $request->validate([
                'scheme_id' => 'required|exists:gold_loan_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'tenure_months' => 'required|numeric|min:1',
                'tenure_type' => 'required|in:DAYS,WEEKS,MONTHS',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly,WEEKLY,BI_WEEKLY,4_WEEKLY,DAILY'
            ]);

            $scheme = LoanAgainstScheme::findOrFail($request->scheme_id);

            $loan         = (float) $request->loan_amount;
            $tenureMonths = (int) $request->tenure_months;
            // Convert Tenure (Days / Weeks / Months)
            $tenureType = $request->tenure_type ?? 'MONTHS';

            if ($tenureType === 'DAYS') {
                $tenureMonths = round($tenureMonths / 30, 2);
            } elseif ($tenureType === 'WEEKS') {
                $tenureMonths = round(($tenureMonths * 7) / 30, 2);
            }

            // Create Display Format (Human Friendly)
            $tenureDisplay = match($rawTenureType) {
                'DAYS' => $rawTenureValue . ' Days',
                'WEEKS' => $rawTenureValue . ' Weeks',
                'MONTHS' => $rawTenureValue . ' Months',
                default => $rawTenureValue . ' Months'
            };

            $annualRate   = (float) $scheme->annual_interest_rate;
            $payout       = $request->payout;

            // FIX — Mapping cleaned
            $setting = strtolower($scheme->gold_loan_setting);

            $interestType = match ($setting) {
                'reducing_balance', 'reducing', 'reducing_emi' => 'reducing',
                'flat_advance_interest', 'flat_advanced_interest' => 'flat_advanced',
                'flat_interest' => 'flat_emi',
                default => 'flat_emi',
            };


            $processingFee   = (float) ($scheme->processing_fee ?? 0);
            $stampAmount     = round($loan * ($scheme->stamp_duty_charge ?? 0) / 100, 2);
            $insuranceAmount = round($loan * ($scheme->insurance_fee ?? 0) / 100, 2);
        }

        /* -------------------------------------------------------
            2. INSTALLMENT COUNT
        ---------------------------------------------------------*/

        $monthsPerInstallment = 1;
        // Normalize payout so comparisons are consistent
        $payout = strtolower($payout ?? 'monthly');

        // Convert common alternate tokens to normalized keys
        // (if your JS sends BI_WEEKLY or 4_WEEKLY in uppercase, they will be normalized here)
        $payout = str_replace(['-', ' '], '_', $payout); // e.g. "half-yearly" -> "half_yearly"
        $payout = str_replace('half_yearly', 'half-yearly', $payout); // keep original hyphen form for later match

        // Ensure tenureMonths is numeric (months value). It may be fractional when converted from weeks/days.
        $tenureMonths = (float) $tenureMonths;

        // Calculate installments robustly for every payout type
        if (in_array($payout, ['daily'])) {
            // approximate 30 days per month
            $installments = max(1, (int) ceil($tenureMonths * 30));
        } elseif (in_array($payout, ['weekly', 'weekly'])) {
            // approx 4 weeks per month
            $installments = max(1, (int) ceil($tenureMonths * 4));
        } elseif (in_array($payout, ['bi_weekly'])) {
            // 2 installments per month
            $installments = max(1, (int) ceil($tenureMonths * 2));
        } elseif (in_array($payout, ['4_weekly', '4-weekly', '4weekly'])) {
            // every 4 weeks -> approx 1 per month
            $installments = max(1, (int) ceil($tenureMonths * 1));
        } else {
            // month-based schedules: monthly, quarterly, half-yearly, yearly
            $monthsPerInstallment = match ($payout) {
                'monthly', 'month' => 1,
                'quarterly', 'quarter' => 3,
                'half-yearly', 'half_yearly', 'half-year' => 6,
                'yearly', 'year' => 12,
                default => 1,
            };

            // Prevent division by zero and ensure at least 1 installment
            if ($monthsPerInstallment <= 0) {
                $monthsPerInstallment = 1;
            }

            $installments = max(1, (int) ceil($tenureMonths / $monthsPerInstallment));
        }

        // FLAT ADVANCED override → always 1 EMI
        if ($interestType === 'flat_advanced') {
            $installments = 1;
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

            if ($payout === 'daily') {
                $emiDate = $startDate->copy()->addDays($installments);
            } elseif ($payout === 'weekly') {
                $emiDate = $startDate->copy()->addDays($installments * 7);
            } elseif ($payout === 'bi_weekly' || $payout === 'bi-weekly') {
                $emiDate = $startDate->copy()->addDays($installments * 14);
            } elseif ($payout === '4_weekly' || $payout === '4-weekly') {
                $emiDate = $startDate->copy()->addDays($installments * 28);
            } else {
                $emiDate = $startDate->copy()->addMonths($monthsPerInstallment);
            }

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

                if ($payout === 'daily') {
                    $emiDate = $startDate->copy()->addDays($i);
                }
                elseif ($payout === 'weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 7);
                }
                elseif ($payout === 'bi_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 14);
                }
                elseif ($payout === '4_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 28);
                }
                else {
                    $emiDate = $startDate->copy()->addMonths($i * $monthsPerInstallment);
                }

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
            4(D). INTEREST AS EMI LOGIC (PRINCIPAL ZERO)
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
        return view('loanagainst.calculator.result', [
            'scheme' => $scheme,
            'is_manual' => $isManual,
            'loan' => $loan,
            'tenure_months' => $tenureMonths,
            'payout' => $payout,
            'installments' => $installments,
            'interest_type' => ucfirst(str_replace('_', ' ', $interestType)),
            'annual_rate' => $annualRate,
            'tenure_display' => $tenureDisplay,
            'disburse_date' => now(),
            'processing_fee' => $processingFee,
            'stamp_amount' => $stampAmount,
            'insurance_amount' => $insuranceAmount,

            'schedule' => $schedule,

            'interest_as_emi' => $interestAsEmi,
            'interest_as_first' => $interestAsFirst,

            
            'ratio_enabled' => $ratioEnabled,
            'ratio_first_emi' => $ratioFirstEmi,
            'ratio_first_percentage' => $ratioFirstPercentage,

            'isReducingWithRatio' => $isReducingWithRatio,
            'ratioFirstEmi' => $ratioFirstEmi,
            'ratioFirstPercentage' => $ratioFirstPercentage,


            'total_interest' => round($totalInterest, 2),
            'total_principal' => $loan,
            'total_emi_paid' => round(($interestType == 'flat_advanced' ? $loan : $loan + $totalInterest), 2),
            'grand_total_payable' => round($grandTotalPayable, 2),
        ]);

    }

////////////////////////////////////////////////////////////////////////////////


    public function appindex()
    {
        // loan applications fetch with pagination
        $applications = LoanAgainstApplication::with(['creditScores'])
            ->latest()
            ->paginate(10); // 10 records

        return view("loanagainst.applications.index", compact('applications'));
    }

    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no','general_branch')->get();
        $branch = Branch::all();
        $scheme = LoanAgainstScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("loanagainst.applications.create", compact('members','branch','scheme','banks'));
    }
   
    public function storeLoanApplication(Request $request)
    {
        Log::info('--- Loan Against Deposite Application Store Started ---', [
            'user_id' => Auth::id(),
            'input_data' => $request->all(),
        ]);

        // Step 1: Convert application_date (d-m-Y → Y-m-d) before validation
        if ($request->filled('application_date')) {
            try {
                $convertedDate = Carbon::createFromFormat('d-m-Y', $request->application_date)->format('Y-m-d');
                $request->merge(['application_date' => $convertedDate]);
                Log::info('Converted application_date successfully', [
                    'original' => $request->application_date,
                    'converted' => $convertedDate,
                ]);
            } catch (Exception $e) {
                Log::error('Invalid application_date format', [
                    'value' => $request->application_date,
                    'error' => $e->getMessage(),
                ]);
            }
        } else {
            Log::warning('application_date field is empty');
        }

        // Step 2: Validation (with detailed logging)
        try {
            $validated = $request->validate([
                'application_date' => 'required|date',
                'member_id' => 'required|exists:members,id',
                'branch_id' => 'required|exists:branches,id',
                'scheme_id' => 'required|exists:loan_against_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'security_amount' => 'required|numeric|min:1',
                'purpose_of_loan' => 'required|string|max:255',
                'securety_type' => 'required|string',
                'tenure_type' => 'required|string',
                'net_loan_amount' => 'required|numeric|min:1',
                'insurance_amount' => 'required|numeric|min:0',
                'credit_period' => 'required|numeric|min:1',
                'emi_collection' => 'required|string',
                'tenure_value' => 'required|numeric|min:1',
            ], [
                'application_date.required' => 'Please select the application date.',
                'member_id.required' => 'Please select a member.',
                'branch_id.required' => 'Please select a branch.',
                'scheme_id.required' => 'Please select a loan scheme.',
                'loan_amount.required' => 'Please enter the loan amount.',
                'security_amount.required' => 'Please enter the security amount.',
                'loan_amount.numeric' => 'Loan amount must be a number.',
                'tenure_value.numeric' => 'Tenure value must be a number.',
                'purpose_of_loan.required' => 'Please enter the purpose of the loan.',
                'securety_type.required' => 'Please select the security type.',
                'tenure_type.required' => 'Please select the tenure type.',
                'emi_collection.required' => 'Please select the EMI collection.',
                'net_loan_amount.required' => 'Please enter Net Loan Amount.',
                'insurance_amount.required' => 'Please enter Insurance Amount.',
                'credit_period.required' => 'Please enter Credit Period.',
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

            Log::info('Validation passed successfully', [
                'validated_data' => $validated,
            ]);
           
            // ---------- Insert this block HERE (after validation passed) ----------
            /*
            * SECURITY CHECK:
            * 1. If security_type = fd_to_self → check fd_accounts table (FD_OF_SELF)
            * 2. If security_type = rd_to_self → check rd_accounts table (RD_OF_SELF)
            * 3. If security_type = dd_to_self → check dds_accounts table (DD_OF_SELF)
            * If the required account doesn’t exist, throw a validation error.
            */
           
            if ($request->filled('securety_type')) 
            {
                $scheme = DB::table('loan_against_schemes')->where('id', $request->scheme_id)->first();

                if (!$scheme) {
                    throw ValidationException::withMessages([
                        'scheme_id' => ['Selected scheme not found.']
                    ]);
                }

                $schemeSecurityType = strtoupper(trim($scheme->security_type ?? ''));

                // 🔸 FD check
                if ($request->securety_type === 'fd_to_self' && $schemeSecurityType === 'FD_OF_SELF') {
                    $exists = DB::table('fd_accounts')->where('member_id', $request->member_id)->exists();
                    if (!$exists) {
                        throw ValidationException::withMessages([
                            'member_id' => ['This customer does not have any FD account for the selected scheme.']
                        ]);
                    }
                }

                // 🔸 RD check
                if ($request->securety_type === 'rd_to_self' && $schemeSecurityType === 'RD_OF_SELF') {
                    $exists = DB::table('rd_accounts')->where('member_id', $request->member_id)->exists();
                    if (!$exists) {
                        throw ValidationException::withMessages([
                            'member_id' => ['This customer does not have any RD account for the selected scheme.']
                        ]);
                    }
                }

                // 🔸 DD check
                if ($request->securety_type === 'dd_to_self' && $schemeSecurityType === 'DD_OF_SELF') {
                    $exists = DB::table('dds_accounts')->where('member_id', $request->member_id)->exists();
                    if (!$exists) {
                        throw ValidationException::withMessages([
                            'member_id' => ['This customer does not have any DD account for the selected scheme.']
                        ]);
                    }
                }
            }

            // ---------- End block ----------


        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
                'input'  => $request->all(),
            ]);
            throw $e; // rethrow to show validation errors in UI
        }

        // Step 3: Store data
        try {
            $loanApplication = LoanAgainstApplication::create($request->only([
                'application_date',
                'member_id',
                'co_applicant_1_id',
                'co_applicant_2_id',
                'branch_id',
                'advisor_id',
                'securety_type',
                'security_amount',
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

            Log::info('Loan Against Deposit created successfully', [
                'loan_application_id' => $loanApplication->id,
            ]);

            // Step 4: Handle CIBIL details
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

                        Log::info('Saving CIBIL Entry', [
                            'loan_application_id' => $loanApplication->id,
                            'index' => $index,
                            'type' => $type,
                            'score' => $request->cibil_score[$index] ?? null,
                            'date' => $request->report_date[$index] ?? null,
                            'path' => $filePath,
                        ]);

                        $loanApplication->creditScores()->create([
                            'cibil_type'       => $type,
                            'cibil_score'      => $request->cibil_score[$index] ?? null,
                            'report_date'      => isset($request->report_date[$index])
                            ? Carbon::createFromFormat('d-m-Y', $request->report_date[$index])->format('Y-m-d') // ✅ Correct format
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

            return redirect()->route('loanagainst.applications.index')
                ->with('success', 'Loan Against Deposit Create successfully!');

        } catch (Exception $e) {
            Log::error('Error while storing Loan Against Deposit', [
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
        $application = LoanAgainstApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme'   // <-- add scheme here
        ])->findOrFail($id);

        return view("loanagainst.applications.view", compact('application'));
    }

    public function appedit($id)
    {
        $application = LoanAgainstApplication::with([
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
        $scheme = LoanAgainstScheme::all();
        $branch = Branch::all();
        $banks = Bank::pluck('name', 'id');

        return view('loanagainst.applications.create', compact(
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
            $application = LoanAgainstApplication::find($id);
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

            $updated = $application->update(
                $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file'])
            );

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
                ->route('loanagainst.applications.view', $application->id)
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
   

    public function linepropertyindex()
    {
        // loan applications fetch excluding status 1 and 0
        $applications = LoanAgainstApplication::with(['creditScores', 'branch', 'member'])
            ->whereNotIn('status', [1, 0])
            ->latest()
            ->paginate(15, ['id', 'status']);

        return view("loanagainst.lineproperty.index", compact('applications'));
    }

    public function exportLoanAgainst()
    {
        $fileName = "loan_against_export_" . now()->format('d-m-Y_H-i-s') . ".xls";

        //  loan_against_applications data fetch 
        $data = DB::table('loan_against_applications as laa')
            ->select('laa.id', 'laa.status')
            ->orderBy('laa.id', 'DESC')
            ->get();

        // Define Excel headers
        $headers = [
            'LOAN APPLICATION NO',
            'LOAN APPLICATION STATUS',
            'LIEN ACCOUNT TYPE',
            'LOAN ACCOUNT STATUS',
            'LIEN ACCOUNT STATUS',
            'LIEN ACCOUNT NUMBER',
            'LIEN ACCOUNT ASSIGNED',
        ];

        // HTTP headers for file download
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$fileName\"");
        header("Pragma: no-cache");
        header("Expires: 0");

        // Open output stream
        $file = fopen('php://output', 'w');

        // Write headings
        fputcsv($file, $headers, "\t");

        // Write data rows
        foreach ($data as $row) {
            $statusText = match ((int) $row->status) {
                0 => 'Draft',
                1 => 'Approved',
                2 => 'Disbursed',
                3 => 'Cancelled',
                default => 'Unknown',
            };

            fputcsv($file, [
                $row->id ?? '',
                $statusText,
                '-',  // LIEN ACCOUNT TYPE
                '-',  // LOAN ACCOUNT STATUS
                '-',  // LIEN ACCOUNT STATUS
                '-',  // LIEN ACCOUNT NUMBER
                'Yes' // LIEN ACCOUNT ASSIGNED (static)
            ], "\t");
        }

        fclose($file);
        exit;
    }


///////////////////////////////////////////////////////////////////////////////////
  

    public function emiChart($id)
    {
        $application = LoanAgainstApplication::with(['scheme', 'member', 'branch'])->findOrFail($id);

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

            return view('loanagainst.applications.view-buttons.show-emi-chart', compact(
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
        return view('loanagainst.applications.view-buttons.show-emi-chart', compact(
            'application','loanAmount','disburseDate',
            'processingFeeInc','stampDutyInc','insuranceInc','fitnessInc',
            'tenure','chargesPerEmi','schedule',
            'totalPrincipal','totalInterest','totalCharges','totalEmi',
            'annualRate','interestType','periodName'
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

    public function submitForApproval($id)
    {
        // Fetch the relevant model — change LoanApplication to appropriate model if many models share same button.
        $application = LoanAgainstApplication::findOrFail($id);

        // Do NOT change status. Only update updated_at to current time so it becomes "latest"
        // Option A: touch() updates updated_at automatically
        $application->touch();
        
        return redirect()->route('loans')
        ->with('success', 'Submitted for approval!');      
        
    }

    
}
