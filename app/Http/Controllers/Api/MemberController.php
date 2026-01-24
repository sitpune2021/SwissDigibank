<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{

    public function fetchMemberDetails()
    {
        $id = Auth::id();
        try {
            $member = Member::with('kyc')
                ->where('user_id', $id)
                ->firstOrFail();
            $fullName = trim(
                ($member->member_info_first_name ?? '') . ' ' .
                    ($member->member_info_middle_name ?? '') . ' ' .
                    ($member->member_info_last_name ?? '')
            );

            return response()->json([
                'status' => true,
                'message' => 'Member fetched successfully',
                'data' => [
                    'title' => $member->member_info_title,
                    'full_name' => $fullName,
                    'member_info_email' => $member->member_info_email,
                    'member_info_mobile_no' => $member->member_info_mobile_no,
                    'member_kyc_aadhaar_no' => $member->kyc->member_kyc_aadhaar_no,
                    'member_kyc_pan_no' => $member->kyc->member_kyc_pan_no,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Member not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}
