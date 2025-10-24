<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use App\Models\Account;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Helpers\AccountsTransactionsHelper;

class ApiTransactionController extends Controller
{
    public function transactionHistory()
    {
        // $account = Account::where('member_id', Auth::id())->first();
        $userId = Auth::id();

        // Get the member related to this user
        $member = Member::where('user_id', $userId)->firstOrFail();

        // Get the account related to this member
        $account = Account::with('branch')->where('member_id', $member->id)->firstOrFail();

        if (!$account) {
            return response()->json(['message' => 'Account not found.'], 404);
        }

        $transactions = Transaction::where('account_id', $account->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json([
            'account' => $account,
            'transactions' => $transactions
        ]);
    }

    public function viewPassbook()
    {
        // $account = Account::where('member_id', Auth::id())->first();
        $userId = Auth::id();

        // Get the member related to this user
        $member = Member::where('user_id', $userId)->firstOrFail();

        // Get the account related to this member
        $account = Account::with('branch')->where('member_id', $member->id)->firstOrFail();
        if (!$account) {
            return response()->json(['message' => 'Account not found.'], 404);
        }

        $transactions = Transaction::where('account_id', $account->id)
            ->orderBy('created_at', 'asc')
            ->get();

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

    public function getBalance()
    {
        $userId = Auth::id();

        // Get the member related to this user
        $member = Member::where('user_id', $userId)->firstOrFail();

        // Get the account related to this member
        $account = Account::with('branch')->where('member_id', $member->id)->firstOrFail();
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.',
            ], 404);
        }

        $balanceData = AccountsTransactionsHelper::getAccountBalacec([$account->id]);

        return response()->json([
            'success' => true,
            'account_id' => $account->id,
            'balance' => $balanceData['total_balance'] ?? 0,
        ]);
    }


    // public function transactionHistory()
    // {
    //     $accountId = Auth::id();

    //     // Validate account exists
    //     $account = Account::find($accountId);
    //     if (!$account) {
    //         return response()->json(['message' => 'Account not found.'], 404);
    //     }

    //     // Fetch transactions with pagination, newest first
    //     $transactions = Transaction::where('account_id', $accountId)
    //         ->orderBy('created_at', 'desc')
    //         ->paginate(10);

    //     return response()->json([
    //         'account' => $account,
    //         'transactions' => $transactions
    //     ]);
    // }
    // public function viewPassbook()
    // {
    //     $accountId = Auth::id();

    //     $account = Account::find($accountId);
    //     if (!$account) {
    //         return response()->json(['message' => 'Account not found.'], 404);
    //     }

    //     // Here, passbook could mean account summary + transactions + balances
    //     $transactions = Transaction::where('account_id', $accountId)
    //         ->orderBy('created_at', 'asc') // chronological order for passbook
    //         ->get();

    //     // Calculate opening balance, credits, debits, closing balance
    //     $openingBalance = 0;
    //     $closingBalance = 0;

    //     if ($transactions->count() > 0) {
    //         $openingBalance = $transactions->first()->opening_balance ?? 0;
    //         $closingBalance = $transactions->last()->closing_balance ?? 0;
    //     }

    //     return response()->json([
    //         'account' => $account,
    //         'opening_balance' => $openingBalance,
    //         'closing_balance' => $closingBalance,
    //         'transactions' => $transactions,
    //     ]);
    // }
    // public function getBalance()
    // {
    //     // Get the account using member_id instead of user_id
    //     $account = \App\Models\Account::where('member_id', Auth::id())->first();

    //     if (!$account) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Account not found.',
    //         ], 404);
    //     }

    //     $balanceData = \App\Helpers\AccountsTransactionsHelper::getAccountBalacec([$account->id]);

    //     return response()->json([
    //         'success' => true,
    //         'account_id' => $account->id,
    //         'balance' => $balanceData['total_balance'] ?? 0,
    //     ]);
    // }
}
