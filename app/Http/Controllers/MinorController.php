<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Minor;
use App\Models\Member;


class MinorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $minors = Minor::all();
        return view('members.minor.index', compact('minors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = config('minor_form');
         $minor = null;
        $route = route('minor.store');
        $method = 'POST';
        $dynamicOptions = [
            'member' =>Member::pluck('member_info_first_name', 'id')
        ];
        return view('members.minor.create', compact('sections', 'minor', 'route', 'method', 'dynamicOptions'));
       // return view('member.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
    $data = $request->validate([
    'member_id' => 'required',
        'enrollment_date' => 'required',
        'title' => 'required|in:md,mr,ms,mrs',
        'gender' => 'required|in:male,female,other',
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'dob' => 'required',
        'father_name' => 'required|string|max:255',
        'aadhaar_no' => 'nullable|string|max:20',
        'address' => 'required|string|max:500',
    ]);


    // Format the date fields if necessary
    $data['enrollment_date'] = date('Y-m-d', strtotime($data['enrollment_date']));
    $data['dob'] = date('Y-m-d', strtotime($data['dob']));

    // Store the student or form data
    Minor::create($data); // Replace with your actual model

    // Redirect with success message
    return redirect()->route('minor.index') // change route as per your routes
                     ->with('success', 'Minor created successfully.');


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        {
      
         $minors = Member::with('address')->findOrFail($id);
         $minor = array_merge(
             $minors->toArray(),
             $minors->address?->toArray() ?? [],
        );

        $sections = config('minor_form');
        $show = true;
        // $button=true;
        return view('members.minor.create', compact('sections', 'minor', 'show'));
    }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        {
        
        $method = 'PUT';
        $memberModel = Member::with('address')->findOrFail($id);
        $minor = array_merge(
             $memberModel->toArray(),
            $memberModel->address?->toArray() ?? [],

        );

        $sections = config('minor_form');
        $route = route('minor.update', $id) ;
        return view('members.minor.create', compact('sections', 'minor', 'route', 'method'));
    }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{
    $data = $request->validate([
            'member_id' => 'required',
        'enrollment_date' => 'required|date',
        'title' => 'required|in:md,mr,ms,mrs',
        'gender' => 'required|in:male,female,other',
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'dob' => 'required|date',
        'father_name' => 'required|string|max:255',
        'aadhaar_no' => 'nullable|string|max:20',
        'address' => 'required|string|max:500',
    ]);

    // Format dates
    $data['dob'] = date('Y-m-d', strtotime($data['dob']));
    $data['enrollment_date'] = date('Y-m-d', strtotime($data['enrollment_date']));

    // Find the minor
    $minor = Minor::findOrFail($id);

    // Update minor
    $minor->update($data);

    return redirect()->route('minor.index')
        ->with('success', 'Minor updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
}
