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
    public function index(Request $request)
    {
        $query = Director::with('member');

        if ($request->has('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('designation', 'like', "%$search%")
                    ->orWhere('director_name', 'like', "%$search%")
                    ->orWhere('din_no', 'like', "%$search%")
                    ->orWhere('authorized_signatory', 'like', "%$search%");

                // Attempt to parse search as date (d/m/Y)
                try {
                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
                    $q->orWhereDate('appointment_date', $date)
                        ->orWhereDate('resignation_date', $date);
                } catch (\Exception $e) {
                    // Ignore if not a valid date
                }
            })
                ->orWhereHas('member', function ($q) use ($search) {
                    $q->where('id', 'like', "%$search%");
                });
        }

        $directors = $query->orderBy('created_at', 'desc')->paginate(10);
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
            'appointment_date' => 'required',
            'resignation_date' => 'nullable|after_or_equal:appointment_date',
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
        return view('company.director.create', compact('director', 'show', 'route', 'method', 'formFields', 'dynamicOptions'));
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
            'appointment_date' => 'required',
            'resignation_date' => 'nullable|after_or_equal:appointment_date',
            'signature' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',  // file validation with allowed types and max size
            'authorized_signatory' => 'required|in:Yes,No',
        ]);

        if ($request->hasFile('signature')) {
            $data['signature'] = $request->file('signature')->store('signatures', 'public');
        } else {
            $data['signature'] = $director->signature;
        }

        $director->update($data);

        return redirect()->route('director.index')->with('success', 'Director updated successfully.');
    }


    public function destroy(string $id)
    {
        //
    }
}
