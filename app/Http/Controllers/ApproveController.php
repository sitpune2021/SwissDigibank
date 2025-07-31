<?php

namespace App\Http\Controllers;

use App\Models\ShareTransfer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ApproveController extends Controller
{
    /**
     *  show all pending transaction
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 10); // default 10 if not passed

        $query = Transaction::with('accounts.members', 'accounts.branches')
            ->where('approve_status', '!=', 'approved');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('payment_mode', 'like', "%{$search}%")
                    ->orWhere('transaction_type', 'like', "%{$search}%")
                    ->orWhere('bank_name', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhereHas('accounts', function ($q2) use ($search) {
                        $q2->where('account_no', 'like', "%{$search}%")
                            ->orWhere('account_type', 'like', "%{$search}%")
                            ->orWhereHas('branches', function ($q3) use ($search) {
                                $q3->where('branch_name', 'like', "%{$search}%");
                            })
                            ->orWhereHas('members', function ($q4) use ($search) {
                                $q4->where('member_info_first_name', 'like', "%{$search}%")
                                    ->orWhere('member_info_last_name', 'like', "%{$search}%");
                            });
                    });
            });
        }

        $pending_transactions = $query
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends($request->all()); // preserve search & perPage on pagination links

        return view('approvals.pending_transactions', compact('pending_transactions'));
    }

    /**
     * Update pending transaction status
     */

    public function update(Request $request, $id)
    {
        try {
            $transaction = Transaction::with('accounts')->findOrFail($id);

            $transaction->approve_status = $request->input('transaction_status');
            $transaction->remarks = $request->input('remarks');
            $transaction->payment_rev_rel = $request->input('payment_status');

            if (strtolower($transaction->payment_mode) === 'online') {
                $transaction->bank_name = $request->input('bank_account_id');
            }

            if ($transaction->save()) {
                return redirect()->back()->with('success', 'Transaction updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to update transaction.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error updating transaction: ' . $e->getMessage());
        }
    }
    /**
     * Show transfer allocaction
     */
    public function approveTransfer(Request $request)
    {
        $search = $request->input('search');

        $share_transfers = ShareTransfer::with('shareholdings.promotors.branch', 'members')
            ->where('status', '!=', 'approved')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search inside 'members' relationship
                    $q->whereHas('members', function ($q2) use ($search) {
                        $q2->where('member_info_first_name', 'like', "%$search%");
                    })
                        ->orWhere('business_type', 'like', "%$search%")
                        ->orWhere('shares', 'like', "%$search%");
                });
            })
            ->paginate(10); // 10 records per page

        return view('approvals.share_transfer_approval', compact('share_transfers', 'search'));
    }
    public function approveShareTransfer(Request $request)
    {
        $validated = $request->validate([
            'share_transfer_id' => 'required|exists:share_transfer,id',
            'status'            => 'required|in:approved,not approve',
            'remarks'           => 'required|string|max:255',
        ]);

        $transfer = ShareTransfer::find($validated['share_transfer_id']);
        $transfer->status = $validated['status'];
        $transfer->remarks = $validated['remarks'];

        $transfer->save();

        return redirect()->back()->with('success', 'Share transfer updated successfully.');
    }
    /**
     * Reverse Transaction. - view form called
     */
    public function reverseTransactionView(Request $request, $id)
    {
        $decodedId = base64_decode($id);
        $transaction = Transaction::findOrFail($decodedId);
        return view('saving-current-ac.accounts.reverse-transaction', compact('transaction', 'id'));
    }

    public function reverseTransactionApprove(Request $request, $id)
    {
        $decodedId = base64_decode($id);

        $validator = Validator::make($request->all(), [
            'reverse_amount' => 'required|numeric|min:0|max:1000',
            'remarks'        => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $originalTransaction = Transaction::findOrFail($decodedId);

        $newTransaction = new Transaction();
        $newTransaction->account_id    = $originalTransaction->account_id;
        $newTransaction->amount        = $request->input('reverse_amount');
        $newTransaction->transaction_type = 'debit';
        $newTransaction->approve_status        = 'pending';
        $newTransaction->remarks       = $request->input('remarks');
        // $newTransaction->account_id = $originalTransaction->id;
        $newTransaction->comment = "Reverse Transaction";
        $newTransaction->reverse_status = 0;
        // $newTransaction->account_id    = Auth::id();
        $newTransaction->save();

        return redirect()->route('transaction.show', base64_encode($originalTransaction->id))
            ->with('success', 'Please approve reversed transaction.');
    }

    public function approveReverseTransaction()
    {
        $transactions = Transaction::with('accounts.members', 'accounts.branches')->where('approve_status', 'pending')
            ->where('reverse_status', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('approvals.reverse_transaction', compact('transactions'));
    }
    public function approveTransaction($encodedId, Request $request)
    {
        $id = base64_decode($encodedId);
        $transaction = Transaction::findOrFail($id);

        if ($transaction->approve_status !== 'pending' || $transaction->reverse_status != 0) {
            return redirect()->back()->with('error', 'Invalid transaction status.');
        }
        $transaction->transaction_type = 'credit';
        $transaction->approve_status = $request->input('transaction_status');
        $transaction->reverse_status = 1;
        $transaction->save();

        return redirect()->route('reverse-transaction.reverse_transaction')->with('success', 'Transaction approved successfully.');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
