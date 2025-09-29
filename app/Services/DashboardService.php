<?php
 
namespace App\Services;

use App\Models\Account;
use App\Models\FdAccount;
use App\Models\Promotor;
use App\Models\Branch;
use App\Models\Member;
use App\Models\Misaccount;
use App\Models\Shareholders;
  
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
        ];
    }
}