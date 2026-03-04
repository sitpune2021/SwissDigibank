<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgriculturController extends Controller
{


    public function index()
    {
        return view("agricultural_loan.schemes.index");
    }

    
}
