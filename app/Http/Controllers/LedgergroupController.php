<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LedgerGroup;
use App\Models\LoanApplication;
use App\Models\GoldLoanDisbursement;

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

        $assets      = LedgerGroup::where('type','Asset')->orderBy('weightage')->get();
        $liabilities = LedgerGroup::where('type','Liability')->orderBy('weightage')->get();
        $equity      = LedgerGroup::where('type','Equity')->orderBy('weightage')->get();
        $expenses    = LedgerGroup::where('type','Expense')->orderBy('weightage')->get();
        $revenue     = LedgerGroup::where('type','Revenue')->orderBy('weightage')->get();


        /*
        |--------------------------------------------------------------------------
        | GOLD LOAN DATA
        |--------------------------------------------------------------------------
        */

        // accounts (approved loans)
        $goldLoanAccounts = LoanApplication::where('status', 2)->count();


        // balance (total disbursed amount)
        $goldLoanBalance = GoldLoanDisbursement::sum('final_amount');

        return view('menu-accounts.ledger-group.index', compact(
            'all','assets','liabilities','equity','expenses','revenue',
            'goldLoanAccounts','goldLoanBalance'
        ));
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

        LedgerGroup::create([
            'display_name'   => strtoupper($request->display_name),
            'system_name'    => strtoupper($request->system_name),
            'type'           => $request->type,
            'is_system_group'=> $request->is_system_group ?? 0,
            'weightage'      => $request->weightage,
        ]);

        return redirect()->route('ledger-group.index')
            ->with('success','Ledger Group Created Successfully');
    }


    public function view()
    {
        return view('menu-accounts.ledger-group.view');
    }
    public function asset_ledger()
    {
        return view('menu-accounts.ledger-group.asset-ledger');
    }

    public function edit_ledger()
    {
        return view('menu-accounts.ledger-group.edit-ledger');
    }
    public function journal_entry()
    {
        return view('menu-accounts.ledger-group.journal-entry');
    }
    public function led_index()
    {
        return view('menu-accounts.ledger.index');
    }
    public function add_leg()
    {
        return view('menu-accounts.ledger.add-ledger');
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
}
