<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivateTransferController extends Controller
{
    public function addContact()
    {
        return view('transfer.add-contact');
    }

    public function overview()
    {
        return view('transfer.overview');
    }

    public function makeTransfer()
    {
        return view('transfer.make-transfer');
    }

    public function chat()
    {
        return view('transfer.chat');
    }
}
