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
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class PaymentsToCollectController extends Controller
{
    public function payment_index()
    {
        $gold = $this->loanModule(
            'loan_applications',
            'gold_loan_emi_status',
            'Gold Loan'
        );

        $mortgage = $this->loanModule(
            'mortgage_loan_applications',
            'mortgage_loan_emi_status',
            'Mortgage Loan'
        );

        $personal = $this->loanModule(
            'personal_loan_applications',
            'personal_loan_emi_status',
            'Personal Loan'
        );

        $loanAgainst = $this->loanModule(
            'loan_against_applications',
            'loan_against_emi_status',
            'Loan Against Deposit'
        );

        $business = $this->loanModule(
            'bussiness_loan_applications',
            'business_loan_emi_status',
            'Business Loan'
        );

        $dailyWeekly = $this->loanModule(
            'daily_weekly_applications',
            'daily_weekly_loan_emi_status',
            'Daily/Weekly Loan'
        );

        $vehicle = $this->loanModule(
            'vehical_applications',
            'vehical_loan_emi_status',
            'Vehicle Loan'
        );

        $ccod = $this->loanModule(
            'cc_od_loan_applications',
            'cc_od_loan_emi_status',
            'CC/OD Loan',
            false
        );
        $rd = DB::table('rd_transactions')
            ->leftJoin('rd_accounts', 'rd_accounts.id', '=', 'rd_transactions.rd_account_id')
            ->leftJoin('members', 'members.id', '=', 'rd_accounts.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'rd_accounts.branch_id')
            ->whereDate('rd_transactions.due_date', '<=', now())

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
            ->whereDate('dd_transactions.transaction_date', '<=', now())
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
            ->whereDate('fd_transactions.due_date', '<=', now())
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
        $mis = DB::table('mis_transactions')
            ->leftJoin('misaccounts', 'misaccounts.id', '=', 'mis_transactions.misaccount_id')
            ->leftJoin('members', 'members.id', '=', 'misaccounts.member_id')
            ->leftJoin('branches', 'branches.id', '=', 'misaccounts.branch_id')

            ->whereDate('mis_transactions.due_date', '<=', now())

            ->where(function ($q) {
                $q->whereNull('mis_transactions.status')
                    ->orWhere('mis_transactions.status', '!=', 'paid');
            })

            ->select(
                'misaccounts.id as loan_id',
                'misaccounts.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name',
                DB::raw("'MIS' as loan_type"),
                DB::raw('NULL as emi_no'),
                'mis_transactions.amount as remaining_amount',
                'mis_transactions.due_date'
            )
            ->get();
        $all = collect()
            ->merge($gold)
            ->merge($mortgage)
            ->merge($personal)
            ->merge($loanAgainst)
            ->merge($business)
            ->merge($dailyWeekly)
            ->merge($vehicle)
            ->merge($ccod)
            ->merge($mis)
            ->merge($rd)
            ->merge($dd)
            ->merge($fd);
        $all = $all->map(function ($item) {

            if (!$item->due_date) {
                $item->due_days = '-';
                return $item;
            }

            $dueDate = Carbon::parse($item->due_date);
            $today = now();

            if ($dueDate->lt($today)) {
                $item->due_days = $dueDate->diffInDays($today) . ' Days Overdue';
            } else {
                $item->due_days = $today->diffInDays($dueDate) . ' Days Left';
            }

            return $item;
        });

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
                'Loan Against Deposit' => 'loan_against_transactions',
                'Vehicle Loan' => 'vehical_loan_transactions',
                'Business Loan' => 'business_loan_transactions',
                'Daily/Weekly Loan' => 'daily_weekly_loan_transactions',
                'CC/OD Loan' => 'cc_od_loan_transactions',
            ];

            if ($item->loan_type == 'MIS') {

                $item->last_transaction = DB::table('mis_transactions')
                    ->where('misaccount_id', $item->loan_id)
                    ->latest('created_at')
                    ->first();
            } elseif ($item->loan_type == 'RD') {

                $item->last_transaction = DB::table('rd_transactions')
                    ->where('rd_account_id', $item->loan_id)
                    ->latest('created_at')
                    ->first();
            } elseif ($item->loan_type == 'DD') {

                $item->last_transaction = DB::table('dd_transactions')
                    ->where('dds_account_id', $item->loan_id)
                    ->latest('created_at')
                    ->first();
            } elseif ($item->loan_type == 'FD') {

                $item->last_transaction = DB::table('fd_transactions')
                    ->where('fd_account_id', $item->loan_id)
                    ->latest('created_at')
                    ->first();
            } elseif (isset($tableMap[$item->loan_type])) {

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
    private function loanModule($appTable, $emiTable, $loanType, $hasDueDate = true)
    {
        $query = DB::table($appTable)
            ->leftJoin('members', 'members.id', '=', $appTable . '.member_id')
            ->leftJoin('branches', 'branches.id', '=', $appTable . '.branch_id')
            ->join($emiTable, $emiTable . '.loan_id', '=', $appTable . '.id')
            ->where($emiTable . '.status', '!=', 'PAID');

        if ($hasDueDate) {
            $query->whereDate($emiTable . '.emi_due_date', '<=', now());
        }
        return $query->select(
            $appTable . '.id as loan_id',
            $appTable . '.member_id',
            'members.member_no',
            'members.member_info_first_name',
            'members.member_info_mobile_no',
            'branches.branch_name',
            DB::raw("'" . $loanType . "' as loan_type"),

            // INST DUE
            DB::raw('COUNT(' . $emiTable . '.emi_no) as inst_due'),

            // OVERDUE EMI
            DB::raw('SUM(CASE WHEN ' . $emiTable . '.emi_due_date < CURDATE() THEN 1 ELSE 0 END) as inst_overdue'),

            // Amount to collect
            DB::raw('SUM(' . $emiTable . '.remaining_amount) as remaining_amount'),

            // Earliest due date
            $hasDueDate
                ? DB::raw('MIN(' . $emiTable . '.emi_due_date) as due_date')
                : DB::raw('NULL as due_date')
        )
            ->groupBy(
                $appTable . '.id',
                $appTable . '.member_id',
                'members.member_no',
                'members.member_info_first_name',
                'members.member_info_mobile_no',
                'branches.branch_name'
            )
            ->get();
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

            case "Loan Against Deposit":
                $table = "loan_against_transactions";
                break;

            case "Vehicle Loan":
                $table = "vehical_loan_transactions";
                break;

            case "Business Loan":
                $table = "business_loan_transactions";
                break;

            case "CC/OD Loan":
                $table = "cc_od_loan_transactions";
                break;

            case "Daily/Weekly Loan":
                $table = "daily_weekly_loan_transactions";
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
                $loanTable = "mortgage_loan_applications";
                break;

            case "Personal Loan":
                $transactionTable = "personal_loan_transactions";
                $statusTable = "personal_loan_emi_status";
                $loanTable = "personal_loan_applications";
                break;
            case "Loan Against Deposit":
                $transactionTable = "loan_against_transactions";
                $statusTable = "loan_against_emi_status";
                $loanTable = "loan_against_applications";
                break;
            case "Business Loan":
                $transactionTable = "business_loan_transactions";
                $statusTable = "business_loan_emi_status";
                $loanTable = "bussiness_loan_applications";
                break;
            case "Daily/Weekly Loan":
                $transactionTable = "daily_weekly_loan_transactions";
                $statusTable = "daily_weekly_loan_emi_status";
                $loanTable = "daily_weekly_applications";
                break;
            case "Vehicle Loan":
                $transactionTable = "vehical_loan_transactions";
                $statusTable = "vehical_loan_emi_status";
                $loanTable = "vehical_applications";
                break;
            case "CC/OD Loan":
                $transactionTable = "cc_od_loan_transactions";
                $statusTable = "cc_od_loan_emi_status";
                $loanTable = "cc_od_loan_applications";
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

    // public function generateLink($loan_type, $loan_id)
    // {
    //     // 1. Loan Find ਕਰੋ
    //     $loan = LoanApplication::with('member')->findOrFail($loan_id);

    //     if (!$loan->member) {
    //         return back()->with('error', 'Member not found for this loan.');
    //     }

    //     // 2. Member Mobile Number
    //     $mobile = $loan->member->member_info_mobile_no;

    //     if (!$mobile) {
    //         return back()->with('error', 'Member mobile number missing.');
    //     }

    //     // 3. Loan Module Wise Payment URL Generate
    //     if ($loan_type === 'Gold Loan') {
    //         $paymentUrl = route('gold-loan.account.pay-emi', $loan_id);
    //     } elseif ($loan_type === 'Mortgage Loan') {
    //         $paymentUrl = route('mortgage.account.pay-emi', $loan_id);
    //     } elseif ($loan_type === 'Personal Loan') {
    //         $paymentUrl = route('personal-loan.account.pay-emi', $loan_id);
    //     } elseif ($loan_type === 'Loan Against Deposit') {
    //         $paymentUrl = route('loanagainst.account.pay-emi', $loan_id);
    //     } elseif ($loan_type === 'Daily/Weekly Loan') {
    //         $paymentUrl = route('daily_weekly.account.pay-emi', $loan_id);
    //     } elseif ($loan_type === 'Vehicle Loan') {
    //         $paymentUrl = route('vehical.account.pay-emi', $loan_id);
    //     } elseif ($loan_type === 'CC/OD Loan') {
    //         $paymentUrl = route('cc_od.account.pay-emi', $loan_id);
    //     } else {
    //         return back()->with('error', 'Invalid loan type.');
    //     }

    //     // 4. SMS Message
    //     $message = "Dear Customer, Click to pay your EMI: " . $paymentUrl;

    //     // 5. Send SMS (Example - Fast2SMS, MSG91, ANY API)
    //     $this->sendSms($mobile, $message);

    //     return back()->with('success', 'Collection link sent to member mobile.');
    // }
    public function generateLink($loan_type, $loan_id)
    {
        switch ($loan_type) {

            case "Gold Loan":
                $loan = DB::table('loan_applications')->where('id', $loan_id)->first();
                break;

            case "Mortgage Loan":
                $loan = DB::table('mortgage_loan_applications')->where('id', $loan_id)->first();
                break;

            case "Personal Loan":
                $loan = DB::table('personal_loan_applications')->where('id', $loan_id)->first();
                break;

            case "Loan Against Deposit":
                $loan = DB::table('loan_against_applications')->where('id', $loan_id)->first();
                break;

            case "Business Loan":
                $loan = DB::table('bussiness_loan_applications')->where('id', $loan_id)->first();
                break;

            case "Daily/Weekly Loan":
                $loan = DB::table('daily_weekly_applications')->where('id', $loan_id)->first();
                break;

            case "Vehicle Loan":
                $loan = DB::table('vehical_applications')->where('id', $loan_id)->first();
                break;

            case "CC/OD Loan":
                $loan = DB::table('cc_od_loan_applications')->where('id', $loan_id)->first();
                break;

            default:
                return back()->with('error', 'Invalid loan type.');
        }

        if (!$loan) {
            return back()->with('error', 'Loan not found.');
        }

        $member = DB::table('members')->where('id', $loan->member_id)->first();

        if (!$member) {
            return back()->with('error', 'Member not found.');
        }

        $mobile = $member->member_info_mobile_no;

        if (!$mobile) {
            return back()->with('error', 'Member mobile number missing.');
        }

        // Payment URL
        switch ($loan_type) {

            case "Gold Loan":
                $paymentUrl = route('gold-loan.account.pay-emi', $loan_id);
                break;

            case "Mortgage Loan":
                $paymentUrl = route('mortgage.account.pay-emi', $loan_id);
                break;

            case "Personal Loan":
                $paymentUrl = route('personal.account.pay-emi', $loan_id);
                break;

            case "Loan Against Deposit":
                $paymentUrl = route('loanagainst.account.pay-emi', $loan_id);
                break;

            case "Business Loan":
                $paymentUrl = route('bussiness.account.pay-emi', $loan_id);
                break;

            case "Daily/Weekly Loan":
                $paymentUrl = route('daily_weekly.account.pay-emi', $loan_id);
                break;

            case "Vehicle Loan":
                $paymentUrl = route('vehical.account.pay-emi', $loan_id);
                break;

            case "CC/OD Loan":
                $paymentUrl = route('cc_od.account.pay-emi', $loan_id);
                break;
        }

        $message = "Dear Customer, Click to pay your EMI: " . $paymentUrl;

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
