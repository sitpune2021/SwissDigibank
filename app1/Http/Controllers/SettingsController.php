<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function profile()
    {
        return view('settings.profile');
    }

    public function security()
    {
        return view('settings.security');
    }

    public function socialNetwork()
    {
        return view('settings.social-network');
    }

    public function notification()
    {
        return view('settings.notification');
    }

    public function paymentLimit()
    {
        return view('settings.payment-limit');
    }
}
