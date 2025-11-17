<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LedgergroupController extends Controller
{
    public function index()
    {
        return view('menu-accounts.ledger-group.index');
    }
    public function add_ledger_group()
    {
        return view('menu-accounts.ledger-group.add-ledger-group');
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
