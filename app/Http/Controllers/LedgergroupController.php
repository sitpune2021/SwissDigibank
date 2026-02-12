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

    // OLD CODE
    // private function calculateGroupBalance($code)
    // {
    //     $map = [
    //         'LOAN'  => 'goldLoanBalance',
    //         'LOANS' => 'goldLoanBalance',
    //         'MORTGAGE_PROPERTY'  => 'mortgageBalance',
    //         'LOAN_AGAINST'       => 'loanagainstBalance',
    //         'BUSINESS_LOAN'      => 'businessloanBalance',
    //         'CC_OD_LOAN'         => 'ccodloanBalance',
    //         'DAILY_WEEKLY_LOAN'  => 'dailyweeklyloanBalance',
    //         'PERSONAL_LOAN'      => 'personalloanBalance',
    //         'VEHICAL_LOAN'       => 'vehicalloanBalance',
    //     ];

    //     if(isset($map[$code])) {
    //         return $this->{$map[$code]}();
    //     }

    //     return [0,0];
    // }

    
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

        // 🔥 Specific matches first

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

    // private function calculateLedgerBalance($groupCode)
    // {
    //     $map = [
    //         'LOANS'     => 'goldLoanBalance',
    //         'GOLD'     => 'goldLoanBalance',
    //         'MORTGAGE'  => 'mortgageBalance',
    //         'LOAN_AGAINST'       => 'loanagainstBalance',
    //         'PERSONAL'  => 'personalLoanBalance',
    //         'BUSINESS'  => 'businessLoanBalance',
    //         'CC_OD_LOAN'         => 'ccodloanBalance',
    //         'DAILY_WEEKLY_LOAN'  => 'dailyweeklyloanBalance',
    //         'VEHICAL_LOAN'       => 'vehicalloanBalance',
    //     ];

    //     if (isset($map[$groupCode])) {
    //         return $this->{$map[$groupCode]}();
    //     }

    //     return [0, 0];
    // }

    
    private function calculateLedgerBalance($ledgerCode)
    {
        $ledgerCode = strtoupper($ledgerCode);

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

        if (Str::contains($ledgerCode, 'DAILY') || Str::contains($ledgerCode, 'WEEKLY')) {
            return $this->dailyweeklyloanBalance();
        }

        if (Str::contains($ledgerCode, 'VEHICLE') || Str::contains($ledgerCode, 'VEHICAL')) {
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

    // // leder create page drop down dynamically function
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

    // leder view page map
    private function loanModuleMap()
    {
        return [

            'GOLD' => [
                'loan'    => 'loan_applications',
                'txn'     => 'gold_loan_transactions',
                'charges' => 'gold_loan_other_charges',
                'closure' => 'gold_loan_fore_closures',
            ],

            'MORTGAGE' => [
                'loan'    => 'mortgage_loan_applications',
                'txn'     => 'mortgage_loan_transactions',
                'charges' => 'mortgage_loan_other_charges',
                'closure' => 'mortgage_loan_fore_closures',
            ],

            'PROPERTY' => [
                'loan'    => 'mortgage_loan_applications',
                'txn'     => 'mortgage_loan_transactions',
                'charges' => 'mortgage_loan_other_charges',
                'closure' => 'mortgage_loan_fore_closures',
            ],

            'LOAN_AGAINST' => [
                'loan'    => 'loan_against_applications',
                'txn'     => 'loan_against_transactions',
                'charges' => 'loan_against_other_charges',
                'closure' => 'loan_against_fore_closures',
            ],

            'PERSONAL' => [
                'loan'    => 'personal_loan_applications',
                'txn'     => 'personal_loan_transactions',
                'charges' => 'personal_loan_other_charges',
                'closure' => 'personal_loan_fore_closures',
            ],

            'BUSINESS' => [
                'loan'    => 'business_loan_applications',
                'txn'     => 'business_loan_transactions',
                'charges' => 'business_loan_other_charges',
                'closure' => 'business_loan_fore_closures',
            ],

            'CC_OD_LOAN' => [
                'loan'    => 'ccod_loan_applications',
                'txn'     => 'ccod_loan_transactions',
                'charges' => 'ccod_loan_other_charges',
                'closure' => 'ccod_loan_fore_closures',
            ],

            'DAILY_WEEKLY_LOAN' => [
                'loan'    => 'daily_weekly_loan_applications',
                'txn'     => 'daily_weekly_loan_transactions',
                'charges' => 'daily_weekly_loan_other_charges',
                'closure' => 'daily_weekly_loan_fore_closures',
            ],

            'VEHICAL_LOAN' => [
                'loan'    => 'vehicle_loan_applications',
                'txn'     => 'vehicle_loan_transactions',
                'charges' => 'vehicle_loan_other_charges',
                'closure' => 'vehicle_loan_fore_closures',
            ],
        ];
    }

    // leder view page
    public function ledgerView($id)
    {
        $ledger = Ledger::with('group')->findOrFail($id);

       
        
        
        

$code = strtoupper(Str::slug($ledger->code, '_'));

$map = $this->loanModuleMap();

$matchedKey = null;

foreach ($map as $key => $tables) {
    if (Str::contains($code, $key)) {
        $matchedKey = $key;
        break;
    }
}

if (!$matchedKey) {
    abort(404, 'Ledger type not supported');
}

$loanTable    = $map[$matchedKey]['loan'];
$txnTable     = $map[$matchedKey]['txn'];
$chargesTable = $map[$matchedKey]['charges'];
$closureTable = $map[$matchedKey]['closure'];


        /*
        |---------------------------------------
        | Fetch loans
        |---------------------------------------
        */

        $loans = DB::table($loanTable)
            ->where('status', 2)
            ->get();

        $totalTransactions = $loans->count();

        $totalDebit  = 0;
        $totalCredit = 0;
        $closingBalance = 0;
        $lastTransactionDate = null;

        foreach ($loans as $loan) {

            $loanAmount = $loan->loan_amount;

            $collectedAmount = DB::table($txnTable)
                ->where('loan_id', $loan->id)
                ->sum('amount_collected');

            $otherCharges = DB::table($chargesTable)
                ->where('loan_id', $loan->id)
                ->sum('amount');

            $remainingAmount = DB::table($closureTable)
                ->where('loan_id', $loan->id)
                ->value('remaining_amount') ?? 0;

            /*
            | Debit / Credit
            */

            $totalDebit += $loanAmount;

            $credit = $collectedAmount + $otherCharges + $remainingAmount;

            $totalCredit += $credit;

            $currentDebt = max(0, $loanAmount - $credit);

            $closingBalance += $currentDebt;

            /*
            | Last Transaction Date
            */

            $dates = collect([
                DB::table($txnTable)->where('loan_id', $loan->id)->max('created_at'),
                DB::table($chargesTable)->where('loan_id', $loan->id)->max('created_at'),
                DB::table($closureTable)->where('loan_id', $loan->id)->max('created_at'),
            ])->filter();

            $maxDate = $dates->max();

            if ($maxDate && (!$lastTransactionDate || $maxDate > $lastTransactionDate)) {
                $lastTransactionDate = $maxDate;
            }
        }

        $difference = $totalDebit - $totalCredit;

        return view('menu-accounts.ledger.assest-ledger', compact(
            'ledger',
            'totalTransactions',
            'totalDebit',
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
