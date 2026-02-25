<?php

namespace App\Http\Controllers;

use App\Models\BusinessLoanApplication;
use App\Models\FixedLoanApplication;
use App\Models\LoanApplication;
use App\Models\PersonalLoanApplication;
use App\Models\VehicalApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function assoc_index()
    {
        return view("associate-report.index");
    }

    public function branch_index(Request $request)
    {
        $from = $request->from_date ?? now()->startOfMonth();
        $to   = $request->to_date ?? now();
        $mode = $request->mode ?? 'all';

        $branches = \App\Models\Branch::with([
            'Member',
            'ddsAccounts'
        ])->get();

        return view("menu-reports.branch-report.index", compact('branches', 'from', 'to', 'mode'));
    }
    public function maturity_index(Request $request)
    {
        $from = $request->from_date ?? '2000-01-01';
        $to   = $request->to_date ?? '2100-12-31';
        /* ================= RD ================= */
        $rdQuery = DB::table('rd_accounts')
            ->where('approve_status', 'Approved')
            ->whereBetween('maturity_date', [$from, $to]);

        $rdTotalAccounts = $rdQuery->count();
        $rdTotalMaturity = $rdQuery->sum('maturity_amount');
        $rdTotalBalance  = $rdQuery->sum(DB::raw('principal + total_interest'));


        /* ================= DD ================= */
        $ddQuery = DB::table('dds_accounts')
            ->where('status', 1)
            ->whereBetween('maturity_date', [$from, $to]);

        $ddTotalAccounts = $ddQuery->count();
        $ddTotalMaturity = $ddQuery->sum('maturity_amount');
        $ddTotalBalance  = $ddQuery->sum('balance'); // correct


        /* ================= FD ================= */
        $fdQuery = DB::table('fd_accounts')
            ->where('status', 1)
            ->where('active', 1)
            ->whereBetween('maturity_date', [$from, $to]);

        $fdTotalAccounts = $fdQuery->count();
        $fdTotalMaturity = $fdQuery->sum('maturity_amount');
        $fdTotalBalance  = $fdQuery->sum('final_amount'); // correct


        /* ================= MIS ================= */
        $misQuery = DB::table('misaccounts')
            ->where('status', 1)
            ->whereBetween('maturity_date', [$from, $to]);

        $misTotalAccounts = $misQuery->count();
        $misTotalMaturity = $misQuery->sum('maturity_amount');
        $misTotalBalance  = $misQuery->sum('final_amount'); // ✅ FIXED


        /* ================= GRAND TOTAL ================= */
        $grandAccounts =
            $rdTotalAccounts +
            $ddTotalAccounts +
            $fdTotalAccounts +
            $misTotalAccounts;

        $grandMaturity =
            $rdTotalMaturity +
            $ddTotalMaturity +
            $fdTotalMaturity +
            $misTotalMaturity;

        $grandBalance =
            $rdTotalBalance +
            $ddTotalBalance +
            $fdTotalBalance +
            $misTotalBalance;

        return view("menu-reports.maturity-report.index", compact(
            'rdTotalAccounts',
            'rdTotalMaturity',
            'rdTotalBalance',
            'ddTotalAccounts',
            'ddTotalMaturity',
            'ddTotalBalance',
            'fdTotalAccounts',
            'fdTotalMaturity',
            'fdTotalBalance',
            'misTotalAccounts',
            'misTotalMaturity',
            'misTotalBalance',
            'grandAccounts',
            'grandMaturity',
            'grandBalance'
        ));
    }

    public function loan_report_index(Request $request)
    {
        $loanType = $request->loan_type;
        $status   = $request->status;

        $query = null;

        switch ($loanType) {

            case 'gold_loan':
                $query = \App\Models\LoanApplication::with(['member', 'scheme', 'branch', 'emiPayments', 'disbursement']);
                break;
            case 'mortgage_loan':
                $query = \App\Models\MortgageLoanApplication::with(['member', 'scheme', 'branch', 'emiPayments', 'disbursement']);
                break;
            case 'loan_against':
                $query = \App\Models\LoanAgainstApplication::with(['member', 'scheme', 'branch', 'emiPayments',]);
                break;
            case 'cc_od':
                $query = \App\Models\CcOdLoanApplication::with(['member', 'scheme', 'branch', 'emiPayments',]);
                break;
            case 'daily_weekly':
                $query = \App\Models\DailyWeeklyApplication::with(['member', 'scheme', 'branch', 'emiPayments']);
                break;
            case 'fixed_loan':
                $query = \App\Models\FixedLoanApplication::with(['member', 'scheme', 'branch', 'emiPayments']);
                break;

            case 'other_loan':
                $query = \App\Models\BusinessLoanApplication::with(['member', 'scheme', 'branch', 'emiPayments', 'disbursement']);
                break;

            case 'personal_loan':
                $query = \App\Models\PersonalLoanApplication::with(['member', 'scheme', 'branch', 'emiPayments']);
                break;

            case 'vehicle_loan':
                $query = \App\Models\VehicalApplication::with(['member', 'scheme', 'branch', 'emiPayments', 'disbursement']);
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
