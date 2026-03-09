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
            'Daily Weekly Loan'
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
            ->join($emiTable, $emiTable . '.loan_id', '=', $appTable . '.id');
        $query->where($emiTable . '.status', '!=', 'DONE');

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
            DB::raw("SUM(CASE WHEN {$emiTable}.status != 'PAID' THEN 1 ELSE 0 END) as inst_due"),
            DB::raw('SUM(' . $emiTable . '.remaining_amount) as remaining_amount'),
            DB::raw("MIN(CASE 
            WHEN {$emiTable}.status = 'DUE' THEN 'DUE'
            WHEN {$emiTable}.status = 'PARTIAL' THEN 'PARTIAL'
            WHEN {$emiTable}.status = 'PAID' THEN 'PAID'
                END) as status"),
            DB::raw('MIN(' . $emiTable . '.emi_no) as emi_no'),
            DB::raw('MIN(' . $emiTable . '.emi_due_date) as due_date')
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
        Log::info("Mark Done Start", compact('type', 'loan_id', 'emi_no', 'amount'));

        $config = [

            "Gold Loan" => [
                "statusTable" => "gold_loan_emi_status",
                "transactionTable" => "gold_loan_transactions"
            ],

            "Mortgage Loan" => [
                "statusTable" => "mortgage_loan_emi_status",
                "transactionTable" => "mortgage_loan_transactions"
            ],

            "Personal Loan" => [
                "statusTable" => "personal_loan_emi_status",
                "transactionTable" => "personal_loan_transactions"
            ],

            "Loan Against Deposit" => [
                "statusTable" => "loan_against_emi_status",
                "transactionTable" => "loan_against_transactions"
            ],

            "Business Loan" => [
                "statusTable" => "business_loan_emi_status",
                "transactionTable" => "business_loan_transactions"
            ],

            "Daily Weekly Loan" => [
                "statusTable" => "daily_weekly_loan_emi_status",
                "transactionTable" => "daily_weekly_loan_transactions"
            ],

            "Vehicle Loan" => [
                "statusTable" => "vehical_loan_emi_status",
                "transactionTable" => "vehical_loan_transactions"
            ],

            "CC/OD Loan" => [
                "statusTable" => "cc_od_loan_emi_status",
                "transactionTable" => "cc_od_loan_transactions"
            ],

            "RD" => [
                "statusTable" => "rd_transactions",
                "loanColumn" => "rd_account_id",
                "emiColumn" => "installment_no"
            ],

            "DD" => [
                "statusTable" => "dd_transactions",
                "loanColumn" => "dds_account_id"
            ],

            "FD" => [
                "statusTable" => "fd_transactions",
                "loanColumn" => "fd_account_id"
            ],

            "MIS" => [
                "statusTable" => "mis_transactions",
                "loanColumn" => "misaccount_id"
            ]
        ];

        if (!isset($config[$type])) {
            Log::error("Invalid Loan Type", ['type' => $type]);
            return back()->with('error', 'Invalid Loan Type');
        }

        $statusTable = $config[$type]['statusTable'];
        $transactionTable = $config[$type]['transactionTable'] ?? null;

        $loanColumn = $config[$type]['loanColumn'] ?? 'loan_id';
        $emiColumn  = $config[$type]['emiColumn'] ?? 'emi_no';

        DB::beginTransaction();

        try {

            $emi = DB::table($statusTable)
                ->where($loanColumn, $loan_id)
                ->where($emiColumn, $emi_no)
                ->first();

            if (!$emi) {
                return back()->with('error', 'EMI not found');
            }

            // Loan EMI modules
            if ($transactionTable) {

                DB::table($transactionTable)->insert([
                    "loan_id" => $loan_id,
                    "emi_no" => $emi_no,
                    "transaction_date" => now(),
                    "paid_date" => now(),
                    "amount_collected" => $amount,
                    "current_debt" => 0,
                    "status" => "paid",
                    "created_at" => now(),
                    "updated_at" => now()
                ]);

                DB::table($statusTable)
                    ->where($loanColumn, $loan_id)
                    ->where($emiColumn, $emi_no)
                    ->update([
                        "remaining_amount" => 0,
                        "status" => "DONE",
                        "paid_date" => now(),
                        "updated_at" => now()
                    ]);
            }
            // RD / FD / MIS / DD
            else {

                DB::table($statusTable)
                    ->where($loanColumn, $loan_id)
                    ->where($emiColumn, $emi_no)
                    ->update([
                        "status" => "paid",
                        "paid_on" => now(),
                        "updated_at" => now()
                    ]);
            }

            DB::commit();

            Log::info("Mark Done Success");

            return back()->with('success', 'Payment Marked Done');
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error("Mark Done Error", ['error' => $e->getMessage()]);

            return back()->with('error', $e->getMessage());
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
    public function payment_comments($loan_type, $loan_id)
    {
        // loan info
        $loan = DB::table('loan_applications')
            ->leftJoin('members', 'members.id', '=', 'loan_applications.member_id')
            ->where('loan_applications.id', $loan_id)
            ->select(
                'members.member_no',
                'members.member_info_first_name'
            )
            ->first();

        // EMI info
        $emi = DB::table('gold_loan_emi_status')
            ->where('loan_id', $loan_id)
            ->where('status', '!=', 'PAID')
            ->orderBy('emi_no')
            ->first();

        $comments = DB::table('payment_collect_comments')
            ->leftJoin('users', 'users.id', '=', 'payment_collect_comments.commented_by')
            ->where('loan_id', $loan_id)
            ->where('loan_type', $loan_type)
            ->select(
                'payment_collect_comments.comment',
                'users.name as comment_by',
                'payment_collect_comments.created_at'
            )
            ->orderBy('payment_collect_comments.id', 'desc')
            ->get();

        return view(
            "payments.payments-to-collect.comments",
            compact('loan_id', 'loan_type', 'comments', 'loan', 'emi')
        );
    }

    public function saveComment(Request $request)
    {
        DB::table('payment_collect_comments')->insert([
            'loan_id' => $request->loan_id,
            'loan_type' => $request->loan_type,
            'comment' => $request->comment,
            'commented_by' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('success', 'Comment Saved');
    }

    public function getComments($loan_type, $loan_id)
    {
        $comments = DB::table('payment_collect_comments')
            ->leftJoin('users', 'users.id', '=', 'payment_collect_comments.commented_by')
            ->where('loan_id', $loan_id)
            ->where('loan_type', $loan_type)
            ->select(
                'payment_collect_comments.comment',
                'users.name as comment_by',
                'payment_collect_comments.created_at'
            )
            ->orderBy('payment_collect_comments.id', 'desc')
            ->get();

        return response()->json($comments);
    }

    public function release_index()
    {

    $fd = DB::table('fd_accounts as f')
    ->join('branches as b','b.id','=','f.branch_id')
    ->join('members as m','m.id','=','f.member_id')
    ->select(
    'b.branch_name as branch',
    DB::raw("CONCAT(m.member_no,' - ',m.member_info_first_name) as member"),
    DB::raw("'FD' as account_type"),
    'f.fd_no as account_no',
    DB::raw("'Active' as account_status"),
    'f.maturity_date as due_date',
    'f.maturity_amount as amount'
    )
    ->where('f.active',1)
    ->where('f.status',1)
    ->whereNull('f.close_date')
    ->whereDate('f.maturity_date','<=',now());


    $rd = DB::table('rd_accounts as r')
    ->join('branches as b','b.id','=','r.branch_id')
    ->join('members as m','m.id','=','r.member_id')
    ->select(
    'b.branch_name as branch',
    DB::raw("CONCAT(m.member_no,' - ',m.member_info_first_name) as member"),
    DB::raw("'RD' as account_type"),
    'r.rd_no as account_no',
    DB::raw("'Active' as account_status"),
    'r.maturity_date as due_date',
    'r.maturity_amount as amount'
    )
    ->where('r.approve_status','Approved')
    ->whereDate('r.maturity_date','<=',now());


    $mis = DB::table('misaccounts as mis')
    ->join('branches as b','b.id','=','mis.branch_id')
    ->join('members as m','m.id','=','mis.member_id')
    ->select(
    'b.branch_name as branch',
    DB::raw("CONCAT(m.member_no,' - ',m.member_info_first_name) as member"),
    DB::raw("'MIS' as account_type"),
    'mis.mis_account_no as account_no',
    DB::raw("'Active' as account_status"),
    'mis.maturity_date as due_date',
    'mis.maturity_amount as amount'
    )
    ->where('mis.status',1)
    ->whereNull('mis.closing_date')
    ->whereDate('mis.maturity_date','<=',now());


    $dd = DB::table('dds_accounts as d')
    ->join('branches as b','b.id','=','d.branch_id')
    ->join('members as m','m.id','=','d.member_id')
    ->select(
    'b.branch_name as branch',
    DB::raw("CONCAT(m.member_no,' - ',m.member_info_first_name) as member"),
    DB::raw("'DD' as account_type"),
    'd.dd_no as account_no',
    DB::raw("'Active' as account_status"),
    'd.maturity_date as due_date',
    'd.maturity_amount as amount'
    )
    ->where('d.status',1)
    ->whereDate('d.maturity_date','<=',now());


    $data = $fd
    ->union($rd)
    ->union($mis)
    ->union($dd)
    ->get();

    return view("payments.payments-to-release.index",compact('data'));

    }

    public function payments_history()
    {

        return view("payments.payments-to-release.payments-history");
    }
    public function print()
    {
        $applications = $this->payment_index()->getData()['applications'];

        return view('payments.payments-to-collect.print', compact('applications'));
    }
    public function exportCsv()
    {
        $applications = $this->payment_index()->getData()['applications'];

        $fileName = "payment_collection.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate"
        ];

        $columns = [
            'Branch',
            'Member No',
            'Customer',
            'Account Type',
            'Account No',
            'Due Date',
            'Amount'
        ];

        $callback = function () use ($applications, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($applications as $app) {

                fputcsv($file, [
                    $app->branch_name,
                    $app->member_no,
                    $app->member_info_first_name,
                    $app->loan_type,
                    $app->loan_id,
                    $app->due_date,
                    $app->remaining_amount
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function exportDat()
    {
        $applications = $this->payment_index()->getData()['applications'];

        $fileName = "collection_machine.dat";

        $content = '';

        foreach ($applications as $app) {

            $content .=
                $app->loan_id . "|" .
                $app->member_no . "|" .
                $app->remaining_amount . "|" .
                $app->due_date .
                "\n";
        }

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', "attachment; filename=$fileName");
    }
}
