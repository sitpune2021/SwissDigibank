<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;


class Form15Gor15HController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('form-15g-15h.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::all();
        // return view('form-15g-15h.create');
      return view('form-15g-15h.create', compact('members'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
        return view('form-15g-15h.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('form-15g-15h.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
