<?php

namespace App\Http\Controllers\Api;

use App\Models\Member;
use App\Models\Account;
use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;
use App\Helpers\AccountsTransactionsHelper;

class ApiTransactionController extends Controller
{
    public function transactionHistory(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|in:1,2,3,4,5',
            'from_date' => 'required_if:filter,5|date',
            'to_date' => 'required_if:filter,5|date|after_or_equal:from_date',
            'download' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        $userId = Auth::id();
        $member = Member::where('user_id', $userId)->firstOrFail();
        $account = Account::where('member_id', $member->id)->firstOrFail();

        $query = Transaction::where('account_id', $account->id);
        $now = Carbon::now();

        // Filters
        $filterMap = [
            '1' => ['key' => '1', 'title' => 'Current Month'],
            '2' => ['key' => '2', 'title' => 'Last 1 Month'],
            '3' => ['key' => '3', 'title' => 'Last 3 Months'],
            '4' => ['key' => '4', 'title' => 'Last 6 Months'],
            '5' => ['key' => '5', 'title' => 'Custom Range'],
        ];

        $filterId = $request->input('filter');
        $selectedFilter = $filterId ? ($filterMap[$filterId] ?? null) : null;

        if ($selectedFilter) {
            switch ($selectedFilter['key']) {
                case '1':
                    $query->whereMonth('created_at', $now->month)
                        ->whereYear('created_at', $now->year);
                    break;

                case '2':
                    $start = $now->copy()->subMonth()->startOfMonth();
                    $end = $now->copy()->subMonth()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case '3':
                    $start = $now->copy()->subMonths(3)->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case '4':
                    $start = $now->copy()->subMonths(6)->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case '5':
                    $from = Carbon::parse($request->from_date);
                    $to = Carbon::parse($request->to_date);

                    if ($from->diffInDays($to) > 365) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Date range cannot exceed 365 days.'
                        ], 422);
                    }

                    $query->whereBetween('created_at', [
                        $from->startOfDay(),
                        $to->endOfDay(),
                    ]);
                    break;
            }
        }

        // CSV export
        if ($request->boolean('download')) {
            $transactions = $query->orderBy('created_at', 'desc')->get();
            $filename = 'transactions_' . now()->format('Ymd_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $columns = ['Date', 'Narration', 'Transaction Type', 'Amount'];

            $callback = function () use ($transactions, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->created_at->format('d-m-Y'),
                        $transaction->comment,
                        $transaction->transaction_type,
                        number_format($transaction->amount, 2),
                    ]);
                }

                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
        }

        // -----------------------------
        //  RUNNING BALANCE CALCULATION
        // -----------------------------

        // Get total balance using helper
        $balanceData = AccountsTransactionsHelper::getAccountBalacec($account->id);
        $currentBalance = $balanceData['total_balance'] ?? 0;

        // Pagination
        $perPage = $request->input('per_page', 10);
        $transactions = $query->orderBy('created_at', 'desc')->paginate($perPage);

        // Convert items to collection
        $items = collect($transactions->items());

        // Reverse (oldest → newest) for correct balance calculation
        $items = $items->reverse()->values();

        // Apply running balance
        $items = $items->map(function ($t) use (&$currentBalance) {

            if ($t->transaction_type === 'credit') {
                $currentBalance += $t->amount;
            } else {
                $currentBalance -= $t->amount;
            }

            return [
                'date' => $t->created_at->format('d-m-Y'),
                'narration' => $t->comment,
                'transaction_type' => $t->transaction_type,
                'amount' => number_format($t->amount, 2),
                'balance' => number_format($currentBalance, 2),
            ];
        });

        // Reverse back to newest → oldest for frontend
        $items = $items->reverse()->values();

        // Replace original paginator items
        $transactions->setCollection($items);

        return response()->json([
            'status' => true,
            'selected_filter' => $selectedFilter,
            'transactions' => $transactions,
        ]);
    }

    public function filterTransactions(Request $request)
    {
        $userId = Auth::id();
        $member = Member::where('user_id', $userId)->firstOrFail();
        $account = Account::where('member_id', $member->id)->firstOrFail();

        $filterOptions = [
            ['id' => '1', 'title' => 'Current Month'],
            ['id' => '2', 'title' => 'Last 1 Month'],
            ['id' => '3', 'title' => 'Last 3 Months'],
            ['id' => '4', 'title' => 'Last 6 Months'],
            ['id' => '5', 'title' => 'Custom Range'],
        ];

        return response()->json([
            'status' => true,
            'filters' => $filterOptions
        ]);
    }

    public function getBalance()
    {
        $userId = Auth::id();
        $member = Member::where('user_id', $userId)->firstOrFail();
        $account = Account::with('branch')->where('member_id', $member->id)->firstOrFail();

        $balanceData = \App\Helpers\AccountsTransactionsHelper::getAccountBalacec([$account->id]);

        return response()->json([
            'success' => true,
            'account_id' => $account->id,
            'balance' => $balanceData['total_balance'] ?? 0,
        ]);
    }
}
