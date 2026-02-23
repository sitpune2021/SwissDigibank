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
use Illuminate\Pagination\LengthAwarePaginator; // ✅ ADD THIS

class PaymentsToCollectController extends Controller
{


    public function payment_index()
    {

        $gold = DB::table('loan_applications')
            ->leftJoin('members', 'members.id', '=', 'loan_applications.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'loan_applications.branch_id')
            ->join('gold_loan_emi_status', 'gold_loan_emi_status.loan_id', '=', 'loan_applications.id')

            ->where('gold_loan_emi_status.remaining_amount', '>', 0)

            ->select(
                'loan_applications.id as loan_id',
                'loan_applications.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name',
                DB::raw("'Gold Loan' as loan_type"),
                'gold_loan_emi_status.emi_no',
                'gold_loan_emi_status.remaining_amount',
                'gold_loan_emi_status.created_at as due_date'
            )
            ->get();
        $mortgage = DB::table('loan_applications')
            ->leftJoin('members', 'members.id', '=', 'loan_applications.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'loan_applications.branch_id')
            ->join('mortgage_loan_emi_status', 'mortgage_loan_emi_status.loan_id', '=', 'loan_applications.id')
            ->where('mortgage_loan_emi_status.status', '!=', 'PAID')
            ->select(
                'loan_applications.id as loan_id',
                'loan_applications.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name',
                DB::raw("'Mortgage Loan' as loan_type"),
                'mortgage_loan_emi_status.emi_no',
                'mortgage_loan_emi_status.remaining_amount',
                'mortgage_loan_emi_status.created_at as due_date'
            )
            ->get();




        $personal = DB::table('loan_applications')
            ->leftJoin('members', 'members.id', '=', 'loan_applications.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'loan_applications.branch_id')
            ->join('personal_loan_emi_status', 'personal_loan_emi_status.loan_id', '=', 'loan_applications.id')
            ->where('personal_loan_emi_status.status', '!=', 'PAID')
            ->select(
                'loan_applications.id as loan_id',
                'loan_applications.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name',
                DB::raw("'Personal Loan' as loan_type"),
                'personal_loan_emi_status.emi_no',
                'personal_loan_emi_status.remaining_amount',
                'personal_loan_emi_status.created_at as due_date'
            )
            ->get();

        $rd = DB::table('rd_transactions')
            ->leftJoin('rd_accounts', 'rd_accounts.id', '=', 'rd_transactions.rd_account_id')
            ->leftJoin('members', 'members.id', '=', 'rd_accounts.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'rd_accounts.branch_id')
            ->where(function ($q) {
                $q->whereNull('rd_transactions.status')
                    ->orWhere('rd_transactions.status', '!=', 'paid');
            })
            ->select(
                'rd_accounts.id as loan_id',
                'rd_accounts.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name',
                DB::raw("'RD' as loan_type"),
                'rd_transactions.installment_no as emi_no',
                'rd_transactions.amount as remaining_amount',
                'rd_transactions.due_date'
            )
            ->get();

        $dd = DB::table('dd_transactions')
            ->leftJoin('dds_accounts', 'dds_accounts.id', '=', 'dd_transactions.dds_account_id')
            ->leftJoin('members', 'members.id', '=', 'dds_accounts.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'dds_accounts.branch_id')
            ->where('dd_transactions.type', 'credit')
            ->whereNull('dd_transactions.deleted_at')
            ->groupBy('dds_accounts.id')
            ->select(
                'dds_accounts.id as loan_id',
                DB::raw('MAX(dds_accounts.member_id) as member_id'),
                DB::raw('MAX(members.member_no) as member_no'),
                DB::raw('MAX(members.member_info_first_name) as member_info_first_name'),
                DB::raw('MAX(members.member_info_mobile_no) as member_info_mobile_no'),
                DB::raw('MAX(branches.branch_name) as branch_name'),
                DB::raw("'DD' as loan_type"),
                DB::raw('NULL as emi_no'),
                DB::raw('SUM(dd_transactions.amount) as remaining_amount'),
                DB::raw('MAX(dd_transactions.transaction_date) as due_date')
            )
            ->get();

        $fd = DB::table('fd_transactions')
            ->leftJoin('fd_accounts', 'fd_accounts.id', '=', 'fd_transactions.fd_account_id')
            ->leftJoin('members', 'members.id', '=', 'fd_accounts.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'fd_accounts.branch_id')
            ->where('fd_transactions.transaction_type', 1)
            ->whereNull('fd_transactions.deleted_at')
            ->select(
                'fd_accounts.id as loan_id',
                'fd_accounts.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name',
                DB::raw("'FD' as loan_type"),
                DB::raw('NULL as emi_no'),
                'fd_transactions.amount as remaining_amount',
                'fd_transactions.due_date'
            )
            ->get();


        $all = collect()
            ->merge($gold)
            ->merge($mortgage)
            ->merge($personal)
            ->merge($rd)
            ->merge($dd)
            ->merge($fd);


        $all = $all->sortBy('due_date')->values();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;

        $applications = new LengthAwarePaginator(
            $all->forPage($currentPage, $perPage),
            $all->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );
        // Attach last transaction BEFORE pagination
        $all = $all->map(function ($item) {

            $tableMap = [
                'Gold Loan' => 'gold_loan_transactions',
                'Mortgage Loan' => 'mortgage_loan_transactions',
                'Personal Loan' => 'personal_loan_transactions',
                'Vehicle Loan' => 'vehical_loan_transactions',
                'Business Loan' => 'business_loan_transactions',
            ];

            if (isset($tableMap[$item->loan_type])) {
                $item->last_transaction = DB::table($tableMap[$item->loan_type])
                    ->where('loan_id', $item->loan_id)
                    ->latest('created_at')
                    ->first();
            } else {
                $item->last_transaction = null;
            }

            return $item;
        });

        // THEN do pagination
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;

        $applications = new LengthAwarePaginator(
            $all->forPage($currentPage, $perPage),
            $all->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        return view("payments.payments-to-collect.index", compact('applications'));
    }
    public function getLastTransaction($type, $loan_id)
    {
        switch ($type) {

            case "Gold Loan":
                $table = "gold_loan_transactions";
                break;

            case "Mortgage Loan":
                $table = "mortgage_loan_transactions";
                break;

            case "Personal Loan":
                $table = "personal_loan_transactions";
                break;

            case "Vehicle Loan":
                $table = "vehical_loan_transactions";
                break;

            case "Business Loan":
                $table = "business_loan_transactions";
                break;

            default:
                return null;
        }

        return DB::table($table)
            ->where('loan_id', $loan_id)
            ->latest('created_at')
            ->first();
    }
    public function markDone($type, $loan_id, $emi_no, $amount)
    {
        switch ($type) {

            case "Gold Loan":
                $transactionTable = "gold_loan_transactions";
                $statusTable = "gold_loan_emi_status";
                $loanTable = "loan_applications";
                break;

            case "Mortgage Loan":
                $transactionTable = "mortgage_loan_transactions";
                $statusTable = "mortgage_loan_emi_status";
                $loanTable = "loan_applications";
                break;

            case "Personal Loan":
                $transactionTable = "personal_loan_transactions";
                $statusTable = "personal_loan_emi_status";
                $loanTable = "loan_applications";
                break;

            default:
                return back()->with('error', 'Invalid loan type');
        }

        DB::beginTransaction();

        try {

            // 1️⃣ Get EMI Remaining
            $emiData = DB::table($statusTable)
                ->where('loan_id', $loan_id)
                ->where('emi_no', $emi_no)
                ->first();

            if (!$emiData) {
                return back()->with('error', 'EMI not found.');
            }

            $remainingBefore = $emiData->remaining_amount;

            // 2️⃣ Calculate new remaining
            $newRemaining = $remainingBefore - $amount;
            if ($newRemaining < 0) $newRemaining = 0;

            // 3️⃣ Insert transaction
            DB::table($transactionTable)->insert([
                "loan_id" => $loan_id,
                "emi_no" => $emi_no,
                "transaction_date" => now(),
                "paid_date" => now(),
                "amount_collected" => $amount,
                "current_debt" => $newRemaining,
                "status" => "paid",
                "created_at" => now(),
                "updated_at" => now(),
            ]);

            // 4️⃣ Update EMI status table
            DB::table($statusTable)
                ->where('loan_id', $loan_id)
                ->where('emi_no', $emi_no)
                ->update([
                    "remaining_amount" => $newRemaining,
                    "status" => $newRemaining == 0 ? "PAID" : "UNPAID",
                    "paid_date" => $newRemaining == 0 ? now() : null,
                    "updated_at" => now()
                ]);

            DB::commit();

            return back()->with('success', 'Payment recorded successfully!');
        } catch (\Exception $e) {

            DB::rollBack();
            return back()->with('error', 'Something went wrong.');
        }
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
        } elseif ($loan_type === 'Mortgage Loan') {
            $paymentUrl = route('mortgage.account.pay-emi', $loan_id);
        } elseif ($loan_type === 'Personal Loan') {
            $paymentUrl = route('personal-loan.account.pay-emi', $loan_id);
        } else {
            return back()->with('error', 'Invalid loan type.');
        }

        // 4. SMS Message
        $message = "Dear Customer, Click to pay your EMI: " . $paymentUrl;

        // 5. Send SMS (Example - Fast2SMS, MSG91, ANY API)
        $this->sendSms($mobile, $message);

        return back()->with('success', 'Collection link sent to member mobile.');
    }

    public function payment_comments()
    {

        return view("payments.payments-to-collect.comments");
    }

    public function release_index()
    {

        return view("payments.payments-to-release.index");
    }

    public function payments_history()
    {

        return view("payments.payments-to-release.payments-history");
    }
}
