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
  
class DashboardService
{
    public static function getDashboardData()
    {
        return [
            'branchesCount'    => Branch::count(),
            'accountsCount'    => Account::count(),
            'membersCount'     => Member::count(),
            'shareholdersCount'=> Shareholders::count(),
            'promotorCount'     => Promotor::count(),
            'savingAccounts'    => Account::where('account_type', 'SAVING')->count(),
            'currentAccounts'   => Account::where('account_type', 'CURRENT')->count(),
            'fdCount'=> FdAccount::count(),
            'misCount'     => Misaccount::count(),
            'goldloan'     => LoanApplication::where('status', '2')->count(),
            'mortgageloan'     => MortgageLoanApplication::where('status', '2')->count(),
            'loanagainst'     => LoanAgainstApplication::where('status', '2')->count(),
            'businessloan'     => BusinessLoanApplication::where('status', '2')->count(),
            'ccodloan'     => CcOdLoanApplication::where('status', '2')->count(),
            'dailyweeklyloan'     => DailyWeeklyApplication::where('status', '2')->count(),
            'personalloan'     => PersonalLoanApplication::where('status', '2')->count(),
            'vehicalloan'     => VehicalApplication::where('status', '2')->count(),
        ];
    }
}