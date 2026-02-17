<?php

namespace App\Http\Controllers;

use App\Models\BusinessLoanApplication;
use App\Models\FixedLoanApplication;
use App\Models\LoanApplication;
use App\Models\PersonalLoanApplication;
use App\Models\VehicalApplication;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function assoc_index()
    {
        return view("associate-report.index");
    }
    public function branch_index()
    {
        return view("branch-report.index");
    }
    public function maturity_index()
    {
        return view("menu-reports.maturity-report.index");
    }
   public function loan_report_index(Request $request)
{
    $loanType = $request->loan_type;
    $status   = $request->status;

    $query = null;

    switch ($loanType) {

        case 'gold_loan':
            $query = \App\Models\LoanApplication::with(['member','scheme','branch','emiPayments','disbursement']);
            break;
        case 'mortgage_loan':
            $query = \App\Models\MortgageLoanApplication::with(['member','scheme','branch','emiPayments','disbursement']);
            break;
        case 'loan_against':
            $query = \App\Models\LoanAgainstApplication::with(['member','scheme','branch','emiPayments',]);
            break;
        case 'cc_od':
            $query = \App\Models\CcOdLoanApplication::with(['member','scheme','branch','emiPayments',]);
            break;
        case 'daily_weekly':
            $query = \App\Models\DailyWeeklyApplication::with(['member','scheme','branch','emiPayments']);
            break;
        case 'fixed_loan':
            $query = \App\Models\FixedLoanApplication::with(['member','scheme','branch','emiPayments']);
            break;

        case 'other_loan':
            $query = \App\Models\BusinessLoanApplication::with(['member','scheme','branch','emiPayments','disbursement']);
            break;

        case 'personal_loan':
            $query = \App\Models\PersonalLoanApplication::with(['member','scheme','branch','emiPayments']);
            break;

        case 'vehicle_loan':
            $query = \App\Models\VehicalApplication::with(['member','scheme','branch','emiPayments','disbursement']);
            break;

        default:
            $query = collect();
    }


    /*
    |--------------------------------------------------------------------------
    | STATUS MAPPING
    |--------------------------------------------------------------------------
    */

        $statusMap = [
            'active'      => 2,
            'fore_closed' => 2,
            'closed'      => 3,
        ];


        if ($query instanceof \Illuminate\Database\Eloquent\Builder && $status && isset($statusMap[$status])) {
            $query->where('status', $statusMap[$status]);
        }

//     if ($query instanceof \Illuminate\Database\Eloquent\Builder && $status) {

//     if ($status === 'fore_closed') {

//         // only loans that exist in foreclosure table
//         $query->whereHas('foreclosure');

//     } else {

//         $statusMap = [
//             'active' => 2,
//             // 'closed' => 3,
//         ];

//         if (isset($statusMap[$status])) {
//             $query->where('status', $statusMap[$status]);
//         }
//     }
// }


    /*
    |--------------------------------------------------------------------------
    | RESULT
    |--------------------------------------------------------------------------
    */

    $loans = $query instanceof \Illuminate\Database\Eloquent\Builder
        ? $query->latest()->get()
        : collect();

    return view('menu-reports.loan-report.index', compact('loans'));
}

}
