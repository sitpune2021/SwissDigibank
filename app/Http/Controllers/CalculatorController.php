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
            'amount' => 'required|numeric|min:0',
            'interest_payout_type' => 'required|string',
            'annual_interest_rate' => 'required|numeric|min:0',
            'tenure_year' => 'required|integer|min:0',
            'tenure_month' => 'required|integer|min:0',
            'tenure_day' => 'required|integer|min:0',
            'bonus_type' => 'required|in:%,fixed',
            'bonus' => 'required|numeric|min:0',
            'tds_deduction' => 'required|boolean',
            'is_senior_citizen' => 'required|boolean',
        ]);

        $openDate = Carbon::parse($validated['open_date']);
        $maturityDate = $openDate->copy()
            ->addYears((int) $validated['tenure_year'])
            ->addMonths((int) $validated['tenure_month'])
            ->addDays((int) $validated['tenure_day']);

        $principal = $validated['amount'];
        $annualRate = $validated['annual_interest_rate'];

        // -------------------------------
        // Calculate Final Interest & Bonus
        // -------------------------------
        $interest = $this->roundToPrecision($principal * ($annualRate / 100) * $validated['tenure_year']);

        $bonusAmount = ($validated['bonus_type'] === '%')
            ? $this->roundToPrecision(($principal * $validated['bonus']) / 100)
            : $this->roundToPrecision($validated['bonus']);

        // TDS Deduction
        $tdsDeducted = 0;
        if ($validated['tds_deduction']) {
            if ($interest > 40000) {
                $tdsDeducted = $this->roundToPrecision(($interest * 10) / 100); // TDS at 10%
            }
        }

        // -------------------------------
        // FINAL PAYMENT (Maturity Amount)
        // -------------------------------
        $maturityAmount = $this->roundToPrecision($principal + $interest + $bonusAmount);

        $fdStatement = FdMaturityStatement::create([
            'user_id' => Auth::id(),
            'principal_amount' => $this->roundToPrecision($principal),
            'interest_earned' => $interest,
            'tds_deducted' => $this->roundToPrecision($tdsDeducted),
            'net_interest_earned' => $this->roundToPrecision($interest),
            'maturity_bonus_amount' => $this->roundToPrecision($bonusAmount),
            'maturity_amount' => $maturityAmount,   // <- FINAL PAYMENT
            'maturity_date' => $maturityDate->toDateString(),
            'statement_from' => $openDate->toDateString(),
            'statement_to' => $maturityDate->toDateString(),
            'currency' => 'INR',
        ]);

        // -------------------------------
        // YEARLY PAYMENTS (Interest Periods)
        // -------------------------------
        $financialYearEnd = Carbon::create($openDate->year + 1, 3, 31);
        $interestPeriods = [];
        $currentStartDate = $openDate->copy();
        $currentEndDate = $financialYearEnd->copy();
        $cumulativeInterest = 0;

        while ($currentEndDate < $maturityDate) {
            $fraction = $currentStartDate->diffInDays($currentEndDate) / $currentStartDate->daysInYear;
            $interest = $this->roundToPrecision($principal * ($annualRate / 100) * $fraction);
            $tds = $this->roundToPrecision(($interest * 10) / 100);
            $net = $interest - $tds;

            $days = $currentStartDate->diffInDays($currentEndDate) + 1;

            $interestPeriods[] = [
                'period_from' => $currentStartDate->toDateString(),
                'period_to' => $currentEndDate->toDateString(),
                'days' => $days,
                'principal' => $principal,
                'interest' => $interest,
                'tds' => $tds,
                'net_interest' => $net,
                'cumulative_net_interest' => $this->roundToPrecision($cumulativeInterest),
            ];

            $cumulativeInterest += $interest;
            $currentStartDate = $currentEndDate->copy()->addDay();
            $currentEndDate = $currentEndDate->copy()->addYear();
        }

        // Last period till Maturity
        $daysInYear = $currentStartDate->isLeapYear() ? 366 : 365;
        $fraction = $currentStartDate->diffInDays($maturityDate) / $daysInYear;
        $interest = $this->roundToPrecision($principal * ($annualRate / 100) * $fraction);
        $tdsPercentage = 10;
        $tds = $this->roundToPrecision(($interest * $tdsPercentage) / 100);
        $net = $interest - $tds;
        $cumulativeInterest += $interest;

        $interestPeriods[] = [
            'period_from' => $currentStartDate->toDateString(),
            'period_to' => $maturityDate->toDateString(),
            'days' => $currentStartDate->diffInDays($maturityDate),
            'principal' => $principal,
            'interest' => $interest,
            'tds' => $tds,
            'net_interest' => $net,
            'cumulative_net_interest' => $this->roundToPrecision($cumulativeInterest),
            'due_by' => $maturityDate->toDateString(),
        ];

        // Save in session
        session([
            'fdStatement' => $fdStatement,
            'interestPeriods' => $interestPeriods,
        ]);

        return redirect()
            ->back()
            ->with('success', 'FD maturity calculated and saved successfully!');
    }

    // app/Http/Controllers/FDController.php

public function calculate(Request $request)
{
    $P = (float) $request->input('amount');
    $rate = (float) $request->input('interest_rate');
    $bonus = (float) $request->input('bonus', 0);
    $tds = $request->input('tds') === 'yes';
    $start_date = Carbon::parse($request->input('open_date'));
    $years = (int) $request->input('tenure_years');
    $months = (int) $request->input('tenure_months');
    $days = (int) $request->input('tenure_days');

    $total_rate = $rate + $bonus;
    $end_date = (clone $start_date)->addYears($years)->addMonths($months)->addDays($days);
    
    $breakup = [];

    // Periods:
    $periods = [
        [
            'from' => $start_date,
            'to' => Carbon::create($start_date->year, 3, 31)->isAfter($end_date) ? $end_date : Carbon::create($start_date->year, 3, 31),
        ],
        [
            'from' => Carbon::create($start_date->year + 1, 4, 1),
            'to' => $end_date,
        ]
    ];

    $total_interest = 0;
    $total_tds = 0;

    foreach ($periods as $period) {
        if ($period['from']->gt($period['to'])) continue;
        $days = $period['to']->diffInDays($period['from']) + 1;
        $interest = $P * ($total_rate / 100) * ($days / 365);
        $tds_amt = $tds ? $interest * 0.1 : 0;
        $net = $interest - $tds_amt;

        $breakup[] = [
            'period' => $period['from']->format('d/m/Y') . ' - ' . $period['to']->format('d/m/Y'),
            'days' => $days,
            'principal' => round($P, 2),
            'interest' => round($interest, 2),
            'tds' => round($tds_amt, 2),
            'net_interest' => round($net, 2),
        ];

        $total_interest += $interest;
        $total_tds += $tds_amt;
    }

    return response()->json([
        'principal' => round($P, 2),
        'maturity_date' => $end_date->format('d/m/Y'),
        'total_interest' => round($total_interest, 2),
        'total_tds' => round($total_tds, 2),
        'net_interest' => round($total_interest - $total_tds, 2),
        'rows' => $breakup
    ]);
}


}
