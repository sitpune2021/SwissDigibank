<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Rdscheme;

class RDCalculatorController extends Controller
{


    public function index()
    {
        // return view('rd_account.calculator.index');
    }

    public function create()
    {
        $schemes = Rdscheme::select('scheme_code', 'scheme_name')->get(); 
        return view('mds_rd_accounts.calculators.create', compact('schemes'));
    }

    public function getScheme($scheme_code)
    {
        $scheme = Rdscheme::where('scheme_code', $scheme_code)->first();

        if ($scheme) {
            return response()->json([
                'status' => true,
                'data'   => [
                    'scheme_code'                => $scheme->scheme_code,
                    'scheme_name'                => $scheme->scheme_name,
                    //'deposit_frequency'          => $scheme->deposit_frequency,
                    'min_rd_dd_amount'           => $scheme->min_rd_dd_amount,
                   // 'lock_in_period'             => $scheme->lock_in_period,
                    'anuual_interest_rate'       => $scheme->anuual_interest_rate,
                    'interest_compounding_interval' => $scheme->interest_compounding_interval,
                    'rd_dd_frequency'            => $scheme->rd_dd_frequency,
                    'tenure_of_rd_dd_type'  => $scheme->tenure_of_rd_dd_type,
                    'tenure_of_rd_dd_value' => $scheme->tenure_of_rd_dd_value,
                    'cancellation_charges_value' => $scheme->cancellation_charges_value,
                    'penal_charges'              => $scheme->penal_charges,
                    'bonus_rate'                 => $scheme->bonus_rate,
                    'penalty_charges_value'      => $scheme->penalty_charges_value,
                   // 'is_active'                  => $scheme->is_active,
                ]
            ]);
        }

        return response()->json([
            'status'  => false,
            'message' => 'Scheme not found'
        ]);
    }

    public function store(Request $request)
    {
        // Validation
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

        //  Inputs
        $amount        = $request->amount;
        $frequency     = strtoupper($request->frequency);
        $compInterval  = strtoupper($request->comp_interval);
        $interestRate  = $request->interest_rate;
        $tenure        = $request->tenure;
        $tenureUnit    = strtoupper($request->tenure_unit);
        $bonusInput    = $request->bonus;
        $openDate      = Carbon::parse($request->open_date);

        //  Frequency map
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

        //  Compounding map
        $compMap = [
            'MONTHLY'     => 12,
            'QUARTERLY'   => 4,
            'HALF-YEARLY' => 2,
            'YEARLY'      => 1,
        ];
        $compounding = $compMap[$compInterval] ?? 4;

        //  Convert tenure to days
        $days = match ($tenureUnit) {
            'DAYS'   => $tenure,
            'WEEKS'  => $tenure * 7,
            'MONTHS' => $tenure * 30,
            'YEARS'  => $tenure * 365,
            default  => $tenure,
        };

        //  Number of installments based on frequency
        $totalInstallments = match ($frequency) {
            'DAILY'   => $days,
            'WEEKLY'  => floor($days / 7),
            'MONTHLY' => floor($days / 30),
            'YEARLY'  => floor($days / 365),
            default   => $days,
        };

        //  Total deposit
        $totalDeposits = $amount * $totalInstallments;

        // Tenure in years
        $tenureInYears = $days / 365;

        // Maturity date
        $maturityDate = $openDate->copy()->addDays($days)->format('d/m/Y');

        // Interest earned (skip if < 30 days)
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

        //  Bonus
        $bonusAmount = ($bonusInput / 100) * $totalDeposits;

        //  Final maturity
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
