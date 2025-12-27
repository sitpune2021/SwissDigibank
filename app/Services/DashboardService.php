<?php

namespace App\Services;

use App\Models\Account;
use App\Models\FdAccount;
use App\Models\Promotor;
use App\Models\Branch;
use App\Models\Member;
use App\Models\Misaccount;
use App\Models\Shareholders;
use App\Models\LoanApplication;
use App\Models\MortgageLoanApplication;
use App\Models\LoanAgainstApplication;
use App\Models\BusinessLoanApplication;
use App\Models\CcOdLoanApplication;
use App\Models\DailyWeeklyApplication;
use App\Models\PersonalLoanApplication;
use App\Models\VehicalApplication;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Notice; 
class DashboardService
{

    public static function getDashboardData()
    {
        // All loan EMI tables list
        $emiTables = [
            'gold_loan_emi_status',
            'mortgage_loan_emi_status',
            'personal_loan_emi_status',
            'business_loan_emi_status',
            'cc_od_loan_emi_status',
            'vehical_loan_emi_status',
            'daily_weekly_loan_emi_status',
            'loan_against_emi_status',
        ];
        $totalDueAmount = 0;

        // Loop through every EMI table
        foreach ($emiTables as $table) {
            if (Schema::hasTable($table)) {
                $totalDueAmount += DB::table($table)
                    ->where('status', 'Due')
                    ->sum('remaining_amount');
            }
        }

        $targetAmount = 100000; // ← अपना target amount डालो

        $percent = $targetAmount > 0
            ? round(($totalDueAmount / $targetAmount) * 100)
            : 0;

                   // 🔹 Fetch latest 5 notices
        $notices = Notice::latest()->take(5)->get();
        return [
            'branchesCount' => Branch::count(),
            'accountsCount' => Account::count(),
            'membersCount' => Member::count(),
            'shareholdersCount' => Shareholders::count(),
            'promotorCount' => Promotor::count(),
            'savingAccounts' => Account::where('account_type', 'SAVING')->count(),
            'currentAccounts' => Account::where('account_type', 'CURRENT')->count(),
            'fdCount' => FdAccount::count(),
            'misCount' => Misaccount::count(),

            // Loan counts
            'goldloan' => LoanApplication::where('status', '2')->count(),
            'mortgageloan' => MortgageLoanApplication::where('status', '2')->count(),
            'loanagainst' => LoanAgainstApplication::where('status', '2')->count(),
            'businessloan' => BusinessLoanApplication::where('status', '2')->count(),
            'ccodloan' => CcOdLoanApplication::where('status', '2')->count(),
            'dailyweeklyloan' => DailyWeeklyApplication::where('status', '2')->count(),
            'personalloan' => PersonalLoanApplication::where('status', '2')->count(),
            'vehicalloan' => VehicalApplication::where('status', '2')->count(),

            // 🔥 NEW → Total EMI Amount Due
            'totalEmiDueAmount' => $totalDueAmount,

            'duePercent' => $percent,
            
            // 🔹 Add notices
            'notices' => $notices,
        ];
    }

}