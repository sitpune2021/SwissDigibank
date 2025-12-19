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
    public function fetchUserLoans($userId)
    {
        // Loan types mapping
        $loanTypes = [
            1 => 'Gold Loan',
            2 => 'Property / Mortgage Loan',
            3 => 'Loan Against Deposit',
            4 => 'Business Loan',
            5 => 'Personal Loan',
            6 => 'Daily / Weekly Loan',
            7 => 'Vehical Loan',
            8 => 'CC / OD Loan',
        ];

        $userLoans = [];

        foreach ($loanTypes as $id => $name) {
            $schemes = collect(); // empty collection

            // Fetch schemes based on loan type
            switch ($id) {
                case 1:
                    $schemes = GoldLoanScheme::where('is_active', 1)->get();
                    break;
                case 2:
                    $schemes = MortgageScheme::where('is_active', 1)->get();
                    break;
                case 3:
                    $schemes = LoanAgainstScheme::where('is_active', 1)->get();
                    break;
                case 4:
                    $schemes = BusinessLoanScheme::where('is_active', 1)->get();
                    break;
                case 5:
                    $schemes = PersonalScheme::where('is_active', 1)->get();
                    break;
                case 6:
                    $schemes = DailyWeeklyScheme::where('is_active', 1)->get();
                    break;
                case 7:
                    $schemes = VehicalScheme::where('is_active', 1)->get();
                    break;
                case 8:
                    $schemes = CcOdLoanScheme::where('is_active', 1)->get();
                    break;
            }

            // Only include if schemes exist
            if ($schemes->count() > 0) {
                $userLoans[] = [
                    'id' => $id,
                    'name' => $name,
                    'schemes' => $schemes
                ];
            }
        }

        return response()->json([
            'status' => true,
            'user_id' => $userId,
            'available_loans' => $userLoans
        ]);
    }
    // public function loanSchemes($id)
    // {
    //     $loanTypes = [
    //         1 => 'Gold Loan',
    //         2 => 'Property / Mortgage Loan',
    //         3 => 'Loan Against Deposit',
    //         4 => 'Business Loan',
    //         5 => 'Personal Loan',
    //         6 => 'Daily / Weekly Loan',
    //         7 => 'Vehical Loan',
    //         8 => 'CC / OD Loan',
    //     ];

    //     if (!isset($loanTypes[$id])) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Loan type not found'
    //         ], 404);
    //     }

    //     $schemes = [];

    //     // Fetch schemes based on loan type
    //     switch ($id) {
    //         case 1:
    //             $schemes = GoldLoanScheme::where('is_active', 1)->get();
    //             break;
    //         case 2:
    //             $schemes = MortgageScheme::where('is_active', 1)->get();
    //             break;
    //         case 3:
    //             $schemes = LoanAgainstScheme::where('is_active', 1)->get();
    //             break;
    //         case 4:
    //             $schemes = BusinessLoanScheme::where('is_active', 1)->get();
    //             break;
    //         case 5:
    //             $schemes = PersonalScheme::where('is_active', 1)->get();
    //             break;
    //         case 6:
    //             $schemes = DailyWeeklyScheme::where('is_active', 1)->get();
    //             break;
    //         case 7:
    //             $schemes = VehicalScheme::where('is_active', 1)->get();
    //             break;
    //         case 8:
    //             $schemes = CcOdLoanScheme::where('is_active', 1)->get();
    //             break;
    //     }

    //     return response()->json([
    //         'status' => 'success',
    //         'loan_type' => [
    //             'id' => $id,
    //             'name' => $loanTypes[$id]
    //         ],
    //         'schemes' => $schemes
    //     ]);
    // }
}
