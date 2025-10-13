<?php

namespace App\Http\Controllers\Api;

use App\Models\Account;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function fetchAccountInfo()
    {
        try {
        $id=Auth::id();
        // $userId = Auth::id();

            $account = Account::with('branch')->findOrFail($id);

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
                    'open_date' => $account->open_date ? Carbon::parse($account->open_date)->format('d-m-Y') : null,
                    'account_status' => $account->status ?? 'active', // assuming you have a status column
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
}
