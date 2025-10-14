<?php

namespace App\Helpers;

use App\Models\DdTransaction;

class TransactionHelper
{
    public static function calculateRunningBalance($transactions)
    {
        $runningBalance = 0;

        foreach ($transactions as $tran) {
            $credit = $tran->balance_available ?? 0;
            $debit = $tran->debit ?? 0;

            // Update running balance
            $runningBalance += ($credit - $debit);

            // Assign the calculated balance to the transaction
            $tran->balance = $runningBalance;
        }

        return $transactions;
    }
}
