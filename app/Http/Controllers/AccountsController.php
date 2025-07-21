<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountsController extends Controller
{
    

    public function bankAccount()
    {
        return view('accounts.bank-account');

    }    
    public function accountOverview()
    {
        return view('accounts.account-overview');
    }

    public function accountDetails()
    {
        return view('accounts.account-details');
    }

    public function depositDetail()
    {
        return view('accounts.deposit-detail');
    }
}
