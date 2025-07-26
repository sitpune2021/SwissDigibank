<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $perPage = $request->input('perPage', 10);
        // $query = Branch::with('state')->orderBy('created_at', 'desc');

        // if ($request->has('search')) {
        //     $search = $request->input('search');
        //     $query->where(function ($q) use ($search) {
        //         $q->where('branch_name', 'like', "%$search%")
        //             ->orWhere('branch_code', 'like', "%$search%")
        //             ->orWhere('city', 'like', "%$search%")
        //             ->orWhere('open_date', 'like', "%$search%")
        //             ->orWhereHas('state', function ($stateQuery) use ($search) {
        //                 $stateQuery->where('name', 'like', "%$search%");
        //             });
        //     });
        // }

        // $branches = $query->paginate($perPage)->appends($request->all());
        return view('roles.manage-permission');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.add-role');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
