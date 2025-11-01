<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PersonalAccountController extends Controller
{
     public function index(Request $request)
    {
            return view(view: 'personal.account.index');
    }
}
