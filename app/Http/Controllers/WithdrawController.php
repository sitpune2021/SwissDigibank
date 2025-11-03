<?php

namespace App\Http\Controllers;

use App\Helpers\AccountsTransactionsHelper;
use App\Models\Bank;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create($encodedId)
    {
        try {
            $id = base64_decode($encodedId);
            $banks = Bank::all();
            $member=Transaction::with(['accounts.members.kyc','accounts.scheme'])->where('account_id', $id)->first();

            return view('saving-current-ac.withdraws.withdraw-create', compact('id', 'banks','member'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, $encodedId)
    // {
    //     try {
    //         $account_id = (int)base64_decode($encodedId);

    //         $rules = [
    //             'amount'           => 'required|numeric|min:1',
    //             'transaction_date' => 'required|date',
    //             'pay_mode'         => 'required|in:cash,online,cheque',
    //             'remarks'          => 'nullable|string|max:255',
    //         ];
    //         $validated = $request->validate($rules);

    //         try {
    //             $balance = AccountsTransactionsHelper::withdrow($account_id, (int)$request->amount, [
    //                 'payment_mode'     => $request->pay_mode,
    //                 'comment'          => $request->remarks,
    //                 'transaction_date' => \Carbon\Carbon::parse($request->input('transaction_date'))
    //             ]);

    //             return redirect()->route('accounts.show', base64_encode($account_id))->with('success', 'Please approve status for withdrawal');
    //         } catch (\Exception $e) {
    //             return redirect()->route('accounts.show', base64_encode($account_id))->with('error', 'Withdraw failed: ' . $e->getMessage());
    //         }
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         abort(404);
    //     } 
    // }

    public function store(Request $request, $encodedId)
    {
        try {
            Log::info('Withdrawal request started', [
                'encoded_id' => $encodedId,
                'request'    => $request->all(),
            ]);

            $account_id = (int) base64_decode($encodedId);

            // Base rules
            $rules = [
                'amount'           => 'required|numeric|min:1',
                'transaction_date' => 'required|date',
                'pay_mode'         => 'required|in:cash,online,cheque',
                'remarks'          => 'nullable|string|max:255',
            ];

            // Extra rules for online
            if ($request->input('pay_mode') === 'online') {
                $rules = array_merge($rules, [
                    'utr_no'        => 'required|string|max:255|unique:transactions,utr_number',
                    'transfer_date' => 'required|date_format:d-m-Y',
                    'transfer_mode' => 'required|in:imps,vpa,neft',
                    'credited'      => 'required|in:0,1',
                ]);
            }

            // Extra rules for cheque
            if ($request->input('pay_mode') === 'cheque') {
                $rules = array_merge($rules, [
                    'bank_name'     => 'nullable',
                    'cheque_number' => 'required|string|max:50|unique:transactions,cheque_no',
                    'cheque_date'   => 'required|date_format:d-m-Y',
                ]);
            }

            $validated = $request->validate($rules);

            Log::info('Validation successful for withdrawal', [
                'account_id' => $account_id,
                'validated'  => $validated,
            ]);

            try {
                $balance = AccountsTransactionsHelper::withdrow($account_id, (int) $request->amount, [
                    'payment_mode'     => $request->pay_mode,
                    'comment'          => $request->remarks,
                    'transaction_date' => \Carbon\Carbon::parse($request->transaction_date),
                    'utr_no'           => $request->utr_no ?? null,
                    'transfer_date'    => $request->transfer_date ?? null,
                    'transfer_mode'    => $request->transfer_mode ?? null,
                    'credited'         => $request->credited ?? null,
                    'bank_name'        => $request->bank_name ?? null,
                    'cheque_no'        => $request->cheque_number ?? null,
                    'cheque_date'      => $request->cheque_date ?? null,
                ]);

                Log::info('Withdrawal processed successfully', [
                    'account_id' => $account_id,
                    'balance'    => $balance,
                ]);

                return redirect()
                    ->route('accounts.show', base64_encode($account_id))
                    ->with('success', 'Please approve status for withdrawal');
            } catch (\Exception $e) {
                Log::error('Withdrawal failed in AccountsTransactionsHelper', [
                    'account_id' => $account_id,
                    'error'      => $e->getMessage(),
                    'trace'      => $e->getTraceAsString(),
                ]);

                return redirect()
                    ->route('accounts.show', base64_encode($account_id))
                    ->with('error', 'Something went wrong while processing withdrawal.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Invalid account ID on withdrawal', [
                'encoded_id' => $encodedId,
                'error'      => $e->getMessage(),
            ]);
            abort(404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed for withdrawal', [
                'errors' => $e->errors(),
            ]);
            return redirect()
                ->route('accounts.show')
                ->with('error', 'Invalid account. Please try again.');
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
