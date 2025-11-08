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

class ApiTransactionController extends Controller
{
    public function transactionHistory(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|string|in:current_month,last_1_month,last_3_months,last_6_months,custom',
            'from_date' => 'required_if:filter,custom|date',
            'to_date' => 'required_if:filter,custom|date|after_or_equal:from_date',
            'download' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100', // optional pagination
        ]);

        $userId = Auth::id();
        $member = Member::where('user_id', $userId)->firstOrFail();
        $account = Account::where('member_id', $member->id)->firstOrFail();

        $query = Transaction::where('account_id', $account->id);
        $filter = $request->input('filter');
        $now = Carbon::now();

        if ($filter) {
            switch ($filter) {
                case 'current_month':
                    $query->whereMonth('created_at', $now->month)
                        ->whereYear('created_at', $now->year);
                    break;

                case 'last_1_month':
                    $start = $now->copy()->subMonth()->startOfMonth();
                    $end = $now->copy()->subMonth()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case 'last_3_months':
                    $start = $now->copy()->subMonths(3)->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case 'last_6_months':
                    $start = $now->copy()->subMonths(6)->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case 'custom':
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
                        $to->endOfDay()
                    ]);
                    break;
            }
        }

        // 📥 CSV download
        if ($request->boolean('download')) {
            $transactions = $query->orderBy('created_at', 'desc')->get();
            $filename = 'transactions_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $columns = ['Date', 'Narration', 'Transaction Type'];

            $callback = function () use ($transactions, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->created_at->format('d-m-Y'),
                        $transaction->comment,
                        $transaction->transaction_type,
                    ]);
                }

                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
        }

        // 🗂 Paginate JSON response
        $perPage = $request->input('per_page', 10);
        $transactions = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return response()->json([
            'status' => true,
            'account' => $account,
            'transactions' => $transactions->through(function ($t) {
                return [
                    'date' => $t->created_at->format('d-m-Y'),
                    'narration' => $t->comment,
                    'transaction_type' => $t->transaction_type,
                ];
            }),
        ]);
    }
    
    public function filterTransactions(Request $request)
    {
        $request->validate([
            'filter' => 'nullable|string|in:current_month,last_1_month,last_3_months,last_6_months,custom',
            'from_date' => 'required_if:filter,custom|date',
            'to_date' => 'required_if:filter,custom|date|after_or_equal:from_date',
            'download' => 'nullable|boolean',
        ]);

        $userId = Auth::id();
        $member = Member::where('user_id', $userId)->firstOrFail();
        $account = Account::where('member_id', $member->id)->firstOrFail();

        $query = Transaction::where('account_id', $account->id);
        $filter = $request->input('filter');
        $now = Carbon::now();

        if ($filter) {
            switch ($filter) {
                case 'current_month':
                    $query->whereMonth('created_at', $now->month)
                        ->whereYear('created_at', $now->year);
                    break;

                case 'last_1_month':
                    $start = $now->copy()->subMonth()->startOfMonth();
                    $end = $now->copy()->subMonth()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case 'last_3_months':
                    $start = $now->copy()->subMonths(3)->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case 'last_6_months':
                    $start = $now->copy()->subMonths(6)->startOfMonth();
                    $end = $now->copy()->endOfMonth();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;

                case 'custom':
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
                        $to->endOfDay()
                    ]);
                    break;
            }
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        // 📥 If download requested
        if ($request->boolean('download')) {
            $filename = 'transactions_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $columns = ['Date', 'Narration', 'Transaction Type'];

            $callback = function () use ($transactions, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);

                foreach ($transactions as $transaction) {
                    fputcsv($file, [
                        $transaction->created_at->format('d-m-y'),
                        $transaction->comment,
                        $transaction->transaction_type,
                    ]);
                }

                fclose($file);
            };

            return Response::stream($callback, 200, $headers);
        }

        // 📤 Otherwise return JSON
        return response()->json([
            'status' => true,
            'transactions' => $transactions->map(function ($t) {
                return [
                    'date' => $t->created_at->format('d-m-Y'),
                    'narration' => $t->comment,
                    'transaction_type' => $t->transaction_type,
                ];
            }),
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
