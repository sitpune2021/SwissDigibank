<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promotor;
use App\Models\Shareholding;
use App\Models\ShareTransfer;
use Illuminate\Support\Facades\DB;

class ShareTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('members.shares-transfer.index');
    }


    public function selectForShareSplit(Request $request)
    {
        $request->validate([
            'split_share' => 'required|exists:promotors,id',
        ]);

        session(['split_promoter_id' => $request->split_share]);
        return redirect()
            ->route('shareholding.index')
            ->with('success', 'Promoter selected successfully for share splitting.');
        // return redirect()->route('shareholding.transfer.form');
    }

    public function transferForm(Request $request)
    {
        $promoterId = session('split_promoter_id');

        if (!$promoterId) {
            return redirect()->route('shareholding.index')->with('error', 'Please select a promoter first.');
        }

        $promoter = Shareholding::with('promotor')->findOrFail($promoterId);

        return view('members.shares-transfer.create', [
            'promoter' => $promoter
        ]);
    }

    public function getPromoterShares($id)
    {
        $shares = Shareholding::where('promotor_id', $id)->sum('share_no');
        return response()->json(['shares' => $shares]);
    }

    public function allocateShares(Request $request)
    {

        $request->validate([
            'from_promoter_id' => 'required|exists:promoters,id',
            'shares' => 'required|array',
        ]);

        $fromPromoter = Promotor::findOrFail($request->from_promoter_id);

        $totalToDeduct = array_sum($request->shares);

        if ($totalToDeduct > $fromPromoter->shares) {
            return back()->with('error', 'Not enough shares to allocate.');
        }

        // Deduct shares from original promoter
        $fromPromoter->shares -= $totalToDeduct;
        $fromPromoter->save();

        // Add shares to selected promoters
        foreach ($request->shares as $promoterId => $shareCount) {
            if ($shareCount > 0) {
                $toPromoter = Promotor::find($promoterId);
                $toPromoter->shares += $shareCount;
                $toPromoter->save();
            }
        }

        return redirect()->route('promoter.list')->with('success', 'Shares allocated successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $validated = $request->validate([
            'transferor'          => 'required',
            'member_id'           => 'required|exists:shareholdings,promotor_id|different:transferor',
            'business_type'       => 'nullable|string|max:255',
            'allotment_date'      => 'required|date',
            'share_no'            => 'required|integer|min:1',
            'share_nominal'       => 'required|numeric|min:0',
            'total_consideration' => 'required|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $transferor = Shareholding::where('promoter_id', $validated['transferor'])->lockForUpdate()->first();
                $transferee = Shareholding::where('promoter_id', $validated['member_id'])->lockForUpdate()->first();

                if (!$transferor || !$transferee) {
                    throw new \Exception("Invalid member details.");
                }

                if ($transferor->shares < $validated['share_no']) {
                    throw new \Exception("Transferor does not have enough shares.");
                }

                if ($transferee->shares + $validated['share_no'] > 100) {
                    throw new \Exception("Transferee cannot hold more than 100 shares.");
                }

                $transferor->shares -= $validated['share_no'];
                $transferor->save();


                $transferee->shares += $validated['share_no'];
                $transferee->save();

                ShareTransfer::create([
                    'transferor_id'      => $validated['transferor'],
                    'member_id'          => $validated['member_id'],
                    'business_type'      => $validated['business_type'],
                    'transfer_date'      => $validated['allotment_date'],
                    'shares'             => $validated['share_no'],
                    'face_value'         => $validated['share_nominal'],
                    'total_consideration' => $validated['total_consideration'],
                    'status'             => 'pending',
                ]);
            });

            return redirect()->route('shares-transfer.index')->with('success', 'Share transfer completed successfully.');
        } catch (\Exception $e) {
            return redirect()->route('shares-transfer.index')->with('error', $e->getMessage());
        }
    }

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
