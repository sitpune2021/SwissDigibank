<?php

namespace App\Http\Controllers;

use App\Models\FDScheme;
use Illuminate\Http\Request;

class FDController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('fd_mis_account.fd_scheme.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fd_mis_account.fd_scheme.add-scheme');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'scheme_name'         => 'required|string|max:255',
            'scheme_code'         => 'required|string|max:255|unique:fd_schemes,scheme_code',
            'min_amount'          => 'required|numeric|min:0',
            'lock_in_period'      => 'required|integer|min:0',
            'interest_lock_in'    => 'required|integer|min:0',
            'bonus_rate'          => 'nullable|numeric|min:0',
            'bonus_type'          => 'nullable|in:%,fixed',
            'cancellation_charge' => 'nullable|numeric|min:0',
            'cancellation_type'   => 'nullable|in:%,fixed',
            'penal_charge'        => 'nullable|numeric|min:0',
            'effective_date'      => 'required|date',
            'stationary_fee'      => 'nullable|numeric|min:0',
            'is_active'           => 'nullable|integer|in:0,1',

            'slabs.*.min_amount' => 'nullable|numeric|min:0',
            'slabs.*.max_amount' => 'nullable|numeric|min:0',
            'slabs.*.interest_rate' => 'nullable|numeric|min:0',
            'slabs.*.tenure' => 'nullable|integer|min:0',
            'slabs.*.payout' => 'nullable|string',
        ]);

        $validated['effective_date'] = \Carbon\Carbon::parse($request->effective_date)->format('Y-m-d');

        $validated['admin']     = $request->has('admin') ? 1 : 0;
        $validated['associate'] = $request->has('associate') ? 1 : 0;
        $validated['member']    = $request->has('member') ? 1 : 0;

        FdScheme::create($validated);

        foreach ($request->slabs as $slab) {
            // Skip empty rows
            if (empty($slab['min_amount']) && empty($slab['max_amount']) && empty($slab['interest_rate']) && empty($slab['tenure'])) {
                continue;
            }

            // Slab::create([
            //     'min_amount' => $slab['min_amount'] ?? 0,
            //     'max_amount' => $slab['max_amount'] ?? 0,
            //     'interest_rate' => $slab['interest_rate'] ?? 0,
            //     'tenure' => $slab['tenure'] ?? 0,
            //     'payout' => $slab['payout'] ?? null,
            // ]);
        }

        return redirect()->route('fd-mis-schemes.index')->with('success', 'FD Scheme created successfully!');
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
