<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Director;


class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directors = Director::with('member')->get();
        return view("director.index", compact('directors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dynamicOptions = [
            'member' =>  Member::pluck('member_info_first_name', 'id')
        ];
        $formFields = config('director_form');
        $branch = null;
        $route = route('director.store');
        $method = 'POST';
        return view('director.create', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validate the request and get the validated data
    $data = $request->validate([
        'designation' => 'required|string|max:255',
        'member_id' => 'required|string|max:255',
        'director_name' => 'required|string|max:255',
        'din_no' => 'required|string|max:50',
        'appointment_date' => 'required|date',
        'resignation_date' => 'required|date|after_or_equal:appointment_date',
        'signature' => 'required',  // add file validation
        'authorized_signatory' => 'required|in:Yes,No',
    ]);

    // Handle file upload for signature
    if ($request->hasFile('signature')) {
        $data['signature'] = $request->file('signature')->store('signatures', 'public');
    }
    if ($request->filled('appointment_date')) {
            $data['appointment_date'] = date('Y-m-d', strtotime($request->input('appointment_date')));
        }
        if ($request->filled('resignation_date')) {
            $data['resignation_date'] = date('Y-m-d', strtotime($request->input('resignation_date')));
        }

    // Create the Director record
    Director::create($data);

    // Redirect with success message
    return redirect()->route('director.index')->with('success', 'Director created successfully.');
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
        $dynamicOptions = [
            'member' =>  Member::pluck('member_info_first_name', 'id')
        ];
        $formFields = config('director_form');
        $director = Director::findOrFail($id);
        $route = route('director.update', $id) ;
        $method = 'PUT';
        return view('director.create', compact('formFields', 'director', 'route', 'method', 'dynamicOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    // Find the Director record by id
    $director = Director::findOrFail($id);

    // Validate the request
    $data = $request->validate([
        'designation' => 'required|string|max:255',
        'member_id' => 'required|string|max:255',
        'director_name' => 'required|string|max:255',
        'din_no' => 'required|string|max:50',
        'appointment_date' => 'required|date',
        'resignation_date' => 'required|date|after_or_equal:appointment_date',
        'signature' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',  // file validation with allowed types and max size
        'authorized_signatory' => 'required|in:Yes,No',
    ]);

    // Handle file upload for signature if provided
    if ($request->hasFile('signature')) {
        // Optionally delete old signature file here if needed
        // Storage::disk('public')->delete($director->signature);

        $data['signature'] = $request->file('signature')->store('signatures', 'public');
    } else {
        // Keep the existing signature path if no new file is uploaded
        $data['signature'] = $director->signature;
    }

    // Format dates
    if ($request->filled('appointment_date')) {
        $data['appointment_date'] = date('Y-m-d', strtotime($request->input('appointment_date')));
    }
    if ($request->filled('resignation_date')) {
        $data['resignation_date'] = date('Y-m-d', strtotime($request->input('resignation_date')));
    }

    // Update the Director record
    $director->update($data);

    // Redirect with success message
    return redirect()->route('director.index')->with('success', 'Director updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
