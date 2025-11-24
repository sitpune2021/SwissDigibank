<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Member;
use App\Models\Branch;
use Carbon\Carbon;
use App\Models\FDAccount;
use App\Models\FdTransaction;
use App\Models\FdMaturityStatement;
use App\Models\RdTransactions;
use App\Models\RDAccount;
use App\Models\Rdscheme;

use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{

    public function fetchAccountInfo(Request $request)
    {
        try {
            $userId = Auth::id();

            $member = Member::where('user_id', $userId)->firstOrFail();
            $account = Account::with('branch')->where('member_id', $member->id)->firstOrFail();

            return response()->json([
                'status' => true,
                'message' => 'Account fetched successfully',
                'data' => [
                    'account_id' => $account->id,
                    'account_no' => $account->account_no,
                    'account_status' => $account->account_status,
                    'account_type' => $account->account_type,
                    'branch_name' => $account->branch->branch_name ?? null,
                    'ifsc_code' => $account->branch->ifsc_code ?? null,
                    'open_date' => optional($account->open_date)->format('d-m-Y'),
                    'account_status' => $account->status ?? 'active',
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Account not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
    public function getBanks(Request $request)
    {
        try {
            if ($request->filled('id')) {
                $branch = Branch::find($request->id);

                if (!$branch) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Branch not found.',
                        'data' => null,
                    ], 404);
                }

                return response()->json([
                    'status' => true,
                    'message' => 'Branch details fetched successfully.',
                    'data' => [
                        'id' => $branch->id,
                        'branch_name' => $branch->branch_name,
                        'address' => trim("{$branch->address_line1}, {$branch->address_line2}, {$branch->city}, {$branch->state}, {$branch->pincode}, {$branch->country}"),
                        'ifsc_code' => $branch->ifsc_code,
                        'swift_code' => $branch->swift_code,
                        'open_date' => optional($branch->open_date)->format('d-m-Y'),
                    ],
                ]);
            }

            $branches = Branch::select(
                'id',
                'branch_name',
                'address_line1',
                'city',
                'state',
                'pincode',
                'country'
            )->get();

            return response()->json([
                'status' => true,
                'message' => 'All bank branches fetched successfully.',
                'data' => $branches,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getFDAccountDetails()
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized. Please log in.'
                ], 401);
            }

            // Get the member associated with this user
            $member = Member::where('user_id', $user->id)->first();

            if (!$member) {
                return response()->json([
                    'status' => false,
                    'message' => 'Member not found for this user.'
                ], 404);
            }

            // Fetch the latest FD account for this member
            $fdAccount = FDAccount::with([
                'branch:id,branch_name,ifsc_code',
                'fdscheme:id,scheme_name,annual_interest_rate'
            ])
                ->where('member_id', $member->id)
                ->latest('created_at')
                ->first();

            if (!$fdAccount) {
                return response()->json([
                    'status' => false,
                    'message' => 'No FD account found for this user.',
                    'data' => null
                ], 404);
            }

            // Fetch all transactions for this FD account
            $transactions = FdTransaction::where('fd_account_id', $fdAccount->id)
                ->orderBy('transaction_date', 'desc')
                ->get();

            // Fetch latest maturity statement for this user
            $maturity = FdMaturityStatement::with('interestPeriods')
                ->where('user_id', $user->id)
                ->orderByDesc('created_at')
                ->first();

            return response()->json([
                'status' => true,
                'message' => 'FD account details fetched successfully.',
                'data' => [
                    'fd_account' => $fdAccount,
                    'transactions' => $transactions,
                    'maturity_statement' => $maturity
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
   public function getRDAccountDetails()
{
    try {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized. Please log in.'
            ], 401);
        }

        // Find member for this user
        $member = Member::where('user_id', $user->id)->first();

        if (!$member) {
            return response()->json([
                'status' => false,
                'message' => 'Member not found for this user.'
            ], 404);
        }

        // Fetch the latest RD Account
        $rdAccount = RDAccount::with([
            'branch:id,branch_name,ifsc_code',
            'scheme:id,scheme_name,anuual_interest_rate'
        ])
        ->where('member_id', $member->id)
        ->latest('created_at')
        ->first();

        if (!$rdAccount) {
            return response()->json([
                'status' => false,
                'message' => 'No RD account found for this user.',
                'data' => null
            ], 404);
        }

        // Fetch rd_transactions for this RD account
        $transactions = RdTransactions::where('rd_account_id', $rdAccount->id)
            ->orderBy('transfer_date', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'RD account details fetched successfully.',
            'data' => [
                'rd_account'   => $rdAccount,
                'transactions' => $transactions
            ]
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status'   => false,
            'message'  => 'Something went wrong.',
            'error'    => $e->getMessage(),
        ], 500);
    }
}

}
