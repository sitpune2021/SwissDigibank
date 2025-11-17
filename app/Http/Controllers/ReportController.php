<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
   public function assoc_index()
    {
        return view("associate-report.index");
    }
    public function branch_index()
    {
        return view("branch-report.index");
    }
    public function maturity_index()
    {
        return view("maturity-report.index");
    }
       public function loan_report_index()
    {
        return view("loan-report.index");
    }
}
