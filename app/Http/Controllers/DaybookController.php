<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DaybookController extends Controller
{
      public function day_book(){
        
        return view("day-book.day-book");
    }
       public function cash_book(){
        
        return view("day-book.cash-book");
    }
       public function bank_book(){
        
        return view("day-book.bank-book");
    }
     public function wallet_book(){
        
        return view("day-book.wallet-book");
    }
      public function edit_ledger(){
        
        return view("day-book.edit-ledger");
    }
     public function journal_entry(){
        
        return view("day-book.journal-entry");
    }
    public function ledger_book(){
        
        return view("day-book.ledger-book");
    }
}
