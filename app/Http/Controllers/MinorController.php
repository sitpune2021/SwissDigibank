<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Minor;
use App\Models\Member;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MinorController extends Controller
{
   

    public function index(Request $request)
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('minor.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

        try {

            $search = $request->search;

            $minors = Minor::with(['member.branch'])

                ->when($search, function ($query) use ($search) {

                    $query->where('first_name', 'LIKE', "%{$search}%")

                        ->orWhereHas('member', function ($q) use ($search) {

                            $q->where('member_info_first_name', 'LIKE', "%{$search}%")
                            ->orWhere('member_no', 'LIKE', "%{$search}%");

                        })

                        ->orWhereHas('member.branch', function ($q) use ($search) {

                            $q->where('branch_name', 'LIKE', "%{$search}%");

                        });

                })

                ->latest()

                ->paginate(20)

                ->withQueryString();

            return view('members.minor.index', compact('minors'));

        } catch (\Exception $e) {

            abort(404);

        }
    }

    public function create(Request $request)
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('minor.index', $permissions)) {

            abort(403, 'Permission Denied');

        }

        try {
            // $memberId = $request->member_id ?? session('member_id');
            // $memberId = $request->member_id ?? session('member_id');
            $type = $request->type ?? session('type');

            // if (!$memberId || !Member::find($memberId)) {
            //     return redirect()->back()->with('error', 'Invalid Member ID');
            // }

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

            Log::info('Minor Store Request Received', [
                'type' => $type,
                'payload' => $request->all()
            ]);

            $validator = Validator::make(
                $request->all(),
                [
                    'enrollment_date' => 'required|date|before_or_equal:today',
                    'title'           => 'required|in:md,mr,ms,mrs',
                    'gender'          => 'required|in:male,female,other',
                    'first_name'      => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                    'last_name'       => 'nullable|string|max:255|regex:/^[A-Za-z]+$/',
                    'dob'             => 'required|date|before_or_equal:today',
                    'father_name'     => 'required|string|max:255|regex:/^[A-Za-z]+$/',
                    'aadhaar_no'      => 'nullable|digits:12|regex:/^[2-9]{1}[0-9]{11}$/',
                    'address'         => 'required|string|max:500',
                    'member_id'       => $type === 'member' ? 'required|exists:members,id' : 'nullable',
                    'promotor_id'     => $type === 'promotor' ? 'required|exists:promotors,id' : 'nullable',
                ]
            );

            if ($validator->fails()) {
                Log::warning('Minor Store Validation Failed', [
                    'errors' => $validator->errors()->toArray()
                ]);
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $validator->validated();

            // ✅ Set member_id/promotor_id correctly
            $data['member_id'] = $type === 'member' ? $request->member_id : null;
            $data['promotor_id'] = $type === 'promotor' ? $request->promotor_id : null;

            // ✅ Format dates
            $data['enrollment_date'] = date('Y-m-d', strtotime($data['enrollment_date']));
            $data['dob'] = date('Y-m-d', strtotime($data['dob']));

            // ✅ Save to DB
            $minor = Minor::create($data);

            Log::info('Minor Created Successfully', [
                'minor_id' => $minor->id,
                'data' => $data
            ]);

            // ✅ Redirect based on type
            if ($type === 'member') {
                return redirect()->route('member.show', $data['member_id'])
                    ->with('success', 'Minor created successfully.');
            } elseif ($type === 'promotor') {
                return redirect()->route('promotor.show', base64_encode($data['promotor_id']))
                    ->with('success', 'Minor created successfully.');
            } else {
                return redirect()->back()->with('success', 'Minor created successfully.');
            }
        } catch (\Exception $e) {
            Log::error('Minor Store Failed', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Failed to save minor: ' . $e->getMessage());
        }
    }
    
    // {{-- 18-09-22 changes  --}}
    public function show(string $id)
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('minor.show', $permissions)) {

            abort(403, 'Permission Denied');

        }

        try {
            $sections = config('minor_form');
            $minor = Minor::findOrFail($id);
            $route = "";
            $method = 'POST';
            $method = 'PUT';
            $show = true;
            $type = 'edit';
            $dynamicOptions = [
                'member' => Member::pluck('member_info_first_name', 'id')
            ];
            return view('members.minor.create', compact('sections', 'type', 'minor', 'method', 'show'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }
    public function edit(string $id)
    {
        $user = auth()->user();

        $permissions = $user->rolePermission->permissions ?? [];

        if ($user->role_id != 1 && !in_array('minor.edit', $permissions)) {

            abort(403, 'Permission Denied');

        }

        $method = 'PUT';
        $minor = Minor::findOrFail($id);
        $sections = config('minor_form');
        $route = route('minor.update', $id);

        // detect type
        $type = null;
        $memberId = null;
        $promotorId = null;

        if (!empty($minor->member_id)) {
            $type = 'member';
            $memberId = $minor->member_id;
        } elseif (!empty($minor->promotor_id)) {
            $promotorId = $minor->promotor_id;
            $type = 'promotor';
        }

        // Debug check
        // dd($type, $memberId);

        return view('members.minor.create', compact('sections', 'minor', 'route', 'type', 'method', 'memberId', 'promotorId'));
    }

    public function update(Request $request, string $id)
    {

        $type = $request->type;

        Log::info('Minor Update Request Received', [
            'minor_id' => $id,
            'type' => $type,
            'payload' => $request->all()
        ]);

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
            'member_id'       => 'nullable|exists:members,id',
            'promotor_id'     => 'nullable|exists:promotors,id',
        ]);

        if (empty($data['member_id']) && empty($data['promotor_id'])) {
            Log::warning('Minor Update Validation Failed - Missing Relation', [
                'minor_id' => $id,
                'data' => $data
            ]);
            return back()->withErrors(['relation' => 'Either member_id or promotor_id is required.']);
        }

        try {
            // ✅ Format dates
            $data['dob'] = date('Y-m-d', strtotime($data['dob']));
            $data['enrollment_date'] = date('Y-m-d', strtotime($data['enrollment_date']));

            // ✅ Find and update minor
            $minor = Minor::findOrFail($id);
            $minor->update($data);

            Log::info('Minor Updated Successfully', [
                'minor_id' => $minor->id,
                'updated_data' => $data
            ]);

            if (isset($data['member_id']) && $data['member_id']) {
                return redirect()->route('member.show', $data['member_id'])
                    ->with('success', 'Minor updated successfully.');
            } elseif (isset($data['promotor_id']) && $data['promotor_id']) {
                return redirect()->route('promotor.show', base64_encode($data['promotor_id']))
                    ->with('success', 'Minor updated successfully.');
            }

            return redirect()->back()->with('success', 'Minor updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Minor Update Failed - Not Found', [
                'minor_id' => $id,
                'error_message' => $e->getMessage()
            ]);
            abort(404);
        } catch (\Exception $e) {
            Log::error('Minor Update Failed - Exception', [
                'minor_id' => $id,
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'payload' => $request->all()
            ]);
            return redirect()->back()->with('error', 'Failed to update minor: ' . $e->getMessage());
        }
    }

    public function destroy(string $id) {}


}
