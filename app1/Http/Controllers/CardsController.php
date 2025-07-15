<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CardsController extends Controller
{
    public function overview()
    {
        return view('cards.overview');
    }

    public function details()
    {
        return view('cards.details');
    }
}
