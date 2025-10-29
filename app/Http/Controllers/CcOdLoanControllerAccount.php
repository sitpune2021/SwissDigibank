<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CcOdLoanControllerAccount extends Controller
{
    public function index(Request $request)
    {
       
            return view('cc_od.account.index');
    }
}
