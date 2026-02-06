<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanEnquiry;
use App\Models\LoanOrnamentsEnquiry;
use App\Models\GoldLoanScheme;
use Illuminate\Support\Facades\Auth;
use App\Models\Account;

class GoldLoanController extends Controller
{
    public function getDropdownOptions()
    {
        $residentialTypes = [
            1 => 'Own House',
            2 => 'Rented',
            3 => 'Company Provided'
        ];

        $occupationTypes = [
            1 => 'Salaried - CSP',
            2 => 'Self Employed',
            3 => 'Business',
            4 => 'Other'
        ];

        return response()->json([
            'status' => true,
            'residential_types' => $residentialTypes,
            'occupation_types' => $occupationTypes
        ]);
    }
    public function savePersonalDetails(Request $request)
    {
        // Validate input
        $request->validate([
            'residential_type' => 'required|integer',
            'occupation_type' => 'required|integer',
            'monthly_income' => 'required|numeric'
        ]);

        // Map dropdown IDs to strings
        $residentialMap = [
            1 => 'Own House',
            2 => 'Rented',
            3 => 'Company Provided'
        ];

        $occupationMap = [
            1 => 'Salaried - CSP',
            2 => 'Self Employed',
            3 => 'Business',
            4 => 'Other'
        ];

        // Create new loan enquiry record with only these fields
        $loanEnquiry = LoanEnquiry::create([
            'residential_type' => $residentialMap[$request->residential_type],
            'occupation_type' => $occupationMap[$request->occupation_type],
            'monthly_income' => $request->monthly_income,
            'status' => 'draft' // default status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Personal details saved successfully',
            'loan_enquiry_id' => $loanEnquiry->id,
            'next_step' => 2
        ]);
    }


    public function step2Ornaments(Request $request)
    {
        $request->validate([
            'ornaments' => 'required|array|min:1',
            'ornaments.*.type' => 'required|string',
            'ornaments.*.qty' => 'required|integer',
            'ornaments.*.carat' => 'required|numeric',
            'ornaments.*.weight' => 'required|numeric',
        ]);

        $ornamentsData = [];

        foreach ($request->ornaments as $item) {
            $ornamentsData[] = [
                'loan_enquiry_id' => $request->loan_enquiry_id,
                'type' => $item['type'],
                'qty' => $item['qty'],
                'carat' => $item['carat'],
                'net_weight' => $item['weight'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        LoanOrnamentsEnquiry::insert($ornamentsData);

        return response()->json([
            'status' => true,
            'message' => 'Ornaments saved successfully',
            'next_step' => 3
        ]);
    }

    public function step3Loan(Request $request)
    {
        $request->validate([
            'scheme_id' => 'required|exists:gold_loan_schemes,id',
            'loan_amount' => 'required|numeric',
            'tenure_months' => 'required|numeric',
        ]);

        // Get latest draft loan enquiry
        $loanEnquiry = LoanEnquiry::where('status', 'draft')
            ->latest('id')
            ->first();

        if (!$loanEnquiry) {
            return response()->json([
                'status' => false,
                'message' => 'No active loan enquiry found'
            ], 404);
        }

        // Get scheme
        $scheme = GoldLoanScheme::findOrFail($request->scheme_id);

        // Update loan enquiry
        $loanEnquiry->update([
            'scheme_id' => $scheme->id,
            'loan_amount' => $request->loan_amount,
            'tenure_months' => $request->tenure_months,
            'interest_rate' => $scheme->annual_interest_rate,
            'margin' => '30%',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Loan scheme details saved',
            'next_step' => 4,
            'loan_enquiry_id' => $loanEnquiry->id
        ]);
    }


    public function step4Account()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // 1️⃣ Fetch active account of logged-in user
        $account = Account::where('member_id', $user->id)
            ->where('account_status', 1) // active account
            ->latest('id')
            ->first();

        if (!$account) {
            return response()->json([
                'status' => false,
                'message' => 'Active account not found for this user'
            ], 404);
        }

        // 2️⃣ Fetch latest draft loan enquiry
        $loanEnquiry = LoanEnquiry::where('status', 'draft')
            ->latest('id')
            ->first();

        if (!$loanEnquiry) {
            return response()->json([
                'status' => false,
                'message' => 'No active loan enquiry found'
            ], 404);
        }

        // 3️⃣ Save account_no into loan_enquiry
        $loanEnquiry->update([
            'credit_account' => $account->account_no
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Credit account fetched from accounts table',
            'credit_account' => $account->account_no,
            'next_step' => 5
        ]);
    }
    public function step5Branch()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not authenticated'
            ], 401);
        }

        // 1️⃣ Fetch branch using existing relation
        $branch = $user->branches;

        if (!$branch || $branch->active !== 'Yes') {
            return response()->json([
                'status' => false,
                'message' => 'Active branch not found for logged-in user'
            ], 404);
        }

        // 2️⃣ Fetch latest draft loan enquiry
        $loanEnquiry = LoanEnquiry::where('status', 'draft')
            ->latest('id')
            ->first();

        if (!$loanEnquiry) {
            return response()->json([
                'status' => false,
                'message' => 'No active loan enquiry found'
            ], 404);
        }

        // 3️⃣ Save branch code into loan_enquiry
        $loanEnquiry->update([
            'branch_code' => $branch->branch_code,
            'status' => 'submitted'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Branch assigned successfully',
            'branch' => [
                'branch_name' => $branch->branch_name,
                'branch_code' => $branch->branch_code
            ],
            'next_step' => 6
        ]);
    }

    public function step6Summary($id)
    {
        return LoanEnquiry::with(['ornaments', 'scheme'])->findOrFail($id);
    }


}
