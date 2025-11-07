<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LedgergroupController extends Controller
{
     public function index()
    {
        return view('ledger-group.index');
    }
     public function add_ledger_group()
    {
        return view('ledger-group.add-ledger-group');
    }
     public function view()
    {
        return view('ledger-group.view');
    }
     public function asset_ledger()
    {
        return view('ledger-group.asset-ledger');
    }
  
    public function edit_ledger()
    {
        return view('ledger-group.edit-ledger');
    }
     public function journal_entry()
    {
        return view('ledger-group.journal-entry');
    }
    public function led_index()
    {
        return view('ledger.index');
    }
    public function add_leg()
    {
        return view('ledger.add-ledger');
    }
    public function update_bulkrisk()
    {
        return view('ledger.update-bulkrisk');
    }
     public function revenue_ledger()
    {
        return view('ledger.view');
    }
      public function edit_ledgers()
    {
        return view('ledger.edit-ledger');
    }
       public function journal_entry_ledger()
    {
        return view('ledger.journal-entry');
    }
    
}
