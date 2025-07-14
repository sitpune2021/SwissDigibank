<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function overview()
    {
        return view('payment.overview');
    }

    public function providers()
    {
        return view('payment.providers');
    }

    public function exchange()
    {
        return view('payment.exchange');
    }

    public function makePayment()
    {
        return view('payment.make-payment');
    }
}
