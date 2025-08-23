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
        'tenure_unit'   => 'required|in:DAYS,MONTHS', // new field for flexibility
        'bonus'         => 'required|numeric|min:0',
    ]);

    // ✅ Inputs
    $amount        = $request->amount;
    $frequency     = strtoupper($request->frequency);
    $compInterval  = strtoupper($request->comp_interval);
    $interestRate  = $request->interest_rate;
    $tenure        = $request->tenure;
    $tenureUnit    = strtoupper($request->tenure_unit); // "DAYS" or "MONTHS"
    $bonusInput    = $request->bonus;
    $openDate      = Carbon::parse($request->open_date);

    // ✅ Frequency map (how many payments per year)
    $freqMap = [
        'DAILY'      => 365,
        'WEEKLY'     => 52,
        'BI_WEEKLY'  => 26,
        'MONTHLY'    => 12,
        'QUARTERLY'  => 4,
        'HALF-YEARLY'=> 2,
        'YEARLY'     => 1,
    ];
    $paymentsPerYear = $freqMap[$frequency] ?? 12;

    // ✅ Compounding frequency (compounding per year)
    $compMap = [
        'MONTHLY'     => 12,
        'QUARTERLY'   => 4,
        'HALF-YEARLY' => 2,
        'YEARLY'      => 1,
    ];
    $compounding = $compMap[$compInterval] ?? 4;

    // ✅ Determine number of installments and total deposits
    if ($tenureUnit === 'DAYS') {
        $totalInstallments = $tenure;
        $tenureInYears = $tenure / 365;
        $maturityDate = $openDate->copy()->addDays($tenure)->format('d/m/Y');
    } else {
        $totalInstallments = $tenure * $paymentsPerYear / 12;
        $tenureInYears = $tenure / 12;
        $maturityDate = $openDate->copy()->addMonths($tenure)->format('d/m/Y');
    }

    $totalDeposits = $amount * $totalInstallments;

    // ✅ If compounding has no time to apply (like < 1 month), no interest
    $interestEarned = 0;

    if ($tenureUnit !== 'DAYS' || $tenure >= 30) {
        // Calculate interest only if tenure allows
        $r = $interestRate / 100;
        $n = $compounding;       // Compounding per year
        $m = $paymentsPerYear;   // Installments per year
        $P = $amount;
        $t = $tenureInYears;

        // FV formula for RD
        $FV = $P * ((pow(1 + $r / $n, $n * $t) - 1) / (pow(1 + $r / $n, $n / $m) - 1));
        $interestEarned = $FV - $totalDeposits;
    }

    // ✅ Bonus as percentage of total deposit
    $bonusAmount = ($bonusInput / 100) * $totalDeposits;

    // ✅ Final maturity
    $maturityAmount = $totalDeposits + $interestEarned + $bonusAmount;

    // ✅ Response
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
