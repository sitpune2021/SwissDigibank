<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Response;

class AccountsTransactionsHelper
{
    public static function getAccountBalacec($account_nos, $payment_details = null)
    {
        // Convert single ID to array
        if (!is_array($account_nos)) {
            $account_nos = [$account_nos];
        }

        $transactions = \App\Models\Transaction::whereIn('account_id', $account_nos)
            ->where('approve_status', 'approved')
            ->whereNull('deleted_at')
            ->get();

        $balances = [];

        foreach ($transactions->groupBy('account_id') as $account_id => $accountTransactions) {
            $credit = $accountTransactions->where('transaction_type', 'credit')->sum('amount');
            $debit = $accountTransactions->where('transaction_type', 'debit')->sum('amount');
            $balances['total_balance'] = $credit - $debit;
        }

        return $balances;
    }
    //deposit function
    public static function deposit($account_id, $amount, $details = [])
    {
        // Step 1: Insert credit transaction
        $tdata = \App\Models\Transaction::create([
            'account_id'       => $account_id,
            'amount'           => $amount,
            'transaction_type' => 'credit',
            'payment_mode'     => $details['payment_mode'] ?? 'cash',
            'approve_status'   => 'pending',
            'transaction_date' => $details['transaction_date'] ?? now(),
            'comment'          => $details['comment'] ?? 'Deposit',
            'bank_name'        => $details['bank_name'] ?? null,
            'cheque_no'        => $details['cheque_no'] ?? null,
            'cheque_date'      => $details['cheque_date'] ?? null,
            'utr_no'           => $details['utr_no'] ?? null,
            'transfer_date'    => $details['transfer_date'] ?? null,
            'transfer_mode'    => $details['transfer_mode'] ?? null,
            'credited'         => $details['credited'] ?? null,
        ]);

        $transaction = \App\Models\Transaction::with('accounts.members')->where('id', $tdata->id)->first();

        $dlttemplateid = 1707172234107198375;
        $mobile = $transaction->accounts->members->member_info_mobile_no;
        $AccountNo = $transaction->accounts->account_no;
        $type = $transaction->transaction_type;

        $amount = $amount;
        $date = $transaction->transaction_date;

        $message = "Dear Customer, your Account $AccountNo has been $type with INR $amount on $date. Payment is subject to approval. SBC GLOBAL";

        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
        // Step 2: Return balance
        return self::getAccountBalacec($account_id);
    }

    public static function withdrow($account_id, $amount, $details = [])
    {

        // Step 1: Get current balance
        $balances = self::getAccountBalacec([$account_id]);
        $current_balance = $balances[array_key_first($balances)] ?? 0;

        // Step 2: Check if sufficient balance is available
        if ($current_balance < $amount) {
            throw new \Exception("Insufficient balance. Available: ₹" . number_format($current_balance, 2));
        }

        $transactionData = [
            'account_id'       => $account_id,
            'amount'           => $amount,
            'transaction_type' => 'debit',
            'payment_mode'     => $details['payment_mode'] ?? 'cash',
            'approve_status'   => 'pending',
            'transaction_date' => $details['transaction_date'] ?? now(),
            'comment'          => $details['comment'] ?? 'Withdraw',
            'remarks'          => $details['comment'] ?? null,
        ];

        if (($details['payment_mode'] ?? null) === 'online') {
            $transactionData = array_merge($transactionData, [
                'utr_number'    => $details['utr_no'] ?? null,
                'transfer_date' => isset($details['transfer_date'])
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $details['transfer_date'])->format('Y-m-d')
                    : null,
                'transfer_mode' => isset($details['transfer_mode']) ? strtoupper($details['transfer_mode']) : null,
                'credited_in'   => isset($details['credited']) ? (int)$details['credited'] : 0,
            ]);
        }

        // Step 5: Add extra fields for cheque transactions
        if (($details['payment_mode'] ?? null) === 'cheque') {
            $transactionData = array_merge($transactionData, [
                'bank_name'   => $details['bank_name'] ?? null,
                'cheque_no'   => $details['cheque_no'] ?? null,
                'cheque_date' => isset($details['cheque_date'])
                    ? \Carbon\Carbon::createFromFormat('d-m-Y', $details['cheque_date'])->format('Y-m-d')
                    : null,
            ]);
        }

        $tdata = \App\Models\Transaction::create($transactionData);
        //     // Step 4: Return updated balance
        $updated_balances = self::getAccountBalacec([$account_id]);

        // $transaction = \App\Models\Transaction::with('accounts.members')->where('id', $tdata->id)->first();

        // $mobile = $transaction->accounts->members->member_info_mobile_no;

        // $AccountNo = $transaction->accounts->account_no;
        // $type = $tdata->transaction_type;

        // $available_balance = $updated_balances['total_balance'];

        // $amount = $amount;
        // $date = $transaction->transaction_date;

        // $dlttemplateid = 1707172234108850512;
        // $message = "Dear Customer, your Account $AccountNo has been $type with INR $amount on $date. The Available Balance is INR $available_balance. SBC GLOBAL";

        // \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

        return $updated_balances[array_key_first($updated_balances)] ?? 0;
    }


    public static function getAccountBalanceBeforeDate($accountId, $date)
    {
        // Get total credits before the date
        $totalCredit = \App\Models\Transaction::where('account_id', $accountId)
            ->where('transaction_type', 'credit')
            ->where('created_at', '<', $date)
            ->sum('amount');

        // Get total debits before the date
        $totalDebit = \App\Models\Transaction::where('account_id', $accountId)
            ->where('transaction_type', 'debit')
            ->where('created_at', '<', $date)
            ->sum('amount');

        // Balance = total credits - total debits
        return $totalCredit - $totalDebit;
    }
}
