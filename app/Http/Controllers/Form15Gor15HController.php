<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Form15Gor15HController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('Form 15G and 15H.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Form 15G and 15H.create');
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
        return view('Form 15G and 15H.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('Form 15G and 15H.edit');
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
