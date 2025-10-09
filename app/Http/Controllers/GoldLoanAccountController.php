<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoldLoanAccountController extends Controller
{
    public function index(Request $request)
    {
       
            return view('gold-loan.account.index');
    }
       
}
