<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AccountsTransactionsHelper;
use App\Models\Account;
use App\Models\Bank;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Saving Account Deposit - create function
     */
    public function create($encodedId)
    {
        try {
            $id = base64_decode($encodedId);
            // $banks = Bank::all();
             $banks = Bank::pluck('name', 'id');
            $member = Transaction::with(['accounts.members.kyc', 'accounts.scheme'])->where('account_id', $id)->first();

            return view('saving-current-ac.deposits.deposit-create', compact('id', 'banks', 'member'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Saving Account Deposit - store function
     */

    public function store(Request $request, $encodedId)
    {
        try {
            Log::info('Execution started');
            $account_id = (int) base64_decode($encodedId);

            // ✅ Validation rules
            $rules = [
                'amount'           => 'required|min:1',
                'transaction_date' => 'required|date',
                'pay_mode'         => 'required|in:cash,online,cheque',
                'remarks'          => 'nullable|string|max:255',
            ];

            if ($request->pay_mode === 'online') {
                $rules = array_merge($rules, [
                    'transfer_date'  => 'required|date_format:d-m-Y',
                    'utr_no'         => [
                        'required',
                        'string',
                        'max:255',
                        Rule::unique('online_transactions', 'utr_no'),
                    ],
                    'transfer_mode'  => 'required|in:imps,vpa,neft',
                    'credited'       => 'required|in:1,0',
                ]);
            }

            if ($request->pay_mode === 'cheque') {
                $rules = array_merge($rules, [
                    'bank_name'     => 'nullable',

                    'cheque_number' => [
                        'required',
                        'string',
                        'max:50',
                        Rule::unique('transactions', 'cheque_no'),
                    ],
                    'cheque_date'   => 'required|date_format:d-m-Y',
                ]);
            }

            $validated = $request->validate($rules);

            Log::info('Deposit request received', [
                'account_id' => $account_id,
                'pay_mode'   => $request->pay_mode,
                'amount'     => $request->amount,
                'validated'  => $validated
            ]);

            try {
                // ✅ Insert transaction via helper
                $balance = AccountsTransactionsHelper::deposit(
                    $account_id,
                    (int) $request->amount,
                    [
                        'payment_mode'   => $request->pay_mode,
                        'comment'        => $request->comment,
                        'remarks'        => $request->remark,
                        'transaction_date' => \Carbon\Carbon::parse($request->transaction_date),
                        'bank_name'      => $request->bank_name ?? null,
                        'cheque_no'      => $request->cheque_number ?? null,
                        'cheque_date'    => $request->cheque_date
                            ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->cheque_date)->format('Y-m-d')
                            : null,
                        'utr_no'         => $request->utr_no ?? null,
                        'transfer_date'  => $request->transfer_date
                            ? \Carbon\Carbon::createFromFormat('d-m-Y', $request->transfer_date)->format('Y-m-d')
                            : null,
                        'transfer_mode'  => $request->transfer_mode ?? null,
                        'credited'       => $request->credited ?? null,
                    ]
                );

                Log::info('Deposit successful in AccountsTransactionsHelper', [
                    'account_id' => $account_id,
                    'balance'    => $balance
                ]);

                return redirect()->route('accounts.show', base64_encode($account_id))
                    ->with('success', 'Amount deposited! Please approve transaction');
            } catch (\Exception $e) {
                Log::error('Deposit failed inside transaction', [
                    'account_id' => $account_id,
                    'error'      => $e->getMessage(),
                    'trace'      => $e->getTraceAsString()
                ]);

                return redirect()->route('accounts.show', base64_encode($account_id))
                    ->with('error', 'Deposit failed: Try again');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Invalid account id on deposit', [
                'encoded_id' => $encodedId,
                'error'      => $e->getMessage()
            ]);
            abort(404);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
