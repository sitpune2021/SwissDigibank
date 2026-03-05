<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LedgerGroup;
use App\Models\Ledger;
use App\Models\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Services\LedgerService;
use Illuminate\Support\Facades\Storage;


class LedgergroupController extends Controller
{


    protected $ledgerService;

    public function __construct(LedgerService $ledgerService)
    {
        $this->ledgerService = $ledgerService;
    }

    public function index(Request $request)
    {
        $branchId = $request->branch_id; // branch capture

        $all = LedgerGroup::orderBy('weightage')->get();

        foreach ($all as $group) {

            // branch id pass in service 
            [$accounts, $balance] = $this->ledgerService
                ->calculateGroupBalance($group->id, $branchId);

            $group->accounts = $accounts;
            $group->balance  = $balance;
        }

        $assets      = $all->where('type', 'Asset');
        $liabilities = $all->where('type', 'Liability');
        $equity      = $all->where('type', 'Equity');
        $expenses    = $all->where('type', 'Expense');
        $revenue     = $all->where('type', 'Revenue');

        $branches = Branch::all();

        return view('menu-accounts.ledger-group.index', compact(
            'all',
            'assets',
            'liabilities',
            'equity',
            'expenses',
            'branches',
            'revenue',
            'branchId'
        ));
    }

    public function create()
    {
        return view('menu-accounts.ledger-group.add-ledger-group');
    }

    public function store(Request $request)
    {
        $request->validate([
            'display_name' => 'required',
            'system_name'  => 'required|unique:ledger_groups,system_name',
            'type'         => 'required',
            'weightage'    => 'required|numeric'
        ]);

        // 🔥 AUTO GENERATE SAFE CODE
        $code = Str::slug($request->system_name, '_'); 
        // example: "Gold Loan" → GOLD_LOAN

        LedgerGroup::create([
            'display_name'    => strtoupper($request->display_name),
            'system_name'     => strtoupper($request->system_name),
            'code'            => strtoupper($code),   // ⭐ NEW
            'type'            => $request->type,
            'is_system_group' => $request->is_system_group ?? 0,
            'weightage'       => $request->weightage,
        ]);

        return redirect()->route('ledger-group.index')
            ->with('success','Ledger Group Created Successfully');
    }

    public function view()
    {
        return view('menu-accounts.ledger-group.view');
    }
   
    public function groupLedgers($id)
    {
        $group = LedgerGroup::findOrFail($id);

        /*
        |----------------------------------------
        | Fetch ledgers
        |----------------------------------------
        */
        $ledgers = Ledger::where('group_id', $id)
            ->with('group')
            ->get();

        $totalBalance = 0;

        foreach ($ledgers as $ledger) {

            /*
            |----------------------------------------
            | ALWAYS USE CODE (NOT NAME)
            |----------------------------------------
            */
            [$accounts, $balance] = $this->ledgerService->calculateLedgersBalance($ledger->code);

            $ledger->balance = $balance ?: $ledger->opening_balance;

            $totalBalance += $ledger->balance;
        }

        $accountsCount = $ledgers->count();

        return view('menu-accounts.ledger-group.asset-ledger', compact(
            'group',
            'ledgers',
            'accountsCount',
            'totalBalance'
        ));
    }

    public function edit_ledger()
    {
        return view('menu-accounts.ledger-group.edit-ledger');
    }

    public function journal_entry()
    {
        return view('menu-accounts.ledger-group.journal-entry');
    }

    public function destroy($id)
    {
        $group = LedgerGroup::findOrFail($id);

        // 1️⃣ Delete all ledgers inside this group
        Ledger::where('group_id', $id)->delete();

        // 2️⃣ Delete group
        $group->delete();

        return redirect()
            ->route('ledger-group.index')
            ->with('success', 'Ledger Group & related Ledgers deleted successfully');
    }


////////////////////////////////    Only Lead Tab      ////////////////////////////////////////////
   

    public function led_index(Request $request)
    {
        $branchId = $request->branch_id;

        $ledgers = Ledger::with('group')->latest()->get();

        foreach ($ledgers as $ledger) {
            // [$accounts, $balance] =
            //     $this->ledgerService->calculateLedgerBalance($ledger->code);

            // $ledger->balance = $balance ?: $ledger->opening_balance;
            // 🔥 branch id passed
            [$accounts, $balance] =
                $this->ledgerService->calculateLedgerBalance($ledger->code, $branchId);

            // if branch selected then opening balance ignore
            $ledger->balance = $balance;
        }

        $branches = Branch::all();

        return view('menu-accounts.ledger.index', compact('ledgers','branches'));
    }

    public function add_leg()
    {
        // first load empty
        $groups = collect();

        return view('menu-accounts.ledger.add-ledger', compact('groups'));
    }

    // leder create page drop down dynamically function
    public function groupsByType($type)
    {
        Log::info('Type Selected: '.$type);

        $groups = LedgerGroup::where('type', $type)
            ->orderBy('display_name')
            ->get(['id','display_name']);

        return response()->json($groups);
    }
   
