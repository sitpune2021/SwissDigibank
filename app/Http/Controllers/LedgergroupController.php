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


class LedgergroupController extends Controller
{
    

    /*
        |--------------------------------------------------------------------------
        | INDEX
        |--------------------------------------------------------------------------
    */

    public function index()
    {
        $all = LedgerGroup::orderBy('weightage')->get();

        /*
        |---------------------------------
        | Attach accounts + balance dynamically
        |---------------------------------
        */
        foreach ($all as $group) {

            [$accounts, $balance] = $this->calculateGroupBalance($group->code);

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

    private function calculateGroupBalance($code)
    {
        switch ($code) {

            case 'LOANS':
                return $this->goldLoanBalance();

            case 'MORTGAGE_PROPERTY':
                return $this->mortgageBalance();

            default:
                return [0, 0];
        }
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


   /*
    |--------------------------------------------------------------------------
    | CREATE FORM
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('menu-accounts.ledger-group.add-ledger-group');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

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
        | Fetch ledgers under this group
        |----------------------------------------
        */
        $ledgers = Ledger::where('group_id', $id)
            ->with('group')
            ->get();


        $totalBalance = 0;


        /*
        |----------------------------------------
        | SAME BALANCE LOGIC (Gold/Mortgage)
        |----------------------------------------
        */
        foreach ($ledgers as $ledger) {

            $ledger->balance = $ledger->opening_balance;


            if ($ledger->system_name == 'Gold Loan') {

                $loans = DB::table('loan_applications')->where('status', 2)->get();

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

                $ledger->balance = $closing;
            }

            elseif ($ledger->system_name == 'Mortgage Loan') {

                $loans = DB::table('mortgage_loan_applications')->where('status', 2)->get();

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

                $ledger->balance = $closing;
            }


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


////////////////////////////////    Only Lead Tab      ////////////////////////////////////////////
   

    public function led_index()
    {
        $ledgers = Ledger::with('group')->latest()->get();
        $groups  = LedgerGroup::orderBy('display_name')->get();


        /*
        |------------------------------------------------
        | Dynamic closing balance for each ledger
        |------------------------------------------------
        */

        foreach ($ledgers as $ledger) {

            $ledger->balance = $ledger->opening_balance; // default


            /*
            |----------------------------------------
            | GOLD LOAN LEDGER
            |----------------------------------------
            */
            if ($ledger->system_name == 'Gold Loan') {

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

                $ledger->balance = $closing;
            }


            /*
            |----------------------------------------
            | MORTGAGE LOAN LEDGER
            |----------------------------------------
            */
            elseif ($ledger->system_name == 'Mortgage Loan') {

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

                $ledger->balance = $closing;
            }
        }


        return view('menu-accounts.ledger.index', compact('ledgers','groups'));
    }

    public function add_leg()
    {
        // first load empty
        $groups = collect();

        return view('menu-accounts.ledger.add-ledger', compact('groups'));
    }

    public function groupsByType($type)
    {
        Log::info('Type Selected: '.$type);

        $groups = LedgerGroup::where('type', $type)
            ->orderBy('display_name')
            ->get(['id','display_name']);

        return response()->json($groups);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function led_store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'group_id' => 'required',
            'display_name' => 'required',
            'system_name' => 'required',
            'code' => 'required|unique:ledgers,code'
        ]);

        Ledger::create([
            'type' => $request->type,
            'group_id' => $request->group_id,
            'display_name' => $request->display_name,
            'system_name' => $request->system_name,
            'code' => strtoupper($request->code),
            'is_bank_acc' => $request->is_bank_acc ?? false,
            'show_in_day' => $request->show_in_day ?? false,
            'opening_balance' => 0
        ]);

        return redirect()
            ->route('ledger.index')
            ->with('success', 'Ledger Added Successfully');
    }

    public function ledgerView($id)
    {
        $ledger = Ledger::with('group')->findOrFail($id);

        /*
        |---------------------------------------
        | Decide tables dynamically
        |---------------------------------------
        */

        if ($ledger->system_name == 'Gold Loan') {

            $loanTable        = 'loan_applications';
            $txnTable         = 'gold_loan_transactions';
            $chargesTable     = 'gold_loan_other_charges';
            $closureTable     = 'gold_loan_fore_closures';

        } elseif ($ledger->system_name == 'Mortgage Loan') {

            $loanTable        = 'mortgage_loan_applications';
            $txnTable         = 'mortgage_loan_transactions';
            $chargesTable     = 'mortgage_loan_other_charges';
            $closureTable     = 'mortgage_loan_fore_closures';

        } else {
            abort(404, 'Ledger type not supported');
        }


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
        $ledgers = Ledger::with('group')->latest()->get();
        $groups  = LedgerGroup::orderBy('display_name')->get();

        return view('menu-accounts.profit-loss.profit_loss', compact('ledgers','groups'));
    }


}
