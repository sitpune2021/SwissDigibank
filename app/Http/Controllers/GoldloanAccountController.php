<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoldloanAccountController extends Controller
{
    public function index(Request $request)
    {
       
            return view('gold-loan.account.index');
    }
       
}
