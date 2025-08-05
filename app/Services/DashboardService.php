<?php

namespace App\Services;

use App\Models\Account;

class DashboardService
{
    public static function getDashboardData()
    {
        return Account::with([
            'minor',
            'members',
            'branch',
            'address',
            'users',
            'transaction',
            'nominee',
            'scheme'
        ])->get();
    }
}
