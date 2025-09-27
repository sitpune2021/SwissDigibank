<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\GoldLoanScheme;

class GoldLoanController extends Controller
{
     public function index()
    {
        // saare gold loan schemes fetch karenge
        $schemes = GoldLoanScheme::all();
        return view("gold-loan.schemes.index", compact('schemes'));
    } 
  

    public function create()
    {
        return view("gold-loan.schemes.create");
    }

    public function store(Request $request)
    {
        // validation
        $validated = $request->validate([
            'scheme_name' => 'required|string|max:255',
            'scheme_code' => 'required|string|max:50|unique:gold_loan_schemes,scheme_code',
            'min_loan_amount' => 'required|numeric',
            'max_loan_amount' => 'required|numeric',
            'tenure' => 'required|integer',
            'annual_interest_rate' => 'required|numeric',
        ]);

        // save data
        GoldLoanScheme::create($request->all());

        return redirect()->route('gold-loan.schemes.index')
                         ->with('success', 'Scheme created successfully!');
    }

    public function show($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view('gold-loan.schemes.show', compact('scheme'));
    }

    public function edit($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view('gold-loan.schemes.create', compact('scheme'));
    }

    public function update(Request $request, $id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);

        $scheme->update($request->all());

        return redirect()->route('gold-loan.schemes.index')
                        ->with('success', 'Scheme updated successfully!');
    }

    
    public function view($id)
    {
        $scheme = GoldLoanScheme::findOrFail($id);
        return view("gold-loan.schemes.view", compact('scheme'));
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
