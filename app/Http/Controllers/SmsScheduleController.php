<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsScheduleController extends Controller
{
   public function sms_index()
    {
        return view("schedule-sms.index");
    }
}
