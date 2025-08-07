<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\Minor;
use App\Models\Member;

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
        $data = $request->validate([
            'type' => 'required|in:member,promoter',
            'enrollment_date' => 'required|date|before_or_equal:today',
            'title' => 'required|in:md,mr,ms,mrs',
            'gender' => 'required|in:male,female,other',
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'dob' => 'required|date|before_or_equal:today',
            'father_name' => 'required|string|max:255',
            'aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
            'address' => 'required|string|max:500',
        ]);

        // Assign member_id or promotors_id based on type
        if ($data['type'] === 'member') {
            $data['member_id'] = $data['id'];
            $data['promotor_id'] = null; // or unset($data['promotors_id']);
        } else {
            $data['promotor_id'] = $data['id'];
            $data['member_id'] = null;  // or unset($data['member_id']);
        }
        // Format the dates to Y-m-d for database
        $data['enrollment_date'] = date('Y-m-d', strtotime($data['enrollment_date']));
        $data['dob'] = date('Y-m-d', strtotime($data['dob']));

        // Create the Minor record
        Minor::create($data);

        unset($data['id']); // Remove 'id' key since you mapped it


        // Redirect to the appropriate member or promoter show page based on type
        if ($data['type'] === 'member') {
            return redirect()->route('member.show', $data['member_id'])
                ->with('success', 'Minor created successfully.');
        } else {
            return redirect()->route('promoter.show', $data['promotors_id'])
                ->with('success', 'Minor created successfully.');
        }
    }

    public function show(string $id)
    {
        {
         $sections = config('minor_form');
         $minor = Minor::findOrFail($id);
        $route ="";
        $method = 'POST';
        $dynamicOptions = [
            'member' =>Member::pluck('member_info_first_name', 'id')
        ];
        return view('members.minor.create', compact('sections', 'minor'));
    }
    }
    public function edit(string $id)
    {
        {
        $method = 'PUT';
        $minor = Minor::findOrFail($id);
        $sections = config('minor_form');
        $route = route('minor.update', $id) ;
        return view('members.minor.create', compact('sections', 'minor', 'route', 'method'));
    }
    }
    public function update(Request $request, string $id)
{
    $data = $request->validate([
        'enrollment_date' => 'required|date|before_or_equal:today',
        'title' => 'required|in:md,mr,ms,mrs',
        'gender' => 'required|in:male,female,other',
        'first_name' => 'required|string|max:255',
        'last_name' => 'nullable|string|max:255',
        'dob' => 'required|date|before_or_equal:today',
        'father_name' => 'required|string|max:255',
        'aadhaar_no' => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
        'address' => 'required|string|max:500',
        'member_id' => 'nullable|exists:members,id',
        'promoter_id' => 'nullable|exists:promotors,id',
    ]);
    if (!$data['member_id'] && !$data['promoter_id']) {
    return back()->withErrors(['relation' => 'Either member_id or promoter_id is required.']);
}
    // Format dates
    $data['dob'] = date('d-m-Y', strtotime($data['dob']));
    $data['enrollment_date'] = date('d-m-Y', strtotime($data['enrollment_date']));

    // Find the minor
    $minor = Minor::findOrFail($id);

    // Update minor
    $minor->update($data);

        if ($data['member_id']) {
    return redirect()->route('member.show', $data['member_id'])->with('success', 'Minor created successfully.');
} elseif ($data['promoter_id']) {
    return redirect()->route('promoter.show', $data['promoter_id'])->with('success', 'Minor created successfully.');
}

}
    public function destroy(string $id)
    {
        
    }
}
