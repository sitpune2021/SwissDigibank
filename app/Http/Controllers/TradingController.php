<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TradingController extends Controller
{
    public function style1()
    {
        return view('trading.style1');
    }

    public function style2()
    {
        return view('trading.style2');
    }

    public function style3()
    {
        return view('trading.style3');
    }
}
