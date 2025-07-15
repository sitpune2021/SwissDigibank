<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Promotor;
use Illuminate\Http\Request;

class HRController extends Controller
{
     public function index()
     {
          return view('employees.manage-employee');
     }
     public function create()
     {
          $promoters = Promotor::all();
          $members = Member::all();
          return view('employees.add-employee');
     }
     
    
}
