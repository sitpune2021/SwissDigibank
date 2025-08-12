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
        $minors = Minor::latest()->get();
        return view('members.minor.index', compact('minors'));
    }

    public function create(Request $request)
    {
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
    }

    public function store(Request $request)
    {
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
    }
    public function show(string $id)
    {
        $sections = config('minor_form');
        $minor = Minor::findOrFail($id);
        $route = "";
        $method = 'POST';
        $type = 'edit';
        $dynamicOptions = [
            'member' => Member::pluck('member_info_first_name', 'id')
        ];
        return view('members.minor.create', compact('sections', 'type', 'minor'));
    }
    public function edit(string $id)
    { {
            $method = 'PUT';
            $minor = Minor::findOrFail($id);
            $sections = config('minor_form');
            $route = route('minor.update', $id);
            $type = 'edit';

            return view('members.minor.create', compact('sections', 'minor', 'route', 'type', 'method'));
        }
    }
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'enrollment_date' => 'required|date|before_or_equal:today',
            'title' => 'required|in:md,mr,ms,mrs',
            'gender' => 'required|in:male,female,other',
            'first_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
            'last_name' => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
            'dob' => 'required|date|before_or_equal:today',
            'father_name' => 'required|string|max:255|regex:/^[A-Za-z]+$/',
            'aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
            'address' => 'required|string|max:500',
            'member_id' => 'required_if:type,member|nullable|exists:members,id',
            'promotor_id' => 'required_if:type,promoter|nullable|exists:promotors,id',

        ]);
        if (!($data['member_id'] ?? null) && !($data['promotor_id'] ?? null)) {
            return back()->withErrors(['relation' => 'Either member_id or promotor_id is required.']);
        }
        // Format dates
        $data['dob'] = date('D M d Y', strtotime($data['dob']));
        $data['enrollment_date'] = date('D M d Y', strtotime($data['enrollment_date']));

        // Find the minor
        $minor = Minor::findOrFail($id);

        // Update minor
        $minor->update($data);

        if ($data['member_id']) {
            return redirect()->route('member.show', $data['member_id'])->with('success', 'Minor created successfully.');
        } elseif ($data['promotor_id']) {
            return redirect()->route('promoter.show', $data['promotor_id'])->with('success', 'Minor created successfully.');
        }
    }
    public function destroy(string $id) {}
}
