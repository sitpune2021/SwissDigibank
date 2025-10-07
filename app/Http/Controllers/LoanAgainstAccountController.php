<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanAgainstAccountController extends Controller
{
    public function index(Request $request)
    {      
            return view('loanagainst.account.index');
    }
       
}
