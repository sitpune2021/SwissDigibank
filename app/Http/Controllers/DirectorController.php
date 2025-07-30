<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Director;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $directors = Director::with('member')->get();
        return view('company.director.index', compact('directors'));
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
        return view('company.director.create', compact('formFields', 'branch', 'route', 'method', 'dynamicOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'designation' => 'nullable|string|max:255',
            'member_id' => 'nullable|string|max:255',
            'director_name' => 'required|string|max:255',
            'din_no' => 'required|string|max:50',
            'appointment_date' => 'required|date',
            'resignation_date' => 'nullable|date|after_or_equal:appointment_date',
            'signature' => 'nullable',  // add file validation
            'authorized_signatory' => 'required|in:Yes,No',
        ]);

        if ($request->hasFile('signature')) {
            $data['signature'] = $request->file('signature')->store('signatures', 'public');
        }

        Director::create($data);

        return redirect()->route('director.index')->with('success', 'Director created successfully.');
    }


    public function show(string $id)
    {
        $decryptedId = base64_decode($id);
        $director = Director::findOrFail($decryptedId);
        // Format the appointment_date only if it exists
        if ($director->appointment_date) {
            $director->appointment_date = Carbon::parse($director->appointment_date)->format('D M d Y');
        }

        $dynamicOptions = [
            'member' =>  Member::pluck('member_info_first_name', 'id')
        ];
        $route = '';
        $formFields = config('director_form');
        $method = 'GET';
        $show = true;
        return view('company.director.create', compact('director', 'show', 'route', 'method', 'formFields','dynamicOptions'));
    }

  
    public function edit(string $id)
    {
        $dynamicOptions = [
            'member' =>  Member::pluck('member_info_first_name', 'id')
        ];
        $decryptedId = base64_decode($id);
        $formFields = config('director_form');
        $director = Director::findOrFail($decryptedId);

        $route = route('director.update', $id);
        $method = 'PUT';
        return view('company.director.create', compact('formFields', 'director', 'route', 'method', 'dynamicOptions'));
    }

   
    public function update(Request $request, $id)
    {
        // Find the Director record by id
        $decryptedId = base64_decode($id);
        $director = Director::findOrFail($decryptedId);

        // Validate the request
        $data = $request->validate([
            'designation' => 'nullable|string|max:255',
            'member_id' => 'nullable|string|max:255',
            'director_name' => 'required|string|max:255',
            'din_no' => 'required|string|max:8',
            'appointment_date' => 'required|date',
            'resignation_date' => 'nullable|date|after_or_equal:appointment_date',
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

        $director->update($data);

        return redirect()->route('director.index')->with('success', 'Director updated successfully.');
    }

    
    public function destroy(string $id)
    {
        //
    }
}
