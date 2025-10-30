<?php

namespace App\Http\Controllers;

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


class ApproveController extends Controller
{
    
    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $perPage = $request->input('perPage', 10); // default 10 if not passed

            $query = Transaction::with('accounts.members', 'accounts.branch')
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
                                ->orWhereHas('branch', function ($q3) use ($search) {
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function updateAccountStatus(Request $request, $id)
    {

        try {
            //  Validate the input
            $validated = $request->validate([
                'transaction_status' => 'required|in:0,1,2',
                'remarks' => 'nullable|string|max:255',
                'source_table' => 'required|in:accounts,fd_accounts',
            ]);

            if ($validated['source_table'] === 'accounts') {
                // 🔹 For normal accounts
                $account = Account::findOrFail($id);
                $account->approve_status = $validated['transaction_status'];
                $account->remarks = $validated['remarks'];
                $account->save();

             try {

                $member = \App\Models\Member::find($account->member_id);
                // dd($account->account_no);
                $dlttemplateid = 1707172181386332784;
                $mobile = $member->member_info_mobile_no;

                $account = $account->account_no;

                $message = "Dear Customer, congratulations! your saving a/c  $account is approved. SHRI SAMARTH NAGRI SAHKARI PAT SANSTHA LTD";
 
                \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
            } catch (\Exception $e) {
                Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
            }

                // 📝 Log the update
                Log::info('Account status updated', [
                    'table' => 'accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            } else {
                // 🔹 For FD accounts
                $fdAccount = FdAccount::findOrFail($id);
                $fdAccount->status = $validated['transaction_status'];
                $fdAccount->remarks = $validated['remarks'];

                $fdAccount->save();

                // 📝 Log the update
                Log::info('FD Account status updated', [
                    'table' => 'fd_accounts',
                    'id' => $id,
                    'new_status' => $validated['transaction_status'],
                    'remarks' => $validated['remarks'],
                    'updated_by' => Auth::id(),
                ]);
            }

            return redirect()->back()->with('success', 'Account status updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Account not found', [
                'id' => $id,
                'source_table' => $request->input('source_table'),
                'updated_by' =>  Auth::id(),
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
        ";

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

            // Merge all 4 collections
            $applications = $loanApplications
                ->concat($mortgageLoans)
                ->concat($loanAgainst)
                ->concat($businessLoans)
                ->concat($cc_od)
                ->concat($daily_weekly)
                ->sortByDesc('created_at');

            // Account types array
            $types = [
                'loan' => 'Gold Loan',
                'mortgage' => 'Mortgage Loan',
                'loan_against' => 'Loan Against',
                'business_loan' => 'Business Loan',
                'cc_od' => 'CC OD',
                'daily_weekly' => 'Daily Weekly',
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
            ->each(function($item){
                $item->model_type = 'loan';
            });

        // Mortgage Loan Applications (approved)
        $mortgageLoans = MortgageLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function($item){
                $item->model_type = 'mortgage';
            });

        // Loan Against Applications (approved)
        $loanAgainst = LoanAgainstApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function($item){
                $item->model_type = 'loan_against';
            });

        // cc_od Applications (approved)
        $cc_od = CcOdLoanApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function($item){
                $item->model_type = 'cc_od';
            });

        // daily_weekly Applications (approved)
        $daily_weekly = DailyWeeklyApplication::with(['branch', 'member'])
            ->where('status', 1)
            ->latest()
            ->get()
            ->each(function($item){
                $item->model_type = 'daily_weekly';
            });

        // Merge all 5 collections
        $applications = $loanApplications
            ->concat($mortgageLoans)
            ->concat($loanAgainst)
            ->concat($cc_od)
            ->concat($daily_weekly)
            ->sortByDesc('created_at');

        return view('approvals.approvals_history', compact('applications'));
    }



}
