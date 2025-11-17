<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuAccountController extends Controller
{
    public function tree_index()
    {
        return view("tree.index");
    }
      public function trail_index()
    {
        return view("trial-balance.index");
    }
      public function profit_loss_index()
    {
        return view("profit-loss.index");
    }
    
       public function income_index()
    {
        return view("income-statement.index");
    }
       public function balance_sheet_index()
    {
        return view("balance-sheet.index");
    }
       public function fy_report_index()
    {
        return view("fy-report.index");
    }
       public function daybook_index()
    {
        return view("day-book.index");
    }
        public function dash_index()
    {
        return view("dashboard.index");
    }
       public function assoc_apr_index()
    {
        return view("associate-approvals.index");
    }
      public function associate_report_index()
    {
        return view("associate-approvals.index");
    }
      public function coll_rep_index()
    {
        return view("collection-report.index");
    }
     public function active_asoc_index()
    {
        return view("active-associate.index");
    }
      public function assoc_limit_index()
    {
        return view("associate-limit.index");
    }
    
    
}

