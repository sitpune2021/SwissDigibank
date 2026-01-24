<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\CollectionCenter;
use App\Models\Group;
use App\Models\GroupComment;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class GroupController extends Controller
{

    public function index()
    {
        $groups = Group::with([
            'collectionCenter:id,center_name',
            'groupHead:id,member_info_first_name'
        ])
            ->withCount('members') // 🔑 MEMBER COUNT
            ->orderBy('created_at', 'desc')
            ->get();
            

        return view('groups.index', compact('groups'));
    }


    public function getBranches($centerId)
{
    $center = CollectionCenter::with('branch')->find($centerId);

    if (!$center || !$center->branch) {
        return response()->json([]);
    }

    return response()->json([
        [
            'branch_id'   => $center->branch_id,
            'branch_name' => $center->branch->branch_name,
        ]
    ]);
}
    // public function getBranches($centerId)
    // {
    //     Log::info('Center ID: ' . $centerId);
    //     $branches = CollectionCenter::where('id', $centerId)->get();

    //     Log::info('Branches: ' . $branches->toJson());
    //     Log::info('branches ID: ' . $branches);
    //     return response()->json($branches);
    // }



    public function create()
    {
        $isEdit = false;
        $collectionCenters = CollectionCenter::all();
        $branches = Branch::all();
        $members = Member::all();
        return view('groups.create', compact('isEdit', 'collectionCenters', 'branches', 'members'));
    }





    public function store(Request $request)
    {
        // dd($request->all());
        // Log incoming request data
        Log::info('Storing new group', [
            'request' => $request->all()
        ]);

        // Validation
        $request->validate([
            // Nullable fields
            'collection_center_id' => 'nullable|exists:collection_centers,id',
            'branch_id' => 'nullable|exists:branches,id',
            'group_cashier_member_id' => 'nullable|exists:members,id',

            // Required fields
            'open_date' => 'required|date',
            'group_name' => 'required|string|max:255',
            'group_no' => 'required|string|unique:groups,group_no',
            'group_head_member_id' => 'required|exists:members,id',
            'group_member_ids' => 'required|array|min:1',
            'group_member_ids.*' => 'distinct|exists:members,id',
            'is_active' => 'required|boolean',
        ]);

        // Create group
        $group = Group::create([
            'collection_center_id' => $request->collection_center_id,
            'branch_id' => $request->branch_id,
            'open_date' => Carbon::createFromFormat('d-m-Y', $request->open_date)->format('Y-m-d'),
            'group_name' => $request->group_name,
            'group_no' => $request->group_no,
            'group_head_member_id' => $request->group_head_member_id,
            'group_cashier_member_id' => $request->group_cashier_member_id,
            'is_active' => $request->is_active,
        ]);

        // Log group creation
        Log::info('Group created successfully', [
            'group_id' => $group->id
        ]);

        // Attach multiple members
        $group->members()->sync($request->group_member_ids);

        // Log attached members
        Log::info('Group members attached', [
            'group_id' => $group->id,
            'member_ids' => $request->group_member_ids
        ]);

        return redirect()
            ->route('groups.index')
            ->with('success', 'Group created successfully');
    }



    public function show($encodedId)
    {
        $id = base64_decode($encodedId);
        // Fetch the group by ID with related data
        $group = Group::with([
            'collectionCenter:id,center_name',
            'groupHead:id,member_info_first_name',
            'cashier:id,member_info_first_name',
            'members:id,member_no,member_info_first_name,general_enrollment_date,member_info_mobile_no,general_branch',
            'members.branch:id,branch_name' // 🔑 REQUIRED
        ])->findOrFail($id); // fetch the specific group or fail if not found
        $comments = GroupComment::with('user')
        ->where('group_id', $id)
        ->latest()
        ->get();


        return view('groups.show', compact('group','comments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encodedId)
    {
        $id = base64_decode($encodedId);
        $group = Group::with(relations: 'members')->findOrFail($id);

        return view('groups.create', [
            'isEdit' => true,
            'group' => $group,
            'collectionCenters' => CollectionCenter::all(),
            'branches' => Branch::all(),
            'members' => Member::all(),
            'selectedMemberIds' => old(
                'group_member_ids',
                $group->members->pluck('id')->toArray()
            ),
        ]);


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encodedId)
    {
        $id = base64_decode($encodedId);
        $group = Group::findOrFail($id);

        $request->validate([
            'collection_center_id' => 'nullable|exists:collection_centers,id',
            'branch_id' => 'nullable|exists:branches,id',
            'group_cashier_member_id' => 'nullable|exists:members,id',

            'open_date' => 'required|date_format:d-m-Y',
            'group_name' => 'required|string|max:255',
            'group_no' => 'required|string|unique:groups,group_no,' . $group->id,
            'group_head_member_id' => 'required|exists:members,id',

            'group_member_ids' => 'required|array|min:1',
            'group_member_ids.*' => 'distinct|exists:members,id',

            'is_active' => 'required|boolean',
        ]);

        $group->update([
            'collection_center_id' => $request->collection_center_id,
            'branch_id' => $request->branch_id,
            'open_date' => Carbon::createFromFormat('d-m-Y', $request->open_date)->format('Y-m-d'),
            'group_name' => $request->group_name,
            'group_no' => $request->group_no,
            'group_head_member_id' => $request->group_head_member_id,
            'group_cashier_member_id' => $request->group_cashier_member_id,
            'is_active' => $request->is_active,
        ]);

        $group->members()->sync($request->group_member_ids);

        return redirect()
            ->route('groups.index')
            ->with('success', 'Group updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
