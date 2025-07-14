<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;

class StateController extends Controller
{
    public function create()
    {
        $states = State::all();
        return view('company-profile.create-profile', compact('states'));
    }
    public function getStates()
    {
        return response()->json(State::all());
    }
}
