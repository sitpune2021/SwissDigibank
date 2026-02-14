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

    // Interest = P × R × T / 100 
    private function calculateFlatInterest($principal, $rate, $months)
    {
        $years = $months / 12;

        return ($principal * $rate * $years) / 100;
    }

    // EMI = P × r × (1+r)^n / ((1+r)^n - 1)
    private function calculateReducingInterest($principal, $annualRate, $months)
    {
        $monthlyRate = $annualRate / 12 / 100;

        $emi = $principal * $monthlyRate * pow(1 + $monthlyRate, $months)
            / (pow(1 + $monthlyRate, $months) - 1);

        $totalPayment = $emi * $months;

        return $totalPayment - $principal;
    }

    private function calculateAdvanceInterest($principal, $rate, $months)
    {
        $interest = $this->calculateFlatInterest($principal, $rate, $months);

        return $interest; // deducted upfront
    }

    private function calculateBulletInterest($principal, $rate, $months)
    {
        return $this->calculateFlatInterest($principal, $rate, $months);
    }

    private function calculateLoanInterest($loanTable, $schemeTable)
    {
        $loans = DB::table($loanTable)
            ->where('status', 2)
            ->get();

        $totalInterest = 0;

        foreach ($loans as $loan) {

            $scheme = DB::table($schemeTable)
                ->where('id', $loan->scheme_id)
                ->first();

            if (!$scheme) continue;

            $principal = $loan->loan_amount;
            $rate      = $scheme->annual_interest_rate;
            $months    = $scheme->tenure;

            switch ($scheme->interest_type ?? $scheme->gold_loan_setting ?? 'flat') {

                case 'reducing_emi':
                    $interest = $this->calculateReducingInterest($principal, $rate, $months);
                    break;

                case 'advance':
                    $interest = $this->calculateAdvanceInterest($principal, $rate, $months);
                    break;

                case 'no_emi':
                    $interest = $this->calculateBulletInterest($principal, $rate, $months);
                    break;

                default:
                    $interest = $this->calculateFlatInterest($principal, $rate, $months);
            }

            $totalInterest += $interest;
        }

        return [$loans->count(), $totalInterest];
    }

    private function goldLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'loan_applications',
            'gold_loan_schemes'
        );
    }

    private function mortgageLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'mortgage_loan_applications',
            'mortgage_schemes'
        );
    }

    private function againstLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'loan_against_applications',
            'loan_against_schemes'
        );
    }

    private function bussinessLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'bussiness_loan_applications',
            'business_loan_schemes'
        );
    }

    private function ccodLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'cc_od_loan_applications',
            'cc_od_loan_schemes'
        );
    }

    private function dailyweeklyLoanInterestBalance()
    {
        return $this->calculateLoanInterest(
            'daily_weekly_applications',
            'daily_weekly_schemes'
        );
    }

    private function personalInterestBalance()
    {
        return $this->calculateLoanInterest(
            'personal_loan_applications',
            'personal_schemes'
        );
    }

    private function vehicalInterestBalance()
    {
        return $this->calculateLoanInterest(
            'vehical_applications',
            'vehical_schemes'
        );
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
            | ALWAYS USE CODE (NOT NAME)
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
        // INTEREST FIRST
        if (Str::contains($code, 'FD_INTEREST')) {
            return $this->fdInterestBalance();
        }

        if (Str::contains($code, 'RD_INTEREST')) {
            return $this->rdInterestBalance();
        }

        if (Str::contains($code, 'MIS_INTEREST')) {
            return $this->misInterestBalance();
        }

        if (Str::contains($code, 'DD_INTEREST')) {
            return $this->ddInterestBalance();
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
            return $fd->fd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function fdInterestBalance()
    {
        $fds = DB::table('fd_accounts')
            ->where('status', 1)
            ->where('active', 1)
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->fd_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
    }

    private function misAccountsBalance()
    {
        $fds = DB::table('misaccounts')
            ->where('status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->mis_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function misInterestBalance()
    {
        $fds = DB::table('misaccounts')
            ->where('status', 1)
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->mis_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
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

    private function ddInterestBalance()
    {
        $fds = DB::table('dds_accounts')
            ->where('status', 1)
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->dd_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
    }

    private function rdAccountsBalance()
    {
        $fds = DB::table('rd_accounts')
            ->where('approve_status', 1)   // Approved
            ->get();

        $totalAccounts = $fds->count();

        $totalBalance = $fds->sum(function ($fd) {
            return $fd->rd_amount;
        });

        return [$totalAccounts, $totalBalance];
    }

    private function rdInterestBalance()
    {
        $fds = DB::table('rd_accounts')
            ->where('approve_status', 'Approved')
            ->get();

        $totalAccounts = $fds->count();

        $totalInterest = $fds->sum(function ($fd) {
            return ($fd->maturity_amount ?? 0) - ($fd->rd_amount ?? 0);
        });

        return [$totalAccounts, $totalInterest];
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

        // FD InterestLIABILITY MODULES FIRST
        if ($ledgerCode === 'FD_INTEREST') {
            return $this->fdInterestBalance();
        }

        // FD Accounts
        if ($ledgerCode === 'FD_ACCOUNTS') {
            return $this->fdAccountsBalance();
        }

        // MIS MODULES
        if ($ledgerCode === 'MIS_ACCOUNTS') {
            return $this->misAccountsBalance();
        }

        // MIS INTEREST
        if ($ledgerCode === 'MIS_INTEREST') {
            return $this->misInterestBalance();
        }

        // DD MODULES
        if ($ledgerCode === 'DD_ACCOUNTS') {
            return $this->ddAccountsBalance();
        }

        // DD INTEREST
        if ($ledgerCode === 'DD_INTEREST') {
            return $this->ddInterestBalance();
        }

        // RD MODULES
        if ($ledgerCode === 'RD_ACCOUNTS') {
            return $this->rdAccountsBalance();
        }

        // RD INTEREST
        if ($ledgerCode === 'RD_INTEREST') {
            return $this->rdInterestBalance();
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

        // GOLD LOAN INTEREST FIRST
        if ($ledgerCode === 'GOLD_LOAN_INTEREST') {
            return $this->goldLoanInterestBalance();
        }

        // Then general GOLD
        if (Str::contains($ledgerCode, 'GOLD')) {
            return $this->goldLoanBalance();
        }

        if ($ledgerCode === 'MORTGAGE_LOAN_INTEREST') {
            return $this->mortgageLoanInterestBalance();
        }

        if ($ledgerCode === 'PROPERTY_LOAN_INTEREST') {
            return $this->mortgageLoanInterestBalance();
        }

        if (Str::contains($ledgerCode, 'MORTGAGE')) {
            return $this->mortgageBalance();
        }

        if ($ledgerCode === 'LOAN_AGINST_INTEREST') {
            return $this->againstLoanInterestBalance();
        }

        if (Str::contains($ledgerCode, 'AGINST')) {
            return $this->loanagainstBalance();
        }

        if ($ledgerCode === 'PERSONAL_LOAN_INTEREST') {
            return $this->personalInterestBalance();
        }
        if ($ledgerCode === 'VEHICAL_LOAN_INTEREST') {
            return $this->vehicalInterestBalance();
        }
        if ($ledgerCode === 'DAILY_WEEKLY_LOAN_INTEREST') {
            return $this->dailyweeklyLoanInterestBalance();
        }
        if ($ledgerCode === 'CC_OD_LOAN_INTEREST') {
            return $this->ccodLoanInterestBalance();
        }
        if ($ledgerCode === 'BUSSINESS_LOAN_INTEREST') {
            return $this->bussinessLoanInterestBalance();
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

        ];
    }

    // public function ledgerView($id)
    // {
    //     $ledger = Ledger::with('group')->findOrFail($id);

    //     //$code = strtoupper(Str::slug($ledger->code, '_'));
    //     $code = strtoupper(trim($ledger->code));
    //     $map  = $this->loanModuleMap();

    //     // $module = collect($map)->first(function ($config, $key) use ($code) {
    //     //     return Str::contains($code, $key);
    //     // });
    //     $module = $map[$code] ?? null;

    //     if (!$module) {
    //         abort(404, 'Ledger type not supported');
    //     }

    //     $loans = DB::table($module['loan'])
    //         ->when(isset($module['status_column']), function ($q) use ($module) {
    //             $q->where($module['status_column'], $module['status_value']);
    //         })
    //         ->when($module['type'] === 'bank', function ($q) use ($module) {
    //             $q->where('account_type', $module['account_type'])
    //             ->where('approve_status', '1')
    //             ->where('account_status', 1)
    //             ->whereNull('deleted_at');
    //         })
    //         ->get();

    //     $totalDebit  = 0;
    //     $totalCredit = 0;
    //     $closingBalance = 0;
    //     $lastTransactionDate = null;

    //     foreach ($loans as $loan) 
    //     {

    //         /*
    //         |--------------------------------------------------------------------------
    //         | SAVING ENGINE
    //         |--------------------------------------------------------------------------
    //         */
    //         if ($module['type'] === 'bank') {

    //             $credit = DB::table($module['txn'])
    //                 ->where($module['id_column'], $loan->id)
    //                 ->where('transaction_type', 'credit')
    //                 ->where('approve_status', 'approved')
    //                 ->sum('amount');

    //             $debit = DB::table($module['txn'])
    //                 ->where($module['id_column'], $loan->id)
    //                 ->where('transaction_type', 'debit')
    //                 ->where('approve_status', 'approved')
    //                 ->sum('amount');

    //             $totalCredit += $credit;
    //             $totalDebit  += $debit;
    //             $closingBalance += ($credit - $debit);
    //         }

    //         // INTEREST LEDGER SPECIAL LOGIC
    //         if (Str::endsWith($code, '_INTEREST')) {

    //             $principal = $loan->fd_amount ?? 
    //                         $loan->rd_amount ?? 
    //                         $loan->mis_amount ?? 
    //                         $loan->dd_amount ?? 0;

    //             $maturity  = $loan->maturity_amount ?? 0;

    //             $interest = $maturity - $principal;

    //             $totalCredit += $interest;
    //             $closingBalance += $interest;

    //             continue; // very important
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | DEPOSIT ENGINE (FD/MIS/RD/DD)
    //         |--------------------------------------------------------------------------
    //         */
    //         elseif ($module['type'] === 'deposit') {

    //             $credit = DB::table($module['txn'])
    //                 ->where($module['id_column'], $loan->id)
    //                 ->where('transaction_type', $module['credit_value'])
    //                 ->sum('amount');

    //             $debit = DB::table($module['txn'])
    //                 ->where($module['id_column'], $loan->id)
    //                 ->where('transaction_type', $module['debit_value'])
    //                 ->sum('amount');

    //             $totalCredit += $credit;
    //             $totalDebit  += $debit;
    //             $closingBalance += ($credit - $debit);
    //         }

    //         elseif ($module['type'] === 'deposit_interest') {

    //             $principal = $loan->fd_amount ?? 0;
    //             $maturity  = $loan->maturity_amount ?? 0;

    //             $interest = $maturity - $principal;

    //             $totalCredit += $interest;
    //             $closingBalance += $interest;
    //         }

    //         elseif ($module['type'] === 'loan_interest') {

    //             $scheme = DB::table($module['scheme'])
    //                 ->where('id', $loan->scheme_id)
    //                 ->first();

    //             if (!$scheme) continue;

    //             $principal = $loan->loan_amount;
    //             $rate      = $scheme->annual_interest_rate;
    //             $months    = $scheme->tenure;

    //             switch ($scheme->gold_loan_setting ?? $scheme->interest_type ?? 'flat') {

    //                 case 'reducing_emi':
    //                     $interest = $this->calculateReducingInterest($principal, $rate, $months);
    //                     break;

    //                 case 'advance':
    //                     $interest = $this->calculateAdvanceInterest($principal, $rate, $months);
    //                     break;

    //                 case 'no_emi':
    //                     $interest = $this->calculateBulletInterest($principal, $rate, $months);
    //                     break;

    //                 default:
    //                     $interest = $this->calculateFlatInterest($principal, $rate, $months);
    //             }

    //             $totalCredit += $interest;
    //             $closingBalance += $interest;
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | LOAN ENGINE (Gold, Mortgage, etc.)
    //         |--------------------------------------------------------------------------
    //         */
    //         else {

    //             $loanAmount = $loan->{$module['amount_column']};

    //             $collected = DB::table($module['txn'])
    //                 ->where($module['loan_id'], $loan->id)
    //                 ->sum($module['collection_column']);

    //             $charges = DB::table($module['charges'])
    //                 ->where($module['loan_id'], $loan->id)
    //                 ->sum('amount');

    //             $closure = DB::table($module['closure'])
    //                 ->where($module['loan_id'], $loan->id)
    //                 ->value('remaining_amount') ?? 0;

    //             $credit = $collected + $charges + $closure;

    //             $totalDebit  += $loanAmount;
    //             $totalCredit += $credit;
    //             $closingBalance += max(0, $loanAmount - $credit);
    //         }

    //         $lastDate = DB::table($module['txn'])
    //             ->where($module['id_column'] ?? $module['loan_id'], $loan->id)
    //             ->max('created_at');

    //         if ($lastDate && (!$lastTransactionDate || $lastDate > $lastTransactionDate)) {
    //             $lastTransactionDate = $lastDate;
    //         }
    //     }

    //     $totalTransactions = $loans->count();

    //     $difference = in_array($module['type'], ['deposit','bank','deposit_interest','loan_interest'])
    //         ? $totalCredit - $totalDebit
    //         : $totalDebit - $totalCredit;

    //     return view('menu-accounts.ledger.assest-ledger', compact(
    //         'ledger',
    //         'totalDebit',
    //         'totalTransactions',
    //         'totalCredit',
    //         'difference',
    //         'closingBalance',
    //         'lastTransactionDate'
    //     ));
    // }

    
    public function ledgerView($id)
    {
        $ledger = Ledger::with('group')->findOrFail($id);

        $code = strtoupper(trim($ledger->code));
        $map  = $this->loanModuleMap();

        $module = $map[$code] ?? null;

        if (!$module) {
            abort(404, 'Ledger type not supported');
        }

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

        $totalDebit  = 0;
        $totalCredit = 0;
        $closingBalance = 0;
        $lastTransactionDate = null;

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

                $scheme = DB::table($module['scheme'])
                    ->where('id', $record->scheme_id)
                    ->first();

                if (!$scheme) continue;

                $principal = $record->loan_amount ?? 0;
                $rate      = $scheme->annual_interest_rate ?? 0;
                $months    = $scheme->tenure ?? 0;

                switch ($scheme->interest_type ?? $scheme->gold_loan_setting ?? 'flat') {

                    case 'reducing_emi':
                        $interest = $this->calculateReducingInterest($principal, $rate, $months);
                        break;

                    case 'advance':
                        $interest = $this->calculateAdvanceInterest($principal, $rate, $months);
                        break;

                    case 'no_emi':
                        $interest = $this->calculateBulletInterest($principal, $rate, $months);
                        break;

                    default:
                        $interest = $this->calculateFlatInterest($principal, $rate, $months);
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

        $totalTransactions = $records->count();

        $difference = in_array($module['type'], ['deposit','bank','deposit_interest','loan_interest'])
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
