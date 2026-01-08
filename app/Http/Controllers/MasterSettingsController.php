<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $settings = [
        ['id' => 1, 'name' => 'Site Name', 'value' => 'My Website'],
        ['id' => 2, 'name' => 'Timezone', 'value' => 'Asia/Kolkata'],
        ['id' => 3, 'name' => 'Currency', 'value' => 'INR'],
    ];
       return view('master-settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
