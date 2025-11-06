<?php

namespace App\Http\Controllers;

use App\Helpers\AccountsTransactionsHelper;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Helpers\CsvExportHelper;
use App\Models\Account;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class AccountTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // view transaction

    public function index($id = null)
    {
        try {
            $account_id = base64_decode($id);
            $transactionsQuery = DB::table('transactions')
                ->select(
                    'id',
                    'account_id',
                    DB::raw("'TRANSACTION' as source_type"),
                    'transaction_date as date',
                    'payment_mode',
                    'amount',
                    'approve_status as status',
                    DB::raw('NULL as waived_amount'),
                    'remarks',
                    'transaction_type',
                )
                ->where('account_id', $account_id);

            $chargesQuery = DB::table('saving_other_charges')
                ->select(
                    'id',
                    'account_id',
                    DB::raw("'OTHER_CHARGE' as source_type"),
                    'charge_date as date',
                    DB::raw('NULL as payment_mode'),
                    'total_amount as amount',
                    DB::raw('status as status'),
                    DB::raw('NULL as waived_amount'), 
                    'remarks',
                    'charge_type as transaction_type',
                )
                ->where('account_id', $account_id);

            $Transactions = $transactionsQuery
                ->unionAll($chargesQuery)
                ->orderBy('date', 'desc')
                ->get();

            $account = DB::table('accounts')->find($account_id);
            // dd( $Transactions );
            return view('saving-current-ac.accounts.view-transactions', compact('Transactions', 'account'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function downloadCsvExample($id)
    {
        $headers = [
            'Branch Name',
            'Agent Name',
            'Agent Code',
            'Supervisor Name',
            'Supervisor Code',
            'Groups Name',
            'Collection Center Name',
            'Member Name',
            'Member Code',
            'Account Number',
            'Saving Account Scheme',
            'Payment Mode',
            'Transaction Date',
            'Transaction Type',
            'O Balance',
            'Credit',
            'Debit',
            'C Balance',
            'Transaction Status',
            'Approved By',
            'Is Accounted',
            'Message',
            'Tranx',
            'Reference Type',
            'Collected By Name',
            'Created By Name',
            'Cheque Number',
            'Cheque Date',
            'Bank Name',
            'Transfer Date',
            'Transfer Mode',
            'Transaction Number',
            'Bank Account',
            'Cheque Clearing Date',
            'Gst Rate',
            'Customer Gst No'
        ];

        $account_id = $id;

        $transactionsQuery = DB::table('transactions')
            ->select(
                'transactions.id',
                'transactions.account_id',
                DB::raw("'TRANSACTION' as source_type"),
                'transactions.transaction_date as date',
                'transactions.payment_mode',
                'transactions.transaction_type',
                'transactions.amount',
                'transactions.approve_status as status',
                'transactions.remarks',
                DB::raw('NULL as is_accounted'),
                DB::raw("CASE WHEN transaction_type = 'credit' THEN amount ELSE 0 END as credited_amount"),
                DB::raw("CASE WHEN transaction_type = 'debit' THEN amount ELSE 0 END as debited_amount")
            )
            ->where('transactions.account_id', $account_id);

        $chargesQuery = DB::table('saving_other_charges')
            ->select(
                'saving_other_charges.id',
                'saving_other_charges.account_id',
                DB::raw("'OTHER_CHARGE' as source_type"),
                'saving_other_charges.charge_date as date',
                DB::raw("NULL as payment_mode"),
                DB::raw("saving_other_charges.charge_type as transaction_type"),
                DB::raw("saving_other_charges.total_amount as amount"),
                DB::raw("saving_other_charges.status as status"),
                DB::raw('NULL as is_accounted'),
                'saving_other_charges.remarks',
                DB::raw("saving_other_charges.total_amount as credited_amount"),
                DB::raw("0 as debited_amount"),

            )
            ->where('saving_other_charges.account_id', $account_id);

        $unionSql = $transactionsQuery->toSql() . ' UNION ALL ' . $chargesQuery->toSql() . ' ORDER BY date DESC';
        $bindings = array_merge($transactionsQuery->getBindings(), $chargesQuery->getBindings());
        $mergedData = DB::select($unionSql, $bindings);

        $transactions = collect($mergedData);
        $accounts = Account::with(['scheme', 'members'])->find($account_id);

        $transactions = $transactions->map(function ($txn) use ($accounts) {
            $txn->accounts = $accounts;
            return $txn;
        });

        $data = $transactions->map(function ($txn) {

            return [
                $txn->accounts->branches->branch_name ?? '',
                $txn->agent->name ?? '',
                $txn->agent->code ?? '',
                $txn->supervisor->name ?? '',
                $txn->supervisor->code ?? '',
                $txn->group->name ?? '',
                $txn->collectionCenter->name ?? '',
                $txn->accounts->members->member_info_first_name ?? '',
                $txn->accounts->members->id ?? '',
                $txn->accounts->account_no  ?? '',
                $txn->accounts->scheme->scheme_name ?? '',
                $txn->accounts->payment_mode ?? '',
                $txn->accounts->transaction_date ?? '',
                $txn->transaction_type ?? '',
                $txn->accounts->opening_balance ?? '',
                $txn->credited_amount ?? '',
                $txn->debited_amount ?? '',
                $txn->closing_balance ?? '',
                $txn->approve_status ?? '',
                $txn->approvedBy->name ?? 'System',
                $txn->is_accounted ? 'Yes' : 'No',
                $txn->message ?? '',
                $txn->tranx ?? '',
                $txn->reference_type ?? '',
                $txn->collected_by_name ?? '',
                $txn->createdBy->name ?? '',
                $txn->cheque_number ?? '',
                $txn->cheque_date ?? '',
                $txn->bank_name ?? '',
                $txn->transfer_date ?? '',
                $txn->transfer_mode ?? '',
                $txn->transaction_number ?? '',
                $txn->bank_account ?? '',
                $txn->cheque_clearing_date ?? '',
                $txn->gst_rate ?? '',
                $txn->customer_gst_no ?? ''
            ];
        })->toArray();


        return CsvExportHelper::downloadCsv($headers, $data, 'transactions.csv');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        try {
            $decryptedId = base64_decode($id);
            $transactions = Transaction::with('accounts')->findOrFail($decryptedId);

            return view('saving-current-ac.accounts.single-transaction', compact('transactions', 'decryptedId'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transaction.index')->with('success', 'Transaction deleted successfully.');
    }

    public function printReceipt($id)
    {
        $id = base64_decode($id);
        $transaction = Transaction::with('accounts.members')->where('id', $id)->first();

        $account = $transaction->accounts ?? null;
        $member  = $account->members ?? null;

        $accountNo = $account->account_no ?? 'N/A';
        if (!$transaction || !$account || !$member) {
            abort(404, 'Transaction not found.');
        }

        $balances = AccountsTransactionsHelper::getAccountBalacec([$transaction->account_id]);

        $data = [
            'member_no' => $member->member_no ?? 'N/A',
            'member_info_first_name' => $member->member_info_first_name ?? 'N/A',
            'member_info_middle_name' => $member->member_info_middle_name ?? '',
            'member_info_last_name' => $member->member_info_last_name ?? '',
            'member_info_mobile_no' => $member->member_info_mobile_no ?? 'N/A',
            'account_no' => $accountNo ?? 'N/A',
            'transaction_date' => \Carbon\Carbon::parse($transaction->transaction_date)->format('d-m-Y'),
            'ref_id' => $transaction->id,
            'amount' => number_format($transaction->amount, 2),
            'amount_suffix' => 'CR',
            'payment_mode' => $transaction->payment_mode ?? 'N/A',
            'avl_balance' => number_format($balances['total_balance'] ?? 0, 2),
            'approve_status' => $transaction->approve_status == 1 ? 'Approved' : 'Pending',
            'type' => $transaction->transaction_type ?? 'Membership Fee',
            'remarks' => $transaction->remarks ?? '',
            'printed_on' => now()->format('d-m-Y H:i:s'),
            'printed_by' => auth()->name ?? 'System',
        ];

        $pdf = Pdf::loadView('saving-current-ac.accounts.print', $data)
            ->setPaper([0, 0, 238.346, 1000], 'portrait');

        return $pdf->stream('saving-current-ac.accounts.print');
    }
}
