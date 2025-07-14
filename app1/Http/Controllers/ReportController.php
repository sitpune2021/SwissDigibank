<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function style1()
    {
        return view('reports.style1');
    }

    public function style2()
    {
        return view('reports.style2');
    }
}
