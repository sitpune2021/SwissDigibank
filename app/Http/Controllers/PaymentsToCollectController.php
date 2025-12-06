<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoanApplication;
use App\Models\Member;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Support\Facades\Auth;

class PaymentsToCollectController extends Controller
{
 

    public function payment_index()
    {
        $baseQuery = LoanApplication::query()
            ->leftJoin('members', 'members.id', '=', 'loan_applications.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'loan_applications.branch_id')
            ->select(
                'loan_applications.id as app_id',
                'loan_applications.id as application_no', // FIX
                'loan_applications.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name'
            );

        // GOLD LOAN
        $gold = (clone $baseQuery)
            ->join('gold_loan_emi_status', 'gold_loan_emi_status.loan_id', '=', 'loan_applications.id')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('gold_loan_transactions')
                    ->whereColumn('gold_loan_transactions.loan_id', 'gold_loan_emi_status.loan_id')
                    ->whereColumn('gold_loan_transactions.emi_no', 'gold_loan_emi_status.emi_no')
                    ->where('gold_loan_transactions.status', 'paid');
            })
            ->selectRaw("'Gold Loan' as loan_type, gold_loan_emi_status.*");

        // MORTGAGE LOAN
        $mortgage = (clone $baseQuery)
            ->join('mortgage_loan_emi_status', 'mortgage_loan_emi_status.loan_id', '=', 'loan_applications.id')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('mortgage_loan_transactions')
                    ->whereColumn('mortgage_loan_transactions.loan_id', 'mortgage_loan_emi_status.loan_id')
                    ->whereColumn('mortgage_loan_transactions.emi_no', 'mortgage_loan_emi_status.emi_no')
                    ->where('mortgage_loan_transactions.status', 'paid');
            })
            ->selectRaw("'Mortgage Loan' as loan_type, mortgage_loan_emi_status.*");

        // PERSONAL LOAN
        $personal = (clone $baseQuery)
            ->join('personal_loan_emi_status', 'personal_loan_emi_status.loan_id', '=', 'loan_applications.id')
            ->whereNotExists(function ($q) {
                $q->select(DB::raw(1))
                    ->from('personal_loan_transactions')
                    ->whereColumn('personal_loan_transactions.loan_id', 'personal_loan_emi_status.loan_id')
                    ->whereColumn('personal_loan_transactions.emi_no', 'personal_loan_emi_status.emi_no')
                    ->where('personal_loan_transactions.status', 'paid');
            })
            ->selectRaw("'Personal Loan' as loan_type, personal_loan_emi_status.*");


        // ✨ Finally merge all modules
        $applications = $gold
            ->unionAll($mortgage)
            ->unionAll($personal)
            ->orderBy('emi_no', 'ASC')  
            ->paginate(20); // Pagination here

        return view("payments.payments-to-collect.index", compact('applications'));
    }

    public function markDone($type, $loan_id, $emi_no, $amount)
    {
        // 1. Detect transaction table + loan application table
        switch ($type) {
            case "Gold Loan":
                $table = "gold_loan_transactions";
                $loanTable = "loan_applications";
                break;

            case "Mortgage Loan":
                $table = "mortgage_loan_transactions";
                $loanTable = "mortgage_loan_applications";
                break;

            case "Personal Loan":
                $table = "personal_loan_transactions";
                $loanTable = "personal_loan_applications";
                break;

            case "Business Loan":
                $table = "business_loan_transactions";
                $loanTable = "bussiness_loan_applications";
                break;

            case "CC/OD Loan":
                $table = "cc_od_loan_transactions";
                $loanTable = "cc_od_loan_applications";
                break;

            case "Vehicle Loan":
                $table = "vehical_loan_transactions";
                $loanTable = "vehical_loan_applications";
                break;

            case "Daily/Weekly Loan":
                $table = "daily_weekly_loan_transactions";
                $loanTable = "daily_weekly_loan_applications";
                break;

            case "Loan Against Deposit":
                $table = "loan_against_transactions";
                $loanTable = "loan_against_applications";
                break;

            default:
                return back()->with('error', 'Invalid loan type');
        }

        // 2. Correct loan table se loan_amount fetch
        $loanAmount = DB::table($loanTable)
            ->where('id', $loan_id)
            ->value('loan_amount');

        if (!$loanAmount) {
            return back()->with('error', 'Loan amount not found for this loan.');
        }

        // 3. Previous EMI paid total
        $previousPaid = DB::table($table)
            ->where('loan_id', $loan_id)
            ->sum('amount_collected');

        // 4. current_debt calculate
        $currentDebt = $loanAmount - ($previousPaid + $amount);
        if ($currentDebt < 0) $currentDebt = 0;

        // 5. Insert new EMI entry
        DB::table($table)->insert([
            "loan_id" => $loan_id,
            "emi_no" => $emi_no,
            "amount_collected" => $amount,
            "total_payable" => $loanAmount,
            "current_debt" => $currentDebt,
            "status" => "paid",
            "transaction_date" => now(),
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        return back()->with('success', 'EMI marked as paid successfully!');
    }

    private function sendSms($mobile, $message)
    {
        // Localhost Testing Mode
        Log::info("SMS TEST MODE: Message sent to $mobile: $message");

        return true; // Always success
    }

    public function generateLink($loan_type, $loan_id)
    {
        // 1. Loan Find ਕਰੋ
        $loan = LoanApplication::with('member')->findOrFail($loan_id);

        if (!$loan->member) {
            return back()->with('error', 'Member not found for this loan.');
        }

        // 2. Member Mobile Number
        $mobile = $loan->member->member_info_mobile_no;

        if (!$mobile) {
            return back()->with('error', 'Member mobile number missing.');
        }

        // 3. Loan Module Wise Payment URL Generate
        if ($loan_type === 'Gold Loan') {
            $paymentUrl = route('gold-loan.account.pay-emi', $loan_id);
        } 
        elseif ($loan_type === 'Mortgage Loan') {
            $paymentUrl = route('mortgage.account.pay-emi', $loan_id);
        } 
        elseif ($loan_type === 'Personal Loan') {
            $paymentUrl = route('personal-loan.account.pay-emi', $loan_id);
        } 
        else {
            return back()->with('error', 'Invalid loan type.');
        }

        // 4. SMS Message
        $message = "Dear Customer, Click to pay your EMI: " . $paymentUrl;

        // 5. Send SMS (Example - Fast2SMS, MSG91, ANY API)
        $this->sendSms($mobile, $message);

        return back()->with('success', 'Collection link sent to member mobile.');
    }

    public function payment_comments(){
        
        return view("payments.payments-to-collect.comments");
    }

    public function release_index(){
        
        return view("payments.payments-to-release.index");
    }

     public function payments_history(){
        
        return view("payments.payments-to-release.payments-history");
    }
    
}
