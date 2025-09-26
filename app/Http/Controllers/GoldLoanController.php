<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class GoldLoanController extends Controller
{
     public function index()
    {
     return view("gold-loan.schemes.index");
    } 
    public function create(){
        //  $banks = Bank::all();
        return view("gold-loan.schemes.create");
    }
    
    public function view(){
        return view("gold-loan.schemes.view");
    }
        public function calculator(){
        return view("gold-loan.calculator.index");
    }
        public function calculation(){
        return view("gold-loan.calculator.calculation");
    }
      public function appindex(){
        return view("gold-loan.applications.index");
    }
     public function appcreate(){
        // $banks = Bank::all(); // or your logic here
        return view("gold-loan.applications.create");
    }
      public function appview(){
        // $banks = Bank::all(); // or your logic here
        return view("gold-loan.applications.view");
    }
     public function showEmiChart(){
        // $banks = Bank::all(); // or your logic here
        return view("gold-loan.applications.view-buttons.show-emi-chart");
    }
     public function showdisbursesetting(){
        
        return view("gold-loan.applications.view-buttons.disburse-setting");
    }

     public function col_process_fee(){
        
        return view("gold-loan.applications.view-buttons.col_process_fee");
    }
    public function upload_documents(){
        
        return view("gold-loan.applications.upload_documents");
    }
     public function upload_cibil_score(){
        
        return view("gold-loan.applications.upload-cibil-score");
    }

    
}
