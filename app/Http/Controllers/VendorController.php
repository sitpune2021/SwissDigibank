<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    //
     public function vendor_index()
    {
        return view("menu-accounts.vendors.index");

    }
     public function add_vendor()
    {
        return view("menu-accounts.vendors.add-vendor");

    }
     public function vendor_view()
    {
        return view("menu-accounts.vendors.view");

    }
     public function libality_ledger()
    {
        return view("menu-accounts.vendors.libality-ledger");

    }
     public function edit_ledger()
    {
        return view("menu-accounts.vendors.edit-ledger");

    }
    
}
