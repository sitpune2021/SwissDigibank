<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LedgerGroup;
use App\Models\LoanApplication;
use App\Models\GoldLoanDisbursement;
use App\Models\Ledger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LedgergroupController extends Controller
{
    

    public function index()
    {
        $all = LedgerGroup::orderBy('weightage')->get();

        /*
        |---------------------------------
        | Attach accounts + balance dynamically
        |---------------------------------
        */
        foreach ($all as $group) {

            [$accounts, $balance] = $this->calculateGroupBalance($group->id);

            $group->accounts = $accounts;
            $group->balance  = $balance;
        }

        /*
        |---------------------------------
        | Type filters
        |---------------------------------
        */
        $assets      = $all->where('type', 'Asset');
        $liabilities = $all->where('type', 'Liability');
        $equity      = $all->where('type', 'Equity');
        $expenses    = $all->where('type', 'Expense');
        $revenue     = $all->where('type', 'Revenue');

        return view('menu-accounts.ledger-group.index', compact(
            'all',
            'assets',
            'liabilities',
            'equity',
            'expenses',
            'revenue'
        ));
    }

    private function calculateGroupBalance($groupId)
    {
        $ledgers = Ledger::where('group_id', $groupId)->get();

        if ($ledgers->isEmpty()) {
            return [0,0]; // no ledger → no balance
        }

        $totalAccounts = 0;
        $totalBalance  = 0;

        foreach ($ledgers as $ledger) {

            [$accounts, $balance] = $this->calculateLedgerBalance($ledger->code);

            $totalAccounts += $accounts;
            $totalBalance  += $balance;
        }

        return [$totalAccounts, $totalBalance];
    }

    private function goldLoanBalance()
    {
        $loans = DB::table('loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('gold_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('gold_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('gold_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function mortgageBalance()
    {
        $loans = DB::table('mortgage_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('mortgage_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('mortgage_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('mortgage_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function loanagainstBalance()
    {
        $loans = DB::table('loan_against_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('loan_against_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('loan_against_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('loan_against_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function businessloanBalance()
    {
        $loans = DB::table('bussiness_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('business_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('business_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('business_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function ccodloanBalance()
    {
        $loans = DB::table('cc_od_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('cc_od_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('cc_od_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('cc_od_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function dailyweeklyloanBalance()
    {
        $loans = DB::table('daily_weekly_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('daily_weekly_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('daily_weekly_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('daily_weekly_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function personalloanBalance()
    {
        $loans = DB::table('personal_loan_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('personal_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('personal_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('personal_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
    }

    private function vehicalloanBalance()
    {
        $loans = DB::table('vehical_applications')
            ->where('status', 2)
            ->get();

        $closing = 0;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collected = DB::table('vehical_loan_transactions')
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $charges = DB::table('vehical_loan_other_charges')
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remain = DB::table('vehical_loan_fore_closures')
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            $closing += max(0, $loanAmount - ($collected + $charges + $remain));
        }

        return [$loans->count(), $closing];
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
            | 🔥 ALWAYS USE CODE (NOT NAME)
            |----------------------------------------
            */
            [$accounts, $balance] = $this->calculateLedgersBalance($ledger->code);

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

    private function calculateLedgersBalance($code)
    {
        $code = strtoupper(Str::slug($code, '_'));

        // Specific matches first

        if (Str::contains($code, 'GOLD')) {
            return $this->goldLoanBalance();
        }

        if (Str::contains($code, ['MORTGAGE', 'PROPERTY'])) {
            return $this->mortgageBalance();
        }

        if (Str::contains($code, ['AGAINST', 'DEPOSITE'])) {
            return $this->loanagainstBalance();
        }

        if (Str::contains($code, 'BUSINESS')) {
            return $this->businessloanBalance();
        }

        if (Str::contains($code, ['CC_OD', 'CCOD'])) {
            return $this->ccodloanBalance();
        }

        if (Str::contains($code, ['DAILY', 'WEEKLY'])) {
            return $this->dailyweeklyloanBalance();
        }

        if (Str::contains($code, 'PERSONAL')) {
            return $this->personalloanBalance();
        }

        if (Str::contains($code, ['VEHICLE', 'CAR'])) {
            return $this->vehicalloanBalance();
        }
        if (Str::contains($code, 'SAVING')) {
            return $this->savingAccountsBalance();
        }
         if (Str::contains($code, 'FD')) {
            return $this->fdAccountsBalance();
        }
         if (Str::contains($code, 'RD')) {
            return $this->rdAccountsBalance();
        }
         if (Str::contains($code, 'MIS')) {
            return $this->misAccountsBalance();
        }
         if (Str::contains($code, 'DD')) {
            return $this->ddAccountsBalance();
        }

        return [0, 0];
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
   

    public function led_index()
    {
        $ledgers = Ledger::with('group')->latest()->get();

        foreach ($ledgers as $ledger) {

            // ⭐ use GROUP code, not ledger code
            //[$accounts, $balance] = $this->calculateLedgerBalance($ledger->group->code ?? '');
            [$accounts, $balance] = $this->calculateLedgerBalance($ledger->code);


            $ledger->balance = $balance ?: $ledger->opening_balance;
        }

        return view('menu-accounts.ledger.index', compact('ledgers'));
    }

    private function fdAccountsBalance()
    {
        $fds = DB::table('fd_accounts')
            ->where('status', 1)   // Approved
            ->where('active', 1)   // Active
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->maturity_amount ?? $fd->fd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function misAccountsBalance()
    {
        $fds = DB::table('misaccounts')
            ->where('status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->maturity_amount ?? $fd->mis_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function ddAccountsBalance()
    {
        $fds = DB::table('dds_accounts')
            ->where('status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->maturity_amount ?? $fd->dd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function rdAccountsBalance()
    {
        $fds = DB::table('rd_accounts')
            ->where('approve_status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->maturity_amount ?? $fd->rd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function savingAccountsBalance()
    {
        $accounts = DB::table('accounts')
            ->where('account_type', 'SAVING')
            ->where('approve_status', '1')   // string match
            ->where('account_status', 1)
            ->get();

        $totalAccounts = $accounts->count();
        $totalBalance = $accounts->sum('amount_deposit');

        return [$totalAccounts, $totalBalance];
    }

    private function currentAccountsBalance()
    {
        $accounts = DB::table('accounts')
            ->where('account_type', 'CURRENT')
            ->where('approve_status', '1')   // string match
            ->where('account_status', 1)
            ->get();

        $totalAccounts = $accounts->count();
        $totalBalance = $accounts->sum('amount_deposit');

        return [$totalAccounts, $totalBalance];
    }

    private function calculateLedgerBalance($ledgerCode)
    {
        
        $ledgerCode = strtoupper($ledgerCode);

        // FD LIABILITY MODULES FIRST

        if (Str::contains($ledgerCode, ['FD', 'FIXED'])) {
            return $this->fdAccountsBalance();
        }

        // MIS MODULES

        if (Str::contains($ledgerCode, ['MIS', 'FIXED'])) {
            return $this->misAccountsBalance();
        }

        // DD Account MODULES

        if (Str::contains($ledgerCode, ['DD', 'FIXED'])) {
            return $this->ddAccountsBalance();
        }

        // RD Account MODULES

        if (Str::contains($ledgerCode, ['RD', 'FIXED'])) {
            return $this->rdAccountsBalance();
        }

        // SAVING Account MODULES

        if (Str::contains($ledgerCode, 'SAVING')) {
            return $this->savingAccountsBalance();
        }

        // Current Account MODULES

        if (Str::contains($ledgerCode, 'CURRENT')) {
            return $this->currentAccountsBalance();
        }

        // ASSET MODULES  -  All Loan Module

        if (Str::contains($ledgerCode, 'GOLD')) {
            return $this->goldLoanBalance();
        }

        if (Str::contains($ledgerCode, 'MORTGAGE')) {
            return $this->mortgageBalance();
        }

        if (Str::contains($ledgerCode, 'PERSONAL')) {
            return $this->personalloanBalance();
        }

        if (Str::contains($ledgerCode, 'BUSINESS')) {
            return $this->businessloanBalance();
        }

        if (Str::contains($ledgerCode, 'CC_OD')) {
            return $this->ccodloanBalance();
        }

        if (Str::contains($ledgerCode, ['DAILY', 'WEEKLY'])) {
            return $this->dailyweeklyloanBalance();
        }

        if (Str::contains($ledgerCode, ['VEHICLE', 'VEHICAL'])) {
            return $this->vehicalloanBalance();
        }

        return [0,0];
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

    private function loanModuleMap()
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | LOAN MODULES (Asset Side)
            |--------------------------------------------------------------------------
            */
            'GOLD' => [
                'type' => 'loan',
                'loan' => 'loan_applications',
                'txn'  => 'gold_loan_transactions',
                'charges' => 'gold_loan_other_charges',
                'closure' => 'gold_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
            ],
            'MORTGAGE' => [
                'type' => 'loan',
                'loan' => 'mortgage_loan_applications',
                'txn'  => 'mortgage_loan_transactions',
                'charges' => 'mortgage_loan_other_charges',
                'closure' => 'mortgage_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
            ],
            'PROPERTY' => [
                'type' => 'loan',
                'loan' => 'mortgage_loan_applications',
                'txn'  => 'mortgage_loan_transactions',
                'charges' => 'mortgage_loan_other_charges',
                'closure' => 'mortgage_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
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
            ],
            'PERSONAL' => [
                'type' => 'loan',
                'loan' => 'personal_loan_applications',
                'txn'  => 'personal_loan_transactions',
                'charges' => 'personal_loan_other_charges',
                'closure' => 'personal_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
            ],
            'BUSINESS' => [
                'type' => 'loan',
                'loan' => 'business_loan_applications',
                'txn'  => 'business_loan_transactions',
                'charges' => 'business_loan_other_charges',
                'closure' => 'business_loan_fore_closures',
                'loan_id' => 'loan_id',
                'amount_column' => 'loan_amount',
                'collection_column' => 'amount_collected',
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
                'status_column' => 'status',
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

        ];
    }

    public function ledgerView($id)
    {
        $ledger = Ledger::with('group')->findOrFail($id);

        //$code = strtoupper(Str::slug($ledger->code, '_'));
        $code = strtoupper(trim($ledger->code));
        $map  = $this->loanModuleMap();

        // $module = collect($map)->first(function ($config, $key) use ($code) {
        //     return Str::contains($code, $key);
        // });
        $module = $map[$code] ?? null;

        if (!$module) {
            abort(404, 'Ledger type not supported');
        }

        $loans = DB::table($module['loan'])
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

        $totalDebit  = 0;
        $totalCredit = 0;
        $closingBalance = 0;
        $lastTransactionDate = null;

        foreach ($loans as $loan) {

            /*
            |--------------------------------------------------------------------------
            | SAVING ENGINE
            |--------------------------------------------------------------------------
            */
            if ($module['type'] === 'bank') {

                $credit = DB::table($module['txn'])
                    ->where($module['id_column'], $loan->id)
                    ->where('transaction_type', 'credit')
                    ->where('approve_status', 'approved')
                    ->sum('amount');

                $debit = DB::table($module['txn'])
                    ->where($module['id_column'], $loan->id)
                    ->where('transaction_type', 'debit')
                    ->where('approve_status', 'approved')
                    ->sum('amount');

                $totalCredit += $credit;
                $totalDebit  += $debit;
                $closingBalance += ($credit - $debit);
            }

            /*
            |--------------------------------------------------------------------------
            | DEPOSIT ENGINE (FD/MIS/RD/DD)
            |--------------------------------------------------------------------------
            */
            elseif ($module['type'] === 'deposit') {

                $credit = DB::table($module['txn'])
                    ->where($module['id_column'], $loan->id)
                    ->where('transaction_type', $module['credit_value'])
                    ->sum('amount');

                $debit = DB::table($module['txn'])
                    ->where($module['id_column'], $loan->id)
                    ->where('transaction_type', $module['debit_value'])
                    ->sum('amount');

                $totalCredit += $credit;
                $totalDebit  += $debit;
                $closingBalance += ($credit - $debit);
            }

            /*
            |--------------------------------------------------------------------------
            | LOAN ENGINE (Gold, Mortgage, etc.)
            |--------------------------------------------------------------------------
            */
            else {

                $loanAmount = $loan->{$module['amount_column']};

                $collected = DB::table($module['txn'])
                    ->where($module['loan_id'], $loan->id)
                    ->sum($module['collection_column']);

                $charges = DB::table($module['charges'])
                    ->where($module['loan_id'], $loan->id)
                    ->sum('amount');

                $closure = DB::table($module['closure'])
                    ->where($module['loan_id'], $loan->id)
                    ->value('remaining_amount') ?? 0;

                $credit = $collected + $charges + $closure;

                $totalDebit  += $loanAmount;
                $totalCredit += $credit;
                $closingBalance += max(0, $loanAmount - $credit);
            }

            $lastDate = DB::table($module['txn'])
                ->where($module['id_column'] ?? $module['loan_id'], $loan->id)
                ->max('created_at');

            if ($lastDate && (!$lastTransactionDate || $lastDate > $lastTransactionDate)) {
                $lastTransactionDate = $lastDate;
            }
        }

        $totalTransactions = $loans->count();

        $difference = in_array($module['type'], ['deposit','bank'])
            ? $totalCredit - $totalDebit
            : $totalDebit - $totalCredit;

        return view('menu-accounts.ledger.assest-ledger', compact(
            'ledger',
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
     

    public function profit_loss()
    {
        $today = Carbon::today();
        $previous = Carbon::today()->subYear();

        /*
        |--------------------------------------------------------------------------
        | 1. All Ledgers for tabs (Assets, Liabilities etc)
        |--------------------------------------------------------------------------
        */
        $ledgers = Ledger::with('group')->get();

        foreach ($ledgers as $ledger) {
            [$acc, $bal] = $this->calculateLedgerBalance($ledger->code);
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

        foreach ($ledgers as $ledger) {

            [$a1, $current]  = $this->calculateLedgerBalance($ledger->code, $today);
            [$a2, $previousBal] = $this->calculateLedgerBalance($ledger->code, $previous);

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
            'netPrevious'
        ));
    }


}
