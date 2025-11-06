<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VehicalAccountController extends Controller
{
    public function index(Request $request)
    {      
            return view('vehical.account.index');
    }
}
