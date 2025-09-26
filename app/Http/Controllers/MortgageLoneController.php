<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MortgageLoneController extends Controller
{
    public function index()
    {
       return view('mortgage-loan.mortgage_schemes.index');
    }

    public function Create()
    {
        return view('mortgage-loan.mortgage_schemes.create_mortgage_scheme');
    }

    public function edit()
    {
        return view('mortgage-loan.mortgage_schemes.edit_mortgage_scheme');
    }

     public function view()
    {
        return view('mortgage-loan.mortgage_schemes.view_mortgage_scheme');
    }

     public function calculator()
    {
        return view('mortgage-loan.mortgage_calculator.calculation ');
    }

    public function calculation()
    {
        return view('mortgage-loan.mortgage_calculator.calculation');
    }

    public function applications()
    {
        return view('mortgage-loan.mortgage_application.create_application');
    }

    public function viewApplication()
    {
        return view('mortgage-loan.mortgage_application.view.view_application');
    }

    public function editApplication()
    {
         return view('mortgage-loan.mortgage_application.create_application');
    }

    public function emiChart()
    {
        return view('mortgage-loan.mortgage_application.view.emi-chart');
    }

    public function uploadDocuments()
    {
        return view('mortgage-loan.mortgage_application.view.upload_documents');
    }

    public function collectProcessFee()
    {
        return view('mortgage-loan.mortgage_application.view.col_process_fee');
    }

    public function disburseSetting()
    {
        return view('mortgage-loan.mortgage_application.view.disburse-setting');
    }

    public function cibilScore()
    {
        return view('mortgage-loan.mortgage_application.view.upload-cibil-score');
    }

    public function disbursementIndex()
    {
        return view('mortgage-loan.mortgage_disbursements.index');
    }

    public function disburseLoan()
    {
        return view('mortgage-loan.mortgage_disbursements.disburse-loan');
    }
    
}
