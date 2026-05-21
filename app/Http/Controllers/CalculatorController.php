<?php

namespace App\Http\Controllers;

use App\Models\FdSchemeSlab;
use Illuminate\Http\Request;
use App\Models\FdMaturityStatement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CalculatorController extends Controller
{


    private function roundToPrecision($number, $precision = 2)
    {
        return round($number, $precision);
    }

    public function index() 
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('calculator.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

    }

    public function create()
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('calculator.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

        return view('fd_account.calculator.create');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'open_date' => 'required|date',
            'principal' => 'required|numeric|min:1',
            'rate' => 'required|numeric|min:0',
            'tenure' => 'required|numeric|min:1',
            'tenure_type' => 'required|in:Months,Years',
            'interest_payout' => 'required',
            'bonus_type' => 'required|in:%,Fixed',
            'bonus_amount' => 'required|numeric|min:0',
        ]);

        $principal = $validated['principal'];
        $rate = $validated['rate'];
        $tenure = $validated['tenure'];
        $tenureType = $validated['tenure_type'];
        $interestPayout = $validated['interest_payout'];
        $bonusType = $validated['bonus_type'] ?? null;
        $bonusAmount = $validated['bonus_amount'] ?? 0;
        $startDate = Carbon::parse($validated['open_date']);
        $tdsRate = 0; // Set to 0 by default as in your screenshot

        // Convert tenure into months
        $totalMonths = $tenureType === 'Years' ? $tenure * 12 : $tenure;

        // Determine payout interval in months
        $intervals = [
            'Monthly' => 1,
            'Quarterly' => 3,
            'Half Yearly' => 6,
            'Yearly' => 12,
        ];

        $compoundingType = strtolower($interestPayout);

        $interestPeriods = [];
        $currentPrincipal = $principal;
        $totalInterest = 0;
        $totalTDS = 0;

        $i = 0;
        $currentDate = clone $startDate;

        while ($i < $totalMonths) {
            // Determine the interval
            $monthsToAdd = match (true) {
                str_contains($compoundingType, 'monthly') => 1,
                str_contains($compoundingType, 'quarterly') => 3,
                str_contains($compoundingType, 'half yearly') => 6,
                str_contains($compoundingType, 'yearly') => 12,
                default => $totalMonths - $i // For "On Maturity"
            };

            $periodStart = $currentDate->copy();
            $periodEnd = $currentDate->copy()->addMonths(min($monthsToAdd, $totalMonths - $i));
            $days = $periodStart->diffInDays($periodEnd);

            $periodRate = ($rate / 100) * ($days / 365);
            $interest = $currentPrincipal * $periodRate;
            $tds = $interest * ($tdsRate / 100);
            $netInterest = $interest - $tds;

            // Compound only for cumulative types
            if (str_contains($compoundingType, 'cumulative') || $compoundingType === 'on maturity') {
                $currentPrincipal += $netInterest;
            }

            $totalInterest += $interest;
            $totalTDS += $tds;

            $interestPeriods[] = [
                'fd_year' => floor($i / 12) + 1, // ✅ IMPORTANT
                'year' => Carbon::parse($periodStart)->year,
                'period' => $periodStart->format('d/m/Y') . ' - ' . $periodEnd->format('d/m/Y'),
                'days' => $days,
                'principal' => round($currentPrincipal, 2),
                'interest' => round($interest, 2),
                'tds' => round($tds, 2),
                'net_interest' => round($netInterest, 2),
                'principal_at_eoy' => ($i + $monthsToAdd) % 12 === 0 ? round($currentPrincipal, 2) : null,
                'due_by' => $periodEnd->format('d/m/Y'),
            ];

            $currentDate = $periodEnd;
            $i += $monthsToAdd;
        }

        // Maturity Bonus Calculation
        $maturityBonus = 0;
        if ($bonusType && $bonusAmount > 0) {
            $maturityBonus = $bonusType === '%' 
                ? $principal * ($bonusAmount / 100) 
                : $bonusAmount;
        }

        $totalAmountPayable = $currentPrincipal + $maturityBonus;

        // Store in session
        session([
            'fdStatement' => (object) [
                'principal' => $principal,
                'rate' => $rate,
                'tenure' => $tenure,
                'tenure_type' => $tenureType,
                'interest_payout' => $interestPayout,
                'bonus_type' => $bonusType,
                'bonus_amount' => $bonusAmount,
                'total_interest' => round($totalInterest, 2),
                'total_tds' => round($totalTDS, 2),
                'maturity_bonus' => round($maturityBonus, 2),
                'total_amount_payable' => round($totalAmountPayable, 2),
                'open_date' => $startDate->format('d/m/Y'),
            ],
            'interestPeriods' => $interestPeriods,
        ]);
    
        return redirect()
            ->back()
            ->with('success', 'FD maturity calculated and saved successfully!');
    }

    // AJAX entry - sanitize inputs, call calc function and return JSON
    public function calculateInvestmentAjax(Request $request)
    {
        // sanitize amount (remove commas/spaces) and cast
        $principal = (float) str_replace([',', ' '], '', $request->input('amount', 0));
        $rate      = (float) str_replace([',', ' '], '', $request->input('annual_interest_rate', 0));

        $tenureYears = (int) $request->input('tenure_year', 0);
        $tenureMonth = (int) $request->input('tenure_month', 0);
        $tenureDays  = (int) $request->input('tenure_day', 0);

        // convert total tenure to years as a float (e.g. 1y 6m => 1.5)
        $tenureTotalYears = $tenureYears + ($tenureMonth / 12) + ($tenureDays / 365);

        $startDate  = $request->input('open_date', Carbon::today()->toDateString());
        $payoutType = strtoupper($request->input('interest_payout_type', 'CUMULATIVE_YEARLY'));

        // call the calculation function (it returns a plain array)
        $results = $this->calculateInvestment('FD', $principal, $rate, $tenureTotalYears, $startDate, $payoutType);

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }

    public function getSchemes()
    {
        $schemes = DB::table('fd_schemes')->select('id', 'scheme_name')->get();

        return response()->json([
            'success' => true,
            'data' => $schemes
        ]);
    }

    public function getSchemeDetails($id)
    {
        $scheme = DB::table('fd_schemes')
            ->where('id', $id)
            ->where('is_active', 1)
            ->first();

        if (!$scheme) {
            return response()->json([
                'success' => false,
                'message' => 'Scheme not found'
            ]);
        }

        $slabs = FdSchemeSlab::where('fd_scheme_id', $id)
            ->orderBy('day_from')
            ->get();


        return response()->json([
            'success' => true,
            'scheme'  => $scheme,
            'slabs'   => $slabs
        ]);
    }

    // year wise tab show ad result
    public function calculateInvestment(
        $type = null,
        $principal = null,
        $rate = null,
        $tenureYears = null,
        $startDate = null,
        $payoutType = null
    ) {
        $principalFn  = (float) ($principal ?? 0);
        $rate         = (float) ($rate ?? 0);
        $tenureYears  = (float) ($tenureYears ?? 1);
        $startDate    = $startDate ?? Carbon::today()->toDateString();
        $payoutType   = strtoupper($payoutType ?? 'CUMULATIVE_YEARLY');

        $annualRate = $rate / 100.0;

        $totalInterest = 0;
        $maturityAmt   = 0;

        // ---------- Final maturity calculation ----------
        switch ($payoutType) {
            case "CUMULATIVE_YEARLY":
                $maturityAmt = $principalFn * pow((1 + ($annualRate / 1)), 1 * $tenureYears);
                break;
            case "CUMULATIVE_HALF_YEARLY":
                $maturityAmt = $principalFn * pow((1 + ($annualRate / 2)), 2 * $tenureYears);
                break;
            case "CUMULATIVE_QUARTERLY":
                $maturityAmt = $principalFn * pow((1 + ($annualRate / 4)), 4 * $tenureYears);
                break;
            case "CUMULATIVE_MONTHLY":
                $maturityAmt = $principalFn * pow((1 + ($annualRate / 12)), 12 * $tenureYears);
                break;
            default:
                $totalInterest = $principalFn * $annualRate * $tenureYears;
                $maturityAmt   = $principalFn + $totalInterest;
                break;
        }

        if (in_array($payoutType, ["CUMULATIVE_YEARLY","CUMULATIVE_HALF_YEARLY","CUMULATIVE_QUARTERLY","CUMULATIVE_MONTHLY"])) {
            $totalInterest = $maturityAmt - $principalFn;
        }

        // ---------- Year-wise breakdown ----------
        $details = [];
        $tempPrincipal = $principalFn;

        for ($year = 1; $year <= floor($tenureYears); $year++) 
        {
            // Ek saal ke liye maturity nikalo
            switch ($payoutType) 
            {
                case "CUMULATIVE_YEARLY":
                    $yearMaturity = $tempPrincipal * pow((1 + ($annualRate / 1)), 1);
                    break;
                case "CUMULATIVE_HALF_YEARLY":
                    $yearMaturity = $tempPrincipal * pow((1 + ($annualRate / 2)), 2);
                    break;
                case "CUMULATIVE_QUARTERLY":
                    $yearMaturity = $tempPrincipal * pow((1 + ($annualRate / 4)), 4);
                    break;
                case "CUMULATIVE_MONTHLY":
                    $yearMaturity = $tempPrincipal * pow((1 + ($annualRate / 12)), 12);
                    break;
                default:
                    $yearMaturity = $tempPrincipal + ($tempPrincipal * $annualRate);
                    break;
            }

            $interest = $yearMaturity - $tempPrincipal;
            $tds = 0; // अभी 0
            $netInterest = $interest - $tds;
            $bonus = 0; // अभी 0
            $maturity = $tempPrincipal + $netInterest + $bonus;

            $details[] = [
                'year'           => $year,
                'principal'      => number_format($tempPrincipal, 2, '.', ''),
                'interestEarned' => number_format($interest, 2, '.', ''),
                'tds'            => number_format($tds, 2, '.', ''),
                'netInterest'    => number_format($netInterest, 2, '.', ''),
                'bonus'          => number_format($bonus, 2, '.', ''),
                'maturity'       => number_format($maturity, 2, '.', ''),
                'date'           => Carbon::parse($startDate)->addYears($year)->format('d/m/Y'),
            ];

            $tempPrincipal = $maturity;

        }

        // ---------- Final summary ----------
        $summary = [
            'principal'       => number_format($principalFn, 2, '.', ''),
            'interest_earned' => number_format($totalInterest, 2, '.', ''),
            'tds_deducted'    => number_format(0, 2, '.', ''),
            'net_interest'    => number_format($totalInterest, 2, '.', ''),
            'maturity_bonus'  => number_format(0, 2, '.', ''),
            'maturity_amount' => number_format($maturityAmt, 2, '.', ''),
            'maturity_date'   => Carbon::parse($startDate)->addYears($tenureYears)->format('d/m/Y'),
        ];

        // ---------------- PERIODS (FD EMI / PERIOD WISE) ----------------
    $periods = [];

    // $totalMonths = floor($tenureYears * 12);
    // 🔥 Determine period interval based on payout type
    $intervalMonths = match ($payoutType) {
        "CUMULATIVE_MONTHLY", "MONTHLY" => 1,
        "CUMULATIVE_QUARTERLY", "QUARTERLY" => 3,
        "CUMULATIVE_HALF_YEARLY", "HALF_YEARLY" => 6,
        "CUMULATIVE_YEARLY", "YEARLY" => 12,
        default => 12,
    };

    $totalMonths = floor($tenureYears * 12);
    $currentDate = Carbon::parse($startDate);
    $currentPrincipal = $principalFn;

    //for ($i = 0; $i < $totalMonths; $i++) {
    for ($i = 0; $i < $totalMonths; $i += $intervalMonths) {

        $periodStart = $currentDate->copy();
        $normalEnd   = $currentDate->copy()->addMonth();

        // 🔥 Check if 31 March falls in between
        $fyEnd = Carbon::create($periodStart->year, 3, 31);

        if ($periodStart <= $fyEnd && $normalEnd > $fyEnd) {

            // ---------------- 1️⃣ PART : till 31 March ----------------
            $days1 = $periodStart->diffInDays($fyEnd);
            $interest1 = ($currentPrincipal * $annualRate * $days1) / 365;

            $periods[] = [
                'fd_year'          => floor($i / 12) + 1,
                'period'           => $periodStart->format('d/m/Y').' - '.$fyEnd->format('d/m/Y'),
                'days'             => $days1,
                'principal'        => round($currentPrincipal, 2),
                'interest'         => round($interest1, 2),
                'tds'              => 0,
                'net_interest'     => round($interest1, 2),
                'net_interest_due' => null, // ✅ ONLY 31 MARCH ROW
                'principal_at_eoy' => null,   // ❌ as per rule
                'due_by'           => null,   // ❌ as per rule
            ];

            // ---------------- 2️⃣ PART : from 1 April ----------------
            $aprilStart = $fyEnd->copy()->addDay();
            $days2 = $aprilStart->diffInDays($normalEnd);
            $interest2 = ($currentPrincipal * $annualRate * $days2) / 365;

            if (str_contains($payoutType, 'CUMULATIVE')) {
                $currentPrincipal += ($interest1 + $interest2);
            }

            $periods[] = [
                'fd_year'          => floor($i / 12) + 1,
                'period'           => $aprilStart->format('d/m/Y').' - '.$normalEnd->format('d/m/Y'),
                'days'             => $days2,
                'principal'        => round($currentPrincipal, 2),
                'interest'         => round($interest2, 2),
                'tds'              => 0,
                'net_interest'     => round($interest2, 2),
                'net_interest_due' => round($interest2, 2),
                'principal_at_eoy' => null,
                'due_by'           => $normalEnd->format('d/m/Y'),
            ];

        } else {

            // ---------------- NORMAL MONTH ----------------
            $days = $periodStart->diffInDays($normalEnd);
            $interest = ($currentPrincipal * $annualRate * $days) / 365;

            if (str_contains($payoutType, 'CUMULATIVE')) {
                $currentPrincipal += $interest;
            }

            $periods[] = [
                'fd_year'          => floor($i / 12) + 1,
                'period'           => $periodStart->format('d/m/Y').' - '.$normalEnd->format('d/m/Y'),
                'days'             => $days,
                'principal'        => round($currentPrincipal, 2),
                'interest'         => round($interest, 2),
                'tds'              => 0,
                'net_interest'     => round($interest, 2),
                'net_interest_due' => round($interest, 2),
                'principal_at_eoy' => null,
                'due_by'           => $normalEnd->format('d/m/Y'),
            ];
        }

        $currentDate = $normalEnd;
    }



        return [
            'summary' => $summary,
            'details' => $details,
            'periods' => $periods 
        ];
    }


    function processPeriod(
        $results,
        $periodStart,
        $periodEnd,
        $principal,
        $annualRate,
        $maturityDateInternal,
        $depositStartInternal,
        $payoutType,
        $totalInterest
    ) {
        $daysInYr = $periodStart->isLeapYear() ? 366 : 365;
        $current  = $periodStart->copy();

        $cumulativeTypes = ['CUMULATIVE', 'CUMULATIVE_MONTHLY', 'CUMULATIVE_HALF_YEARLY', 'YEARLY'];

        if (in_array($payoutType, $cumulativeTypes)) {
            while ($current < $periodEnd) {
                // determine next compounding boundary
                $next = match($payoutType) {
                    'CUMULATIVE_MONTHLY'     => $current->copy()->addMonth(1),
                    'CUMULATIVE_HALF_YEARLY' => $current->copy()->addMonths(6),
                    'YEARLY'                 => $current->copy()->addYear(1),
                    default                  => $periodEnd->copy(),
                };

                if ($next > $periodEnd) $next = $periodEnd->copy();

                $days = (int) $current->diffInDays($next) + 1;

                $interest = ($principal * $annualRate * $days) / $daysInYr;
                $netInt   = round($interest, 2);

                $principal     += $netInt;
                $totalInterest += $netInt;

                $results[] = [
                    'period'           => $current->format('d/m/Y') . ' - ' . $next->format('d/m/Y'),
                    'days'             => $days,
                    'principal'        => round($principal - $netInt, 2),
                    'interest'         => $netInt,
                    'tds'              => 0.0,
                    'net_interest'     => $netInt,
                    'net_interest_due' => $netInt,
                    'principal_eoy'    => ($next->format('d/m') === '31/03') ? round($principal, 2) : '',
                    'due_by'           => $next->copy()->addDay(1)->format('d/m/Y'),
                    'maturity_amount'  => round($principal, 2),
                    'maturity_date'    => Carbon::createFromFormat('Y-m-d', $maturityDateInternal)->format('d/m/Y'),
                ];

                $current = $next->copy()->addDay(1);
            }
        } else {
            $days     = (int) $periodStart->diffInDays($periodEnd) + 1;
            $interest = ($principal * $annualRate * $days) / $daysInYr;
            $netInt   = round($interest, 2);
            $totalInterest += $netInt;

            $results[] = [
                'period'           => $periodStart->format('d/m/Y') . ' - ' . $periodEnd->format('d/m/Y'),
                'days'             => $days,
                'principal'        => round($principal, 0),
                'interest'         => $netInt,
                'tds'              => 0.0,
                'net_interest'     => $netInt,
                'net_interest_due' => $netInt,
                'principal_eoy'    => ($periodEnd->format('d/m') === '31/03') ? $principal : '',
                'due_by'           => $periodEnd->copy()->addDay(1)->format('d/m/Y'),
                'maturity_amount'  => $principal + $totalInterest,
                'maturity_date'    => Carbon::createFromFormat('Y-m-d', $maturityDateInternal)->format('d/m/Y'),
            ];
        }

        return [$results, $totalInterest, $principal];
    }


}