    // leder store
    public function led_store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'group_id' => 'required',
            'display_name' => 'required',
            'system_name' => 'required',
        ]);

        // 🔥 AUTO UNIQUE CODE
        $baseCode = strtoupper(Str::slug($request->system_name, '_'));
        $code = $baseCode;

        $count = 1;

        while (Ledger::where('code', $code)->exists()) {
            $code = $baseCode . '_' . $count;
            $count++;
        }

        Ledger::create([
            'type' => $request->type,
            'group_id' => $request->group_id,
            'display_name' => $request->display_name,
            'system_name' => $request->system_name,
            'code' => $code,
            'is_bank_acc' => $request->is_bank_acc ?? 0,
            'show_in_day' => $request->show_in_day ?? 0,
            'opening_balance' => 0
        ]);

        return redirect()->route('ledger.index')
            ->with('success', 'Ledger Added Successfully');
    }

    private function buildLoanTransactionLedger($module)
    {
        $ledgerRows = [];
        $runningBalance = 0;

        $loans = DB::table($module['loan'])
            ->where('status', 2)
            ->get();

        foreach ($loans as $loan) {

            $branchName = DB::table('branches')
                ->where('id', $loan->branch_id)
                ->value('branch_name') ?? 'HEAD OFFICE';

            /*
            |------------------------------------------
            | 1️⃣ Loan Disbursement (Debit)
            |------------------------------------------
            */
            $opening = $runningBalance;

            $loanAmount = $loan->{$module['amount_column']} ?? 0;

            $runningBalance += $loanAmount;

            $ledgerRows[] = [
                'branch' => $branchName,
                'date'   => $loan->created_at,
                'description' => 'Loan Disbursement - ID '.$loan->id,
                'is_system'   => 'Yes',
                'opening' => $opening,
                'debit'   => $loanAmount,
                'credit'  => 0,
                'closing' => $runningBalance,
            ];

            /*
            |------------------------------------------
            | 2️⃣ Collections (Credit)
            |------------------------------------------
            */
            $collections = DB::table($module['txn'])
                ->where($module['loan_id'], $loan->id)
                ->get();

            foreach ($collections as $txn) {

                $opening = $runningBalance;

                $amount = $txn->{$module['collection_column']} ?? 0;

                $runningBalance -= $amount;

                $ledgerRows[] = [
                    'branch' => $branchName,
                    'date'   => $txn->created_at,
                    'description' => 'Collection - Loan ID '.$loan->id,
                    'is_system'   => 'Yes',
                    'opening' => $opening,
                    'debit'   => 0,
                    'credit'  => $amount,
                    'closing' => $runningBalance,
                ];
            }
        }

        usort($ledgerRows, fn($a,$b) => strtotime($a['date']) <=> strtotime($b['date']));

        return $ledgerRows;
    }

    private function buildDepositTransactionLedger($module)
    {
        $ledgerRows = [];
        $runningBalance = 0;

        $accounts = DB::table($module['loan'])
            ->when(isset($module['status_column']), function ($q) use ($module) {
                $q->where($module['status_column'], $module['status_value']);
            })
            ->get();

        foreach ($accounts as $account) {

            $branchName = DB::table('branches')
                ->where('id', $account->branch_id)
                ->value('branch_name') ?? 'HEAD OFFICE';

            // Opening Deposit (Credit)
            $opening = $runningBalance;

            $amount = $account->rd_amount 
                ?? $account->fd_amount 
                ?? $account->mis_amount 
                ?? $account->dd_amount 
                ?? 0;

            $runningBalance += $amount;

            $ledgerRows[] = [
                'branch' => $branchName,
                'date'   => $account->created_at,
                'description' => 'Account Opening - ID '.$account->id,
                'is_system'   => 'Yes',
                'opening' => $opening,
                'debit'   => 0,
                'credit'  => $amount,
                'closing' => $runningBalance,
            ];

            // Transactions
            $transactions = DB::table($module['txn'])
                ->where($module['id_column'], $account->id)
                ->get();

            foreach ($transactions as $txn) {

                $opening = $runningBalance;

                $txnAmount = $txn->amount ?? 0;

                if ($txn->transaction_type == $module['credit_value']) {
                    $runningBalance += $txnAmount;
                    $credit = $txnAmount;
                    $debit  = 0;
                } else {
                    $runningBalance -= $txnAmount;
                    $credit = 0;
                    $debit  = $txnAmount;
                }

                $ledgerRows[] = [
                    'branch' => $branchName,
                    'date'   => $txn->created_at,
                    'description' => 'Transaction - Account ID '.$account->id,
                    'is_system'   => 'Yes',
                    'opening' => $opening,
                    'debit'   => $debit,
                    'credit'  => $credit,
                    'closing' => $runningBalance,
                ];
            }
        }

        usort($ledgerRows, fn($a,$b) => strtotime($a['date']) <=> strtotime($b['date']));

        return $ledgerRows;
    }

    private function buildExpenseLedger($module)
    {
        $ledgerRows = [];
        $runningBalance = 0;

        $accounts = DB::table($module['loan'])
            ->when(isset($module['status_column']), function ($q) use ($module) {
                $q->where($module['status_column'], $module['status_value']);
            })
            ->get();

        foreach ($accounts as $account) {

            $branchName = DB::table('branches')
                ->where('id', $account->branch_id)
                ->value('branch_name') ?? 'HEAD OFFICE';

            $principal = $account->{$module['amount_column']} ?? 0;
            $maturity  = $account->maturity_amount ?? 0;

            $interest = max(0, $maturity - $principal);

            if ($interest <= 0) continue;

            $opening = $runningBalance;

            // Expense → Debit Increase
            $runningBalance += $interest;

            $ledgerRows[] = [
                'branch' => $branchName,
                'date'   => $account->created_at,
                'description' => 'Deposit Interest Expense - ID '.$account->id,
                'is_system'   => 'Yes',
                'opening' => $opening,
                'debit'   => $interest,
                'credit'  => 0,
                'closing' => $runningBalance,
            ];
        }

        usort($ledgerRows, fn($a,$b) => strtotime($a['date']) <=> strtotime($b['date']));

        return $ledgerRows;
    }

    private function buildRevenueLedger($module)
    {
        $ledgerRows = [];
        $runningBalance = 0;

        $loans = DB::table($module['loan'])->get();

        foreach ($loans as $loan) {

            $branchName = DB::table('branches')
                ->where('id', $loan->branch_id)
                ->value('branch_name') ?? 'HEAD OFFICE';

            $scheme = DB::table($module['scheme'])
                ->where('id', $loan->scheme_id)
                ->first();

            if (!$scheme) continue;

            $principal = $loan->loan_amount ?? 0;
            $rate      = $scheme->annual_interest_rate ?? 0;
            $months    = $scheme->tenure ?? 0;

            switch ($scheme->interest_type ?? 'flat') {

                case 'reducing_emi':
                    $interest = $this->ledgerService
                        ->calculateReducingInterest($principal, $rate, $months);
                    break;

                case 'advance':
                    $interest = $this->ledgerService
                        ->calculateAdvanceInterest($principal, $rate, $months);
                    break;

                case 'no_emi':
                    $interest = $this->ledgerService
                        ->calculateBulletInterest($principal, $rate, $months);
                    break;

                default:
                    $interest = $this->ledgerService
                        ->calculateFlatInterest($principal, $rate, $months);
            }

            if ($interest <= 0) continue;

            $opening = $runningBalance;

            // Revenue → Credit Increase
            $runningBalance += $interest;

            $ledgerRows[] = [
                'branch' => $branchName,
                'date'   => $loan->created_at,
                'description' => 'Loan Interest Income - Loan ID '.$loan->id,
                'is_system'   => 'Yes',
                'opening' => $opening,
                'debit'   => 0,
                'credit'  => $interest,
                'closing' => $runningBalance,
            ];
        }

        usort($ledgerRows, fn($a,$b) => strtotime($a['date']) <=> strtotime($b['date']));

        return $ledgerRows;
    }

    private function loanModuleMap()
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | LOAN MODULES (Asset Side)
            |--------------------------------------------------------------------------
            */
            'GOLD_LOAN' => [
                'type' => 'loan',
                'loan' => 'loan_applications',
                'txn'  => 'gold_loan_transactions',
                'charges' => 'gold_loan_other_charges',
                'closure' => 'gold_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'MORTGAGE_LOAN' => [
                'type' => 'loan',
                'loan' => 'mortgage_loan_applications',
                'txn'  => 'mortgage_loan_transactions',
                'charges' => 'mortgage_loan_other_charges',
                'closure' => 'mortgage_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'PROPERTY_LOAN' => [
                'type' => 'loan',
                'loan' => 'mortgage_loan_applications',
                'txn'  => 'mortgage_loan_transactions',
                'charges' => 'mortgage_loan_other_charges',
                'closure' => 'mortgage_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'LOAN_AGAINST' => [
                'type' => 'loan',
                'loan' => 'loan_against_applications',
                'txn'  => 'loan_against_transactions',
                'charges' => 'loan_against_other_charges',
                'closure' => 'loan_against_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'DEPOSIT_LOAN' => [
                'type' => 'loan',
                'loan' => 'loan_against_applications',
                'txn'  => 'loan_against_transactions',
                'charges' => 'loan_against_other_charges',
                'closure' => 'loan_against_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'PERSONAL_LOAN' => [
                'type' => 'loan',
                'loan' => 'personal_loan_applications',
                'txn'  => 'personal_loan_transactions',
                'charges' => 'personal_loan_other_charges',
                'closure' => 'personal_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'BUSINESS_LOAN' => [
                'type' => 'loan',
                'loan' => 'business_loan_applications',
                'txn'  => 'business_loan_transactions',
                'charges' => 'business_loan_other_charges',
                'closure' => 'business_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'BUSSINESS_LOAN' => [
                'type' => 'loan',
                'loan' => 'business_loan_applications',
                'txn'  => 'business_loan_transactions',
                'charges' => 'business_loan_other_charges',
                'closure' => 'business_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'CC_OD_LOAN' => [
                'type' => 'loan',
                'loan' => 'ccod_loan_applications',
                'txn'  => 'ccod_loan_transactions',
                'charges' => 'ccod_loan_other_charges',
                'closure' => 'ccod_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'CCOD_LOAN' => [
                'type' => 'loan',
                'loan' => 'ccod_loan_applications',
                'txn'  => 'ccod_loan_transactions',
                'charges' => 'ccod_loan_other_charges',
                'closure' => 'ccod_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'DAILY_WEEKLY_LOAN' => [
                'type' => 'loan',
                'loan' => 'daily_weekly_loan_applications',
                'txn'  => 'daily_weekly_loan_transactions',
                'charges' => 'daily_weekly_loan_other_charges',
                'closure' => 'daily_weekly_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'DAILYWEEKLY_LOAN' => [
                'type' => 'loan',
                'loan' => 'daily_weekly_loan_applications',
                'txn'  => 'daily_weekly_loan_transactions',
                'charges' => 'daily_weekly_loan_other_charges',
                'closure' => 'daily_weekly_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],
            'VEHICAL_LOAN' => [
                'type' => 'loan',
                'loan' => 'vehicle_loan_applications',
                'txn'  => 'vehicle_loan_transactions',
                'charges' => 'vehicle_loan_other_charges',
                'closure' => 'vehicle_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
                'status_column' => 'status',
                'status_value'  => 2,
            ],

            'GOLD_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'loan_applications',
                'scheme' => 'gold_loan_schemes',
            ],
            'MORTGAGE_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'mortgage_loan_applications',
                'scheme' => 'mortgage_schemes',
            ],
            'PROPERTY_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'mortgage_loan_applications',
                'scheme' => 'mortgage_schemes',
            ],
            'DEPOSIT_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'loan_against_applications',
                'scheme' => 'loan_against_schemes',
            ],
            'LOAN_AGAINST_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'loan_against_applications',
                'scheme' => 'loan_against_schemes',
            ],
            'BUSSINESS_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'bussiness_loan_applications',
                'scheme' => 'business_loan_schemes',
            ],
            'BUSINESS_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'bussiness_loan_applications',
                'scheme' => 'business_loan_schemes',
            ],
            'CCOD_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'cc_od_loan_applications',
                'scheme' => 'cc_od_loan_schemes',
            ],
            'CC_OD_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'cc_od_loan_applications',
                'scheme' => 'cc_od_loan_schemes',
            ],
            'DAILYWEEKLY_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'daily_weekly_applications',
                'scheme' => 'daily_weekly_schemes',
            ],
            'DAILY_WEEKLY_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'daily_weekly_applications',
                'scheme' => 'daily_weekly_schemes',
            ],
            'PERSONAL_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'personal_loan_applications',
                'scheme' => 'personal_schemes',
            ],
            'VEHICAL_LOAN_INTEREST' => [
                'type' => 'loan_interest',
                'loan' => 'vehical_applications',
                'scheme' => 'vehical_schemes',
            ],

            /*
            |--------------------------------------------------------------------------
            | DEPOSIT / LIABILITY MODULES
            |--------------------------------------------------------------------------
            */
            'FD_ACCOUNTS' => [
                'type' => 'deposit',
                'loan' => 'fd_accounts',
                'txn'  => 'fd_transactions',
                'id_column' => 'fd_account_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                'status_column' => 'status',
                'status_value'  => 1,
            ],
            'MIS_ACCOUNTS' => [
                'type' => 'deposit',
                'loan' => 'misaccounts',
                'txn'  => 'mis_transactions',
                'id_column' => 'misaccount_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                'status_column' => 'status',
                'status_value'  => 1,
            ],
            'DD_ACCOUNTS' => [
                'type' => 'deposit',
                'loan' => 'dds_accounts',
                'txn'  => 'dd_transactions',
                'id_column' => 'dds_account_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                'status_column' => 'status',
                'status_value'  => 1,
            ],
            'RD_ACCOUNTS' => [
                'type' => 'deposit',
                'loan' => 'rd_accounts',
                'txn'  => 'rd_transactions',
                'id_column' => 'rd_account_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                //'status_column' => 'status',
                'status_value'  => 1,
            ],
            'SAVING_ACCOUNTS' => [
                'type' => 'bank',
                'account_type' => 'SAVING',
                'loan' => 'accounts',
                'txn'  => 'transactions',
                'id_column' => 'account_id',
            ],
            'CURRENT_ACCOUNT' => [
                'type' => 'bank',
                'account_type' => 'CURRENT',
                'loan' => 'accounts',
                'txn'  => 'transactions',
                'id_column' => 'account_id',
            ],
            'FD_INTEREST' => [
                'type' => 'deposit_interest',
                'loan' => 'fd_accounts',
                'txn'  => 'fd_transactions',
                'id_column' => 'fd_account_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                'status_column' => 'status',
                'status_value'  => 1,
                'amount_column' => 'fd_amount',
            ],
            'MIS_INTEREST' => [
                'type' => 'deposit_interest',
                'loan' => 'misaccounts',
                'txn'  => 'mis_transactions',
                'id_column' => 'misaccount_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                'status_column' => 'status',
                'status_value'  => 1,
                 'amount_column' => 'mis_amount',
            ],
            'DD_INTEREST' => [
                'type' => 'deposit_interest',
                'loan' => 'dds_accounts',
                'txn'  => 'dd_transactions',
                'id_column' => 'dds_account_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                'status_column' => 'status',
                'status_value'  => 1,
                'amount_column' => 'dd_amount',
            ],
            'RD_INTEREST' => [
                'type' => 'deposit_interest',
                'loan' => 'rd_accounts',
                'txn'  => 'rd_transactions',
                'id_column' => 'rd_account_id',
                'credit_value' => 1,
                'debit_value'  => 0,
                'status_column' => 'approve_status',
                'status_value'  => 1,
                'amount_column' => 'rd_amount',
            ],

            'CASH_BOOK' => [
                'type' => 'cash',
            ],
            'BANK_BOOK' => [
                'type' => 'bank',
            ],
            'WALLET_BALANCE' => [
                'type' => 'balance',
            ],


        ];
    }

    public function ledgerView($id)
    {
        $ledger = Ledger::with('group')->findOrFail($id);

        $code = strtoupper(trim($ledger->code));
        $map  = $this->loanModuleMap();

        $module = $map[$code] ?? null;

        if (!$module) {
            abort(404, 'Ledger type not supported');
        }

        $records = collect(); // default empty collection

        if (isset($module['loan'])) {

            $records = DB::table($module['loan'])
                ->when(isset($module['status_column']), function ($q) use ($module) {
                    $q->where($module['status_column'], $module['status_value']);
                })
                ->when($module['type'] === 'bank', function ($q) use ($module) {
                    $q->where('account_type', $module['account_type'])
                    ->where('approve_status', '1')
                    ->where('account_status', 1)
                    ->whereNull('deleted_at');
                })
                ->get();
        }


        $totalDebit  = 0;
        $totalCredit = 0;
        $closingBalance = 0;
        $lastTransactionDate = null;

        $ledgerRows = [];

        foreach ($records as $record) {

            /*
            |--------------------------------------------------------------------------
            | BANK ENGINE (Saving / Current)
            |--------------------------------------------------------------------------
            */
            if ($module['type'] === 'bank') {

                $credit = DB::table($module['txn'])
                    ->where($module['id_column'], $record->id)
                    ->where('transaction_type', 'credit')
                    ->where('approve_status', 'approved')
                    ->sum('amount');

                $debit = DB::table($module['txn'])
                    ->where($module['id_column'], $record->id)
                    ->where('transaction_type', 'debit')
                    ->where('approve_status', 'approved')
                    ->sum('amount');

                $totalCredit += $credit;
                $totalDebit  += $debit;
                $closingBalance += ($credit - $debit);
            }

            /*
            |--------------------------------------------------------------------------
            | DEPOSIT ENGINE (FD / RD / MIS / DD)
            |--------------------------------------------------------------------------
            */
            elseif ($module['type'] === 'deposit') {

                $ledgerRows = $this->buildDepositTransactionLedger($module);

                $credit = DB::table($module['txn'])
                    ->where($module['id_column'], $record->id)
                    ->where('transaction_type', $module['credit_value'])
                    ->sum('amount');

                $debit = DB::table($module['txn'])
                    ->where($module['id_column'], $record->id)
                    ->where('transaction_type', $module['debit_value'])
                    ->sum('amount');

                $totalCredit += $credit;
                $totalDebit  += $debit;
                $closingBalance += ($credit - $debit);
            }

            /*
            |--------------------------------------------------------------------------
            | DEPOSIT INTEREST (FD / RD / MIS / DD)
            |--------------------------------------------------------------------------
            */
            elseif ($module['type'] === 'deposit_interest') {

                $ledgerRows = $this->buildExpenseLedger($module);

                $principal = $record->{$module['amount_column']} ?? 0;
                $maturity  = $record->maturity_amount ?? 0;

                $interest = max(0, $maturity - $principal);

                $totalCredit += $interest;
                $closingBalance += $interest;
            }

            /*
            |--------------------------------------------------------------------------
            | LOAN INTEREST (Gold / Mortgage / Personal etc.)
            |--------------------------------------------------------------------------
            */
            elseif ($module['type'] === 'loan_interest') {

                $ledgerRows = $this->buildRevenueLedger($module);

                $scheme = DB::table($module['scheme'])
                    ->where('id', $record->scheme_id)
                    ->first();

                if (!$scheme) continue;

                $principal = $record->loan_amount ?? 0;
                $rate      = $scheme->annual_interest_rate ?? 0;
                $months    = $scheme->tenure ?? 0;

                switch ($scheme->interest_type ?? $scheme->gold_loan_setting ?? 'flat') {

                    case 'reducing_emi':
                        $interest = $this->ledgerService
                            ->calculateReducingInterest($principal, $rate, $months);
                        break;

                    case 'advance':
                        $interest = $this->ledgerService
                            ->calculateAdvanceInterest($principal, $rate, $months);
                        break;

                    case 'no_emi':
                        $interest = $this->ledgerService
                            ->calculateBulletInterest($principal, $rate, $months);
                        break;

                    default:
                        $interest = $this->ledgerService
                            ->calculateFlatInterest($principal, $rate, $months);
                }


                $totalCredit += $interest;
                $closingBalance += $interest;
            }

            /*
            |--------------------------------------------------------------------------
            | LOAN PRINCIPAL ENGINE
            |--------------------------------------------------------------------------
            */
            elseif ($module['type'] === 'loan') {

                $ledgerRows = $this->buildLoanTransactionLedger($module);

                $loanAmount = $record->{$module['amount_column']} ?? 0;

                $collected = DB::table($module['txn'])
                    ->where($module['loan_id'], $record->id)
                    ->sum($module['collection_column']);

                $charges = DB::table($module['charges'])
                    ->where($module['loan_id'], $record->id)
                    ->sum('amount');

                $closure = DB::table($module['closure'])
                    ->where($module['loan_id'], $record->id)
                    ->value('remaining_amount') ?? 0;

                $credit = $collected + $charges + $closure;

                $totalDebit  += $loanAmount;
                $totalCredit += $credit;
                $closingBalance += max(0, $loanAmount - $credit);
            }


            /*
            |--------------------------------------------------------------------------
            | LAST TRANSACTION DATE (SAFE CHECK)
            |--------------------------------------------------------------------------
            */
            if (isset($module['txn'])) {

                $lastDate = DB::table($module['txn'])
                    ->where($module['id_column'] ?? $module['loan_id'], $record->id)
                    ->max('created_at');

                if ($lastDate && (!$lastTransactionDate || $lastDate > $lastTransactionDate)) {
                    $lastTransactionDate = $lastDate;
                }
            }
            
        }

        // CASH BOOK HANDLE SEPARATELY
        if ($module['type'] === 'cash') {

            $cashData = $this->ledgerService->cashBookBalance();
            $ledgerRows = $this->ledgerService->buildCashLedger();

            $totalDebit  = $cashData[0] ?? 0;
            $totalCredit = $cashData[1] ?? 0;

            $closingBalance = $totalDebit - $totalCredit;

            $totalTransactions = 0; // optional
        }

        // BANK BOOK HANDLE SEPARATELY
        if ($code === 'BANK_BOOK') {

            $bankData = $this->ledgerService->bankBookBalance();
            $ledgerRows = $this->ledgerService->buildOnlineLedger();

            $totalDebit  = $bankData[0] ?? 0;
            $totalCredit = $bankData[1] ?? 0;

            $closingBalance = $totalDebit - $totalCredit;

            $totalTransactions = count($ledgerRows);
        }


        $totalTransactions = $records->count();

        $difference = in_array($module['type'], ['deposit','bank','deposit_interest','loan_interest'])
            ? $totalCredit - $totalDebit
            : $totalDebit - $totalCredit;

        return view('menu-accounts.ledger.assest-ledger', compact(
            'ledger',
            'ledgerRows',
            'totalDebit',
            'totalTransactions',
            'totalCredit',
            'difference',
            'closingBalance',
            'lastTransactionDate'
        ));

    }

    public function update_bulkrisk()
    {
        return view('menu-accounts.ledger.update-bulkrisk');
    }
    public function revenue_ledger()
    {
        return view('menu-accounts.ledger.view');
    }
    public function edit_ledgers()
    {
        return view('menu-accounts.ledger.edit-ledger');
    }
    public function journal_entry_ledger()
    {
        return view('menu-accounts.ledger.journal-entry');
    }


