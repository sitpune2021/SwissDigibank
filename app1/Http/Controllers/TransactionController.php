<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function style1()
    {
        return view('transaction.style1');
    }

    public function style2()
    {
        return view('transaction.style2');
    }

    public function style3()
    {
        return view('transaction.style3');
    }
}
