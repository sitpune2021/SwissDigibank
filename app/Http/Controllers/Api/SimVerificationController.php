<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class SimVerificationController extends Controller
{
    public function requestOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|min:10|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = \App\Models\User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Mobile number not found in user records.',
            ], 404);
        }

        $otp = rand(100000, 999999);
        $expiresAt = \Carbon\Carbon::now()->addMinutes(5);

        $user->update([
            'otp' => $otp,
            'otp_expires_at' => $expiresAt,
            'otp_verified' => 0,
        ]);

        try {
            $dlttemplateid = '1707172240212439291'; 
            $mobile = $user->mobile;
            $message = "Your login OTP is $otp which is valid for 5 min. Do not disclose OTP to anyone. SBC GLOBAL";

            \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error while sending SMS', [
                'error' => $e->getMessage(),
                'mobile' => $user->mobile,
                
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully to your registered mobile number.',
            // 'otp' => $otp,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|string|min:10|max:15',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        if (!$user->otp || !$user->otp_expires_at) {
            return response()->json([
                'status' => false,
                'message' => 'No OTP request found for this number.',
            ], 400);
        }

        if (Carbon::parse($user->otp_expires_at)->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'OTP has expired.',
            ], 400);
        }

        if ($user->otp !== $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP code.',
            ], 400);
        }

        $user->update([
            'otp_verified' => 1,
            'otp' => null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'SIM verified successfully.',
        ]);
    }
}
