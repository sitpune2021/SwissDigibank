<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\BusinessLoanScheme;
use App\Models\BusinessProcessingFee;
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
            'input' => $request->all(),
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
                    'overdue_type' => 'nullable|string|max:50',
                    'overdue_interest_rate' => 'required_if:overdue_type,TYPE_1,TYPE_2|numeric|min:0',
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
                    'input' => $request->all(),
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
                'scheme_id' => 'required|exists:business_loan_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'tenure_months' => 'required|numeric|min:1',
                'tenure_type' => 'required|in:DAYS,WEEKS,MONTHS',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly,WEEKLY,BI_WEEKLY,4_WEEKLY,DAILY'
            ]);

            $scheme = BusinessLoanScheme::findOrFail($request->scheme_id);

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

        $chargePerEmiType = null;

        if (!$isManual && $scheme) {
            $chargePerEmiType = $scheme->charge_per_emi ?? 1; // default On EMI
        }

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
        return view('bussiness.calculator.result', [
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
            'charge_per_emi_type' => $chargePerEmiType,

        ]);
    }

    // same function use business and personal loan
    // public function calculateResult(Request $request)
    // {
    //     $isManual = $request->has('manual_interest_rate') && $request->manual_interest_rate != '';

    //     //  ADD HERE (Correct Location)
    //     $interestType = $request->interest_type;

    //     // ADD THIS EXACTLY HERE
    //     $interestAsEmi = $request->has('option_interest_emi') ? 'Yes' : '';
    //     $interestAsFirst = $request->has('option_interest_first') ? 'Yes' : '';

    //     // 🔥 If one is selected, hide the other
    //     if ($interestAsEmi === 'Yes') {
    //         $interestAsFirst = '';
    //     }

    //     if ($interestAsFirst === 'Yes') {
    //         $interestAsEmi = '';
    //     }
    //     // END
    //     // If both set, prefer interestAsFirst (mutually exclusive in UI ideally)
    //     if ($interestAsEmi === 'Yes' && $interestAsFirst === 'Yes') {
    //         // you can choose preferred behaviour; here we prioritize interestAsFirst
    //         $interestAsEmi = 'No';
    //     }
    //     //  END

    //     //  EMI Ratio Handling
    //     $ratioEnabled = ($request->ratio_enabled == 'Yes') ? 'Yes' : 'No';
    //     $ratioFirstEmi = $request->ratio_first_emi ?? null;
    //     $ratioFirstPercentage = $request->ratio_first_percentage ?? null;

    //     $isReducingWithRatio = ($interestType === 'reducing' && $ratioEnabled === 'Yes');


    //     // ---------------------------------------------
    //     // STEP 1: BASIC VALIDATION & SETUP
    //     // ---------------------------------------------
    //     if ($isManual) {
    //         $request->validate([
    //             'loan_amount' => 'required|numeric|min:1',
    //             'max_tenure' => 'required|integer|min:1',
    //             'manual_interest_rate' => 'required|numeric|min:0',
    //             'payout' => 'required|in:monthly,quarterly,half-yearly,yearly,weekly,bi_weekly,4_weekly,daily',
    //         ]);

    //         $loan = (float) $request->loan_amount;
    //         $tenureMonths = (int) $request->max_tenure;
    //         $annualRate = (float) $request->manual_interest_rate;
    //         $payout = $request->payout;
    //         $interestType = strtolower($request->interest_type ?? 'flat_interest');

    //         $processingFee = (float) ($request->manual_processing_fee ?? 0);
    //         $stampAmount = round($loan * ((float) ($request->manual_stamp ?? 0)) / 100, 2);
    //         $insuranceAmount = round($loan * ((float) ($request->manual_insurance ?? 0)) / 100, 2);
    //         $processing_incl_gst = round($processingFee + ($processingFee * 0.18), 2);
    //         $stamp_incl_gst = round($stampAmount + ($stampAmount * 0.18), 2);

    //         $charge_per_emi_type = strtoupper($request->input('manual_charge_per_emi_type', 'ON PRINCIPAL'));
    //         if (!in_array($charge_per_emi_type, ['ON EMI', 'ON PRINCIPAL'])) {
    //             $charge_per_emi_type = 'ON PRINCIPAL';
    //         }

    //         $scheme = null;
    //     } else {
    //         $request->validate([
    //             'scheme_id' => 'required|exists:business_loan_schemes,id',
    //             'loan_amount' => 'required|numeric|min:1',
    //             'tenure_months' => 'required|integer|min:1',
    //             'payout' => 'required|in:monthly,quarterly,half-yearly,yearly,weekly,bi_weekly,4_weekly,daily',
    //         ]);

    //         $scheme = BusinessLoanScheme::findOrFail($request->scheme_id);

    //         $loan = (float) $request->loan_amount;
    //         $tenureMonths = (int) $request->tenure_months;
    //         $annualRate = (float) ($scheme->annual_interest_rate ?? 0);
    //         $payout = $request->payout;

    //         $charge_per_emi_type = (isset($scheme->charge_per_emi) && (int) $scheme->charge_per_emi === 1)
    //             ? 'ON EMI'
    //             : 'ON PRINCIPAL';

    //         $setting = strtolower(trim($scheme->gold_loan_setting ?? ''));
    //         switch ($setting) {
    //             case 'flat_advanced_interest':
    //             case 'flat advance interest':
    //                 $interestType = 'flat_advanced_interest';
    //                 break;
    //             case 'reducing_balance':
    //             case 'reducing emi':
    //             case 'reducing_emi':
    //                 $interestType = 'reducing_balance';
    //                 break;
    //             default:
    //                 $interestType = 'flat_interest';
    //         }

    //         $processingFee = (float) ($scheme->processing_fee ?? 0);
    //         $processing_incl_gst = round($processingFee + ($processingFee * 0.18), 2);

    //         $stampAmount = round($loan * ($scheme->stamp_duty_charge ?? 0) / 100, 2);
    //         $insuranceAmount = round($loan * ($scheme->insurance_fee ?? 0) / 100, 2);
    //         $stamp_incl_gst = round($stampAmount + ($stampAmount * 0.18), 2);
    //     }

    //     // ---------------------------------------------
    //     // STEP 2: EMI INSTALLMENTS CALCULATION
    //     // ---------------------------------------------
    //     $tenureType = strtoupper($request->tenure_type ?? 'MONTHS');

    //     if ($tenureType === 'MONTHS') {
    //         $monthsPerInstallment = match ($payout) {
    //             'monthly' => 1,
    //             'quarterly' => 3,
    //             'half-yearly' => 6,
    //             'yearly' => 12,
    //             default => 1,
    //         };
    //         $installments = (int) ceil($tenureMonths / $monthsPerInstallment);
    //     } elseif ($tenureType === 'WEEKS') {
    //         // Here $tenureMonths actually contains number of WEEKS (user input).
    //         // installments should be number of payout periods (weeks/groups of weeks)
    //         $weeksPerInstallment = match ($payout) {
    //             'weekly' => 1,
    //             'bi_weekly' => 2,
    //             '4_weekly' => 4,
    //             default => 1,
    //         };

    //         // IMPORTANT: use tenure value as weeks directly
    //         $installments = (int) max(1, ceil($tenureMonths / $weeksPerInstallment));
    //     } elseif ($tenureType === 'DAYS') {
    //         // Here $tenureMonths actually contains number of DAYS (user input).
    //         $daysPerInstallment = match ($payout) {
    //             'daily' => 1,
    //             default => 1,
    //         };

    //         // use tenure value as days directly
    //         $installments = (int) max(1, ceil($tenureMonths / $daysPerInstallment));
    //     } else {
    //         $installments = (int) ceil($tenureMonths);
    //     }

    //     // ---------------------------------------------
    //     // STEP 3: RATE PER INSTALLMENT
    //     // ---------------------------------------------
    //     $ratePerInstallment = match ($tenureType) {
    //         'MONTHS' => ($annualRate / 100) / 12,
    //         'WEEKS' => ($annualRate / 100) / 52,
    //         'DAYS' => ($annualRate / 100) / 365,
    //         default => ($annualRate / 100) / 12,
    //     };

    //     $schedule = [];
    //     $totalInterest = $totalCharges = 0;

    //     // ---------------------------------------------
    //     // STEP 4: EMI CALCULATION
    //     // ---------------------------------------------
    //     // ===== ADD THIS EXACTLY ABOVE flat_interest LOOP =====
    //     $addDateByTenure = function ($date, $i) use ($tenureType, $payout) {

    //         if ($tenureType === 'WEEKS') {
    //             $weeks = match ($payout) {
    //                 'weekly' => 1,
    //                 'bi_weekly' => 2,
    //                 '4_weekly' => 4,
    //                 default => 1,
    //             };
    //             return $date->copy()->addWeeks($i * $weeks);
    //         }

    //         if ($tenureType === 'DAYS') {
    //             return $date->copy()->addDays($i);
    //         }

    //         // default MONTHS
    //         return $date->copy()->addMonths($i);
    //     };

    //     /////////////////////////////////////////////////////////////////////////////////
    //     // Reducing EMI EMI CODE START
    //     // RATE PER INSTALLMENT (Reducing Balance)
    //     if ($tenureType === 'WEEKS') {

    //         if ($payout === 'bi_weekly') {
    //             $ratePerInstallment = ($annualRate / 100) / 26; // 🔥 BI-WEEKLY
    //             $weeksPerInstallment = 2;
    //         } elseif ($payout === '4_weekly') {
    //             $ratePerInstallment = ($annualRate / 100) / 13; // 🔥 4-WEEKLY
    //             $weeksPerInstallment = 4;
    //         } else {
    //             // WEEKLY
    //             $ratePerInstallment = ($annualRate / 100) / 52;
    //             $weeksPerInstallment = 1;
    //         }
    //     } elseif ($tenureType === 'DAYS') {

    //         $ratePerInstallment = ($annualRate / 100) / 365;  // 🔥 daily interest
    //         $daysPerInstallment = 1;
    //     } else {
    //         // MONTHLY / QUARTERLY / HALF-YEARLY / YEARLY
    //         if ($payout === 'yearly') {
    //             $ratePerInstallment = ($annualRate / 100);
    //             $monthsPerInstallment = 12;
    //         } elseif ($payout === 'half-yearly') {
    //             $ratePerInstallment = ($annualRate / 100) / 2;
    //             $monthsPerInstallment = 6;
    //         } elseif ($payout === 'quarterly') {
    //             $ratePerInstallment = ($annualRate / 100) / 4;
    //             $monthsPerInstallment = 3;
    //         } else {
    //             $ratePerInstallment = ($annualRate / 100) / 12;
    //             $monthsPerInstallment = 1;
    //         }
    //     }


    //     if ($interestType === 'reducing_balance') {
    //         $emi = round(($loan * $ratePerInstallment * pow(1 + $ratePerInstallment, $installments)) /
    //             (pow(1 + $ratePerInstallment, $installments) - 1), 2);
    //         $outstanding = $loan;

    //         for ($i = 1; $i <= $installments; $i++) {
    //             // EMI & Due date
    //             if ($tenureType === 'WEEKS') {
    //                 $emiDate = now()->copy()->addWeeks($i * $weeksPerInstallment);
    //             } elseif ($tenureType === 'DAYS') {
    //                 $emiDate = now()->copy()->addDays($i * $daysPerInstallment);
    //             } else {
    //                 $emiDate = now()->copy()->addMonths($i * $monthsPerInstallment);
    //             }
    //             $dueDate = $emiDate->copy()->addDay();

    //             $interest = round($outstanding * $ratePerInstallment, 2);
    //             $principal = round($emi - $interest, 2);
    //             $outstanding -= $principal;
    //             $balance = max(round($outstanding, 2), 0);

    //             // if no charges selected → no EMI charges
    //             if ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0) {
    //                 $charges = 0;
    //             } else {
    //                 $charges = ($charge_per_emi_type === 'ON EMI')
    //                     ? 207
    //                     : round(($loan * 0.02549) / $installments, 2);
    //             }

    //             $emiTotal = round($principal + $interest + $charges, 2);
    //             if ($interestAsEmi === 'Yes')
    //                 $principal = 0;

    //             $totalInterest += $interest;
    //             $totalCharges += $charges;

    //             $schedule[] = [
    //                 'no' => $i,
    //                 'emi_date' => $emiDate->format('d/m/Y'),
    //                 'due_date' => $dueDate->format('d/m/Y'),
    //                 'principal' => $principal,
    //                 'interest' => $interest,
    //                 'charges' => $charges,
    //                 'emi' => $emiTotal,
    //                 'balance' => $balance,
    //             ];
    //         }

    //         // Last principal adjustment
    //         if (!empty($schedule)) {
    //             $lastIndex = count($schedule) - 1;
    //             $schedule[$lastIndex]['balance'] = 0.00;
    //             $diff = round($loan - array_sum(array_column($schedule, 'principal')), 2);
    //             $schedule[$lastIndex]['principal'] += $diff;
    //         }
    //     }
    //     // Reducing EMI EMI CODE END


    //     /////////////////////////////////////////////////////////////////////////////////
    //     // flat_advanced_interest EMI CODE START
    //     elseif ($interestType === 'flat_advanced_interest') {


    //         if (!isset($startDate)) {
    //             $startDate = now();
    //         }

    //         $schedule = [];
    //         $outstanding = $loan;

    //         if ($tenureType === 'MONTHS') {
    //             // ✅ Monthly logic unchanged
    //             $principalPerEmi = round($loan / $installments, 2);

    //             if ($interestAsEmi === 'Yes') {
    //                 for ($i = 1; $i <= $installments; $i++) {
    //                     if ($payout === 'quarterly') {
    //                         $emiDate = $startDate->copy()->addMonths($i * 3);
    //                     } elseif ($payout === 'half-yearly') {
    //                         $emiDate = $startDate->copy()->addMonths($i * 6);
    //                     } else {
    //                         $emiDate = $startDate->copy()->addMonths($i);
    //                     }

    //                     $dueDate = $emiDate->copy()->addDay();

    //                     $principal = ($i == $installments) ? $outstanding : $principalPerEmi;

    //                     $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
    //                         ? 0
    //                         : ($charge_per_emi_type === 'ON EMI' ? 207 : round(($loan * 0.02549) / $installments, 2));

    //                     $outstanding -= $principal;

    //                     $schedule[] = [
    //                         'no' => $i,
    //                         'emi_date' => $emiDate->format('d/m/Y'),
    //                         'due_date' => $dueDate->format('d/m/Y'),
    //                         'principal' => round($principal, 2),
    //                         'interest' => 0,
    //                         'charges' => $charges,
    //                         'emi' => round($principal + $charges, 2),
    //                         'balance' => max(round($outstanding, 2), 0),
    //                     ];
    //                 }
    //             } else {
    //                 // Single row monthly (No)
    //                 $emiDate = $startDate->copy()->addMonths($tenureMonths);
    //                 $dueDate = $emiDate->copy()->addDay();

    //                 $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
    //                     ? 0
    //                     : ($charge_per_emi_type === 'ON EMI' ? 207 : round($loan * 0.02549, 2));

    //                 $schedule[] = [
    //                     'no' => 1,
    //                     'emi_date' => $emiDate->format('d/m/Y'),
    //                     'due_date' => $dueDate->format('d/m/Y'),
    //                     'principal' => round($loan, 2),
    //                     'interest' => 0,
    //                     'charges' => $charges,
    //                     'emi' => round($loan + $charges, 2),
    //                     'balance' => 0,
    //                 ];
    //             }
    //         } elseif ($tenureType === 'WEEKS') {
    //             $weeks = $installments;
    //             $schedule = [];
    //             $outstanding = $loan;

    //             if ($interestAsEmi === 'Yes') {
    //                 // Principal per week
    //                 $principalPerEmi = round($loan / $weeks, 2);

    //                 for ($i = 1; $i <= $weeks; $i++) {
    //                     $emiDate = $startDate->copy()->addWeeks($i);
    //                     $dueDate = $emiDate->copy()->addDay();

    //                     // Last EMI adjust
    //                     $principal = ($i == $weeks) ? $outstanding : $principalPerEmi;

    //                     // Charges per EMI
    //                     $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
    //                         ? 0
    //                         : ($charge_per_emi_type === 'ON EMI' ? 207 : round(($loan * 0.02549) / $weeks, 2));

    //                     $outstanding -= $principal;

    //                     $schedule[] = [
    //                         'no' => $i,
    //                         'emi_date' => $emiDate->format('d/m/Y'),
    //                         'due_date' => $dueDate->format('d/m/Y'),
    //                         'principal' => round($principal, 2),
    //                         'interest' => 0, // Interest = 0 for each EMI row
    //                         'charges' => $charges,
    //                         'emi' => round($principal + $charges, 2),
    //                         'balance' => max(round($outstanding, 2), 0),
    //                     ];
    //                 }
    //             } else {
    //                 // Single row weekly logic (jaise pehle tha)
    //                 $totalInterest = round($loan * ($annualRate / 100) * ($weeks / 52), 2);

    //                 $emiDate = $startDate->copy()->addWeeks($weeks);
    //                 $dueDate = $emiDate->copy()->addDay();

    //                 $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
    //                     ? 0
    //                     : ($charge_per_emi_type === 'ON EMI' ? 207 : round($loan * 0.02549, 2));

    //                 $schedule[] = [
    //                     'no' => 1,
    //                     'emi_date' => $emiDate->format('d/m/Y'),
    //                     'due_date' => $dueDate->format('d/m/Y'),
    //                     'principal' => round($loan, 2),
    //                     'interest' => $totalInterest,
    //                     'charges' => $charges,
    //                     'emi' => round($loan + $totalInterest + $charges, 2),
    //                     'balance' => 0,
    //                 ];
    //             }
    //         } elseif ($tenureType === 'DAYS') {
    //             if (!isset($startDate)) {
    //                 $startDate = now();
    //             }
    //             // 🔥 IMPORTANT FIX (ONLY HERE)
    //             $installments = 1;

    //             $schedule = [];
    //             $outstanding = $loan;

    //             // Equal daily principal
    //             $principalPerDay = floor($loan / $installments);
    //             $lastPrincipal = $loan - ($principalPerDay * ($installments - 1));

    //             // Charges per EMI
    //             $chargesPerEmi = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
    //                 ? 0
    //                 : ($charge_per_emi_type === 'ON EMI'
    //                     ? 207
    //                     : round(($loan * 0.02549) / $installments, 2)
    //                 );

    //             // =========================================
    //             // INTEREST AS EMI = YES
    //             // =========================================
    //             if ($interestAsEmi === 'Yes') {
    //                 for ($i = 1; $i <= $installments; $i++) {
    //                     $emiDate = $startDate->copy()->addDays($i);
    //                     $dueDate = $emiDate->copy()->addDay();

    //                     // principal distribution
    //                     if ($i == $installments) {
    //                         $principal = $lastPrincipal;   // last day adjustment
    //                     } else {
    //                         $principal = $principalPerDay;
    //                     }

    //                     $outstanding -= $principal;

    //                     $schedule[] = [
    //                         'no' => $i,
    //                         'emi_date' => $emiDate->format('d/m/Y'),
    //                         'due_date' => $dueDate->format('d/m/Y'),
    //                         'principal' => round($principal, 2),
    //                         'interest' => 0.00,
    //                         'charges' => round($chargesPerEmi, 2),
    //                         'emi' => round($principal + $chargesPerEmi, 2),
    //                         'balance' => max(round($outstanding, 2), 0),
    //                     ];
    //                 }
    //             }

    //             // =========================================
    //             // INTEREST AS EMI = NO (single row)
    //             // =========================================
    //             else {
    //                 // ✅ DAILY FLAT ADVANCED INTEREST
    //                 $dailyInterest = round(
    //                     $loan * ($annualRate / 100) * ($tenureMonths / 365),
    //                     2
    //                 );


    //                 $emiDate = $startDate->copy()->addDays(1);
    //                 $dueDate = $emiDate->copy()->addDay();

    //                 $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
    //                     ? 0
    //                     : ($charge_per_emi_type === 'ON EMI'
    //                         ? 207
    //                         : round($loan * 0.02549, 2)
    //                     );

    //                 $schedule[] = [
    //                     'no' => 1,
    //                     'emi_date' => $emiDate->format('d/m/Y'),
    //                     'due_date' => $dueDate->format('d/m/Y'),
    //                     'principal' => round($loan, 2),
    //                     'interest' => $dailyInterest,
    //                     'charges' => round($charges, 2),
    //                     'emi' => round($loan + $dailyInterest + $charges, 2),
    //                     'balance' => 0.00,
    //                 ];
    //             }
    //         }
    //     }
    //     // flat_advanced_interest EMI CODE END


    //     /////////////////////////////////////////////////////////////////////////////////
    //     // FLAT EMI CODE START
    //     else {

    //         // flat emi - monthly
    //         if (!isset($startDate)) {
    //             $startDate = now();
    //         }

    //         // Flat interest
    //         if ($tenureType === 'WEEKS') {
    //             $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 52), 0);
    //         } elseif ($tenureType === 'DAYS') {
    //             $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 365), 0);
    //         } else {
    //             $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12), 0);
    //         }

    //         $schedule = [];
    //         $outstanding = $loan;
    //         $installments = $installments;

    //         // ----------------------------------------------------
    //         // INTEREST TYPE = YES (your working logic)
    //         // ----------------------------------------------------
    //         // ===== WEEKLY FLAT EMI AMOUNT =====
    //         $emiAmount = round(($loan + $totalInterest) / $installments);

    //         if ($interestAsFirst === 'Yes') {

    //             // ================= ONLY FOR WEEKLY =================
    //             if ($tenureType === 'WEEKS') {

    //                 $emiAmount = round(($loan + $totalInterest) / $installments);

    //                 for ($i = 1; $i <= $installments; $i++) {

    //                     $emiDate = $addDateByTenure($startDate, $i);
    //                     $dueDate = $emiDate->copy()->addDay();

    //                     if ($i == 1) {
    //                         // FIRST EMI → interest only once
    //                         $interest = $totalInterest;
    //                         $principal = $emiAmount - $interest;
    //                     } else {
    //                         // REST EMI → principal only
    //                         $interest = 0;
    //                         $principal = $emiAmount;
    //                     }

    //                     // last EMI adjustment
    //                     if ($i == $installments) {
    //                         $principal = $outstanding;
    //                     }

    //                     $outstanding -= $principal;

    //                     $schedule[] = [
    //                         'no' => $i,
    //                         'emi_date' => $emiDate->format('d/m/Y'),
    //                         'due_date' => $dueDate->format('d/m/Y'),
    //                         'principal' => round($principal, 2),
    //                         'interest' => round($interest, 2),
    //                         'charges' => 0,
    //                         'emi' => round($principal + $interest, 2),
    //                         'balance' => max(round($outstanding, 2), 0),
    //                     ];
    //                 }
    //             }
    //             // ================= DAILY (NEW – SAME AS WEEKLY) =================
    //             elseif ($tenureType === 'DAYS') {
    //                 $emiAmount = round(($loan + $totalInterest) / $installments);

    //                 for ($i = 1; $i <= $installments; $i++) {
    //                     $emiDate = $addDateByTenure($startDate, $i);
    //                     $dueDate = $emiDate->copy()->addDay();

    //                     if ($i == 1) {
    //                         // FIRST EMI → interest only once
    //                         $interest = $totalInterest;
    //                         $principal = $emiAmount - $interest;
    //                     } else {
    //                         // REST EMI → principal only
    //                         $interest = 0;
    //                         $principal = $emiAmount;
    //                     }

    //                     // last EMI adjustment
    //                     if ($i == $installments) {
    //                         $principal = $outstanding;
    //                     }

    //                     $outstanding -= $principal;

    //                     $schedule[] = [
    //                         'no' => $i,
    //                         'emi_date' => $emiDate->format('d/m/Y'),
    //                         'due_date' => $dueDate->format('d/m/Y'),
    //                         'principal' => round($principal, 2),
    //                         'interest' => round($interest, 2),
    //                         'charges' => 0,
    //                         'emi' => round($principal + $interest, 2),
    //                         'balance' => max(round($outstanding, 2), 0),
    //                     ];
    //                 }
    //             }
    //             // ================= MONTHLY / OTHER (UNCHANGED) =================
    //             else {

    //                 // INTEREST SPLIT
    //                 $fullInterest = $totalInterest;
    //                 $secondInterest = round($fullInterest / 12);
    //                 $firstInterest = $fullInterest - $secondInterest;

    //                 // PRINCIPAL SPLIT
    //                 $principal_2 = floor($loan / 12);

    //                 $divider = ($installments - 2);
    //                 if ($divider <= 0) {
    //                     $principal_flat = 0;
    //                 } else {
    //                     $principal_flat = round(($loan - $principal_2) / $divider);
    //                 }

    //                 for ($i = 1; $i <= $installments; $i++) {

    //                     $emiDate = $addDateByTenure($startDate, $i);
    //                     $dueDate = $emiDate->copy()->addDay();


    //                     if ($i == 1) {
    //                         $principal = 0;
    //                         $interest = $firstInterest;
    //                     } elseif ($i == 2) {
    //                         $principal = $principal_2;
    //                         $interest = $secondInterest;
    //                     } elseif ($i == $installments) {
    //                         $principal = $outstanding;
    //                         $interest = 0;
    //                     } else {
    //                         $principal = $principal_flat;
    //                         $interest = 0;
    //                     }


    //                     $outstanding -= $principal;

    //                     $schedule[] = [
    //                         'no' => $i,
    //                         'emi_date' => $emiDate->format('d/m/Y'),
    //                         'due_date' => $dueDate->format('d/m/Y'),
    //                         'principal' => $principal,
    //                         'interest' => $interest,
    //                         'charges' => 0,
    //                         'emi' => $principal + $interest,
    //                         'balance' => max($outstanding, 0),
    //                     ];
    //                 }
    //             }
    //         }


    //         // ----------------------------------------------------
    //         // INTEREST TYPE = NO  (NEW SAMPLE LOGIC ADDED HERE)
    //         // ----------------------------------------------------
    //         else {

    //             // equal interest per EMI
    //             $interest_each = floor($totalInterest / $installments);
    //             $last_interest = $totalInterest - ($interest_each * ($installments - 1));

    //             // equal principal per EMI
    //             $principal_each = floor($loan / $installments);
    //             $last_principal = $loan - ($principal_each * ($installments - 1));

    //             for ($i = 1; $i <= $installments; $i++) {

    //                 $emiDate = $addDateByTenure($startDate, $i);
    //                 $dueDate = $emiDate->copy()->addDay();


    //                 if ($i == $installments) {
    //                     $principal = $last_principal;
    //                     $interest = $last_interest;
    //                 } else {
    //                     $principal = $principal_each;
    //                     $interest = $interest_each;
    //                 }
    //                 if ($interestAsEmi === 'Yes') {
    //                     if ($i == $installments) {
    //                         $principal = $outstanding;   // last EMI → full principal
    //                     } else {
    //                         $principal = 0;              // all previous → principal zero
    //                     }
    //                 }

    //                 $outstanding -= $principal;

    //                 $schedule[] = [
    //                     'no' => $i,
    //                     'emi_date' => $emiDate->format('d/m/Y'),
    //                     'due_date' => $dueDate->format('d/m/Y'),
    //                     'principal' => $principal,
    //                     'interest' => $interest,
    //                     'charges' => 0,
    //                     'emi' => $principal + $interest,
    //                     'balance' => max($outstanding, 0),
    //                 ];
    //             }
    //         }
    //     }
    //     // FLAT EMI CODE END

    //     // ---------------------------------------------
    //     // STEP 5: TOTALS
    //     // ---------------------------------------------
    //     $totalPrincipal = array_sum(array_column($schedule, 'principal'));
    //     $totalInterest = array_sum(array_column($schedule, 'interest'));
    //     $totalCharges = array_sum(array_column($schedule, 'charges'));
    //     $totalEmiSum = round($totalPrincipal + $totalInterest + $totalCharges, 2);
    //     $total_emi_paid = round($totalEmiSum, 2);

    //     $grandTotalPayable = round($loan + $totalInterest + $totalCharges + $processingFee + $stampAmount + $insuranceAmount, 2);
    //     $disbursedAmount = ($interestType === 'flat_advanced_interest') ? $loan - $totalInterest : $loan;

    //     $tenureType = strtoupper($request->tenure_type ?? 'MONTHS');

    //     $tenureUnit = match ($tenureType) {
    //         'MONTHS' => 'MONTHS',
    //         'WEEKS' => 'WEEKS',
    //         'DAYS' => 'DAYS',
    //         default => 'MONTHS',
    //     };

    //     //////////////////////////  flat emi - quarterly    /////////////////////////////
    //     // if (
    //     //     strtolower($interestType) === 'flat_interest' &&
    //     //     strtolower($payout) === 'quarterly' &&
    //     //     $interestAsFirst === 'Yes'
    //     // ) {

    //     //     if (!isset($startDate)) {
    //     //         $startDate = now();
    //     //     }

    //     //     // Total flat interest
    //     //     $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12), 0);

    //     //     $schedule = [];
    //     //     $outstanding = $loan;
    //     //     $quarters = $installments; // 4 EMI

    //     //     // -------------------------------------------
    //     //     // Principal split as per required pattern
    //     //     // -------------------------------------------
    //     //     $first_principal = round($loan * 0.175);     // 17,500 on 100000
    //     //     $other_principal = round(($loan - $first_principal) / ($quarters - 1));  // 27,500 each

    //     //     for ($i = 1; $i <= $quarters; $i++) {

    //     //         $emiDate = $startDate->copy()->addMonths($i * 3);
    //     //         $dueDate = $emiDate->copy()->addDay();

    //     //         if ($i == 1) {
    //     //             $principal = $first_principal;
    //     //             $interest  = $totalInterest; // full interest on 1st EMI
    //     //         } else {
    //     //             $principal = $other_principal;
    //     //             $interest  = 0;
    //     //         }

    //     //         $outstanding -= $principal;

    //     //         $schedule[] = [
    //     //             'no'        => $i,
    //     //             'emi_date'  => $emiDate->format('d/m/Y'),
    //     //             'due_date'  => $dueDate->format('d/m/Y'),
    //     //             'principal' => $principal,
    //     //             'interest'  => $interest,
    //     //             'charges'   => 0,
    //     //             'emi'       => $principal + $interest,
    //     //             'balance'   => max($outstanding, 0),
    //     //         ];
    //     //     }
    //     // }

    //     //////////////////////////  flat emi - half-yearly    /////////////////////////////
    //     // if (
    //     //     strtolower($interestType) === 'flat_interest' &&
    //     //     strtolower($payout) === 'half-yearly' &&
    //     //     $interestAsFirst === 'Yes'
    //     // ) {

    //     //     if (!isset($startDate)) {
    //     //         $startDate = now();
    //     //     }

    //     //     $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12), 0);

    //     //     $schedule = [];
    //     //     $outstanding = $loan;
    //     //     $emiCount = $installments; 

    //     //     $first_principal = round($loan * 0.45, 2);
    //     //     $last_principal  = $loan - $first_principal;

    //     //     // initialize totals
    //     //     $totalEmiSum = 0;
    //     //     $totalCharges = 0;

    //     //     for ($i = 1; $i <= $emiCount; $i++) {

    //     //         $emiDate = $startDate->copy()->addMonths($i * 6);
    //     //         $dueDate = $emiDate->copy()->addDay();

    //     //         if ($i == 1) {
    //     //             $principal = $first_principal;
    //     //             $interest  = $totalInterest;
    //     //         } else {
    //     //             $principal = $last_principal;
    //     //             $interest  = 0;
    //     //         }

    //     //         $outstanding -= $principal;

    //     //         // >>>>> FIX HERE <<<<<
    //     //         $totalEmiSum += ($principal + $interest);

    //     //         $schedule[] = [
    //     //             'no'        => $i,
    //     //             'emi_date'  => $emiDate->format('d/m/Y'),
    //     //             'due_date'  => $dueDate->format('d/m/Y'),
    //     //             'principal' => $principal,
    //     //             'interest'  => $interest,
    //     //             'charges'   => 0,
    //     //             'emi'       => $principal + $interest,
    //     //             'balance'   => max($outstanding, 0),
    //     //         ];
    //     //     }
    //     // }

    //     /////////////////////   flat emi - Yearly   /////////////////////////
    //     // if (
    //     //     strtolower($interestType) === 'flat_interest' &&
    //     //     strtolower($payout) === 'yearly' &&
    //     //     $interestAsFirst === 'Yes'
    //     // ) {

    //     //     if (!isset($startDate)) {
    //     //         $startDate = now();
    //     //     }

    //     //     // Total interest for the year
    //     //     $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12), 0);

    //     //     $schedule = [];
    //     //     $outstanding = $loan;

    //     //     // Yearly = always 1 EMI
    //     //     $emiCount = 1;

    //     //     // initialize totals
    //     //     $totalEmiSum = 0;
    //     //     $totalCharges = 0;

    //     //     for ($i = 1; $i <= $emiCount; $i++) {

    //     //         $emiDate = $startDate->copy()->addMonths($i * 12);
    //     //         $dueDate = $emiDate->copy()->addDay();

    //     //         // YEARLY CASE:
    //     //         $principal = $loan;     // entire principal in one EMI
    //     //         $interest  = 0;         // your example shows interest = 0

    //     //         $outstanding -= $principal;

    //     //         // Total EMI sum update
    //     //         $totalEmiSum += ($principal + $interest);

    //     //         $schedule[] = [
    //     //             'no'        => $i,
    //     //             'emi_date'  => $emiDate->format('d/m/Y'),
    //     //             'due_date'  => $dueDate->format('d/m/Y'),
    //     //             'principal' => $principal,
    //     //             'interest'  => $interest,
    //     //             'charges'   => 0,
    //     //             'emi'       => $principal + $interest,
    //     //             'balance'   => max($outstanding, 0),
    //     //         ];
    //     //     }
    //     // }


    //     // ---------------------------------------------
    //     // STEP 6: RETURN VIEW
    //     // ---------------------------------------------
    //     return view('bussiness.calculator.result', [
    //         'scheme' => $scheme,
    //         'is_manual' => $isManual,
    //         'loan' => $loan,
    //         'tenure_months' => $tenureMonths,
    //         'tenure_unit' => $tenureUnit,
    //         'payout' => $payout,
    //         'installments' => $installments,
    //         'interest_type' => ucfirst(str_replace('_', ' ', $interestType)),
    //         'annual_rate' => $annualRate,
    //         'charge_per_emi' => $charge_per_emi_type,
    //         'disburse_date' => now(),
    //         'processing_fee' => $processingFee,
    //         'processing_incl_gst' => $processing_incl_gst,
    //         'stamp_amount' => $stampAmount,
    //         'stamp_incl_gst' => $stamp_incl_gst,
    //         'insurance_amount' => $insuranceAmount,
    //         'schedule' => $schedule,
    //         'total_interest' => round($totalInterest, 2),
    //         'total_principal' => round($loan, 2),
    //         'total_charges' => round($totalCharges, 2),
    //         'total_emi_sum' => round($totalEmiSum, 2),
    //         'total_emi_paid' => $total_emi_paid,
    //         'grand_total_payable' => $grandTotalPayable,
    //         'disbursed_amount' => $disbursedAmount,
    //         'interest_as_emi' => $interestAsEmi,
    //         'interest_as_first' => $interestAsFirst,
    //         'ratio_enabled' => $request->ratio_enabled ?? 'No',
    //         'ratio_first_emi' => $request->ratio_first_emi ?? 0,
    //         'ratio_first_percentage' => $request->ratio_first_percentage ?? 0,
    //     ]);
    // }


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
        $members = Member::select('id', 'member_info_first_name', 'member_info_mobile_no', 'general_branch')->get();
        $branch = Branch::all();
        $scheme = BusinessLoanScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("bussiness.applications.create", compact('members', 'branch', 'scheme', 'banks'));
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
                'application_date' => 'required|date',
                'member_id' => 'required|exists:members,id',
                'branch_id' => 'required|exists:branches,id',
                'scheme_id' => 'required|exists:business_loan_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'purpose_of_loan' => 'required|string|max:255',
                'tenure_type' => 'required|string',
                'net_loan_amount' => 'required|numeric|min:1',
                'insurance_amount' => 'required|numeric|min:0',
                'credit_period' => 'required|numeric|min:1',
                'emi_collection' => 'required|string',
                'tenure_value' => 'required|numeric|min:1',
                'charge_per_emi' => 'required|in:0,1',
            ], [
                'application_date.required' => 'Please select the application date.',
                'member_id.required' => 'Please select a member.',
                'branch_id.required' => 'Please select a branch.',
                'scheme_id.required' => 'Please select a loan scheme.',
                'loan_amount.required' => 'Please enter the loan amount.',
                'loan_amount.numeric' => 'Loan amount must be a number.',
                'tenure_value.numeric' => 'Tenure value must be a number.',
                'purpose_of_loan.required' => 'Please enter the purpose of the loan.',
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
            // Ratio + Interest checkbox merge
            $request->merge([

                'ratio_enabled' => $request->has('divide_emi_ratio') ? 'Yes' : 'No',

                'ratio_first_emi' => $request->has('divide_emi_ratio')
                    ? $request->ratio_first_emi
                    : null,

                'ratio_first_percentage' => $request->has('divide_emi_ratio')
                    ? $request->ratio_first_percentage
                    : null,
            ]);

            Log::info('Validation passed successfully.');
        } catch (ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
            ]);

            return back()->withErrors($e->errors())->withInput();
        }



        $applicationDate = Carbon::createFromFormat(
            'd-m-Y',
            $request->application_date
        )->format('Y-m-d');

        $chequeDate = $request->cheque_date
            ? Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d')
            : null;

        $transferDate = $request->transfer_date
            ? Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d')
            : null;
        // 🔹 Fetch selected scheme
        $scheme = BusinessLoanScheme::find($request->scheme_id);

        $loanAmount = $request->loan_amount ?? 0;
        $processingPercent = $scheme->processing_fee ?? 0;

        // 🔹 Calculate processing fee
        $processingFee = ($loanAmount * $processingPercent) / 100;

        // 🔹 Optional GST (if needed 18%)
        $gstPercent = 18;
        $gstAmount = ($processingFee * $gstPercent) / 100;
        $totalProcessingFee = $processingFee + $gstAmount;

        // 🔹 Merge values into request
        $request->merge([
            'processing_fee_value' => $processingFee,
            'processing_fee_gst'   => $gstAmount,
            'processing_fee_total' => $totalProcessingFee,
        ]);

        Log::info('Processing Fee Calculated', [
            'loan_amount' => $loanAmount,
            'percent' => $processingPercent,
            'processing_fee' => $processingFee,
            'gst' => $gstAmount,
            'total' => $totalProcessingFee,
        ]);
        try {
            // Create record (Security fields removed, null sent instead)
            $loanApplication = BusinessLoanApplication::create([
                'application_date' => $applicationDate,
                'member_id' => $request->member_id,
                'co_applicant_1_id' => $request->co_applicant_1_id,
                'co_applicant_2_id' => $request->co_applicant_2_id,
                'branch_id' => $request->branch_id,
                'advisor_id' => $request->advisor_id,
                'guarantor_1_id' => $request->guarantor_1_id,
                'guarantor_2_id' => $request->guarantor_2_id,
                'guarantor_3_id' => $request->guarantor_3_id,
                'guarantor_4_id' => $request->guarantor_4_id,
                'scheme_id' => $request->scheme_id,
                'tenure_type' => $request->tenure_type,
                'tenure_value' => $request->tenure_value,
                'emi_collection' => $request->emi_collection,
                'credit_period' => $request->credit_period,
                'loan_amount' => $request->loan_amount,
                'insurance_amount' => $request->insurance_amount,
                'net_loan_amount' => $request->net_loan_amount,
                'purpose_of_loan' => $request->purpose_of_loan,
                'charge_per_emi' => $request->charge_per_emi,
                'processing_fee_value' => $request->processing_fee_value ?? 0,
                'processing_fee_gst' => $request->processing_fee_gst,
                'processing_fee_sgst' => $request->processing_fee_sgst,
                'processing_fee_cgst' => $request->processing_fee_cgst,
                'processing_fee_igst' => $request->processing_fee_igst,
                'processing_fee_total' => $request->processing_fee_total,
                'fee_mode' => $request->fee_mode,
                'bank_id' => $request->bank_id,
                'cheque_no' => $request->cheque_no,
                'cheque_date' => $chequeDate,
                'transfer_date' => $transferDate,
                'utr_no' => $request->utr_no,
                'transfer_mode' => $request->transfer_mode,
                'credited' => ($request->credited === 'yes' || $request->credited == 1) ? 1 : 0,
                'collect_principal_as_emi' => $request->collect_principal_as_emi ?? 0,
                'collect_advance_processing_fee' => $request->collect_advance_processing_fee ?? 0,
                'max_loan_amount' => $request->max_loan_amount ?? 0,
                'maximum_approvable_amount' => $request->maximum_approvable_amount ?? 0,
                'approved_loan_amount' => $request->approved_loan_amount ?? 0,
                // Security fields set to null (since removed from form)
                'ratio_enabled' => $request->ratio_enabled ?? 'No',
                'ratio_first_emi' => $request->ratio_first_emi,
                'ratio_first_percentage' => $request->ratio_first_percentage,
                'security_type' => null,
                'security_amount' => null,
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
                            'cibil_type' => $type,
                            'cibil_score' => $request->cibil_score[$index] ?? null,
                            'report_date' => isset($request->report_date[$index]) && !empty($request->report_date[$index])
                                ? Carbon::createFromFormat('d-m-Y', $request->report_date[$index])->format('Y-m-d')
                                : null,
                            // 'report_date' => isset($request->report_date[$index])
                            //     ? Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d')
                            //     : null,
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

            return redirect()->route('bussiness.applications.view', $loanApplication->id)
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
            'application',
            'members',
            'scheme',
            'branch',
            'banks'
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
                'member_id' => 'required|exists:members,id',
                'scheme_id' => 'required|exists:business_loan_schemes,id',
                'loan_amount' => 'required|numeric',
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

            // 🔧 ADDED: application_date conversion (DD-MM-YYYY → YYYY-MM-DD)
            if (!empty($inputData['application_date'])) {
                $inputData['application_date'] = \Carbon\Carbon::createFromFormat(
                    'd-m-Y',
                    $inputData['application_date']
                )->format('Y-m-d');
            }

            // Convert 'credited' value ('yes'/'no') to integer (1/0)
            if (isset($inputData['credited'])) {
                $inputData['credited'] = ($inputData['credited'] === 'yes' || $inputData['credited'] === '1') ? 1 : 0;
            }

            $updated = $application->update($inputData);


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
            $cibilTypes = $request->input('cibil_type', []);
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
                        'cibil_type' => $type,
                        'cibil_score' => $cibilScores[$index] ?? null,
                        'report_date' => $formattedDate,
                        'report_file' => $filePath,
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
        if ($tenure <= 0)
            $tenure = 1;

        /* Charges */
        // $processingFeeInc = floatval($application->processing_fee ?? 0);
        // $stampDutyInc     = floatval($application->stamp_duty ?? 0);
        // $insuranceInc     = floatval($application->insurance_fee ?? 0);
        // $fitnessInc       = floatval($application->fitness_fee ?? 0);

        // $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;
        /* Charges */
        $processingFeeInc = floatval($application->processing_fee ?? 0);
        $stampDutyInc = floatval($application->stamp_duty ?? 0);
        $insuranceInc = floatval($application->insurance_fee ?? 0);
        $fitnessInc = floatval($application->fitness_fee ?? 0);

        $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;

        /* EMI Type Logic: charge_per_emi = 1 => On EMI, 0 => On Principal */
        $chargeType = intval($application->scheme->charge_per_emi ?? 1);

        if ($chargeType === 1) {
            // Charges distributed across EMIs
            $chargesPerEmi = $tenure ? round($totalChargesInc / $tenure, 2) : 0;
        } else {
            // Charges deducted upfront (On Principal)
            $chargesPerEmi = 0;
            $loanAmount = max(0, $loanAmount - $totalChargesInc);
        }

        $chargesPerEmi = $tenure ? round($totalChargesInc / $tenure, 2) : 0;

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

            return view('bussiness.applications.view-buttons.show-emi-chart', compact(
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
        $totalInterest = array_sum(array_map(fn($r) => floatval($r['interest']), $schedule));
        $totalCharges = array_sum(array_map(fn($r) => floatval($r['charges_per_emi']), $schedule));
        $totalEmi = array_sum(array_map(fn($r) => floatval($r['emi']), $schedule));
        if ($interestType === 'no_emi') {
            $totalPrincipal = 0;
            $totalInterest = 0;
            $totalCharges = 0;
            $totalEmi = 0;
        }
        return view('bussiness.applications.view-buttons.show-emi-chart', compact(
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

    public function submitForApproval($id)
    {
        return redirect()->back()
            ->with('pending_request', true);
    }

    public function bussiness_process_fee($id)
    {
        $application = BusinessLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view("bussiness.applications.view-buttons.col_process_fee", compact('application', 'banks'));
    }

    public function bussinessstoreProcessFee(Request $request, $id)
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

        BusinessProcessingFee::create($data);

        return redirect()->route('bussiness.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }
}
