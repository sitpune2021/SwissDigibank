<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\Promotor;
use App\Models\Shareholding;
use App\Models\ShareTransfer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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


    public function transferForm(Request $request)
    {
        $memberId = $request->input('member_id');
        try {
            Log::debug("Starting transferForm method.", ['memberId' => $memberId]);

            $members = Member::pluck('member_info_first_name', 'id');
            Log::debug("Fetched members info.", ['members_count' => $members->count()]);

            $promoterId = Promotor::where('is_transfer', 1)->value('id');
            Log::debug("Promoter ID fetched.", ['promoterId' => $promoterId]);

            if (!$promoterId) {
                Log::warning("No promoter found with is_transfer set to 1.");
                return redirect()->route('shareholding.index')->with('error', 'Please select a promoter first.');
            }

            $promoter = Shareholding::with('promotor')->where('promotor_id', $promoterId)->first();
            Log::debug("Promoter and Shareholding fetched.", ['promoter_id' => $promoterId]);

            $selectedMember = $memberId ? Member::find($memberId) : null;
            if ($selectedMember) {
                Log::debug("Selected member fetched.", ['member_id' => $selectedMember->id, 'member_name' => $selectedMember->member_info_first_name]);
            } else {
                Log::debug("No member selected or member not found.", ['memberId' => $memberId]);
            }
            // dd($memberId);
            return view('members.shares-transfer.create', [
                'promoter' => $promoter,
                'members' => $members,
                'selectedMember' => $selectedMember
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("ModelNotFoundException in transferForm method.", ['exception' => $e->getMessage()]);
            abort(404);
        } catch (\Exception $e) {
            Log::error("Exception in transferForm method.", ['exception' => $e->getMessage()]);
            abort(500);
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

    public function store(Request $request, $memberId = null)
    {
        $validated = $request->validate([
            'transferor_id'          => 'required',
            'member_id'              => 'required',
            'business_type'          => 'required',
            'allotment_date'         => 'required|date',
            'share_no'               => 'required|integer|min:1',
            'share_nominal'          => 'required|numeric|min:0',
            'total_consideration'    => 'required|numeric|min:0',
        ]);

        Log::info('Share Transfer Request Received', [
            'request_data' => $validated,
            'member_id_param' => $memberId
        ]);

        $memberExists = Member::where('id', $validated['member_id'])->exists();
        if (!$memberExists) {
            Log::warning('Share Transfer Failed: Member not found', [
                'member_id' => $validated['member_id']
            ]);
            return redirect()->route('shares-transfer.index')->with('error', 'Selected member does not exist.');
        }

        try {
            DB::transaction(function () use ($validated) {
                $transferorId = $validated['transferor_id'];
                $newShares = $validated['share_no'];

                $promoterTotalShares = Shareholding::where('id', $transferorId)->value('total_share_held');

                if (!$promoterTotalShares || $promoterTotalShares <= 0) {
                    Log::error('Promoter has no shares', [
                        'transferor_id' => $transferorId
                    ]);
                    throw new \Exception('Promoter does not have any shares.');
                }

                $lastToShare = ShareTransfer::where('transferor_id', $transferorId)
                    ->max('to_share_no');

                $fromShareNo = $lastToShare ? ($lastToShare + 1) : 1;
                $toShareNo = ($fromShareNo + $newShares) - 1;

                if ($toShareNo > $promoterTotalShares) {
                    Log::error('Not enough shares left to allocate', [
                        'transferor_id' => $transferorId,
                        'requested_shares' => $newShares,
                        'last_available_share' => $promoterTotalShares
                    ]);
                    throw new \Exception("Not enough shares left to allocate. Last available share no: {$promoterTotalShares}");
                }

                ShareTransfer::create([
                    'transferor_id'       => $transferorId,
                    'member_id'           => $validated['member_id'],
                    'business_type'       => $validated['business_type'],
                    'transfer_date'       => \Carbon\Carbon::createFromFormat('d-m-Y', $validated['allotment_date'])->format('Y-m-d'),
                    'shares'              => $newShares,
                    'face_value'          => $validated['share_nominal'],
                    'total_consideration' => $validated['total_consideration'],
                    'from_share_no'       => $fromShareNo,
                    'to_share_no'         => $toShareNo,
                ]);

                Log::info('Share Transfer Created', [
                    'transferor_id' => $transferorId,
                    'member_id' => $validated['member_id'],
                    'from_share_no' => $fromShareNo,
                    'to_share_no' => $toShareNo,
                    'shares' => $newShares,
                ]);
            });

            Log::info('Share Transfer Transaction Successful', [
                'member_id' => $validated['member_id']
            ]);

            return redirect()->route('shareholding', ['id' => $validated['member_id']])
                ->with('success', 'Share transfer successfully added. Please approve it.');
        } catch (\Exception $e) {
            Log::error('Share Transfer Failed', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('shares-transfer.index')->with('error', 'Something wrong! Please try again');
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
