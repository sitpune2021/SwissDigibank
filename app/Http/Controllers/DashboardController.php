<?php

namespace App\Http\Controllers;
use App\Models\Branch;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return redirect()->route('index1');
    }

    public function index1()
    {
        $branchCount = Branch::count();

        // $branchCount = Branch::where('active', 'Yes')->count();

        
        return view('dashboard.dashboard', compact('branchCount'));
    }
}
