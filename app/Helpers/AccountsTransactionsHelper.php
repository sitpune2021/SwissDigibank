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
            // dd($details);
            // Step 1: Insert credit transaction
            \App\Models\Transaction::create([
                'account_id'       => $account_id,
                'amount'           => $amount,
                'transaction_type' => 'credit',
                'payment_mode'     => $details['payment_mode'] ?? 'cash',
                'approve_status'   => 'pending', // change to 'approved' if needed
                'transaction_date' => now(),
                'comment'          => $details['comment'] ?? 'Deposit',
            ]);

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

            // Step 3: Insert debit transaction
            \App\Models\Transaction::create([
                'account_id'       => $account_id,
                'amount'           => $amount,
                'transaction_type' => 'debit',
                'payment_mode'     => $details['payment_mode'] ?? 'cash',
                'approve_status'   => 'pending', // or 'approved' based on workflow
                'transaction_date' => now(),
                'comment'          => $details['comment'] ?? 'Withdraw',
            ]);

            // Step 4: Return updated balance
            $updated_balances = self::getAccountBalacec([$account_id]);
            return $updated_balances[array_key_first($updated_balances)] ?? 0;
        }
    }
