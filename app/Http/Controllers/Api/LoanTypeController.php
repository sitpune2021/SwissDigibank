<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GoldLoanScheme;
use App\Models\MortgageScheme;
use App\Models\LoanAgainstScheme;
use App\Models\BusinessLoanScheme;
use App\Models\PersonalScheme;
use App\Models\DailyWeeklyScheme;
use App\Models\VehicalScheme;
use App\Models\CcOdLoanScheme;

class LoanTypeController extends Controller
{
    public function loanTypes()
    {
        $loanTypes = [
            ['id' => 1, 'name' => 'Gold Loan'],
            ['id' => 2, 'name' => 'Property / Mortgage Loan'],
            ['id' => 3, 'name' => 'Loan Against Deposit'],
            ['id' => 4, 'name' => 'Business Loan'],
            ['id' => 5, 'name' => 'Personal Loan'],
            ['id' => 6, 'name' => 'Daily / Weekly Loan'],
            ['id' => 7, 'name' => 'CC / OD Loan'],
        ];
        return response()->json([
            'status' => 'success',
            'loan_types' => $loanTypes
        ]);
    }
    public function getSchemes($loanType)
    {
        $loanTypes = [
            1 => ['name' => 'Gold Loan', 'model' => GoldLoanScheme::class],
            2 => ['name' => 'Property / Mortgage Loan', 'model' => MortgageScheme::class],
            3 => ['name' => 'Loan Against Deposit', 'model' => LoanAgainstScheme::class],
            4 => ['name' => 'Business Loan', 'model' => BusinessLoanScheme::class],
            5 => ['name' => 'Personal Loan', 'model' => PersonalScheme::class],
            8 => ['name' => 'CC / OD Loan', 'model' => CcOdLoanScheme::class],
        ];

        if (!isset($loanTypes[$loanType])) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid loan type'
            ], 400);
        }

        $config = $loanTypes[$loanType];

        // Fetch ALL fields, order by SAME column
        $schemes = $config['model']::where('is_active', 1)
            ->orderBy('gold_loan_setting', 'asc')
            ->get();

        if ($schemes->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No schemes found'
            ], 404);
        }

        // Differentiate schemes by gold_loan_setting
        $groupedSchemes = $schemes->groupBy('gold_loan_setting');

        return response()->json([
            'status' => true,
            'loan_type_id' => (int) $loanType,
            'loan_type_name' => $config['name'],
            'schemes' => $groupedSchemes
        ]);
    }

    // public function getSchemes($loanType)
    // {
    //     $loanTypeNames = [
    //         1 => 'Gold Loan',
    //         2 => 'Property / Mortgage Loan',
    //         3 => 'Loan Against Deposit',
    //         4 => 'Business Loan',
    //         5 => 'Personal Loan',
    //         6 => 'Daily / Weekly Loan',
    //         7 => 'Vehical Loan',
    //         8 => 'CC / OD Loan',
    //     ];

    //     $schemes = match ((int)$loanType) {

    //         1 => GoldLoanScheme::where('is_active', 1)
    //             ->orderBy('gold_loan_setting', 'asc')
    //             ->get(),

    //         2 => MortgageScheme::where('is_active', 1)->get(),
    //         3 => LoanAgainstScheme::where('is_active', 1)->get(),
    //         4 => BusinessLoanScheme::where('is_active', 1)->get(),
    //         5 => PersonalScheme::where('is_active', 1)->get(),
    //         6 => DailyWeeklyScheme::where('is_active', 1)->get(),
    //         7 => VehicalScheme::where('is_active', 1)->get(),
    //         8 => CcOdLoanScheme::where('is_active', 1)->get(),

    //         default => collect(),
    //     };

    //     if ($schemes->isEmpty()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'No schemes found'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'loan_type_id' => (int)$loanType,
    //         'loan_type_name' => $loanTypeNames[$loanType] ?? 'Unknown',
    //         'schemes' => $schemes
    //     ]);
    // }

    // public function getSchemes($loanType)
    // {
    //     $loanTypeNames = [
    //         1 => 'Gold Loan',
    //         2 => 'Property / Mortgage Loan',
    //         3 => 'Loan Against Deposit',
    //         4 => 'Business Loan',
    //         5 => 'Personal Loan',
    //         6 => 'Daily / Weekly Loan',
    //         7 => 'Vehical Loan',
    //         8 => 'CC / OD Loan',
    //     ];

    //     $schemes = match ((int)$loanType) {
    //         1 => GoldLoanScheme::where('is_active', 1)->get(),
    //         2 => MortgageScheme::where('is_active', 1)->get(),
    //         3 => LoanAgainstScheme::where('is_active', 1)->get(),
    //         4 => BusinessLoanScheme::where('is_active', 1)->get(),
    //         5 => PersonalScheme::where('is_active', 1)->get(),
    //         6 => DailyWeeklyScheme::where('is_active', 1)->get(),
    //         7 => VehicalScheme::where('is_active', 1)->get(),
    //         8 => CcOdLoanScheme::where('is_active', 1)->get(),
    //         default => collect(),
    //     };

    //     if ($schemes->isEmpty()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'No schemes found'
    //         ], 404);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'loan_type_id' => (int)$loanType,
    //         'loan_type_name' => $loanTypeNames[$loanType] ?? 'Unknown',
    //         'schemes' => $schemes
    //     ]);
    // }
}
