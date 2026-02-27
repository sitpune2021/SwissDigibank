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

    // same function Gold, Mortgage, Loanagainst, Vehical
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
        // $interestAsEmi = $request->has('option_interest_emi') ? 'Yes' : 'No';
        // $interestAsFirst = $request->has('option_interest_first') ? 'Yes' : 'No';
        // ADD THIS EXACTLY HERE
        $interestAsEmi = $request->has('option_interest_emi') ? 'Yes' : '';
        $interestAsFirst = $request->has('option_interest_first') ? 'Yes' : '';

        // If one is selected, hide the other
        if ($interestAsEmi === 'Yes') {
            $interestAsFirst = '';
        }

        if ($interestAsFirst === 'Yes') {
            $interestAsEmi = '';
        }
        // END
        // If both set, prefer interestAsFirst (mutually exclusive in UI ideally)
        if ($interestAsEmi === 'Yes' && $interestAsFirst === 'Yes') {
            // you can choose preferred behaviour; here we prioritize interestAsFirst
            $interestAsEmi = 'No';
        }
        //  END

        //  EMI Ratio Handling
        $ratioEnabled = ($request->ratio_enabled == 'Yes') ? 'Yes' : 'No';
        $ratioFirstEmi = $request->ratio_first_emi ?? null;
        $ratioFirstPercentage = $request->ratio_first_percentage ?? null;

        $isReducingWithRatio = ($interestType === 'reducing' && $ratioEnabled === 'Yes');

        if ($isManual) {

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
            $tenureDisplay = match ($rawTenureType) {
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
                'no_emi' => 'no_emi',
                default => 'flat_emi',
            };


            $processingFee  = (float) ($request->manual_processing_fee ?? 0);
            $stampAmount    = round($loan * ($request->manual_stamp ?? 0) / 100, 2);
            $insuranceAmount = round($loan * ($request->manual_insurance ?? 0) / 100, 2);

            $scheme         = null;
        } else {

            $request->validate([
                'scheme_id' => 'required|exists:loan_against_schemes,id',
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
            $tenureDisplay = match ($rawTenureType) {
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

        // keep raw inputs for accurate scheduling
        $rawTenureValue = (float) $rawTenureValue; // already set earlier from $request
        $rawTenureType = strtoupper($rawTenureType ?? 'MONTHS');

        // Normalize payout so comparisons are consistent
        $payout = strtolower($payout ?? 'monthly');
        $payout = str_replace(['-', ' '], '_', $payout); // e.g. half-yearly -> half_yearly
        $payout = str_replace('half_yearly', 'half-yearly', $payout);

        // Ensure tenureMonths is numeric (months value). keep for month-based fallback
        $tenureMonths = (float) $tenureMonths;

        // --- Prefer computing installments directly from user's raw unit (better precision) ---
        $installments = 0;

        // If user gave weeks directly, and payout is weekly → simply use weeks
        if ($rawTenureType === 'WEEKS' && in_array($payout, ['weekly'])) {
            $installments = max(1, (int) round($rawTenureValue));
        }
        // If raw is WEEKS but payout is bi-weekly (every 2 weeks) => installments = ceil(weeks/2)
        elseif ($rawTenureType === 'WEEKS' && in_array($payout, ['bi_weekly', 'bi-weekly'])) {
            $installments = max(1, (int) ceil($rawTenureValue / 2));
        }
        // If raw is WEEKS and payout is 4_weekly (every 4 wks)
        elseif ($rawTenureType === 'WEEKS' && in_array($payout, ['4_weekly', '4-weekly', '4weekly'])) {
            $installments = max(1, (int) ceil($rawTenureValue / 4));
        }
        // If raw is DAYS and payout = daily => days count
        elseif ($rawTenureType === 'DAYS' && in_array($payout, ['daily'])) {
            $installments = max(1, (int) round($rawTenureValue));
        }
        // If raw is DAYS and payout = weekly => ceil(days/7)
        elseif ($rawTenureType === 'DAYS' && in_array($payout, ['weekly'])) {
            $installments = max(1, (int) ceil($rawTenureValue / 7));
        }
        // If raw is MONTHS or fallback -> use months-based logic
        else {
            // month-based schedules: monthly, quarterly, half-yearly, yearly
            $monthsPerInstallment = match ($payout) {
                'monthly', 'month' => 1,
                'quarterly', 'quarter' => 3,
                'half-yearly', 'half_yearly', 'half-year' => 6,
                'yearly', 'year' => 12,
                'daily' => null,
                'weekly' => null,
                'bi_weekly' => null,
                '4_weekly' => null,
                default => 1,
            };

            if ($monthsPerInstallment === null) {
                // if payout is daily/weekly types but rawTenureType was not DAYS/WEEKS,
                // convert tenureMonths to appropriate installments:
                if (in_array($payout, ['daily'])) {
                    $installments = max(1, (int) ceil($tenureMonths * 30)); // approximate
                } elseif (in_array($payout, ['weekly'])) {
                    $installments = max(1, (int) ceil($tenureMonths * 4)); // approximate
                } elseif (in_array($payout, ['bi_weekly'])) {
                    $installments = max(1, (int) ceil($tenureMonths * 2)); // approx
                } elseif (in_array($payout, ['4_weekly', '4-weekly', '4weekly'])) {
                    $installments = max(1, (int) ceil($tenureMonths * 1)); // approx
                } else {
                    $installments = max(1, (int) ceil($tenureMonths / 1));
                }
            } else {
                if ($monthsPerInstallment <= 0) $monthsPerInstallment = 1;
                $installments = max(1, (int) ceil($tenureMonths / $monthsPerInstallment));
            }
        }


        $schedule = [];
        $startDate = now();
        $outstanding = $loan;

        /* -------------------------------------------------------
            CHARGES PER EMI (FROM SCHEME TABLE)
        ---------------------------------------------------------*/

        $chargesPerEmi = 0;

        if (!$isManual && $scheme) {

            $chargesPerEmi =
                (float)($scheme->sms_charge ?? 0) +
                (float)($scheme->fuel_charge ?? 0) +
                (float)($scheme->stationary_charge ?? 0) +
                (float)($scheme->maintenance_charge ?? 0) +
                (float)($scheme->collection ?? 0);
        }


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

            // Force principal split always
            $remainingPrincipal = $loan;
            $principalPerEmi = round($loan / $installments, 2);

            for ($i = 1; $i <= $installments; $i++) {

                // EMI DATE
                if ($payout === 'daily') {
                    $emiDate = $startDate->copy()->addDays($i);
                } elseif ($payout === 'weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 7);
                } elseif ($payout === 'bi_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 14);
                } elseif ($payout === '4_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 28);
                } else {
                    $emiDate = $startDate->copy()->addMonths($i * $monthsPerInstallment);
                }

                $dueDate = $emiDate->copy()->addDay();

                // Always normal principal split
                $principal = ($i == $installments)
                    ? $remainingPrincipal
                    : $principalPerEmi;

                $balance = max($remainingPrincipal - $principal, 0);

                $schedule[] = [
                    'no'        => $i,
                    'emi_date'  => $emiDate->format('d/m/Y'),
                    'due_date'  => $dueDate->format('d/m/Y'),
                    'principal' => $principal,
                    'interest'  => 0,
                    'charges'   => 0,
                    'emi'       => $principal,
                    'balance'   => $balance,
                ];

                $remainingPrincipal -= $principal;
            }

            // Summary
            $total_principal = $loan;
            $total_interest  = 0;
            $total_emi_paid  = $loan;
        }


        /* -------------------------------------------------------
             4(B). FLAT EMI
        ---------------------------------------------------------*/

        if ($interestType === 'flat_emi') {

            $principalPerEmi = round($loan / $installments, 2);
            $interestPerEmi  = round($totalInterest / $installments, 2);

            for ($i = 1; $i <= $installments; $i++) {

                if ($payout === 'daily') {
                    $emiDate = $startDate->copy()->addDays($i);
                } elseif ($payout === 'weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 7);
                } elseif ($payout === 'bi_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 14);
                } elseif ($payout === '4_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 28);
                } else {
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
            FIX: FLAT EMI + INTEREST AS FIRST EMI (ALL PAYOUTS)
            1st EMI -> full interest
            Other EMI -> interest = 0
        ---------------------------------------------------------*/
        /* -------------------------------------------------------
            FLAT EMI + INTEREST AS FIRST EMI
            (1st EMI = principal + interest)
        ---------------------------------------------------------*/
        // this code as per nidhi bi_weekly

        if ($interestAsFirst === 'Yes' && $interestType === 'flat_emi' && strtolower($payout) === 'bi_weekly') {

            $installments = count($schedule);
            $loanAmount   = (float)$loan;
            $rate         = (float)$annualRate;
            $tenureMonths = (float)$tenureMonths;

            // TOTAL INTEREST (flat)
            $totalInterest = round($loanAmount * $rate / 100 * ($tenureMonths / 12), 2);

            // FIXED EMI
            $flatEmi = round(($loanAmount + $totalInterest) / $installments, 2);

            // Principal per EMI (2..n)
            $principalOther = $flatEmi;

            // First Principal
            $principal1 = round($loanAmount - ($principalOther * ($installments - 1)), 2);

            // First Interest = EMI - first principal
            //$interest1 = round($flatEmi - $principal1, 2);
            // 1st EMI must take EXACT total interest
            $interest1   = $totalInterest;

            // Now recompute principal1 so EMI stays accurate
            $principal1  = round($flatEmi - $interest1, 2);

            $remaining = $loanAmount;

            foreach ($schedule as $i => $row) {

                $emiNo = $row['no'];

                if ($emiNo == 1) {

                    // FIRST EMI
                    $schedule[$i]['principal'] = $principal1;
                    $schedule[$i]['interest']  = $interest1;
                    $schedule[$i]['emi']       = $flatEmi;

                    $remaining -= $principal1;
                } else {

                    // OTHER EMIs = principal only
                    if ($emiNo == $installments) {
                        $principal = round($remaining, 2);
                    } else {
                        $principal = $principalOther;
                    }

                    $schedule[$i]['principal'] = $principal;
                    $schedule[$i]['interest']  = 0;
                    $schedule[$i]['emi']       = $flatEmi;

                    $remaining -= $principal;
                }

                // BALANCE UPDATE
                $schedule[$i]['balance'] = max(0, round($remaining, 2));
            }
        }

        // this code as per nidhi 4_weekly
        if ($interestAsFirst === 'Yes' && $interestType === 'flat_emi' && strtolower($payout) === '4_weekly') {

            $installments = count($schedule);
            $loanAmount   = (float)$loan;
            $rate         = (float)$annualRate;
            $tenureMonths = (float)$tenureMonths;

            // TOTAL INTEREST (flat)
            $totalInterest = round($loanAmount * $rate / 100 * ($tenureMonths / 12), 2);

            // FIXED EMI
            $flatEmi = round(($loanAmount + $totalInterest) / $installments, 2);

            // FIRST EMI takes exact total interest
            $interest1 = $totalInterest;

            // First principal = EMI - interest
            $principal1 = round($flatEmi - $interest1, 2);

            $remaining = $loanAmount;

            foreach ($schedule as $i => $row) {

                $emiNo = $row['no'];

                if ($emiNo == 1) {

                    // FIRST EMI
                    $schedule[$i]['principal'] = $principal1;
                    $schedule[$i]['interest']  = $interest1;
                    $schedule[$i]['emi']       = $flatEmi;

                    $remaining -= $principal1;
                } else {

                    // OTHER EMIs = principal only
                    if ($emiNo == $installments) {
                        $principal = round($remaining, 2);
                    } else {
                        $principal = $flatEmi;
                    }

                    $schedule[$i]['principal'] = $principal;
                    $schedule[$i]['interest']  = 0;
                    $schedule[$i]['emi']       = $flatEmi;

                    $remaining -= $principal;
                }

                // BALANCE UPDATE
                $schedule[$i]['balance'] = max(0, round($remaining, 2));
            }
        }


        // --- FIX: Reducing + Quarterly => EMI count = tenureMonths / 3 ---
        $total_principal = 0;
        $total_interest  = 0;
        $total_emi_paid  = 0;

        $totalInterestAll = 0;
        $total_charges = 0;


        /* -------------------------------------------------------
            4(C). REDUCING EMI — MULTI-PAYOUT SUPPORT
        ---------------------------------------------------------*/
        if ($interestType === 'reducing') {

            $schedule = [];
            $remaining = $loan;

            $isRatio = ($ratioEnabled === 'Yes' && in_array($payout, ['daily', 'weekly', 'bi_weekly', '4_weekly', 'monthly', 'quarterly', 'half-yearly', 'yearly']));
            $ratioEmiCount   = (int) $ratioFirstEmi;
            $ratioPercentage = (float) $ratioFirstPercentage;

            $ratioPrincipalTotal = round($loan * $ratioPercentage / 100, 2);
            $ratioPrincipalPerEmi = $ratioEmiCount > 0 ? round($ratioPrincipalTotal / $ratioEmiCount, 2) : 0;

            // Days per EMI mapping
            $daysPerEmi = match ($payout) {
                'daily'       => 1,
                'weekly'      => 7,
                'bi_weekly'   => 14,
                '4_weekly'    => 28,
                'monthly'     => 30,
                'quarterly'   => 91,
                'half-yearly' => 182,
                'yearly'      => 365,
                default       => 30,
            };

            // Interest rate per period
            $periodRate = ($annualRate / 100) * ($daysPerEmi / 365);

            for ($i = 1; $i <= $installments; $i++) {

                if ($isRatio && $i <= $ratioEmiCount) {
                    // First ratio EMI → fixed principal
                    $principal = $ratioPrincipalPerEmi;
                    $interest  = round($remaining * $periodRate, 2);
                } else {
                    // Remaining EMIs → split remaining principal equally
                    $remainingInstallments = $installments - $i + 1;
                    $principal = round($remaining / $remainingInstallments, 2);
                    $interest  = round($remaining * $periodRate, 2);
                }

                // Last EMI adjustment to avoid rounding issues
                if ($i == $installments) {
                    $principal = round($remaining, 2);
                    $interest  = round($remaining * $periodRate, 2);
                }

                $remaining -= $principal;

                $schedule[] = [
                    'no'        => $i,
                    'emi_date'  => now()->addDays($i * $daysPerEmi)->format('d/m/Y'),
                    'due_date'  => now()->addDays($i * $daysPerEmi + 1)->format('d/m/Y'),
                    'principal' => $principal,
                    'interest'  => $interest,
                    'charges'   => 0,
                    'emi'       => round($principal + $interest, 2),
                    'balance'   => max(0, round($remaining, 2)),
                ];
            }

            $total_principal = $loan;
            $total_emi_paid  = array_sum(array_map(fn($e) => $e['emi'], $schedule));
        }


        // ADD THIS LINE - FIX TOTAL INTEREST FOR REDUCING EMI
        if ($interestType === 'reducing') {
            $totalInterest = array_sum(array_column($schedule, 'interest'));
        }


        /* -------------------------------------------------------
            4(AA). NO EMI — Every EMI shows same principal only
        ---------------------------------------------------------*/ elseif (strtolower($interestType) === 'no_emi') {

            for ($i = 1; $i <= $installments; $i++) {

                // EMI Date
                if ($payout === 'daily') {
                    $emiDate = $startDate->copy()->addDays($i);
                } elseif ($payout === 'weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 7);
                } elseif ($payout === 'bi_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 14);
                } elseif ($payout === '4_weekly') {
                    $emiDate = $startDate->copy()->addDays($i * 28);
                } else {
                    $emiDate = $startDate->copy()->addMonths($i * $monthsPerInstallment);
                }

                $dueDate = $emiDate->copy()->addDay();

                $schedule[] = [
                    'no'        => $i,
                    'emi_date'  => $emiDate->format('d/m/Y'),
                    'due_date'  => $dueDate->format('d/m/Y'),
                    'principal' => round($loan, 2),   // SAME VALUE EVERY EMI
                    'interest'  => '',                // NO INTEREST
                    'charges'   => '',                // NO CHARGES
                    'emi'       => '',                // NO EMI
                    'balance'   => ''                 // ALWAYS EMPTY
                ];
            }
        }


        /* -------------------------------------------------------
            4(D). INTEREST AS EMI LOGIC (PRINCIPAL ZERO)
        ---------------------------------------------------------*/

        /* INTEREST AS EMI LOGIC (PRINCIPAL ZERO) */
        //if ($interestAsEmi === 'Yes' && $interestType !== 'flat_advanced') {
        if ($interestAsEmi === 'Yes' && $interestType === 'flat_emi') {

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
            IF INTEREST AS EMI = NO → ONLY ONE ROW (flat_advanced only)
        ---------------------------------------------------------*/

        if ($interestType === 'flat_advanced' && $interestAsEmi !== 'Yes') {

            if (!empty($schedule)) {

                // FINAL EMI DATE / DUE DATE use karenge
                $lastRow = end($schedule);

                // Replace full schedule with single row and force full loan
                $schedule = [
                    [
                        'no'        => 1,
                        'emi_date'  => $lastRow['emi_date'],
                        'due_date'  => $lastRow['due_date'],

                        // ⭐ SINGLE ROW CASE → FULL LOAN AS PRINCIPAL
                        'principal' => round($loan, 2),

                        'interest'  => 0,
                        'charges'   => 0,

                        // EMI = FULL LOAN
                        'emi'       => round($loan, 2),

                        // Balance = 0
                        'balance'   => 0,
                    ]
                ];
            }
        }


        /* -------------------------------------------------------
            4(F). INTEREST AS FIRST EMI LOGIC
        ---------------------------------------------------------*/

        /* ---------------------------------------------------------
                INTEREST AS FIRST EMI (FLAT EMI + QUARTERLY/HALF/YEARLY)
        ---------------------------------------------------------*/

        if (
            $interestAsFirst === 'Yes' &&
            $interestType === 'flat_emi' &&
            in_array(strtolower($payout), ['quarterly', 'half-yearly', 'yearly'])
        ) {
            $installments = (int)$installments;   // ex: 4
            $loanAmount   = (float)$loan;
            $rate         = (float)$annualRate;
            $tenureMonths = (int)$tenureMonths;

            // Total flat interest for whole tenure (e.g. 5000)
            $totalInterest = round($loanAmount * $rate / 100 * ($tenureMonths / 12), 2);

            // --- Compute flat EMI (so EMI stays same for each period) ---
            $flatEmi = ($loanAmount + $totalInterest) / max(1, $installments);
            $flatEmi = round($flatEmi, 2);

            // Principal parts:
            // - For "other" EMIs (principal-only rows) we'll use flatEmi (because interest = 0 there)
            // - For first EMI, principal = flatEmi - totalInterest
            $otherPrincipal = $flatEmi;
            $firstPrincipal = round($flatEmi - $totalInterest, 2);

            // Safety: if rounding caused tiny negative, clamp to 0
            if ($firstPrincipal < 0 && abs($firstPrincipal) < 0.01) {
                $firstPrincipal = 0.00;
            }

            $remaining = $loanAmount;

            // Reset previous values first (defensive)
            foreach ($schedule as $i => $row) {
                $schedule[$i]['principal'] = 0;
                $schedule[$i]['interest']  = 0;
                $schedule[$i]['emi']       = 0;
                $schedule[$i]['balance']   = 0;
            }

            // Rebuild schedule cleanly
            foreach ($schedule as $i => $row) {
                $emiNo = $i + 1;

                if ($emiNo === 1) {
                    // FIRST EMI: full interest + first principal (smaller)
                    $schedule[$i]['principal'] = $firstPrincipal;
                    $schedule[$i]['interest']  = $totalInterest;
                    $schedule[$i]['emi']       = round($firstPrincipal + $totalInterest, 2);

                    $remaining -= $firstPrincipal;
                } else {
                    // OTHER EMIs: principal only (= flatEmi), last EMI clears any rounding residue
                    if ($emiNo == $installments) {
                        $principal = round($remaining, 2);
                    } else {
                        $principal = $otherPrincipal;
                    }

                    $schedule[$i]['principal'] = $principal;
                    $schedule[$i]['interest']  = 0.00;
                    $schedule[$i]['emi']       = $principal;

                    $remaining -= $principal;
                }

                // ensure no tiny negative balance due to rounding
                $schedule[$i]['balance'] = round(max(0, $remaining), 2);
            }
        }

        ///////////////////////////////////////////////////////////////////////////////////////////////        

        /* -------------------------------------------------------
            APPLY CHARGES TO ALL EMI (EXCEPT NO EMI)
        ---------------------------------------------------------*/

        if (strtolower($interestType) !== 'no_emi') {

            foreach ($schedule as $k => $row) {

                $schedule[$k]['charges'] = $chargesPerEmi;

                // EMI me charges add karo
                if ($schedule[$k]['emi'] !== '' && $schedule[$k]['emi'] !== null) {
                    $schedule[$k]['emi'] = round(
                        (float)$schedule[$k]['emi'] + $chargesPerEmi,
                        2
                    );
                }
            }
        }


        // perefect only month show
        /* ---------------------------------------------------------
            PERFECT FIX — Flat EMI + Interest As First EMI (MONTHLY)
        ---------------------------------------------------------*/
        if (
            $interestAsFirst === 'Yes' &&
            $interestType === 'flat_emi' &&
            strtolower($payout) === 'monthly'
        ) {
            $installments = count($schedule);
            $loanAmount   = (float)$loan;
            $rate         = (float)$annualRate;
            $tenureMonths = (float)$tenureMonths;

            // Total interest
            $totalInterest = round($loanAmount * $rate / 100 * ($tenureMonths / 12), 2);

            // EMI amount
            $flatEmi = round(($loanAmount + $totalInterest) / $installments, 2);

            // Interest breakup (your expected pattern)
            // 1st EMI interest = flatEmi
            $interest1 = $flatEmi;

            // Remaining interest
            $interest2 = round($totalInterest - $interest1, 2);
            if ($interest2 < 0) $interest2 = 0;

            // Principal for remaining EMIs
            $principalForOthers = round($loanAmount / ($installments - 1), 2);

            $remaining = $loanAmount;

            foreach ($schedule as $i => $row) {
                $emiNo = $row['no'];

                if ($emiNo == 1) {

                    // 1st EMI → interest only
                    $schedule[$i]['principal'] = 0;
                    $schedule[$i]['interest']  = $interest1;
                    $schedule[$i]['emi']       = $flatEmi;
                    $schedule[$i]['balance']   = $remaining;
                } elseif ($emiNo == 2) {

                    // 2nd EMI → remaining interest + partial principal
                    $interest  = $interest2;
                    $principal = round($flatEmi - $interest, 2);

                    $schedule[$i]['principal'] = $principal;
                    $schedule[$i]['interest']  = $interest;
                    $schedule[$i]['emi']       = $flatEmi;

                    $remaining -= $principal;
                    $schedule[$i]['balance'] = round($remaining, 2);
                } else {

                    // 3rd EMI onward → principal = EMI (interest zero)
                    if ($emiNo == $installments) {
                        $principal = round($remaining, 2);
                    } else {
                        $principal = $flatEmi;
                    }

                    $schedule[$i]['principal'] = $principal;
                    $schedule[$i]['interest']  = 0;
                    $schedule[$i]['emi']       = $flatEmi;

                    $remaining -= $principal;
                    $schedule[$i]['balance'] = max(0, round($remaining, 2));
                }
            }
        }


        // only daily and weekly case perfect show as per nidhi
        if (
            $interestAsFirst === 'Yes' &&
            $interestType === 'flat_emi' &&
            in_array(strtolower($payout), ['daily', 'weekly'])
        ) {
            $installments = count($schedule);
            $loanAmount   = $loan;
            $rate         = $annualRate;
            $tenureMonths = $tenureMonths;

            // Total flat interest (example: 3,891.67)
            $totalInterest = round($loanAmount * $rate / 100 * ($tenureMonths / 12), 2);

            // Flat EMI (same for all)
            $flatEmi = round(($loanAmount + $totalInterest) / $installments, 2);

            $remaining = $loanAmount;

            foreach ($schedule as $i => $row) {

                $emiNo = $row['no'];

                if ($emiNo == 1) {

                    // ---- CHANGE: show TOTAL interest in first row (not per-installment) ----
                    $interest  = $totalInterest;                      // ← show totalInterest here (₹3,891.67)
                    $principal = round($flatEmi - $interest, 2);      // EMI - totalInterest

                    // safety: if principal became negative (rare), clamp to 0 and adjust interest to flatEmi
                    if ($principal < 0) {
                        $principal = 0.00;
                        $interest = $flatEmi; // first EMI cannot exceed EMI amount visually
                    }

                    $schedule[$i]['interest']  = $interest;
                    $schedule[$i]['principal'] = $principal;
                    $schedule[$i]['emi']       = $flatEmi;

                    $remaining -= $principal;
                } else {

                    // OTHER EMIs -> ONLY PRINCIPAL = flatEmi (last one adjust)
                    if ($emiNo == $installments) {
                        $principal = round($remaining, 2);
                        $schedule[$i]['emi'] = $principal;
                    } else {
                        $principal = $flatEmi;
                        $schedule[$i]['emi'] = $flatEmi;
                    }

                    $schedule[$i]['interest']  = 0;
                    $schedule[$i]['principal'] = $principal;

                    $remaining -= $principal;
                }

                $schedule[$i]['balance'] = max(0, round($remaining, 2));
            }
        }


        /////////////////////////////////////////////////////////////////////////////////////////////////       


        /* -------------------------------------------------------
             5. TOTAL PAYABLE
        ---------------------------------------------------------*/
        //$grandTotalPayable = $loan + $totalInterest + $processingFee + $stampAmount + $insuranceAmount;

        //$totalCharges = $chargesPerEmi * count($schedule);
        $totalCharges = array_sum(array_column($schedule, 'charges'));

        $grandTotalPayable =
            $loan
            + $totalInterest
            + $totalCharges
            + $processingFee
            + $stampAmount
            + $insuranceAmount;

        /* --------------------------------------------
        FINAL FIX — Ensure correct value after mapping
        ---------------------------------------------*/
        $isReducingWithRatio = ($interestType === 'reducing' && $ratioEnabled === 'Yes');


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

            'disburse_date' => now(),
            'processing_fee' => $processingFee,
            'stamp_amount' => $stampAmount,
            'insurance_amount' => $insuranceAmount,

            'schedule' => $schedule,

            'interest_as_emi' => $interestAsEmi,
            'interest_as_first' => $interestAsFirst,

            'tenure_display' => $tenureDisplay,
            'ratio_enabled' => $ratioEnabled,
            'ratio_first_emi' => $ratioFirstEmi,
            'ratio_first_percentage' => $ratioFirstPercentage,

            'isReducingWithRatio' => $isReducingWithRatio,
            'ratioFirstEmi' => $ratioFirstEmi,
            'ratioFirstPercentage' => $ratioFirstPercentage,

            'interestType' => $interestType,

            'total_interest' => round($totalInterest, 2),
            'total_principal' => $loan,
            //'total_emi_paid' => round(($interestType == 'flat_advanced' ? $loan : $loan + $totalInterest), 2),
            'total_emi_paid' => round(array_sum(array_column($schedule, 'emi')), 2),
            'grand_total_payable' => round($grandTotalPayable, 2),
            'total_charges' => round($totalCharges, 2),

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
        $members = Member::select('id', 'member_info_first_name', 'member_info_mobile_no', 'general_branch')->get();
        $branch = Branch::all();
        $scheme = LoanAgainstScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("loanagainst.applications.create", compact('members', 'branch', 'scheme', 'banks'));
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
        // Convert cheque_date (d-m-Y → Y-m-d)
        if ($request->filled('cheque_date')) {
            try {
                $originalChequeDate = $request->cheque_date;

                $convertedChequeDate = Carbon::createFromFormat('d-m-Y', $originalChequeDate)
                    ->format('Y-m-d');

                $request->merge([
                    'cheque_date' => $convertedChequeDate,
                ]);

                Log::info('Converted cheque_date successfully', [
                    'original'  => $originalChequeDate,
                    'converted' => $convertedChequeDate,
                    'user_id'   => Auth::id(),
                ]);
            } catch (\Exception $e) {
                Log::error('Invalid cheque_date format', [
                    'value'   => $request->cheque_date,
                    'user_id' => Auth::id(),
                    'error'   => $e->getMessage(),
                ]);
            }
        } else {
            Log::warning('cheque_date field is empty', [
                'user_id' => Auth::id(),
            ]);
        }
        // Convert transfer_date (d-m-Y → Y-m-d)
        if ($request->filled('transfer_date')) {
            try {
                $originalTransferDate = $request->transfer_date;

                $convertedTransferDate = Carbon::createFromFormat('d-m-Y', $originalTransferDate)
                    ->format('Y-m-d');

                $request->merge([
                    'transfer_date' => $convertedTransferDate,
                ]);

                Log::info('Converted transfer_date successfully', [
                    'original'  => $originalTransferDate,
                    'converted' => $convertedTransferDate,
                    'user_id'   => Auth::id(),
                ]);
            } catch (\Exception $e) {
                Log::error('Invalid transfer_date format', [
                    'value'   => $request->transfer_date,
                    'user_id' => Auth::id(),
                    'error'   => $e->getMessage(),
                ]);
            }
        } else {
            Log::warning('transfer_date field is empty', [
                'user_id' => Auth::id(),
            ]);
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

            $request->merge([

                // Interest collection options
                'interest_as_emi'   => $request->has('interest_as_emi') ? 'Yes' : null,
                'interest_as_first' => $request->has('interest_as_first') ? 'Yes' : null,

                // Ratio checkbox
                'ratio_enabled' => $request->has('divide_emi_ratio') ? 'Yes' : 'No',

                // Ratio values
                'ratio_first_emi' => $request->has('divide_emi_ratio')
                    ? $request->ratio_first_emi
                    : null,

                'ratio_first_percentage' => $request->has('divide_emi_ratio')
                    ? $request->ratio_first_percentage
                    : null,
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

            if ($request->filled('securety_type')) {
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
        // 🔹 Fetch selected scheme
        $scheme = LoanAgainstScheme::find($request->scheme_id);

        $loanAmount = $request->approved_loan_amount ?? $request->loan_amount ?? 0;
        $processingPercent = $scheme->processing_fee ?? 0;

        // 🔹 Calculate base processing fee
        $processingFee = ($loanAmount * $processingPercent) / 100;

        // 🔹 Calculate GST (18%)
        $gst = ($processingFee * 18) / 100;

        // 🔹 Final total
        $totalProcessingFee = $processingFee + $gst;

        // 🔹 Merge into request
        $request->merge([
            'processing_fee_value' => round($processingFee, 2),
            'processing_fee_gst'   => round($gst, 2),
            'processing_fee_total' => round($totalProcessingFee, 2),
        ]);

        Log::info('Processing Fee Calculated', [
            'loan_amount' => $loanAmount,
            'percent' => $processingPercent,
            'base_fee' => $processingFee,
            'gst' => $gst,
            'total' => $totalProcessingFee,
        ]);
     
        Log::info('Processing Fee Calculated', [
            'loan_amount' => $loanAmount,
            'percent' => $processingPercent,
            'processing_fee' => $processingFee,
        ]);
        // Step 3: Store data
        try {

            $data = $request->only([
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
            ]);

            // 🔥 Add ratio fields properly
            $data['ratio_enabled'] = $request->ratio_enabled ?? 'No';
            $data['ratio_first_emi'] = $request->ratio_first_emi;
            $data['ratio_first_percentage'] = $request->ratio_first_percentage;

            // 🔎 Debug once if needed

            $loanApplication = LoanAgainstApplication::create($data);

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

            return redirect()->route('loanagainst.applications.view', $loanApplication->id)
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
            'application',
            'members',
            'scheme',
            'branch',
            'banks'
        ));
    }

    public function appupdate(Request $request, $id)
    {
        // --- Normalize application_date ---
        if ($request->filled('application_date')) {
            try {
                $original = $request->application_date;

                $converted = Carbon::createFromFormat('d-m-Y', $original)
                    ->format('Y-m-d');

                $request->merge([
                    'application_date' => $converted,
                ]);

                Log::info('Converted application_date (UPDATE)', [
                    'application_id' => $id,
                    'original' => $original,
                    'converted' => $converted,
                    'user_id' => auth()->id(),
                ]);
            } catch (\Exception $e) {
                Log::error('Invalid application_date format (UPDATE)', [
                    'application_id' => $id,
                    'value' => $request->application_date,
                    'error' => $e->getMessage(),
                ]);

                return back()->with('error', 'Invalid application date format.');
            }
        }
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
                'scheme_id'        => 'required|exists:loan_against_schemes,id',
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

        // $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;
        // $chargesPerEmi = $tenure ? round($totalChargesInc / $tenure, 2) : 0;
        /* PER EMI CHARGES FROM SCHEME */
        $smsCharge        = floatval($application->scheme->sms_charge ?? 0);
        $fuelCharge       = floatval($application->scheme->fuel_charge ?? 0);
        $stationaryCharge = floatval($application->scheme->stationary_charge ?? 0);
        $maintenanceCharge = floatval($application->scheme->maintenance_charge ?? 0);
        $collectionCharge = floatval($application->scheme->collection ?? 0);

        $chargesPerEmi = round(
            $smsCharge +
                $fuelCharge +
                $stationaryCharge +
                $maintenanceCharge +
                $collectionCharge,
            2
        );


        /* Interest Rate */
        $annualRate = floatval($application->scheme->annual_interest_rate ?? 0);

        /* Collection Frequency */
        $collection = strtolower($application->emi_collection ?? 'monthly');
        switch ($collection) {
            case 'daily':
                $periodIncrement = 'addDay';
                $periodName = 'DAILY';
                $periodsPerYear = 365;
                break;
            case 'weekly':
                $periodIncrement = 'addWeek';
                $periodName = 'WEEKLY';
                $periodsPerYear = 52;
                break;
            default:
                $periodIncrement = 'addMonth';
                $periodName = 'MONTHLY';
                $periodsPerYear = 12;
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
                'application',
                'loanAmount',
                'disburseDate',
                'processingFeeInc',
                'stampDutyInc',
                'insuranceInc',
                'fitnessInc',
                'tenure',
                'chargesPerEmi',
                'schedule',
                'totalPrincipal',
                'totalInterest',
                'totalCharges',
                'totalEmi',
                'annualRate',
                'interestType',
                'periodName'
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
        $totalPrincipal = array_sum(array_map(fn($r) => floatval($r['principal']), $schedule));
        $totalInterest  = array_sum(array_map(fn($r) => floatval($r['interest']), $schedule));
        $totalCharges   = array_sum(array_map(fn($r) => floatval($r['charges_per_emi']), $schedule));
        $totalEmi       = array_sum(array_map(fn($r) => floatval($r['emi']), $schedule));
        if ($interestType === 'no_emi') {
            $totalPrincipal = 0;
            $totalInterest  = 0;
            $totalCharges   = 0;
            $totalEmi       = 0;
        }
        return view('loanagainst.applications.view-buttons.show-emi-chart', compact(
            'application',
            'loanAmount',
            'disburseDate',
            'processingFeeInc',
            'stampDutyInc',
            'insuranceInc',
            'fitnessInc',
            'tenure',
            'chargesPerEmi',
            'schedule',
            'totalPrincipal',
            'totalInterest',
            'totalCharges',
            'totalEmi',
            'annualRate',
            'interestType',
            'periodName'
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

        return view("loanagainst.applications.view-buttons.col_process_fee", compact('application', 'banks'));
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
                'cheque_date' => 'required',
            ]);
        }

        if ($request->fee_mode == 'online') {
            $request->validate([
                'transfer_date' => 'required',
                'utr_no' => 'required',
                'transfer_mode' => 'required|in:imps,vpa,neft_rtgs',
                'credited' => 'required|in:yes,no',
            ]);
        }

        // 🔥 UNIVERSAL DATE CONVERSION
        if (!empty($data['cheque_date'])) {
            $data['cheque_date'] = Carbon::createFromFormat('d-m-Y', $data['cheque_date'])->format('Y-m-d');
        }

        if (!empty($data['transfer_date'])) {
            $data['transfer_date'] = Carbon::createFromFormat('d-m-Y', $data['transfer_date'])->format('Y-m-d');
        }

        LoanagainstProcessingFee::create($data);

        return redirect()->route('loanagainst.applications.view', $id)
            ->with('success', 'Processing Fee Collected Successfully!');
    }
    public function submitForApproval($id)
    {
        return redirect()->back()
            ->with('pending_request', true);
    }

    // public function submitForApproval($id)
    // {
    //     $application = LoanAgainstApplication::findOrFail($id);

    //     $application->status = 1;
    //     $application->save();

    //     return redirect()->back()
    //         ->with('success', 'Submitted for approval.');
    // }
}
