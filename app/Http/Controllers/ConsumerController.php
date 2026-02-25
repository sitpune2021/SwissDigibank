<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsumerController extends Controller
{
    
    public function index()
    {
        return view("consumer_loan.schemes.index");
    }

}
