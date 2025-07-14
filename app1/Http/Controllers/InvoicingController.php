<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InvoicingController extends Controller
{
    public function addInvoicing()
    {
        return view('invoicing.add-invoice');
    }

    public function style1()
    {
        return view('invoicing.style1');
    }

    public function style2()
    {
        return view('invoicing.style2');
    }
}
