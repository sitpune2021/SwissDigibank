<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\PersonalScheme;
use App\Models\Member;
use App\Models\Branch;
use App\Models\Scheme;
use App\Models\PersonalLoanApplication;
use App\Models\Calculator;
use App\Models\MortgageProcessingFee;
use App\Models\PersonalCreditScore;
use Carbon\Carbon;
use App\Exports\LinePropertExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class PersonalController extends Controller
{
    
    public function index()
    {       
        $schemes = PersonalScheme::orderBy('id', 'desc')->paginate(10);
        return view("personal.schemes.index", compact('schemes'));
    } 
  
    public function create()
    {
        return view("personal.schemes.create");
    }

    public function store(Request $request)
    {
        Log::info('personal Scheme Store Started', [
            'input' => $request->all(),
            'user_id' => Auth::id(),
        ]);

        // Step 1: Validation (add new fields)
        $validated = $request->validate([
            'scheme_name' => 'required|string|max:255',
            'tenure' => 'required|string|max:255',
            'scheme_code' => 'required|string|max:50|unique:personal_schemes,scheme_code',
            'max_loan_amount' => 'required|numeric|min:1|max:200000',
            'annual_interest_rate' => 'required|numeric|min:0',
            'is_active' => 'required|in:0,1',
            'charge_per_emi' => 'required|in:0,1',

            // optional numeric fields (these will be saved if present)
            'overdue_interest_rate' => 'nullable|numeric',
            'overdue_type' => 'nullable|in:TYPE_1,TYPE_2', 
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
            'tenure.required' => 'Tenure type is required.',
            'annual_interest_rate.required' => 'Annual interest rate is required.',
            'max_loan_amount.max' => 'Maximum loan amount cannot exceed ₹2,00,000.',
        ]);

        try {
            DB::beginTransaction();

            // Create record directly with validated fields
            $scheme = PersonalScheme::create($validated);

            DB::commit();

            Log::info('personal Scheme Created Successfully', [
                'scheme_id' => $scheme->id,
            ]);

            return redirect()
                ->route('personal.schemes.index')
                ->with('success', 'Scheme created successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            Log::error('Error While Storing personal Scheme', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->with('error', 'Something went wrong! Please check log file.');
        }
    }

    public function show($id)
    {
        $scheme = PersonalScheme::findOrFail($id);
        return view('personal.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = PersonalScheme::findOrFail($id);
        return view('personal.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = PersonalScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('personal.schemes.index')
                        ->with('success', 'Scheme updated successfully!');
    }
  
    public function view($id)
    {
        $scheme = PersonalScheme::findOrFail($id);
        return view("personal.schemes.view", compact('scheme'));
    }


//////////////////////////////////////////////////////////////////////////////////////


    public function calculator()
    {
        $scheme = PersonalScheme::all();
        return view("personal.calculator.index", compact('scheme'));
    }

    // same function use business and personal loan
    public function calculateResult(Request $request)
    {
        $isManual = $request->has('manual_interest_rate') && $request->manual_interest_rate != '';
        
        //  ADD HERE (Correct Location)
        $interestType = $request->interest_type;

        // ADD THIS EXACTLY HERE
        $interestAsEmi = $request->has('option_interest_emi') ? 'Yes' : '';
        $interestAsFirst = $request->has('option_interest_first') ? 'Yes' : '';

        // 🔥 If one is selected, hide the other
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


        // ---------------------------------------------
        // STEP 1: BASIC VALIDATION & SETUP
        // ---------------------------------------------
        if ($isManual) 
        {
            $request->validate([
                'loan_amount' => 'required|numeric|min:1',
                'max_tenure' => 'required|integer|min:1',
                'manual_interest_rate' => 'required|numeric|min:0',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly,weekly,bi_weekly,4_weekly,daily',
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

            $charge_per_emi_type = strtoupper($request->input('manual_charge_per_emi_type', 'ON PRINCIPAL'));
            if (!in_array($charge_per_emi_type, ['ON EMI', 'ON PRINCIPAL'])) {
                $charge_per_emi_type = 'ON PRINCIPAL';
            }

            $scheme = null;
        } 
        else 
        {
            $request->validate([
                'scheme_id' => 'required|exists:personal_schemes,id',
                'loan_amount' => 'required|numeric|min:1',
                'tenure_months' => 'required|integer|min:1',
                'payout' => 'required|in:monthly,quarterly,half-yearly,yearly,weekly,bi_weekly,4_weekly,daily',
            ]);

            $scheme = PersonalScheme::findOrFail($request->scheme_id);

            $loan = (float) $request->loan_amount;
            $tenureMonths = (int) $request->tenure_months;
            $annualRate = (float) ($scheme->annual_interest_rate ?? 0);
            $payout = $request->payout;

            $charge_per_emi_type = (isset($scheme->charge_per_emi) && (int)$scheme->charge_per_emi === 1)
                ? 'ON EMI'
                : 'ON PRINCIPAL';

            $setting = strtolower(trim($scheme->gold_loan_setting ?? ''));
            switch ($setting) {
                case 'flat_advanced_interest':
                case 'flat advance interest':
                    $interestType = 'flat_advanced_interest';
                    break;
                case 'reducing_balance':
                case 'reducing emi':
                case 'reducing_emi':
                    $interestType = 'reducing_balance';
                    break;
                default:
                    $interestType = 'flat_interest';
            }

            $processingFee = (float) ($scheme->processing_fee ?? 0);
            $processing_incl_gst = round($processingFee + ($processingFee * 0.18), 2);

            $stampAmount = round($loan * ($scheme->stamp_duty_charge ?? 0) / 100, 2);
            $insuranceAmount = round($loan * ($scheme->insurance_fee ?? 0) / 100, 2);
            $stamp_incl_gst = round($stampAmount + ($stampAmount * 0.18), 2);
        }

        // ---------------------------------------------
        // STEP 2: EMI INSTALLMENTS CALCULATION
        // ---------------------------------------------
        $tenureType = strtoupper($request->tenure_type ?? 'MONTHS');

        if ($tenureType === 'MONTHS') 
        {
            $monthsPerInstallment = match ($payout) {
                'monthly' => 1,
                'quarterly' => 3,
                'half-yearly' => 6,
                'yearly' => 12,
                default => 1,
            };
            $installments = (int) ceil($tenureMonths / $monthsPerInstallment);
        } 
        elseif ($tenureType === 'WEEKS') 
        {
            // Here $tenureMonths actually contains number of WEEKS (user input).
            // installments should be number of payout periods (weeks/groups of weeks)
            $weeksPerInstallment = match ($payout) {
                'weekly' => 1,
                'bi_weekly' => 2,
                '4_weekly' => 4,
                default => 1,
            };

            // IMPORTANT: use tenure value as weeks directly
            $installments = (int) max(1, ceil($tenureMonths / $weeksPerInstallment));
        } 
        elseif ($tenureType === 'DAYS') 
        {
            // Here $tenureMonths actually contains number of DAYS (user input).
            $daysPerInstallment = match ($payout) {
                'daily' => 1,
                default => 1,
            };

            // use tenure value as days directly
            $installments = (int) max(1, ceil($tenureMonths / $daysPerInstallment));
        }
        else 
        {
            $installments = (int) ceil($tenureMonths);
        }

        // ---------------------------------------------
        // STEP 3: RATE PER INSTALLMENT
        // ---------------------------------------------
        $ratePerInstallment = match ($tenureType) {
            'MONTHS' => ($annualRate / 100) / 12,
            'WEEKS'  => ($annualRate / 100) / 52,
            'DAYS'   => ($annualRate / 100) / 365,
            default  => ($annualRate / 100) / 12,
        };

        $schedule = [];
        $totalInterest = $totalCharges = 0;

        // ---------------------------------------------
        // STEP 4: EMI CALCULATION
        // ---------------------------------------------
        // ===== ADD THIS EXACTLY ABOVE flat_interest LOOP =====
        $addDateByTenure = function ($date, $i) use ($tenureType, $payout) {

            if ($tenureType === 'WEEKS') {
                $weeks = match ($payout) {
                    'weekly'     => 1,
                    'bi_weekly'  => 2,
                    '4_weekly'   => 4,
                    default      => 1,
                };
                return $date->copy()->addWeeks($i * $weeks);
            }

            if ($tenureType === 'DAYS') {
                return $date->copy()->addDays($i);
            }

            // default MONTHS
            return $date->copy()->addMonths($i);
        };

        /////////////////////////////////////////////////////////////////////////////////
        // Reducing EMI EMI CODE START
        // RATE PER INSTALLMENT (Reducing Balance)
        if ($tenureType === 'WEEKS') {

            if ($payout === 'bi_weekly') {
                $ratePerInstallment = ($annualRate / 100) / 26; // 🔥 BI-WEEKLY
                $weeksPerInstallment = 2;
            }
            elseif ($payout === '4_weekly') {
                $ratePerInstallment = ($annualRate / 100) / 13; // 🔥 4-WEEKLY
                $weeksPerInstallment = 4;
            }
            else {
                // WEEKLY
                $ratePerInstallment = ($annualRate / 100) / 52;
                $weeksPerInstallment = 1;
            }

        }
        elseif ($tenureType === 'DAYS') {

            $ratePerInstallment = ($annualRate / 100) / 365;  // 🔥 daily interest
            $daysPerInstallment = 1;

        }
        else {
            // MONTHLY / QUARTERLY / HALF-YEARLY / YEARLY
            if ($payout === 'yearly') {
                $ratePerInstallment = ($annualRate / 100);
                $monthsPerInstallment = 12;
            }
            elseif ($payout === 'half-yearly') {
                $ratePerInstallment = ($annualRate / 100) / 2;
                $monthsPerInstallment = 6;
            }
            elseif ($payout === 'quarterly') {
                $ratePerInstallment = ($annualRate / 100) / 4;
                $monthsPerInstallment = 3;
            }
            else {
                $ratePerInstallment = ($annualRate / 100) / 12;
                $monthsPerInstallment = 1;
            }
        }


        if ($interestType === 'reducing_balance') 
        {
            $emi = round(($loan * $ratePerInstallment * pow(1 + $ratePerInstallment, $installments)) / 
                        (pow(1 + $ratePerInstallment, $installments) - 1), 2);
            $outstanding = $loan;

            for ($i = 1; $i <= $installments; $i++) 
            {
                // EMI & Due date
                if ($tenureType === 'WEEKS') {
                    $emiDate = now()->copy()->addWeeks($i * $weeksPerInstallment);
                } elseif ($tenureType === 'DAYS') {
                    $emiDate = now()->copy()->addDays($i * $daysPerInstallment);
                } else {
                    $emiDate = now()->copy()->addMonths($i * $monthsPerInstallment);
                }
                $dueDate = $emiDate->copy()->addDay();

                $interest = round($outstanding * $ratePerInstallment, 2);
                $principal = round($emi - $interest, 2);
                $outstanding -= $principal;
                $balance = max(round($outstanding, 2), 0);

                // if no charges selected → no EMI charges
                if ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0) {
                    $charges = 0;
                } else {
                    $charges = ($charge_per_emi_type === 'ON EMI')
                        ? 207
                        : round(($loan * 0.02549) / $installments, 2);
                }

                $emiTotal = round($principal + $interest + $charges, 2);
                if ($interestAsEmi === 'Yes') $principal = 0;

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

            // Last principal adjustment
            if (!empty($schedule)) {
                $lastIndex = count($schedule) - 1;
                $schedule[$lastIndex]['balance'] = 0.00;
                $diff = round($loan - array_sum(array_column($schedule, 'principal')), 2);
                $schedule[$lastIndex]['principal'] += $diff;
            }
        } 
        // Reducing EMI EMI CODE END

        
        /////////////////////////////////////////////////////////////////////////////////
        // flat_advanced_interest EMI CODE START
        elseif ($interestType === 'flat_advanced_interest') 
        {


            if (!isset($startDate)) {
                $startDate = now();
            }

            $schedule = [];
            $outstanding = $loan;

            if ($tenureType === 'MONTHS') {
                // ✅ Monthly logic unchanged
                $principalPerEmi = round($loan / $installments, 2);

                if ($interestAsEmi === 'Yes') {
                    for ($i = 1; $i <= $installments; $i++) {
                        if ($payout === 'quarterly') {
                            $emiDate = $startDate->copy()->addMonths($i * 3);
                        } elseif ($payout === 'half-yearly') {
                            $emiDate = $startDate->copy()->addMonths($i * 6);
                        } else {
                            $emiDate = $startDate->copy()->addMonths($i);
                        }

                        $dueDate = $emiDate->copy()->addDay();

                        $principal = ($i == $installments) ? $outstanding : $principalPerEmi;

                        $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
                            ? 0
                            : ($charge_per_emi_type === 'ON EMI' ? 207 : round(($loan * 0.02549) / $installments, 2));

                        $outstanding -= $principal;

                        $schedule[] = [
                            'no'        => $i,
                            'emi_date'  => $emiDate->format('d/m/Y'),
                            'due_date'  => $dueDate->format('d/m/Y'),
                            'principal' => round($principal, 2),
                            'interest'  => 0,
                            'charges'   => $charges,
                            'emi'       => round($principal + $charges, 2),
                            'balance'   => max(round($outstanding, 2), 0),
                        ];
                    }
                } else {
                    // Single row monthly (No)
                    $emiDate = $startDate->copy()->addMonths($tenureMonths);
                    $dueDate = $emiDate->copy()->addDay();

                    $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
                        ? 0
                        : ($charge_per_emi_type === 'ON EMI' ? 207 : round($loan * 0.02549, 2));

                    $schedule[] = [
                        'no'        => 1,
                        'emi_date'  => $emiDate->format('d/m/Y'),
                        'due_date'  => $dueDate->format('d/m/Y'),
                        'principal' => round($loan, 2),
                        'interest'  => 0,
                        'charges'   => $charges,
                        'emi'       => round($loan + $charges, 2),
                        'balance'   => 0,
                    ];
                }

            } 


            elseif ($tenureType === 'WEEKS') {
                $weeks = $installments;
                $schedule = [];
                $outstanding = $loan;

                if ($interestAsEmi === 'Yes') {
                    // Principal per week
                    $principalPerEmi = round($loan / $weeks, 2);

                    for ($i = 1; $i <= $weeks; $i++) {
                        $emiDate = $startDate->copy()->addWeeks($i);
                        $dueDate = $emiDate->copy()->addDay();

                        // Last EMI adjust
                        $principal = ($i == $weeks) ? $outstanding : $principalPerEmi;

                        // Charges per EMI
                        $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
                            ? 0
                            : ($charge_per_emi_type === 'ON EMI' ? 207 : round(($loan * 0.02549) / $weeks, 2));

                        $outstanding -= $principal;

                        $schedule[] = [
                            'no'        => $i,
                            'emi_date'  => $emiDate->format('d/m/Y'),
                            'due_date'  => $dueDate->format('d/m/Y'),
                            'principal' => round($principal, 2),
                            'interest'  => 0, // Interest = 0 for each EMI row
                            'charges'   => $charges,
                            'emi'       => round($principal + $charges, 2),
                            'balance'   => max(round($outstanding, 2), 0),
                        ];
                    }
                } else {
                    // Single row weekly logic (jaise pehle tha)
                    $totalInterest = round($loan * ($annualRate / 100) * ($weeks / 52), 2);

                    $emiDate = $startDate->copy()->addWeeks($weeks);
                    $dueDate = $emiDate->copy()->addDay();

                    $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
                        ? 0
                        : ($charge_per_emi_type === 'ON EMI' ? 207 : round($loan * 0.02549, 2));

                    $schedule[] = [
                        'no'        => 1,
                        'emi_date'  => $emiDate->format('d/m/Y'),
                        'due_date'  => $dueDate->format('d/m/Y'),
                        'principal' => round($loan, 2),
                        'interest'  => $totalInterest,
                        'charges'   => $charges,
                        'emi'       => round($loan + $totalInterest + $charges, 2),
                        'balance'   => 0,
                    ];
                }
            }

            elseif ($tenureType === 'DAYS') 
            {
                if (!isset($startDate)) {
                    $startDate = now();
                }
                // 🔥 IMPORTANT FIX (ONLY HERE)
                $installments = 1;

                $schedule = [];
                $outstanding = $loan;

                // Equal daily principal
                $principalPerDay = floor($loan / $installments);
                $lastPrincipal   = $loan - ($principalPerDay * ($installments - 1));

                // Charges per EMI
                $chargesPerEmi = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
                    ? 0
                    : ($charge_per_emi_type === 'ON EMI'
                        ? 207
                        : round(($loan * 0.02549) / $installments, 2)
                    );

                // =========================================
                // INTEREST AS EMI = YES
                // =========================================
                if ($interestAsEmi === 'Yes') 
                {
                    for ($i = 1; $i <= $installments; $i++) 
                    {
                        $emiDate = $startDate->copy()->addDays($i);
                        $dueDate = $emiDate->copy()->addDay();

                        // principal distribution
                        if ($i == $installments) {
                            $principal = $lastPrincipal;   // last day adjustment
                        } else {
                            $principal = $principalPerDay;
                        }

                        $outstanding -= $principal;

                        $schedule[] = [
                            'no'        => $i,
                            'emi_date'  => $emiDate->format('d/m/Y'),
                            'due_date'  => $dueDate->format('d/m/Y'),
                            'principal' => round($principal, 2),
                            'interest'  => 0.00,
                            'charges'   => round($chargesPerEmi, 2),
                            'emi'       => round($principal + $chargesPerEmi, 2),
                            'balance'   => max(round($outstanding, 2), 0),
                        ];
                    }
                }

                // =========================================
                // INTEREST AS EMI = NO (single row)
                // =========================================
                else 
                {
                    // ✅ DAILY FLAT ADVANCED INTEREST
                    $dailyInterest = round(
                        $loan * ($annualRate / 100) * ($tenureMonths / 365),
                        2
                    );

                    
                    $emiDate = $startDate->copy()->addDays(1);
                    $dueDate = $emiDate->copy()->addDay();

                    $charges = ($processingFee == 0 && $stampAmount == 0 && $insuranceAmount == 0)
                        ? 0
                        : ($charge_per_emi_type === 'ON EMI'
                            ? 207
                            : round($loan * 0.02549, 2)
                        );

                    $schedule[] = [
                        'no'        => 1,
                        'emi_date'  => $emiDate->format('d/m/Y'),
                        'due_date'  => $dueDate->format('d/m/Y'),
                        'principal' => round($loan, 2),
                        'interest'  => $dailyInterest,
                        'charges'   => round($charges, 2),
                        'emi' => round($loan + $dailyInterest + $charges, 2),
                        'balance'   => 0.00,
                    ];
                }
            }


        }
        // flat_advanced_interest EMI CODE END


        /////////////////////////////////////////////////////////////////////////////////
        // FLAT EMI CODE START
        else 
        {

            // flat emi - monthly
            if (!isset($startDate)) {
                $startDate = now();
            }

            // Flat interest
            if ($tenureType === 'WEEKS') {
                $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 52), 0);
            } elseif ($tenureType === 'DAYS') {
                $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 365), 0);
            } else {
                $totalInterest = round($loan * ($annualRate / 100) * ($tenureMonths / 12), 0);
            }

            $schedule = [];
            $outstanding = $loan;
            $installments = $installments;

            // ----------------------------------------------------
            // INTEREST TYPE = YES (your working logic)
            // ----------------------------------------------------
            // ===== WEEKLY FLAT EMI AMOUNT =====
            $emiAmount = round(($loan + $totalInterest) / $installments);

            if ($interestAsFirst === 'Yes') 
            {

                // ================= ONLY FOR WEEKLY =================
                    if ($tenureType === 'WEEKS') 
                    {

                        $emiAmount = round(($loan + $totalInterest) / $installments);

                        for ($i = 1; $i <= $installments; $i++) 
                        {

                            $emiDate = $addDateByTenure($startDate, $i);
                            $dueDate = $emiDate->copy()->addDay();

                            if ($i == 1) {
                                // FIRST EMI → interest only once
                                $interest  = $totalInterest;
                                $principal = $emiAmount - $interest;
                            } else {
                                // REST EMI → principal only
                                $interest  = 0;
                                $principal = $emiAmount;
                            }

                            // last EMI adjustment
                            if ($i == $installments) {
                                $principal = $outstanding;
                            }

                            $outstanding -= $principal;

                            $schedule[] = [
                                'no'        => $i,
                                'emi_date'  => $emiDate->format('d/m/Y'),
                                'due_date'  => $dueDate->format('d/m/Y'),
                                'principal' => round($principal, 2),
                                'interest'  => round($interest, 2),
                                'charges'   => 0,
                                'emi'       => round($principal + $interest, 2),
                                'balance'   => max(round($outstanding, 2), 0),
                            ];
                        }

                        
                    }
                    // ================= DAILY (NEW – SAME AS WEEKLY) =================
                    elseif ($tenureType === 'DAYS') 
                    {
                        $emiAmount = round(($loan + $totalInterest) / $installments);

                        for ($i = 1; $i <= $installments; $i++) 
                        {
                            $emiDate = $addDateByTenure($startDate, $i);
                            $dueDate = $emiDate->copy()->addDay();

                            if ($i == 1) {
                                // FIRST EMI → interest only once
                                $interest  = $totalInterest;
                                $principal = $emiAmount - $interest;
                            } else {
                                // REST EMI → principal only
                                $interest  = 0;
                                $principal = $emiAmount;
                            }

                            // last EMI adjustment
                            if ($i == $installments) {
                                $principal = $outstanding;
                            }

                            $outstanding -= $principal;

                            $schedule[] = [
                                'no'        => $i,
                                'emi_date'  => $emiDate->format('d/m/Y'),
                                'due_date'  => $dueDate->format('d/m/Y'),
                                'principal' => round($principal, 2),
                                'interest'  => round($interest, 2),
                                'charges'   => 0,
                                'emi'       => round($principal + $interest, 2),
                                'balance'   => max(round($outstanding, 2), 0),
                            ];
                        }
                    }
                    // ================= MONTHLY / OTHER (UNCHANGED) =================
                    else 
                    {

                        // INTEREST SPLIT
                        $fullInterest    = $totalInterest;
                        $secondInterest  = round($fullInterest / 12);
                        $firstInterest   = $fullInterest - $secondInterest;

                        // PRINCIPAL SPLIT
                        $principal_2 = floor($loan / 12);

                        $divider = ($installments - 2);
                        if ($divider <= 0) {
                            $principal_flat = 0; 
                        } else {
                            $principal_flat = round(($loan - $principal_2) / $divider);
                        }

                        for ($i = 1; $i <= $installments; $i++) {

                            $emiDate = $addDateByTenure($startDate, $i);
                            $dueDate = $emiDate->copy()->addDay();


                            if ($i == 1) {
                                $principal = 0;
                                $interest  = $firstInterest;

                            } elseif ($i == 2) {
                                $principal = $principal_2;
                                $interest  = $secondInterest;

                            } elseif ($i == $installments) {
                                $principal = $outstanding;
                                $interest  = 0;

                            } else {
                                $principal = $principal_flat;
                                $interest  = 0;
                            }
                            

                            $outstanding -= $principal;

                            $schedule[] = [
                                'no'        => $i,
                                'emi_date'  => $emiDate->format('d/m/Y'),
                                'due_date'  => $dueDate->format('d/m/Y'),
                                'principal' => $principal,
                                'interest'  => $interest,
                                'charges'   => 0,
                                'emi'       => $principal + $interest,
                                'balance'   => max($outstanding, 0),
                            ];
                        }
                    }
            }


            // ----------------------------------------------------
            // INTEREST TYPE = NO  (NEW SAMPLE LOGIC ADDED HERE)
            // ----------------------------------------------------
            else {

                // equal interest per EMI
                $interest_each = floor($totalInterest / $installments);
                $last_interest = $totalInterest - ($interest_each * ($installments - 1));

                // equal principal per EMI
                $principal_each = floor($loan / $installments);
                $last_principal = $loan - ($principal_each * ($installments - 1));

                for ($i = 1; $i <= $installments; $i++) {

                    $emiDate = $addDateByTenure($startDate, $i);
                    $dueDate = $emiDate->copy()->addDay();


                    if ($i == $installments) {
                        $principal = $last_principal;
                        $interest  = $last_interest;
                    } else {
                        $principal = $principal_each;
                        $interest  = $interest_each;
                    }
                    if ($interestAsEmi === 'Yes') {
                    if ($i == $installments) {
                        $principal = $outstanding;   // last EMI → full principal
                    } else {
                        $principal = 0;              // all previous → principal zero
                    }
                }

                    $outstanding -= $principal;

                    $schedule[] = [
                        'no'        => $i,
                        'emi_date'  => $emiDate->format('d/m/Y'),
                        'due_date'  => $dueDate->format('d/m/Y'),
                        'principal' => $principal,
                        'interest'  => $interest,
                        'charges'   => 0,
                        'emi'       => $principal + $interest,
                        'balance'   => max($outstanding, 0),
                    ];
                }
            }

        }
        // FLAT EMI CODE END

        // ---------------------------------------------
        // STEP 5: TOTALS
        // ---------------------------------------------
        $totalPrincipal = array_sum(array_column($schedule, 'principal'));
        $totalInterest = array_sum(array_column($schedule, 'interest'));
        $totalCharges = array_sum(array_column($schedule, 'charges'));
        $totalEmiSum = round($totalPrincipal + $totalInterest + $totalCharges, 2);
        $total_emi_paid = round($totalEmiSum, 2);

        $grandTotalPayable = round($loan + $totalInterest + $totalCharges + $processingFee + $stampAmount + $insuranceAmount, 2);
        $disbursedAmount = ($interestType === 'flat_advanced_interest') ? $loan - $totalInterest : $loan;

        $tenureType = strtoupper($request->tenure_type ?? 'MONTHS');

        $tenureUnit = match ($tenureType) {
            'MONTHS' => 'MONTHS',
            'WEEKS'  => 'WEEKS',
            'DAYS'   => 'DAYS',
            default  => 'MONTHS',
        };

       
        // ---------------------------------------------
        // STEP 6: RETURN VIEW
        // ---------------------------------------------
        return view('personal.calculator.result', [
            'scheme' => $scheme,
            'is_manual' => $isManual,
            'loan' => $loan,
            'tenure_months' => $tenureMonths,
            'tenure_unit' => $tenureUnit,
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
            'interest_as_emi' => $interestAsEmi,
            'interest_as_first' => $interestAsFirst,
            'ratio_enabled' => $request->ratio_enabled ?? 'No',
            'ratio_first_emi' => $request->ratio_first_emi ?? 0,
            'ratio_first_percentage' => $request->ratio_first_percentage ?? 0,
        ]);
    }


////////////////////////////////////////////////////////////////////////////////////////


    public function appindex()
    {
        //  loan applications fetch 
        $applications = PersonalLoanApplication::with(['creditScores'])->latest()->paginate(10);

        return view("personal.applications.index", compact('applications'));
    }

    public function appcreate() 
    {
        //$members = Member::all();
        $members = Member::select('id', 'member_info_first_name','member_info_mobile_no','general_branch')->get();
        $branch = Branch::all();
        $scheme = PersonalScheme::all();
        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']
        return view("personal.applications.create", compact('members','branch','scheme','banks'));
    }
   
    public function storeLoanApplication(Request $request)
    {
    Log::info('--- Loan Application Store Started ---', [
        'user_id' => Auth::id(),
        'input_data' => $request->all(),
    ]);

    try {
        // Step 1: Validate main fields
        $validated = $request->validate([
            'application_date'   => 'required|date_format:d-m-Y',
            'member_id'          => 'required|exists:members,id',
            'branch_id'          => 'required|exists:branches,id',
            'scheme_id'          => 'required|exists:personal_schemes,id',
            'loan_amount'        => 'required|numeric|min:1',
            'insurance_amount'   => 'required|numeric|min:0',
            'net_loan_amount'    => 'required|numeric|min:1',
            'tenure_type'        => 'required|string',
            'tenure_value'       => 'required|numeric|min:1',
            'emi_collection'     => 'required|string',
            'credit_period'      => 'required|numeric|min:1',
            'purpose_of_loan'    => 'required|string|max:255',
            // Optional (if not always sent)
            'total_security_amount' => 'nullable|numeric|min:0',
            'charges_per_emi_type' => 'required|in:ON EMI,ON PRINCIPAL',

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

        // Step 2: Convert application_date to MySQL format
        $formattedDate = Carbon::createFromFormat('d-m-Y', $request->application_date)->format('Y-m-d');
        $request->merge(['application_date' => $formattedDate]);

        // Step 3: Map total_security_amount → security_amount
        $securityAmount = $request->filled('total_security_amount') 
            ? $request->total_security_amount 
            : ($request->security_amount ?? 0);
        
        // Step 4: Create main loan application
        $loanApplication = PersonalLoanApplication::create([
            'application_date'            => $request->application_date,
            'member_id'                   => $request->member_id,
            'branch_id'                   => $request->branch_id,
            'scheme_id'                   => $request->scheme_id,
            'co_applicant_1_id'           => $request->co_applicant_1_id,
            'co_applicant_2_id'           => $request->co_applicant_2_id,
            'guarantor_1_id'              => $request->guarantor_1_id,
            'guarantor_2_id'              => $request->guarantor_2_id,
            'guarantor_3_id'              => $request->guarantor_3_id,
            'guarantor_4_id'              => $request->guarantor_4_id,
            'tenure_type'                 => $request->tenure_type,
            'tenure_value'                => $request->tenure_value,
            'emi_collection'              => $request->emi_collection,
            'credit_period'               => $request->credit_period,
            'loan_amount'                 => $request->loan_amount,
            'insurance_amount'            => $request->insurance_amount,
            'net_loan_amount'             => $request->net_loan_amount,
            'purpose_of_loan'             => $request->purpose_of_loan,
            'security_amount'             => $securityAmount,
            'securety_type'               => $request->securety_type ?? 'Property',
            'max_loan_amount'             => $request->max_loan_amount,
            'max_loan_limit'              => $request->max_loan_limit,
            'maximum_approvable_amount'   => $request->maximum_approvable_amount,
            'approved_loan_amount'        => $request->approved_loan_amount,
            'charges_per_emi_type' => $request->charges_per_emi_type,
            'created_by'                  => Auth::id(),
        ]);

        Log::info('Loan Application Created', ['loan_application_id' => $loanApplication->id]);

        // Step 5: Save CIBIL details if available
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

                    PersonalCreditScore::create([
                        'loan_application_id' => $loanApplication->id,
                        'cibil_type'          => $type,
                        'cibil_score'         => $request->cibil_score[$index] ?? null,
                        'report_date'         => $reportDate,
                        'report_file_path'    => $filePath,
                    ]);

                } catch (Exception $e) {
                    Log::warning('CIBIL Record Insert Failed', [
                        'index' => $index,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        Log::info('All Data Saved Successfully', ['loan_application_id' => $loanApplication->id]);

        return redirect()
            ->route('personal.applications.index')
            ->with('success', 'Loan application saved successfully.');

    } catch (Exception $e) {
        Log::error('Error while storing Loan Application', [
            'error_message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()->with('error', 'Something went wrong while saving the loan application.');
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
        $application = PersonalLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',  // <-- add scheme here
            'creditScores'
        ])->findOrFail($id);

        return view("personal.applications.view", compact('application'));
    }

    public function appedit($id)
    {
        $application = PersonalLoanApplication::with(['member', 'scheme', 'creditScores', 'properties'])->findOrFail($id);

        $members = Member::all();
        $schemes = PersonalScheme::all();
        $scheme  = PersonalScheme::all();
        $branch  = Branch::all();
        $banks   = Bank::pluck('name', 'id');

        return view('personal.applications.create', compact('application', 'members', 'schemes', 'branch', 'scheme', 'banks'));
    }

    public function appupdate(Request $request, $id)
    {
        // Step 1: Validate inputs
        $validated = $request->validate([
            'application_date' => 'required|date_format:d-m-Y',
            'member_id'        => 'required|exists:members,id',
            'scheme_id'        => 'required|exists:gold_loan_schemes,id',
            'loan_amount'      => 'required|numeric|min:1',
        ]);

        // Step 2: Find application
        $application = PersonalLoanApplication::findOrFail($id);

        // Step 3: Clean incoming data (exclude CIBIL + property fields)
        $data = $request->except(['cibil_type', 'cibil_score', 'report_date', 'report_file', 'properties']);

        // Step 4: Convert date fields (only if needed)
        $convertDate = fn($date) => !empty($date) && strpos($date, '-') === 2
            ? Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d')
            : $date;

        $data['application_date'] = $convertDate($data['application_date'] ?? null);
        if (!empty($data['cheque_date'])) $data['cheque_date'] = $convertDate($data['cheque_date']);
        if (!empty($data['transfer_date'])) $data['transfer_date'] = $convertDate($data['transfer_date']);

        // Step 5: Update application record
        $application->update($data);

        // Step 6: Update CIBIL reports
        $application->creditScores()->delete();

        if ($request->has('cibil_type')) {
            foreach ($request->cibil_type as $index => $type) {
                if (empty($type)) continue;

                $filePath = $request->hasFile("report_file.$index")
                    ? $request->file("report_file.$index")->store('uploads/cibil_reports', 'public')
                    : null;

                $reportDate = !empty($request->report_date[$index])
                    ? Carbon::createFromFormat('d/m/Y', $request->report_date[$index])->format('Y-m-d')
                    : null;

                $application->creditScores()->create([
                    'cibil_type'        => $type,
                    'cibil_score'       => $request->cibil_score[$index] ?? null,
                    'report_date'       => $reportDate,
                    'report_file_path'  => $filePath,
                ]);
            }
        }

        // Step 7: Update property details
        $application->properties()->delete();

        if ($request->has('properties') && is_array($request->properties)) {
            foreach ($request->properties as $prop) {
                $application->properties()->create($prop);
            }
        }

        // Step 8: Redirect success
        return redirect()
            ->route('personal.applications.view', $application->id)
            ->with('success', 'Application updated successfully.');
    }


//////////////////////////////////////////////////////////////////////////////////////


    public function emiChart($id)
    {
        $application = PersonalLoanApplication::with(['scheme', 'member', 'branch'])->findOrFail($id);

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
        // $processingFeeInc = floatval($application->processing_fee ?? 0);
        // $stampDutyInc     = floatval($application->stamp_duty ?? 0);
        // $insuranceInc     = floatval($application->insurance_fee ?? 0);
        // $fitnessInc       = floatval($application->fitness_fee ?? 0);

        // $totalChargesInc = $processingFeeInc + $stampDutyInc + $insuranceInc + $fitnessInc;
        /* Charges */
        $processingFeeInc = floatval($application->processing_fee ?? 0);
        $stampDutyInc     = floatval($application->stamp_duty ?? 0);
        $insuranceInc     = floatval($application->insurance_fee ?? 0);
        $fitnessInc       = floatval($application->fitness_fee ?? 0);

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

            return view('personal.applications.view-buttons.show-emi-chart', compact(
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
        return view('personal.applications.view-buttons.show-emi-chart', compact(
            'application','loanAmount','disburseDate',
            'processingFeeInc','stampDutyInc','insuranceInc','fitnessInc',
            'tenure','chargesPerEmi','schedule',
            'totalPrincipal','totalInterest','totalCharges','totalEmi',
            'annualRate','interestType','periodName'
        ));
    }

    public function personalcol_process_fee($id)
    {
        $application = PersonalLoanApplication::with([
            'member',
            'coApplicant1',
            'guarantor1',
            'scheme',
            'creditScores'
        ])->findOrFail($id);

        $banks = Bank::pluck('name', 'id'); // ['id' => 'name']

        return view("personal.applications.view-buttons.col_process_fee", compact('application','banks'));
    }

    public function personalstoreProcessFee(Request $request, $id)
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

        MortgageProcessingFee::create($data);

        return redirect()->route('personal.applications.view', $id)->with('success', 'Processing Fee Collected Successfully!');
    }

    public function submitForApproval($id)
    {
        // Fetch the relevant model — change LoanApplication to appropriate model if many models share same button.
        $application = PersonalLoanApplication::findOrFail($id);

        // Do NOT change status. Only update updated_at to current time so it becomes "latest"
        // Option A: touch() updates updated_at automatically
        $application->touch();
        
        return redirect()->route('loans')
        ->with('success', 'Submitted for approval!');      
        
    }

    
}
