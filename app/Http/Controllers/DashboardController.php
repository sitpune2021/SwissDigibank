<?php

namespace App\Http\Controllers;
use App\Services\DashboardService;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index1()
    {
        $dashboardData = DashboardService::getDashboardData();

        return view('dashboard.dashboard', compact('dashboardData'));
    }
}
