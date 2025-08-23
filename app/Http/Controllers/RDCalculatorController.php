<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class RDCalculatorController extends Controller
{
    public function index()
    {
        // return view('rd_account.calculator.index');
    }

    public function create()
    {
        return view('mds_rd_accounts.calculators.create');
    }

    public function store(Request $request)
    {
        // ✅ Validation
        $request->validate([
            'scheme'        => 'required',
            'open_date'     => 'required|date',
            'amount'        => 'required|numeric|min:500',
            'frequency'     => 'required',
            'comp_interval' => 'required',
            'interest_rate' => 'required|numeric|min:0',
            'tenure'        => 'required|integer|min:1',
            'tenure_unit'   => 'required|in:DAYS,WEEKS,MONTHS,YEARS',
            'bonus'         => 'required|numeric|min:0',
        ]);

        // ✅ Inputs
        $amount        = $request->amount;
        $frequency     = strtoupper($request->frequency);
        $compInterval  = strtoupper($request->comp_interval);
        $interestRate  = $request->interest_rate;
        $tenure        = $request->tenure;
        $tenureUnit    = strtoupper($request->tenure_unit);
        $bonusInput    = $request->bonus;
        $openDate      = Carbon::parse($request->open_date);

        // ✅ Frequency map
        $freqMap = [
            'DAILY'      => 365,
            'WEEKLY'     => 52,
            'BI_WEEKLY'  => 26,
            'MONTHLY'    => 12,
            'QUARTERLY'  => 4,
            'HALF-YEARLY' => 2,
            'YEARLY'     => 1,
        ];
        $paymentsPerYear = $freqMap[$frequency] ?? 12;

        // ✅ Compounding map
        $compMap = [
            'MONTHLY'     => 12,
            'QUARTERLY'   => 4,
            'HALF-YEARLY' => 2,
            'YEARLY'      => 1,
        ];
        $compounding = $compMap[$compInterval] ?? 4;

        // ✅ Convert tenure to days
        $days = match ($tenureUnit) {
            'DAYS'   => $tenure,
            'WEEKS'  => $tenure * 7,
            'MONTHS' => $tenure * 30,
            'YEARS'  => $tenure * 365,
            default  => $tenure,
        };

        // ✅ Number of installments based on frequency
        $totalInstallments = match ($frequency) {
            'DAILY'   => $days,
            'WEEKLY'  => floor($days / 7),
            'MONTHLY' => floor($days / 30),
            'YEARLY'  => floor($days / 365),
            default   => $days,
        };

        // ✅ Total deposit
        $totalDeposits = $amount * $totalInstallments;

        // ✅ Tenure in years
        $tenureInYears = $days / 365;

        // ✅ Maturity date
        $maturityDate = $openDate->copy()->addDays($days)->format('d/m/Y');

        // ✅ Interest earned (skip if < 30 days)
        $interestEarned = 0;
        if ($days >= 30) {
            $r = $interestRate / 100;
            $n = $compounding;       // compounding per year
            $m = $paymentsPerYear;   // installments per year
            $P = $amount;
            $t = $tenureInYears;

            // Future Value (RD formula)
            $FV = $P * ((pow(1 + $r / $n, $n * $t) - 1) / (pow(1 + $r / $n, $n / $m) - 1));
            $interestEarned = $FV - $totalDeposits;
        }

        // ✅ Bonus
        $bonusAmount = ($bonusInput / 100) * $totalDeposits;

        // ✅ Final maturity
        $maturityAmount = $totalDeposits + $interestEarned + $bonusAmount;

        return back()->with([
            'success'        => 'Calculation successful!',
            'totalDeposit'   => round($totalDeposits, 2),
            'interestEarned' => round($interestEarned, 2),
            'bonus'          => round($bonusAmount, 2),
            'maturityAmount' => round($maturityAmount, 2),
            'maturityDate'   => $maturityDate,
        ]);
    }
}
