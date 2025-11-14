<?php

namespace App\Http\Controllers;

use App\Helpers\AccountsTransactionsHelper;
use App\Models\ShareTransfer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Account;
use App\Models\FDAccount;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\LoanApplication;
use App\Models\MortgageLoanApplication;
use App\Models\LoanAgainstApplication;
use App\Models\BusinessLoanApplication;
use App\Models\CcOdLoanApplication;
use App\Models\DailyWeeklyApplication;
use App\Models\DdsAccount;
use App\Models\VehicalApplication;
use App\Models\MembershipChargeTransaction;
// use Illuminate\Http\Request;
use App\Models\PersonalLoanApplication;
use Illuminate\Pagination\LengthAwarePaginator;

class ApproveController extends Controller
{

    public function index(Request $request)
    {
        try {
            $perPage = $request->input('perPage', 10);
            Log::info('🟢 Starting Pending Transaction Fetch', ['perPage' => $perPage]);

            Log::info('Fetching transaction data...');
            $transactionQuery = DB::table('transactions')
                ->select(
                    'transactions.id',
                    DB::raw("'transaction' AS source_table"),
                    'transactions.payment_mode',
                    'transactions.amount',
                    'transactions.bank_name',
                    'transactions.approve_status',
                    'transactions.created_at',
                    'branches.branch_name',
                    'accounts.account_no',
                    'accounts.account_type',
                    'accounts.account_holder_type',
                    'accounts.firm_name',
                    'accounts.branch_id',
                    'accounts.member_id',
                    'accounts.account_status',
                    DB::raw("'Saving' AS transaction_type")
                )
                ->join('accounts', 'accounts.id', '=', 'transactions.account_id')
                ->join('branches', 'branches.id', '=', 'accounts.branch_id')
                ->where('transactions.approve_status', '!=', 'approved')
                ->whereNull('transactions.deleted_at');

            Log::info('Transaction query built successfully.');

            Log::info('Fetching membership charges data...');
            $membershipQuery = DB::table('membership_charges_transaction')
                ->select(
                    'membership_charges_transaction.id',
                    DB::raw("'membership_charges_transaction' AS source_table"),
                    'membership_charges_transaction.charges_pay_mode AS payment_mode',
                    'membership_charges_transaction.membership_fee AS amount',
                    'membership_charges_transaction.cheque_bank_name AS bank_name',
                    'membership_charges_transaction.approve_status',
                    'membership_charges_transaction.created_at',
                    'branches.branch_name',
                    'accounts.account_no',
                    DB::raw("'Share amount' AS account_type"),
                    'accounts.account_holder_type',
                    DB::raw('NULL AS firm_name'),
                    'accounts.branch_id',
                    'accounts.member_id',
                    'accounts.account_status',
                    DB::raw("'Share amount' AS transaction_type")
                )
                ->leftJoin('accounts', 'accounts.id', '=', 'membership_charges_transaction.member_id')
                ->leftJoin('members', 'members.id', '=', 'accounts.member_id')
                ->leftJoin('branches', 'branches.id', '=', 'members.general_branch')
                ->where('membership_charges_transaction.type', '=', 'Share amount')
                ->where('membership_charges_transaction.approve_status', '!=', 1)
                ->whereNull('membership_charges_transaction.deleted_at');

            Log::info('Membership charges query built successfully.');

            Log::info('Combining transaction and membership queries...');
            $unionQuery = $transactionQuery->unionAll($membershipQuery);

            Log::info('Creating final combined query...');
            $finalQuery = DB::query()
                ->fromSub($unionQuery, 'combined')
                ->orderByDesc('created_at');

            Log::info('Paginating results...');
            $results = $finalQuery->paginate($perPage);

            Log::info('✅ Pending transactions fetched successfully.', [
                'total' => $results->total(),
                'perPage' => $results->perPage(),
                'currentPage' => $results->currentPage()
            ]);

            return view('approvals.pending_transactions', [
                'pending_transactions' => $results
            ]);
        } catch (\Exception $e) {
            Log::error('❌ Error fetching pending transactions', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            dd('Error fetching pending transactions: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {

        try {
            $sourceTable = $request->input('source_table');

            $status = $request->input('transaction_status');
            $remarks = $request->input('remarks');
            $paymentStatus = $request->input('payment_status');

            if ($sourceTable === 'transaction') {

                $transaction = Transaction::with('accounts.members')->findOrFail($id);

                $transaction->approve_status = $status;
                $transaction->remarks = $remarks;
                $transaction->payment_rev_rel = $paymentStatus;

                if (strtolower($transaction->payment_mode) === 'online') {
                    $transaction->bank_name = $request->input('bank_account_id');
                }

                if ($transaction->save()) {
                    $mobile = $transaction->accounts->members->member_info_mobile_no ?? '';
                    $AccountNo = $transaction->accounts->account_no;
                    $type = $transaction->transaction_type;
                    $amount = $transaction->amount;
                    $account_id = $transaction->accounts->id;
                    $updated_balances = \App\Helpers\AccountsTransactionsHelper::getAccountBalacec([$account_id]);
                    $available_balance = $updated_balances['total_balance'];
                    $date = $transaction->transaction_date;

                    $dlttemplateid = '1707172234108850512';
                    $message = "Dear Customer, your Account $AccountNo has been $type with INR $amount on $date. The Available Balance is INR $available_balance. SBC GLOBAL";
                    \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

                    return redirect()->back()->with('success', 'Saving transaction approved successfully.');
                }
            }
             elseif ($sourceTable === 'membership_charges_transaction') {

                $updated = DB::table('membership_charges_transaction')
                    ->where('id', $id)
                    ->update([
                        'approve_status' => 1,
                        'updated_at' => now(),
                    ]);

                if ($updated) {
                    return redirect()->back()->with('success', 'Membership Share Amount approved successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to update Membership Share Amount.');
                }
            } 
            else {
                return redirect()->back()->with('error', 'Invalid source table specified.');
            }
        } catch (\Exception $e) {
            dd('Error updating status: ' . $e->getMessage());
        }
    }

    // pending transaction ends

    // Approve account status
    public function updateAccountStatus(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'transaction_status' => 'required|in:0,1,2',
                'remarks' => 'nullable|string|max:255',
                'source_table' => 'required|in:accounts,fd_accounts,misaccounts,rd_accounts,dds_accounts',
            ]);

            if ($validated['source_table'] === 'accounts') {
                // 🔹 For normal accounts
                $account = Account::findOrFail($id);
                $account->approve_status = $validated['transaction_status'];
                $account->remarks = $validated['remarks'];
                $account->save();

                try {
                    $Account = Account::with('members')->find($account->id);
                    $mobile = $Account->members->member_info_mobile_no;
                    $accountNo = $Account->account_no;

                    if ($account->approve_status == "1") {
                        $dlttemplateid = 1707172181386332784;
                        $message = "Dear Customer, congratulations! your saving a/c  $accountNo is approved. SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LTD";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        $dlttemplateid = 1707172181389479065;
                        $message = "Dear Customer, your saving a/c $accountNo is disapproved. Please contact branch for details. SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LTD";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
                }

                Log::info('Account status updated', [
                    'table' => 'accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'fd_accounts') {
                // 🔹 For FD accounts
                $fdAccount = FdAccount::findOrFail($id);
                $fdAccount->status = $validated['transaction_status'];
                $fdAccount->remarks = $validated['remarks'];
                $fdAccount->save();

                try {
                    $fdaccount = \App\Models\FdAccount::with('member')->find($fdAccount->id);
                    $mobile = $fdaccount->member->member_info_mobile_no;
                    $account = $fdaccount->fd_no;

                    if ($fdaccount->status == 1) {
                        $dlttemplateid = 1707172234113442938;
                        $message = "Congratulations! Your FD no $account is approved. SBC GLOBAL";
                    } elseif ($fdaccount->status == 2) {
                        $dlttemplateid = 1707172234115386436;
                        $message = "Dear Customer, your FD no $account is disapproved. SBC GLOBAL";
                    }

                    \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

                    if ($fdaccount->status == 1) {
                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
                }

                Log::info('FD Account status updated', [
                    'table' => 'fd_accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'misaccounts') {
                // 🔹 MIS Accounts
                $misAccount = \App\Models\Misaccount::findOrFail($id);
                $misAccount->status = $validated['transaction_status'];
                $misAccount->remarks = $validated['remarks'];
                $misAccount->save();

                try {
                    $mis_account = \App\Models\Misaccount::with('member')->find($misAccount->member_id);
                    $mobile = $mis_account->member->member_info_mobile_no;
                    $misAccountNo = $misAccount->mis_account_no;

                    if ($misAccount->status == 1) {
                        $dlttemplateid = 1707172234273006430;
                        $message = "Congratulations! your MIS no $misAccountNo is approved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        $dlttemplateid = 1707172234274327934;
                        $message = "Dear Customer, your MIS no $misAccountNo is disapproved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS for MIS Account', ['error' => $e->getMessage()]);
                }

                Log::info('MIS Account status updated', [
                    'table' => 'misaccounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'rd_accounts') {
                // 🔹 RD Accounts
                $rdAccount = \App\Models\RdAccount::findOrFail($id);
                $status = $validated['transaction_status'] == 1 ? 'Approved' : 'Disapproved';
                $rdAccount->approve_status = $status;
                $rdAccount->remarks = $validated['remarks'];
                $rdAccount->save();

                try {
                    $member = \App\Models\Member::find($rdAccount->member_id);
                    $dlttemplateid = 1707172234135070517;
                    $mobile = $member->member_info_mobile_no;
                    $rdAccountNo = $rdAccount->rd_no;
                    $message = "Congratulations! your RD no. $rdAccountNo is approved. SBC GLOBAL";
                    \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);

                    if ($rdAccount->approve_status == 'Approved') {
                        return redirect()->back()->with('success', 'Account approved successfully.');
                    } else {
                        return redirect()->back()->with('error', 'Account disapproved.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS for RD Account', ['error' => $e->getMessage()]);
                }

                Log::info('RD Account status updated', [
                    'table' => 'rd_accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } elseif ($validated['source_table'] === 'dds_accounts') {
                // 🔹 DDS Accounts (✅ Corrected Section)
                $ddsAccount = \App\Models\DdsAccount::findOrFail($id);
                $ddsAccount->status = (int) $validated['transaction_status'];
                $ddsAccount->remarks = $validated['remarks'];
                $ddsAccount->save();

                try {
                    $mobile = $ddsAccount->member_mobile;
                    $accountNo = $ddsAccount->dd_no;

                    if (!$mobile) {
                        Log::warning("Mobile number missing for DDS account ID: {$ddsAccount->id}");
                        return redirect()->back()->with('error', 'Mobile number missing. SMS not sent.');
                    }

                    if ($ddsAccount->status == 1) {
                        // ✅ Approved Message
                        $dlttemplateid = '1707172234296835518';
                        $message = "Congratulations! your DD no. $accountNo is approved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('success', 'DDS Account approved successfully.');
                    } elseif ($ddsAccount->status == 2) {
                        // ❌ Disapproved Message
                        $dlttemplateid = '1707172234298099036';
                        $message = "Dear Customer, your DD no. $accountNo is disapproved. SBC GLOBAL";
                        \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
                        return redirect()->back()->with('error', 'DDS Account disapproved.');
                    } else {
                        return redirect()->back()->with('info', 'DDS Account status updated but no SMS sent.');
                    }
                } catch (\Exception $e) {
                    Log::error('Error while sending SMS for DDS Account', ['error' => $e->getMessage()]);
                    return redirect()->back()->with('error', 'Something went wrong while sending SMS.');
                }

                Log::info('DDS Account status updated', [
                    'table' => 'dds_accounts',
                    'id' => $ddsAccount->id,
                    'new_status' => $ddsAccount->status,
                    'remarks' => $ddsAccount->remarks,
                    'updated_by' => Auth::id(),
                ]);
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Account not found', [
                'id' => $id,
                'source_table' => $request->input('source_table'),
                'updated_by' => Auth::id(),
            ]);
            abort(404);
        } catch (\Exception $e) {
            Log::error('Error updating account status', [
                'message' => $e->getMessage(),
                'id' => $id,
                'request' => $request->all(),
                'updated_by' => Auth::id(),
            ]);
            return redirect()->back()->withErrors(['error' => 'Something went wrong while updating account status.']);
        }
    }

    public function approveAccounts(Request $request)
    {
        try {
            $search = $request->input('search');
            $perPage = $request->input('perPage', 10);

            $sql = "
        SELECT 
            accounts.id,
            accounts.account_no,
            accounts.account_type,
            accounts.firm_name,
            accounts.amount_deposit,
            accounts.payment_mode,
            accounts.account_holder_type,
            accounts.mode_of_operation,
            accounts.approve_status,
            accounts.open_date,
            accounts.branch_id,
            accounts.member_id,
            JSON_OBJECT(
             'id', members.id,
             'member_no', members.member_no,
                'member_info_first_name', members.member_info_first_name,
                'member_info_last_name', members.member_info_last_name
            ) AS members,
              JSON_OBJECT(
            'branch_name', branches.branch_name
            ) AS branch,
            'accounts' AS source_table,
            accounts.created_at
        FROM accounts
        INNER JOIN branches ON accounts.branch_id = branches.id
        INNER JOIN members ON accounts.member_id = members.id
        WHERE accounts.account_type IN ('SAVING', 'CURRENT', 'RD', 'MIS')
          AND accounts.approve_status = '0'

        UNION ALL

        SELECT 
            fd_accounts.id,
            fd_accounts.account_no AS account_no,
            'FD' AS account_type,
            null,
            fd_accounts.fd_amount AS amount_deposit,
            fd_accounts.payment_mode,
            fd_accounts.account_holder_type,
            fd_accounts.mode_of_operation,
            fd_accounts.status AS approve_status,
            fd_accounts.open_date,
            fd_accounts.branch_id,
            fd_accounts.member_id,
            JSON_OBJECT(
             'id', members.id,
             'member_no', members.member_no,
                'member_info_first_name', members.member_info_first_name,
                'member_info_last_name', members.member_info_last_name
            ) AS members,
            JSON_OBJECT(
            'branch_name', branches.branch_name
             ) AS branch,
            'fd_accounts' AS source_table,
            fd_accounts.created_at
        FROM fd_accounts
        INNER JOIN branches ON fd_accounts.branch_id = branches.id
        INNER JOIN members ON fd_accounts.member_id = members.id
        WHERE fd_accounts.status = '0'
 UNION ALL
        SELECT 
        misaccounts.id,
        misaccounts.mis_account_no AS account_no,
        'MIS' AS account_type,
        NULL AS firm_name,
        misaccounts.mis_amount AS amount_deposit,
        NULL AS payment_mode,
        NULL AS account_holder_type,
        NULL AS mode_of_operation,
        misaccounts.status AS approve_status,
        misaccounts.open_date,
        misaccounts.branch_id,
        misaccounts.member_id,
        JSON_OBJECT(
            'id', members.id,
            'member_no', members.member_no,
            'member_info_first_name', members.member_info_first_name,
            'member_info_last_name', members.member_info_last_name
        ) AS members,
        JSON_OBJECT(
            'branch_name', branches.branch_name
        ) AS branch,
        'misaccounts' AS source_table,
        misaccounts.created_at
    FROM misaccounts
    INNER JOIN branches ON misaccounts.branch_id = branches.id
    INNER JOIN members ON misaccounts.member_id = members.id
    WHERE misaccounts.status = '0'

    UNION ALL
        SELECT 
        rd_accounts.id,
        rd_accounts.rd_no AS account_no,
        'RD' AS account_type,
        NULL AS firm_name,
        rd_accounts.rd_amount AS amount_deposit,
        NULL AS payment_mode,
        NULL AS account_holder_type,
        NULL AS mode_of_operation,
        rd_accounts.approve_status AS approve_status,
        rd_accounts.open_date,
        rd_accounts.branch_id,
        rd_accounts.member_id,
        JSON_OBJECT(
            'id', members.id,
            'member_no', members.member_no,
            'member_info_first_name', members.member_info_first_name,
            'member_info_last_name', members.member_info_last_name
        ) AS members,
        JSON_OBJECT(
            'branch_name', branches.branch_name
        ) AS branch,
        'rd_accounts' AS source_table,
        rd_accounts.created_at
    FROM rd_accounts
    INNER JOIN branches ON rd_accounts.branch_id = branches.id
    INNER JOIN members ON rd_accounts.member_id = members.id
    WHERE rd_accounts.approve_status = 'Pending'
 UNION ALL
 
        SELECT
        dds_accounts.id,
        dds_accounts.dd_no AS account_no,
        'DDS' AS account_type,
        NULL AS firm_name,
        dds_accounts.dd_amount AS amount_deposit,
        NULL AS payment_mode,
        NULL AS account_holder_type,
        NULL AS mode_of_operation,
        dds_accounts.status AS approve_status,
        dds_accounts.open_date,
        dds_accounts.branch_id,
        dds_accounts.member_id,
        JSON_OBJECT(
            'id', members.id,
            'member_no', members.member_no,
            'member_info_first_name', members.member_info_first_name,
            'member_info_last_name', members.member_info_last_name
        ) AS members,
        JSON_OBJECT(
            'branch_name', branches.branch_name
        ) AS branch,
        'dds_accounts' AS source_table,
        dds_accounts.created_at
    FROM dds_accounts
    INNER JOIN branches ON dds_accounts.branch_id = branches.id
    INNER JOIN members ON dds_accounts.member_id = members.id
    WHERE dds_accounts.status = 0";

            $query = DB::table(DB::raw("({$sql}) as combined"))
                ->orderBy('created_at', 'desc');


            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('account_no', 'like', "%{$search}%")
                        ->orWhere('firm_name', 'like', "%{$search}%")
                        ->orWhere('amount_deposit', 'like', "%{$search}%")
                        ->orWhere('payment_mode', 'like', "%{$search}%")
                        ->orWhere('account_holder_type', 'like', "%{$search}%")
                        ->orWhere('mode_of_operation', 'like', "%{$search}%")
                        ->orWhere('branch_name', 'like', "%{$search}%")
                        ->orWhereRaw("JSON_EXTRACT(members, '$.member_info_first_name') LIKE ?", ["%{$search}%"])
                        ->orWhereRaw("JSON_EXTRACT(members, '$.member_info_last_name') LIKE ?", ["%{$search}%"]);
                });
            }

            $pending_transactions = $query->paginate($perPage)->appends($request->all());
            // dd($pending_transactions);
            $pending_transactions->getCollection()->transform(function ($item) {
                $item->members = json_decode($item->members);
                $item->branch  = json_decode($item->branch);
                return $item;
            });

            return view('approvals.saving_rd_fd_mis', compact('pending_transactions'));
        } catch (\Exception $e) {
            Log::error('Error in approveAccounts: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return back()->withErrors(['error' => 'Something went wrong, please check logs.']);
        }
    }
    // Approve account status ends

    // Approve Share Transfer 
    public function approveTransfer(Request $request)
    {
        try {
            $search = $request->input('search');

            $share_transfers = ShareTransfer::with('shareholdings.promotor.branch', 'members')
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
                ->orderBy('id', 'desc')
                ->paginate(10); // 10 records per page

            return view('approvals.share_transfer_approval', compact('share_transfers', 'search'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function approveShareTransfer(Request $request)
    {
        try {
            $validated = $request->validate([
                'share_transfer_id' => 'required|exists:share_transfer,id',
                'status'            => 'required|in:approved,not approve',
                'remarks'           => 'nullable|string|max:255',
            ]);

            $transfer = ShareTransfer::with('members')->find($validated['share_transfer_id']);
            $transfer->status = $validated['status'];
            $transfer->remarks = $validated['remarks'];

            if ($validated['status'] === 'approved') {

                $transfer->certificate_number = $transfer->id;
            } else {
                $transfer->certificate_number = null;
            }

            if ($transfer->save()) {
                $transfer->members->share_allocated = 1;
                $transfer->members->save();
            }

            return redirect()->back()->with('success', 'Share transfer updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
    // Approve share Transfer ends

    // Approve reverse transaction
    public function reverseTransactionView(Request $request, $id)
    {
        try {
            $decodedId = base64_decode($id);
            $transaction = Transaction::findOrFail($decodedId);
            return view('saving-current-ac.accounts.reverse-transaction', compact('transaction', 'id'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function reverseTransactionApprove(Request $request, $id)
    {
        try {
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function approveReverseTransaction()
    {
        try {
            $transactions = Transaction::with('accounts.members', 'accounts.branch')->where('approve_status', 'pending')
                ->where('reverse_status', 0)
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('approvals.reverse_transaction', compact('transactions'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function approveTransaction($encodedId, Request $request)
    {
        try {
            $id = base64_decode($encodedId);
            $transaction = Transaction::findOrFail($id);

            if ($transaction->approve_status !== 'pending' || $transaction->reverse_status != 0) {
                return redirect()->back()->with('error', 'Invalid transaction status.');
            }
            $transaction->transaction_type = 'debit';
            $transaction->approve_status = $request->input('transaction_status');
            $transaction->reverse_status = 1;
            $transaction->save();

            return redirect()->route('reverse-transaction.reverse_transaction')->with('success', 'Transaction approved successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function loans()
    {
        // Normal Loan Applications
        $loanApplications = LoanApplication::with(['creditScores', 'branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'loan';
                return $item;
            });

        // Mortgage Loan Applications
        $mortgageLoans = MortgageLoanApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'mortgage';
                return $item;
            });

        // Loan Against Applications
        $loanAgainst = LoanAgainstApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'loan_against';
                return $item;
            });

        // Business Loan Applications
        $businessLoans = BusinessLoanApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'business_loan';
                return $item;
            });

        // cc od Loan Applications
        $cc_od = CcOdLoanApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'cc_od';
                return $item;
            });

        // Daily Weekly Loan Applications
        $daily_weekly = DailyWeeklyApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'daily_weekly';
                return $item;
            });

        // Personal Loan Applications
        $personal = PersonalLoanApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'personal';
                return $item;
            });

        // Personal Loan Applications
        $vehical = VehicalApplication::with(['branch', 'member'])
            ->whereNotIn('status', [1, 2, 3])
            ->latest()
            ->get()
            ->map(function ($item) {
                $item->model_type = 'vehical';
                return $item;
            });

        // Merge all 4 collections
        $applications = $loanApplications
            ->concat($mortgageLoans)
            ->concat($loanAgainst)
            ->concat($businessLoans)
            ->concat($cc_od)
            ->concat($daily_weekly)
            ->concat($personal)
            ->concat($vehical)
            ->sortByDesc('created_at');

        // Account types array
        $types = [
            'loan' => 'Gold Loan',
            'mortgage' => 'Mortgage Loan',
            'loan_against' => 'Loan Against',
            'business_loan' => 'Business Loan',
            'cc_od' => 'CC OD',
            'daily_weekly' => 'Daily Weekly',
            'personal' => 'Personal Loan',
            'vehical' => 'Vehical Loan',
        ];

        return view('approvals.loans', compact('applications', 'types'));
    }


    public function updateStatus(Request $request, $id)
    {
        Log::info('--- Update Status Started ---', [
            'id' => $id,
            'status' => $request->status,
            'model_type' => $request->model_type,
        ]);

        $modelType = $request->model_type;
        $status = $request->status;

        switch ($modelType) {
            case 'loan':
                $application = LoanApplication::find($id);
                break;
            case 'mortgage':
                $application = MortgageLoanApplication::find($id);
                break;
            case 'loan_against':
                $application = LoanAgainstApplication::find($id);
                break;
            case 'business_loan':
                $application = BusinessLoanApplication::find($id);
                break;
            case 'cc_od':
                $application = CcOdLoanApplication::find($id);
                break;
            case 'daily_weekly':
                $application = DailyWeeklyApplication::find($id);
                break;
            case 'personal':
                $application = PersonalLoanApplication::find($id);
            case 'vehical':
                $application = VehicalApplication::find($id);
                break;
            default:
                $application = null;
        }

        if ($application) {
            $application->status = $status;
            $application->save();

            Log::info('Status Updated Successfully', [
                'id' => $application->id,
                'table' => get_class($application),
                'new_status' => $status,
            ]);

            return redirect()->back()->with('success', 'Status updated successfully!');
        }

        return redirect()->back()->with('error', 'Application not found in any table!');
    }


    public function approvals_history()
    {
        // gold Loan Applications (approved)
        $loanApplications = LoanApplication::with(['creditScores', 'branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'loan';
            });

        // Mortgage Loan Applications (approved)
        $mortgageLoans = MortgageLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'mortgage';
            });

        // Loan Against Applications (approved)
        $loanAgainst = LoanAgainstApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'loan_against';
            });

        // cc_od Applications (approved)
        $cc_od = CcOdLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'cc_od';
            });

        // daily_weekly Applications (approved)
        $daily_weekly = DailyWeeklyApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'daily_weekly';
            });

        // Personal Loan Applications (approved)
        $personal = PersonalLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'personal';
            });

        // Vehical Loan Applications (approved)
        $vehical = VehicalApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function ($item) {
                $item->model_type = 'vehical';
            });

        // Merge all 5 collections
        $applications = $loanApplications
            ->concat($mortgageLoans)
            ->concat($loanAgainst)
            ->concat($cc_od)
            ->concat($daily_weekly)
            ->concat($personal)
            ->concat($vehical)
            ->sortByDesc('created_at');

        return view('approvals.approvals_history', compact('applications'));
    }
}
