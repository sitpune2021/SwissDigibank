<?php

namespace App\Http\Controllers\Api;
use App\Models\Account;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiTransactionController extends Controller
{
    public function transactionHistory($accountId)
    {
        // Validate account exists
        $account = Account::find($accountId);
        if (!$account) {
            return response()->json(['message' => 'Account not found.'], 404);
        }

        // Fetch transactions with pagination, newest first
        $transactions = Transaction::where('account_id', $accountId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'account' => $account,
            'transactions' => $transactions
        ]);
    }
    public function viewPassbook($accountId)
    {
        $account = Account::find($accountId);
        if (!$account) {
            return response()->json(['message' => 'Account not found.'], 404);
        }

        // Here, passbook could mean account summary + transactions + balances
        $transactions = Transaction::where('account_id', $accountId)
            ->orderBy('created_at', 'asc') // chronological order for passbook
            ->get();

        // Calculate opening balance, credits, debits, closing balance
        $openingBalance = 0;
        $closingBalance = 0;

        if ($transactions->count() > 0) {
            $openingBalance = $transactions->first()->opening_balance ?? 0;
            $closingBalance = $transactions->last()->closing_balance ?? 0;
        }

        return response()->json([
            'account' => $account,
            'opening_balance' => $openingBalance,
            'closing_balance' => $closingBalance,
            'transactions' => $transactions,
        ]);
    }
}
