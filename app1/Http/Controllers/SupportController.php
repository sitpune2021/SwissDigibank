<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function helpCenter()
    {
        return view('support.help-center');
    }

    public function privacyPolicy()
    {
        return view('support.privacy-policy');
    }

    public function contactUs()
    {
        return view('support.contact-us');
    }
}
