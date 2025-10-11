<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;

use Illuminate\Http\Request;

class MemberController extends Controller
{
   
     public function fetchMemberDetails($id)
    {
        
        try {
            $member = Member::findOrFail($id);

            $fullName = trim(
                ($member->member_info_title ?? '') . ' ' .
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
