<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FdMaturityStatement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CalculatorController extends Controller
{
    private function roundToPrecision($number, $precision = 2)
    {
        return round($number, $precision);
    }

    public function index() {}

    public function create()
    {
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
            $days = $periodEnd->diffInDays($periodStart);

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
// calculateInvestment (replace your existing function body with this)

public function calculateInvestmentAjax(Request $request)
{

    $type        = 'FD';
    $principal   = $request->input('amount');
    $rate        = $request->input('annual_interest_rate');
    $tenureYears = (int) $request->input('tenure_year', 0);
    $tenureMonthsq= (int) $request->input('tenure_month', 0);
    $tenureDays  = (int) $request->input('tenure_day', 0);

    $tenureMonths = ($tenureYears * 12) + $tenureMonthsq;

    $startDate   = $request->input('open_date');
    $payoutType  = $request->input('interest_payout_type');

    // Call your existing function
    $results = $this->calculateInvestment($type, $principal, $rate, $tenureMonths, $startDate, $payoutType);

    return response()->json([
        'success' => true,
        'results' => $results
    ]);
}


function calculateInvestment(
    $type = null,
    $principal = null,
    $rate = null,
    $tenureMonths = null,
    $startDate = null,
    $payoutType = null
) {

   
    $results = [];

    // ---- Defaults ----
    $type         = $type ?? 'FD';
    $principal    = (float) ($principal ?? 0);
    $rate         = (float) ($rate ?? 10);
    $tenureMonths = (int) ($tenureMonths ?? 12);
    $startDate    = $startDate ?? '2025-08-27';
    $payoutType   = strtoupper($payoutType ?? 'CUMULATIVE_HALF_YEARLY');

    $annualRate = $rate / 100;

    $currentDate    = Carbon::parse($startDate)->startOfDay();
    $maturityCarbon = Carbon::parse($startDate)->addMonths($tenureMonths)->startOfDay();

    $maturityDateInternal  = $maturityCarbon->format('Y-m-d');
    $maturityDate          = $maturityCarbon->format('d/m/Y');
    $depositStartInternal  = Carbon::parse($startDate)->startOfDay()->format('Y-m-d');

    $totalInterest = 0;
    $totalTDS      = 0;
    $maturityBonus = 0;

    $isCumulative = str_starts_with($payoutType, 'CUMULATIVE_');

    $cycleMonths = match($payoutType) {
        'MONTHLY', 'CUMULATIVE_MONTHLY'             => 1,
        'QUARTERLY', 'CUMULATIVE_QUARTERLY'         => 3,
        'HALF_YEARLY', 'CUMULATIVE_HALF_YEARLY'     => 6,
        'YEARLY', 'CUMULATIVE_YEARLY'               => 12,
        default                                     => 1,
    };

    $cycleMonths = (int) $cycleMonths;

    while ($currentDate < $maturityCarbon) {
        $periodStart = $currentDate->copy()->startOfDay();
        $periodEnd   = $currentDate->copy()->addMonths($cycleMonths)->subDay()->startOfDay();

        if ($periodEnd > $maturityCarbon) {
            $periodEnd = $maturityCarbon->copy()->startOfDay();
        }

        // March 31 adjustment
        $marchYear = ($periodStart->month > 3) ? $periodStart->year + 1 : $periodStart->year;
        $marchEnd  = Carbon::createFromDate($marchYear, 3, 31)->startOfDay();

        if ($marchEnd >= $periodStart && $marchEnd <= $periodEnd) {
            [$results, $totalInterest, $principal] = $this->processPeriod(
                $results, $periodStart, $marchEnd, $principal, $annualRate,
                $maturityDateInternal, $depositStartInternal, $payoutType, $totalInterest
            );

            $periodStart = $marchEnd->copy()->addDay(1)->startOfDay();

            [$results, $totalInterest, $principal] = $this->processPeriod(
                $results, $periodStart, $periodEnd, $principal, $annualRate,
                $maturityDateInternal, $depositStartInternal, $payoutType, $totalInterest
            );
        } else {
            [$results, $totalInterest, $principal] = $this->processPeriod(
                $results, $periodStart, $periodEnd, $principal, $annualRate,
                $maturityDateInternal, $depositStartInternal, $payoutType, $totalInterest
            );
        }

        $currentDate = $periodEnd->copy()->addDay(1)->startOfDay();
    }

    // ---- Final Summary ----
    $netInterest = $totalInterest - $totalTDS;
    $maturityAmt = $principal + $maturityBonus;

    $summary['summary'] = [
        'principal'       => number_format($principal, 2),
        'interest_earned' => number_format($totalInterest, 2),
        'tds_deducted'    => number_format($totalTDS, 2),
        'net_interest'    => number_format($netInterest, 2),
        'maturity_bonus'  => number_format($maturityBonus, 2),
        'maturity_amount' => number_format($maturityAmt, 2),
        'maturity_date'   => $maturityDate
    ];


            return response()->json([
                'success' => true,
                'summary' => $summary,
                'details' => $results
            ]);

            
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
