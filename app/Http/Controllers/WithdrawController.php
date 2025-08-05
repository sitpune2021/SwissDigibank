<?php

namespace App\Http\Controllers;

use App\Helpers\AccountsTransactionsHelper;
use Illuminate\Http\Request;

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
        $id = base64_decode($encodedId);
        return view('saving-current-ac.withdraws.withdraw-create', compact('id'));
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
        $validated = $request->validate($rules);

        try {
            $balance = AccountsTransactionsHelper::withdrow($account_id, (int)$request->amount, [
                'payment_mode'     => $request->pay_mode,
                'comment'          => $request->remarks,
                'transaction_date' => \Carbon\Carbon::parse($request->input('transaction_date'))
            ]);

            return redirect()->route('accounts.show', base64_encode($account_id))->with('success', 'Amount withdraw successfully. Balance: ₹' . number_format($balance['total_balance'] ?? 0, 2));
        } catch (\Exception $e) {
            return redirect()->route('accounts.show', base64_encode($account_id))->with('error', 'Withdraw failed: ' . $e->getMessage());
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