////////////////////////////////    Only Profit & Loss Tab      ////////////////////////////////////////////
     

    public function profit_loss(Request $request)
    {
        $branchId = $request->branch_id;
        $today = Carbon::today();
        $previous = Carbon::today()->subYear();

        /*
        |--------------------------------------------------------------------------
        | 1. All Ledgers for tabs (Assets, Liabilities etc)
        |--------------------------------------------------------------------------
        */
        $ledgers = Ledger::with('group')->get();

        foreach ($ledgers as $ledger) {
            [$acc, $bal] = $this->ledgerService
                ->calculateLedgerBalance($ledger->code, $branchId);

            $ledger->balance = $bal ?: $ledger->opening_balance;
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Profit & Loss Data
        |--------------------------------------------------------------------------
        */
        $revenues = [];
        $expenses = [];

        $totalRevenueCurrent = 0;
        $totalRevenuePrevious = 0;

        $totalExpenseCurrent = 0;
        $totalExpensePrevious = 0;

        foreach ($ledgers as $ledger) 
        {

            // [$a1, $current]  = $this->ledgerService->calculateLedgerBalance($ledger->code, $today);
            // [$a2, $previousBal] = $this->ledgerService->calculateLedgerBalance($ledger->code, $previous);

            [$a1, $current] = $this->ledgerService->calculateLedgerBalance($ledger->code, $branchId);
            $previousBal = 0; // agar previous year logic nahi hai

            if ($ledger->type == 'Revenue') {

                $revenues[] = [
                    'name' => $ledger->display_name,
                    'current' => $current,
                    'previous' => $previousBal,
                ];

                $totalRevenueCurrent += $current;
                $totalRevenuePrevious += $previousBal;
            }

            if ($ledger->type == 'Expense') {

                $expenses[] = [
                    'name' => $ledger->display_name,
                    'current' => $current,
                    'previous' => $previousBal,
                ];

                $totalExpenseCurrent += $current;
                $totalExpensePrevious += $previousBal;
            }
        }

        $netCurrent  = $totalRevenueCurrent - $totalExpenseCurrent;
        $netPrevious = $totalRevenuePrevious - $totalExpensePrevious;

        $branches = Branch::all();


        return view('menu-accounts.profit-loss.profit_loss', compact(
            'ledgers',
            'revenues',
            'expenses',
            'today',
            'previous',
            'totalRevenueCurrent',
            'totalRevenuePrevious',
            'totalExpenseCurrent',
            'totalExpensePrevious',
            'netCurrent',
            'netPrevious',
            'branches', 
            'branchId' 
        ));
    }
    
    public function balance_sheet(Request $request)
    {
        $today = Carbon::today();
        $branchId = $request->branch_id;

        $branches = Branch::all(); // dropdown ke liye

        $ledgers = Ledger::with('group')->get();

        $assets = [];
        $liabilities = [];
        $equities = [];

        $totalAssets = 0;
        $totalLiabilities = 0;
        $totalEquity = 0;

        foreach ($ledgers as $ledger) {

            // ✅ Correct branch filter applied
            [$acc, $balance] =
                $this->ledgerService->calculateLedgerBalance($ledger->code, $branchId);

            $balance = $balance ?: 0;

            if ($ledger->type == 'Asset') {

                $assets[] = [
                    'name' => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalAssets += $balance;
            }

            if ($ledger->type == 'Liability') {

                $liabilities[] = [
                    'name' => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalLiabilities += $balance;
            }

            if ($ledger->type == 'Equity') {

                $equities[] = [
                    'name' => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalEquity += $balance;
            }
        }

        /*
        |------------------------------------------------------
        | Add Current Year Profit to Equity (Branch wise)
        |------------------------------------------------------
        */

        [$profitAcc, $netProfit] =
            $this->ledgerService->calculateNetProfit($branchId);

        $totalEquity += $netProfit;

        $difference = $totalAssets - ($totalLiabilities + $totalEquity);

        return view('menu-accounts.balance-sheet.index', compact(
            'assets',
            'liabilities',
            'equities',
            'totalAssets',
            'totalLiabilities',
            'totalEquity',
            'netProfit',
            'difference',
            'today',
            'branches',
            'branchId'
        ));
    }

    public function printBalanceSheet(Request $request)
    {
        $today = Carbon::today();
        $branchId = $request->branch_id;

        $ledgers = Ledger::with('group')->get();

        $assets = [];
        $liabilities = [];
        $equities = [];

        $totalAssets = 0;
        $totalLiabilities = 0;
        $totalEquity = 0;

        
        // Default logo (public folder)
        $logoUrl = asset('assets/images/SBC_Logo.png');

        // If custom logo exists in storage/app/public/logo.png
        $customLogoPath = 'logo.png'; // change if different filename

        if (Storage::disk('public')->exists($customLogoPath)) {
            $logoUrl = Storage::url($customLogoPath);
        }

        foreach ($ledgers as $ledger) {

            [$acc, $balance] =
            $this->ledgerService->calculateLedgerBalance($ledger->code, $branchId);

            $balance = $balance ?: 0;

            if ($ledger->type == 'Asset') {

                $assets[] = [
                    'name' => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalAssets += $balance;
            }

            if ($ledger->type == 'Liability') {

                $liabilities[] = [
                    'name' => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalLiabilities += $balance;
            }

            if ($ledger->type == 'Equity') {

                $equities[] = [
                    'name' => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalEquity += $balance;
            }
        }

        [$profitAcc, $netProfit] =
        $this->ledgerService->calculateNetProfit($branchId);

        $totalEquity += $netProfit;

        return view('menu-accounts.balance-sheet.print', compact(
            'assets',
            'liabilities',
            'equities',
            'totalAssets',
            'totalLiabilities',
            'totalEquity',
            'netProfit',
            'today',
            'logoUrl'
        ));
    }

    public function trial_balance(Request $request)
    {
        $from = $request->from ?? now()->startOfMonth();
        $to   = $request->to ?? now();

        $type = $request->type ?? 'ALL';
        $search = $request->search ?? null;
        $branchId = $request->branch_id ?? null;

        $data = $this->ledgerService->generateTrialBalance($from, $to, $branchId);

        // Type filter
        if ($type !== 'ALL') {
            $data = collect($data)->where('type', $type)->values();
        }

        // Search filter
        if ($search) {
            $data = collect($data)->filter(function ($item) use ($search) {
                return str_contains(strtolower($item['name']), strtolower($search))
                    || str_contains(strtolower($item['code']), strtolower($search));
            })->values();
        }

        $totalDebit = collect($data)->sum('balance_debit');
        $totalCredit = collect($data)->sum('balance_credit');

        $branches = \App\Models\Branch::all();

        return view('menu-accounts.trial-balance.index', compact(
            'data','from','to','type','search',
            'totalDebit','totalCredit','branches','branchId'
        ));
    }

    // final working day book code with all logic and filter
    public function dayBook(Request $request)
    {
        $date      = $request->date ?? now()->format('Y-m-d');
        $branchId  = $request->branch_id;

        /*
            |--------------------------------------------------------------------------
            | LOGO HANDLING (NO MODEL REQUIRED)
            |--------------------------------------------------------------------------
        */

        // Default logo (public folder)
        $logoUrl = asset('assets/images/SBC_Logo.png');

        // If custom logo exists in storage/app/public/logo.png
        $customLogoPath = 'logo.png'; // change if different filename

        if (Storage::disk('public')->exists($customLogoPath)) {
            $logoUrl = Storage::url($customLogoPath);
        }

        $ledgers = Ledger::where('show_in_day', 1)->get();

        $openingData = [];
        $closingData = [];
        $dayTxnData  = [];
        $dayBookData = []; 

        foreach ($ledgers as $ledger) {

            $opening = 0;
            $closing = 0;
            $dayTxn  = 0;
            $debit   = 0;
            $credit  = 0;

            // CASH BOOK
            if ($ledger->code === 'CASH_BOOK') {

                $rows = $this->ledgerService->buildCashLedger($branchId);

                $previousRows = collect($rows)->where('date', '<', $date);

                $todayRows = collect($rows)->whereBetween('date', [
                    $date.' 00:00:00',
                    $date.' 23:59:59'
                ]);

                $opening = $previousRows->last()['closing'] ?? 0;
                $closing = collect($rows)->last()['closing'] ?? 0;

                $debit  = $todayRows->sum('debit');
                $credit = $todayRows->sum('credit');
                $dayTxn = $debit - $credit;
            }

            // BANK BOOK
            if ($ledger->code === 'BANK_BOOK') {

                $rows = $this->ledgerService->buildOnlineLedger($branchId);

                $previousRows = collect($rows)->where('date', '<', $date);

                $todayRows = collect($rows)->whereBetween('date', [
                    $date.' 00:00:00',
                    $date.' 23:59:59'
                ]);

                $opening = $previousRows->last()['closing'] ?? 0;
                $closing = collect($rows)->last()['closing'] ?? 0;

                $debit  = $todayRows->sum('debit');
                $credit = $todayRows->sum('credit');
                $dayTxn = $debit - $credit;
            }

            // UI Cards
            $openingData[] = [
                'name'   => $ledger->display_name,
                'amount' => $opening
            ];

            $closingData[] = [
                'name'   => $ledger->display_name,
                'amount' => $closing
            ];

            $dayTxnData[] = [
                'name'   => $ledger->display_name,
                'amount' => $dayTxn
            ];

            // TABLE DATA FOR PRINT
            $dayBookData[] = [
                'name'    => $ledger->display_name,
                'type' => $ledger->group->type ?? $ledger->type ?? 'Ledger',
                'opening' => $opening,
                'debit'   => $debit,
                'credit'  => $credit,
                'closing' => $closing,
            ];
        }

        $branches = Branch::all();

        return view('menu-accounts.day-book.index', compact(
            'date',
            'branchId',
            'branches',
            'openingData',
            'closingData',
            'dayTxnData',
            'dayBookData',
            'logoUrl' 
        ));
    }

    public function accountingTree(Request $request)
    {
        $branchId = $request->branch_id;

        $branches = Branch::all();

        $ledgers = Ledger::with('group')->get();

        $tree = [
            'REVENUE'   => [],
            'ASSET'     => [],
            'LIABILITY' => [],
            'EQUITY'    => [],
            'EXPENSE'   => [],
        ];

        foreach ($ledgers as $ledger) {

            [$acc, $balance] =
                $this->ledgerService->calculateLedgerBalance($ledger->code, $branchId);

            $balance = $balance ?: 0;

            $type = strtoupper($ledger->type);

            if (isset($tree[$type])) {

                $tree[$type][] = [
                    'name'   => $ledger->display_name,
                    'system' => $ledger->name,
                    'amount' => $balance
                ];
            }
        }

        return view('menu-accounts.accounting-tree.index', compact(
            'tree',
            'branches',
            'branchId'
        ));
    }

    public function incomeStatement(Request $request)
    {
        $branchId = $request->branch_id;

        $branches = Branch::all();

        $ledgers = Ledger::all();

        $revenues = [];
        $expenses = [];

        $totalRevenue = 0;
        $totalExpense = 0;

        foreach ($ledgers as $ledger) {

            [$acc, $balance] =
                $this->ledgerService->calculateLedgerBalance($ledger->code, $branchId);

            $balance = $balance ?: 0;

            // REVENUE
            if (strtoupper($ledger->type) === 'REVENUE') {

                $revenues[] = [
                    'name'   => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalRevenue += $balance;
            }

            // EXPENSE
            if (strtoupper($ledger->type) === 'EXPENSE') {

                $expenses[] = [
                    'name'   => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalExpense += $balance;
            }
        }

        $netProfit = $totalRevenue - $totalExpense;

        return view('menu-accounts.income-statement.index', compact(
            'revenues',
            'expenses',
            'totalRevenue',
            'totalExpense',
            'netProfit',
            'branches',
            'branchId'
        ));
    }

    public function printIncomeStatement(Request $request)
    {
        $branchId = $request->branch_id;

        $ledgers = Ledger::all();

        $revenues = [];
        $expenses = [];

        $totalRevenue = 0;
        $totalExpense = 0;

        // Default logo (public folder)
        $logoUrl = asset('assets/images/SBC_Logo.png');

        // If custom logo exists in storage/app/public/logo.png
        $customLogoPath = 'logo.png'; // change if different filename

        if (Storage::disk('public')->exists($customLogoPath)) {
            $logoUrl = Storage::url($customLogoPath);
        }

        foreach ($ledgers as $ledger) {

            [$acc, $balance] = $this->ledgerService->calculateLedgerBalance($ledger->code, $branchId);

            $balance = $balance ?: 0;

            if (strtoupper($ledger->type) === 'REVENUE') {

                $revenues[] = [
                    'name'   => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalRevenue += $balance;
            }

            if (strtoupper($ledger->type) === 'EXPENSE') {

                $expenses[] = [
                    'name'   => $ledger->display_name,
                    'amount' => $balance
                ];

                $totalExpense += $balance;
            }
        }

        $netProfit = $totalRevenue - $totalExpense;

        return view('menu-accounts.income-statement.print', compact(
            'revenues',
            'expenses',
            'totalRevenue',
            'totalExpense',
            'netProfit',
            'logoUrl'
        ));
    }

    public function exportIncomeStatement(Request $request)
    {
        $branchId = $request->branch_id;

        $ledgers = Ledger::all();

        $fileName = "income_statement.csv";

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($ledgers, $branchId) {

            $file = fopen('php://output', 'w');

            fputcsv($file, ['TYPE', 'NAME', 'AMOUNT']);

            foreach ($ledgers as $ledger) {

                [$acc, $balance] = app(LedgerService::class)
                    ->calculateLedgerBalance($ledger->code, $branchId);

                $balance = $balance ?: 0;

                if (in_array(strtoupper($ledger->type), ['REVENUE','EXPENSE'])) {

                    fputcsv($file, [
                        $ledger->type,
                        $ledger->display_name,
                        $balance
                    ]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }   


}
