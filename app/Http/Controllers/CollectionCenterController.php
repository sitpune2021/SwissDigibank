<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\CollectionCenter;
use App\Models\Employee;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CollectionCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collectionCenters = CollectionCenter::with([
        'branch',
        'centerHeadMember',
        'centerHeadEmployee',
        'centerCashierMember',
        'centerCashierEmployee'
    ])->get();
       return view('collection-centers.index',compact('collectionCenters'));
    }   

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('collection-centers.create', [
            'branches'  => Branch::all(),      // Branch dropdown
            'members'   => Member::all(),      // Members dropdown
            'employees' => Employee::all(),    // Employees dropdown
            'current_head' => null,            // No pre-selected value on create
            'current_cashier' => null,         // No pre-selected value on create
        ]);
    }

    public function store(Request $request)
 {
        // Validate the request
        $validated = $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'center_no' => 'required|string|max:50',
            'center_name' => 'required|string|max:255',

            'center_head' => 'nullable|string',
            'center_cashier' => 'nullable|string',

            'collection_day' => 'nullable|string',
            'collection_time' => 'nullable|string',

            'is_active' => 'required|boolean',

            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',

            'group_id' => 'nullable|integer',
            'address' => 'nullable|string',
        ]);

        // Parse Center Head selection
        $center_head_member_id = null;
        $center_head_employee_id = null;
        if (!empty($validated['center_head'])) {
            [$type, $id] = explode('_', $validated['center_head']);
            if ($type === 'member') $center_head_member_id = $id;
            elseif ($type === 'employee') $center_head_employee_id = $id;
        }

        // Parse Center Cashier selection
        $center_cashier_member_id = null;
        $center_cashier_employee_id = null;
        if (!empty($validated['center_cashier'])) {
            [$type, $id] = explode('_', $validated['center_cashier']);
            if ($type === 'member') $center_cashier_member_id = $id;
            elseif ($type === 'employee') $center_cashier_employee_id = $id;
        }

        // Create the collection center
        $collectionCenter = CollectionCenter::create([
            'branch_id' => $validated['branch_id'],
            'center_no' => $validated['center_no'],
            'center_name' => $validated['center_name'],

            'center_head_member_id' => $center_head_member_id,
            'center_head_employee_id' => $center_head_employee_id,

            'center_cashier_member_id' => $center_cashier_member_id,
            'center_cashier_employee_id' => $center_cashier_employee_id,

            'collection_day' => $validated['collection_day'] ?? null,
            'collection_time' => $validated['collection_time'] ?? null,

            'is_active' => $validated['is_active'],

            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'group_id' => $validated['group_id'] ?? null,
            'address' => $validated['address'] ?? null,
        ]);

        // Optional: Log the creation for debugging
        Log::info('Collection Center Created', $collectionCenter->toArray());

        return redirect()
            ->route('collection-centers.index')
            ->with('success', 'Collection Center created successfully');
    }


    // public function store(Request $request)
    // {
    //     $request->validate([
    //     'branch_id' => 'required|exists:branches,id',
    //     'center_no' => 'required|string|max:50',
    //     'center_name' => 'required|string|max:255',

    //     'center_head_member_id' => 'nullable|exists:members,id',
    //     'center_head_employee_id' => 'nullable|exists:employees,id',

    //     'center_cashier_member_id' => 'nullable|exists:members,id',
    //     'center_cashier_employee_id' => 'nullable|exists:employees,id',

    //     'collection_day' => 'nullable|string',
    //     'collection_time' => 'nullable|string',

    //     'is_active' => 'required|boolean',

    //     'latitude' => 'nullable|string',
    //     'longitude' => 'nullable|string',

    //     'group_id' => 'nullable|integer',
    // ]);

    // CollectionCenter::create($request->all());

    // return redirect()
    //     ->route('collection-centers.index')
    //     ->with('success', 'Collection Center created successfully');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $encodedId)
    {
        $id = base64_decode($encodedId); // decode the Base64 ID
    $center = CollectionCenter::with(['branch', 'centerHeadMember', 'centerHeadEmployee', 'centerCashierMember', 'centerCashierEmployee'])->findOrFail($id);

        return view('collection-centers.show', compact('center'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
         $decodedId = base64_decode($id);

    $center = CollectionCenter::findOrFail($decodedId);
        // $center = CollectionCenter::findOrFail($id);

    return view('collection-centers.create', [
        'center'    => $center,
        'branches'  => Branch::all(),
        'members'   => Member::all(),
        'employees' => Employee::all(),
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
{
     $decodedId = base64_decode($id);
        $center = CollectionCenter::findOrFail($decodedId);
    // $center = CollectionCenter::findOrFail($id);

    $validated = $request->validate([
        'branch_id' => 'required|exists:branches,id',
        'center_no' => 'required|string|max:50',
        'center_name' => 'required|string|max:255',

        'center_head' => 'nullable|string',
        'center_cashier' => 'nullable|string',

        'collection_day' => 'nullable|string',
        'collection_time' => 'nullable|string',

        'is_active' => 'required|boolean',

        'latitude' => 'nullable|string',
        'longitude' => 'nullable|string',

        // 'group_id' => 'nullable|integer',
        'address' => 'nullable|string',
    ]);

    // Center Head
    $center_head_member_id = null;
    $center_head_employee_id = null;
    if (!empty($validated['center_head'])) {
        [$type, $idVal] = explode('_', $validated['center_head']);
        if ($type === 'member') $center_head_member_id = $idVal;
        if ($type === 'employee') $center_head_employee_id = $idVal;
    }

    // Center Cashier
    $center_cashier_member_id = null;
    $center_cashier_employee_id = null;
    if (!empty($validated['center_cashier'])) {
        [$type, $idVal] = explode('_', $validated['center_cashier']);
        if ($type === 'member') $center_cashier_member_id = $idVal;
        if ($type === 'employee') $center_cashier_employee_id = $idVal;
    }

    $center->update([
        'branch_id' => $validated['branch_id'],
        'center_no' => $validated['center_no'],
        'center_name' => $validated['center_name'],

        'center_head_member_id' => $center_head_member_id,
        'center_head_employee_id' => $center_head_employee_id,

        'center_cashier_member_id' => $center_cashier_member_id,
        'center_cashier_employee_id' => $center_cashier_employee_id,

        'collection_day' => $validated['collection_day'],
        'collection_time' => $validated['collection_time'],

        'is_active' => $validated['is_active'],

        'latitude' => $validated['latitude'],
        'longitude' => $validated['longitude'],
        // 'group_id' => $validated['group_id'],
        'address' => $validated['address'],
    ]);

    return redirect()
        ->route('collection-centers.index')
        ->with('success', 'Collection Center updated successfully');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
