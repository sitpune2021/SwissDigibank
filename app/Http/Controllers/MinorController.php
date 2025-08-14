<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Minor;
use App\Models\Member;
use Illuminate\Support\Facades\Validator;

class MinorController extends Controller
{
    public function index()
    {
        try {
            $minors = Minor::latest()->get();
            return view('members.minor.index', compact('minors'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function create(Request $request)
    {
        try {
            $memberId = $request->member_id ?? session('member_id');
            $type = $request->type ?? session('type');

            if (!$memberId || !Member::find($memberId)) {
                return redirect()->back()->with('error', 'Invalid Member ID');
            }

            $sections = config('minor_form');
            $minor = null;
            $route = route('minor.store');
            $method = 'POST';
            $dynamicOptions = [

                'member' => Member::pluck('member_info_first_name', 'id')
            ];

            return view('members.minor.create', compact('sections', 'minor', 'route', 'method', 'dynamicOptions', 'type'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }

    public function store(Request $request)
    {
        try {
            $type = $request->type;


            $validator = Validator::make(
                $request->all(),
                [
                    'enrollment_date'   => 'required|date|before_or_equal:today',
                    'title'             => 'required|in:md,mr,ms,mrs',
                    'gender'            => 'required|in:male,female,other',
                    'first_name'        => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                    'last_name'         => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                    'dob'               => 'required|date|before_or_equal:today',
                    'father_name'       => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                    'aadhaar_no'        => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                    'address'           => 'required|string|max:500',
                    'member_id'          => $type === 'member' ? 'required|exists:members,id' : 'nullable',
                    'promotor_id'       => $type === 'promoter' ? 'required|exists:promotors,id' : 'nullable',
                ]
            );



            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $data = $validator->validated();

            // Fix key name to match DB column exactly:
            $validated['member_id'] = $type === 'member' ? $request->member_id : null;
            $validated['promotor_id'] = $type === 'promoter' ? $request->promotor_id : null;

            // Set null for the irrelevant ID
            if ($type === 'member') {
            } else {
                $data['member_id'] = null;
            }

            $data['enrollment_date'] = date('Y-m-d', strtotime($data['enrollment_date']));
            $data['dob'] = date('Y-m-d', strtotime($data['dob']));

            Minor::create($data);

            // Redirect based on type
            if ($type === 'member') {
                $type = null;
                $memberId = $data['member_id'] ?? session('member_id') ?? $request->member_id;
                return redirect()->route('member.show', $memberId)->with('success', 'Minor created successfully.');
            } else {
                $type = null;
                return redirect()->route('promotor.show', base64_encode($data['promotor_id']))
                    ->with('success', 'Minor created successfully.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }
    public function show(string $id)
    {
        try {
            $sections = config('minor_form');
            $minor = Minor::findOrFail($id);
            $route = "";
            $method = 'POST';
            $type = 'edit';
            $dynamicOptions = [
                'member' => Member::pluck('member_info_first_name', 'id')
            ];
            return view('members.minor.create', compact('sections', 'type', 'minor'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } 
    }
    public function edit(string $id)
{
    $method = 'PUT';
    $minor = Minor::findOrFail($id);
    $sections = config('minor_form');
    $route = route('minor.update', $id);
    $type = 'edit';
    // Assuming $minor has a relationship or column 'member_id'
    $memberId = $minor->member_id;

    return view('members.minor.create', compact('sections', 'minor', 'route', 'type', 'method', 'memberId'));
}


    public function update(Request $request, string $id)
    {
        // dd($request);
            $type = $request->type;

        $data = $request->validate([
            'enrollment_date' => 'required|date|before_or_equal:today',
            'title'           => 'required|in:md,mr,ms,mrs',
            'gender'          => 'required|in:male,female,other',
            'first_name'      => 'required|string|max:255|regex:/^[A-Za-z]+$/',
            'last_name'       => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
            'dob'             => 'required|date|before_or_equal:today',
            'father_name'     => 'required|string|max:255|regex:/^[A-Za-z]+$/',
            'aadhaar_no'      => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
            'address'         => 'required|string|max:500',
        ]);
        // Format dates
        $data['dob'] = date('Y-m-d', strtotime($data['dob']));
        $data['enrollment_date'] = date('Y-m-d', strtotime($data['enrollment_date']));
        // Find the minor
        $minor = Minor::findOrFail($id);
        // Update minor
        $minor->update($data);
        $minors = Minor::latest()->get();
        return view('members.minor.index', compact('minors'));

    }
    public function destroy(string $id) {}
}
