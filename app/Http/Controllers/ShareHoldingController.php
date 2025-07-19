<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShareHoldingController extends Controller
{
    public function index()
    {
        // $share_holdings = ShareHolding::orderBy('created_at', 'desc')->paginate(10);

        return view('share-holdings.manage-shareholding');
    }
    public function create()
    {
         $shareholding = null;
        $formFields = config('share_form');
        $route = route('add.shareholding');
        $method = 'POST';
        return view('share-holdings.add-shares',compact('formFields','shareholding', 'route', 'method'));
    }
}
