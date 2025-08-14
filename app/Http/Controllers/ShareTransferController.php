<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Promotor;
use App\Models\Shareholding;
use App\Models\ShareTransfer;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ShareTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $shareholdings = ShareTransfer::with('promotor', 'members')
                ->where('status', 'approved')
                ->orderBy('id', 'desc')->paginate(10);
            return view('members.shares-transfer.index', compact('shareholdings'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function selectForShareSplit(Request $request)
    {
        try {
            $decryptedId = $request->input('split_share');

            DB::transaction(function () use ($decryptedId) {
                Promotor::query()->update(['is_transfer' => 0]);

                $shareholding = Promotor::findOrFail($decryptedId);

                $shareholding->update(['is_transfer' => 1]);
            });

            return redirect()->route('shareholding.index')
                ->with('success', 'Shareholding updated. Only one marked as transferred.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function transferForm($memberId = null)
    {

        try {
            $members = Member::pluck('member_info_first_name', 'id');

            $promoterId = Promotor::where('is_transfer', 1)->value('id');

            if (!$promoterId) {
                return redirect()->route('shareholding.index')->with('error', 'Please select a promoter first.');
            }

            $promoter = Shareholding::with('promotor')->where('promotor_id', $promoterId)->first();

            $selectedMember = $memberId ? Member::find($memberId) : null;

            return view('members.shares-transfer.create', [
                'promoter' => $promoter,
                'members'         => $members,
                'selectedMember'  => $selectedMember
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function getPromoterShares($id)
    {
        try {
            $shares = ShareTransfer::where('member_id', $id)->sum('shares');
            return response()->json(['shares' => $shares]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    // public function store(Request $request,$memberId = null)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'transferor_id'          => 'required',
    //             'member_id'              => 'required',
    //             'business_type'          => 'required',
    //             'allotment_date'         => 'required|date',
    //             'share_no'               => 'required|integer|min:1',
    //             'share_nominal'          => 'required|numeric|min:0',
    //             'total_consideration'    => 'required|numeric|min:0',
    //         ]);

    //         try {
    //             DB::transaction(function () use ($validated) {
    //                 $transferorId = $validated['transferor_id'];
    //                 $newShares = $validated['share_no'];

    //                 $promoterTotalShares = Shareholding::where('id', $transferorId)->value('total_share_held');

    //                 if (!$promoterTotalShares || $promoterTotalShares <= 0) {
    //                     throw new \Exception('Promoter does not have any shares.');
    //                 }

    //                 $lastToShare = ShareTransfer::where('transferor_id', $transferorId)
    //                     ->max('to_share_no');


    //                 $fromShareNo = $lastToShare ? ($lastToShare + 1) : 1;
    //                 $toShareNo = ($fromShareNo + $newShares) - 1;

    //                 if ($toShareNo > $promoterTotalShares) {
    //                     throw new \Exception("Not enough shares left to allocate. Last available share no: {$promoterTotalShares}");
    //                 }

    //                 ShareTransfer::create([
    //                     'transferor_id'       => $transferorId,
    //                     'member_id'           => $validated['member_id'],
    //                     'business_type'       => $validated['business_type'],
    //                     'transfer_date'       => $validated['allotment_date'],
    //                     'shares'              => $newShares,
    //                     'face_value'          => $validated['share_nominal'],
    //                     'total_consideration' => $validated['total_consideration'],
    //                     'from_share_no'       => $fromShareNo,
    //                     'to_share_no'         => $toShareNo,
    //                 ]);
    //             });

    //             return redirect()->route('shares-transfer.index')->with('success', 'Share transfer successfully added. Please approve it.');
    //         } catch (\Exception $e) {
    //             return redirect()->route('shares-transfer.index')->with('error', $e->getMessage());
    //         }
    //     } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    //         abort(404);
    //     } 
    // }

    public function store(Request $request, $memberId = null)
    {
        try {
            $validated = $request->validate([
                'transferor_id'          => 'required',
                'member_id'              => 'required',
                'business_type'          => 'required',
                'allotment_date'         => 'required|date',
                'share_no'               => 'required|integer|min:1',
                'share_nominal'          => 'required|numeric|min:0',
                'total_consideration'    => 'required|numeric|min:0',
            ]);

            try {
                // ✅ Check if member exists in DB before proceeding
                $memberExists = Member::where('id', $validated['member_id'])->exists();
                if (!$memberExists) {
                    return redirect()->route('shares-transfer.index')->with('error', 'Selected member does not exist.');
                }

                DB::transaction(function () use ($validated) {
                    $transferorId = $validated['transferor_id'];
                    $newShares = $validated['share_no'];

                    $promoterTotalShares = Shareholding::where('id', $transferorId)->value('total_share_held');

                    if (!$promoterTotalShares || $promoterTotalShares <= 0) {
                        throw new \Exception('Promoter does not have any shares.');
                    }

                    $lastToShare = ShareTransfer::where('transferor_id', $transferorId)
                        ->max('to_share_no');

                    $fromShareNo = $lastToShare ? ($lastToShare + 1) : 1;
                    $toShareNo = ($fromShareNo + $newShares) - 1;

                    if ($toShareNo > $promoterTotalShares) {
                        throw new \Exception("Not enough shares left to allocate. Last available share no: {$promoterTotalShares}");
                    }

                    ShareTransfer::create([
                        'transferor_id'       => $transferorId,
                        'member_id'           => $validated['member_id'],
                        'business_type'       => $validated['business_type'],
                        'transfer_date'       => $validated['allotment_date'],
                        'shares'              => $newShares,
                        'face_value'          => $validated['share_nominal'],
                        'total_consideration' => $validated['total_consideration'],
                        'from_share_no'       => $fromShareNo,
                        'to_share_no'         => $toShareNo,
                    ]);
                });

                return redirect()->route('shares-transfer.index')->with('success', 'Share transfer successfully added. Please approve it.');
            } catch (\Exception $e) {
                return redirect()->route('shares-transfer.index')->with('error', $e->getMessage());
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }


    public function show(string $id)
    {
        try {
            $shareholding = ShareTransfer::with('promotor', 'members')->findOrFail($id);
            return view('members.shares-transfer.view', compact('shareholding'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function print($id)
    {
        try {
            $shareholding = ShareTransfer::with('promotor', 'members')->findOrFail($id);

            $headers = [
                'title' => 'SHARE CERTIFICATE',
                'customer_id'           => 'CUSTOMER ID',
                'date'                  => 'DATE',
                'customer_name'         => 'MEMBER',
                'share_allotment_date'     => 'SHARE ALLOTMENT DATE',
                'share_range'          => 'SHARE RANGE',
                'total_shares'               => 'TOTAL SHARES',
                'nominal_value'                  => 'NOMINAL VALUE',
                'total_value'                 => 'TOTAL VALUE',
                'date_of_transfer'    => 'DATE OF TRANSFER',
                'share_certificate_no'  => 'SHARE CERTIFICATE NUMBER',
                'is_surrendered'            => 'IS SURRENDERED',
                // 'terms_conditions'      => 'TERMS AND CONDITIONS'
            ];

            // return view('members.shares-transfer.share-certificate', compact('shareholding','headers'));
            $pdf = Pdf::loadView('members.shares-transfer.share-certificate', compact('shareholding', 'headers'));
            return $pdf->download('share-certificate-' . $shareholding->id . '.pdf');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
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
