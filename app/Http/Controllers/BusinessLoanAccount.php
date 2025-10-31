<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessLoanAccount extends Controller
{
    public function index(Request $request)
    {
       
            return view('bussiness.account.index');
    }
}
