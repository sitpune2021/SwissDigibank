<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MortgageAccountController extends Controller
{
    public function index(Request $request)
    {      
            return view('mortgage.account.index');
    }
       
}
