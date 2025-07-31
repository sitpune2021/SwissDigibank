<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\AccountsTransactionsHelper;
use Illuminate\Support\Facades\DB;

class DepositController extends Controller
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
        $id = base64_decode($encodedId);
        return view('saving-current-ac.deposits.deposit-create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $encodedId)
    {
        $account_id = (int)base64_decode($encodedId);

        $rules = [
            'amount'           => 'required|numeric|min:1',
            'transaction_date' => 'required|date',
            'pay_mode'         => 'required|in:cash,online,cheque',
            'remarks'          => 'nullable|string|max:255',
        ];

        if ($request->pay_mode === 'online') {
            $rules = array_merge($rules, [
                'transfer_date'  => 'required|date',
                'utr_no'         => 'required|string|max:255',
                'transfer_mode'  => 'required|in:imps,vpa,neft',
                'credited'       => 'required|in:yes,no',
            ]);
        }

        if ($request->pay_mode === 'cheque') {
            $rules = array_merge($rules, [
                'bank_name'     => 'required|string|in:SBI,HDFC,ICICI,BOB,PNB',
                'cheque_number' => 'required|string|max:50',
                'cheque_date'   => 'required|date',
            ]);
        }

        $validated = $request->validate($rules);

        // $account_id = $request->account_id ?? 1;

        try {
            // Call deposit helper
            $balance = AccountsTransactionsHelper::deposit($account_id, (int)$request->amount, [
                'payment_mode'     => $request->pay_mode,
                'comment'          => $request->remarks,
                'transaction_date' => \Carbon\Carbon::parse($request->input('transaction_date'))
            ]);

            if ($request->pay_mode === 'online') {
                DB::table('online_transactions')->insert([
                    'account_id'     => $account_id,
                    'amount'         => $request->amount,
                    'transfer_date'  => $request->transfer_date,
                    'utr_no'         => $request->utr_no,
                    'transfer_mode'  => $request->transfer_mode,
                    'credited'       => $request->credited,
                    'remarks'        => $request->remarks,
                    'created_at'     => now(),
                ]);
            }

            if ($request->pay_mode === 'cheque') {
                DB::table('cheque_transactions')->insert([
                    'account_id'     => $account_id,
                    'amount'         => $request->amount,
                    'bank_name'      => $request->bank_name,
                    'cheque_number'  => $request->cheque_number,
                    'cheque_date'    => $request->cheque_date,
                    'remarks'        => $request->remarks,
                    'created_at'     => now(),
                ]);
            }

            return redirect()->back()->with('success', 'Amount deposited successfully. Balance: ₹' . number_format($balance['total_balance'] ?? 0, 2));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Deposit failed: ' . $e->getMessage());
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
