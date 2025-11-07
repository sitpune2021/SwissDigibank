<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $username = trim($data['username']);
        $password = $data['password'];

        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $username)->first();
        } else {
            $normalizedMobile = preg_replace('/[^\d\+]/', '', $username);

            if (!preg_match('/^\+?\d{7,15}$/', $normalizedMobile)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Username must be a valid email or mobile number.',
                ], 422);
            }

            $user = User::where('mobile', $normalizedMobile)
                ->orWhere('mobile', ltrim($normalizedMobile, '+'))
                ->first();
        }
        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        if ($user->user_active != 1) {
            return response()->json([
                'status' => false,
                'message' => 'User account is inactive.',
            ], 403);
        }

        if ($user->role_id == 1) { // admin
            return response()->json([
                'status' => false,
                'message' => 'Admin cannot login here.',
            ], 403);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(30);
        $user->save();
        try {

            $user = \App\Models\User::find($user->id);
            $dlttemplateid = 1707172240212439291;
            $mobile = $user->mobile;
            $message = "Your login OTP is $otp which is valid for 5 min. Do not disclose OTP to anyone. SBC GLOBAL";

            \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
        } catch (\Exception $e) {
            Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
        }
        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully.',
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'otp' => 'required|digits:6',
        ]);

        $user = null;

        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', strtolower(trim($request->username)))->first();
        } else {
            $normalizedMobile = preg_replace('/[^\d\+]/', '', $request->username);
            if (!preg_match('/^\+?\d{7,15}$/', $normalizedMobile)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid mobile number format.',
                ], 422);
            }
            $user = User::where('mobile', $normalizedMobile)->first();
        }

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        if ($user->otp !== $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP.',
            ], 401);
        }

        if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'OTP has expired.',
            ], 401);
        }

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();
        $token = $user->createToken('AuthToken')->plainTextToken;
        $member = $user->member;
        $canAccessDashboard = $member && $member->share_allocated > 0;

        $isMpinSet = !empty($user->mpin);
        $addresses = $user->addresses()->first(['member_address_line_1']);

        return response()->json([
            'status' => true,
            'token' => $token,
            'message' => 'OTP verified successfully!',
            'user' => $user->only(['id', 'name', 'email', 'mobile', 'user_active']),
            'addresses' => $addresses ? $addresses->only('member_address_line_1') : null,
            'isMpinSet' => $isMpinSet,
            'can_access_dashboard' => $canAccessDashboard,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logout successful!',
        ]);
    }

    public function requestMpinOtp(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'username' => 'required|string',
        ]);

        $username = $request->input('username');

        $user = filter_var($username, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $username)->first()
            : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->otp_verified = false;
        $user->save();

        try {
            $dlttemplateid = '1707172240212439291';

            $mobile = preg_replace('/\D/', '', $user->mobile);
            if (strlen($mobile) == 10) {
                $mobile = "91" . $mobile;
            }

            $message = "Your login OTP is {$otp} which is valid for 5 min. Do not disclose OTP to anyone. SBC GLOBAL";
            Log::info("Sending OTP to {$mobile}", [
                'message' => $message,
                'dlttemplateid' => $dlttemplateid,
            ]);

            $response = \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
            Log::info("VoiceNSMS Response", ['response' => $response]);
        } catch (\Exception $e) {
            Log::error('Error while sending SMS', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Failed to send OTP. Please try again later.',
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully to your registered mobile number. Please verify to set mPIN.',
            // 'otp' => $otp,
        ]);
    }

    public function verifympinOtp(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'otp' => 'required|digits:6',
        ]);

        $username = $request->input('username');
        $otp = $request->input('otp');

        $user = filter_var($username, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $username)->first()
            : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        if (!$user->otp || $user->otp_expires_at->isPast()) {
            return response()->json([
                'status' => false,
                'message' => 'OTP expired or not found. Please request a new one.',
            ], 400);
        }

        if ($user->otp != $otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP.',
            ], 401);
        }

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->otp_verified = true;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'OTP verified successfully. You can now set your mPIN.',
        ]);
    }

    public function setOrResetMpin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'mpin' => 'required|digits:4|confirmed', // requires mpin_confirmation
        ]);

        $username = $request->input('username');

        $user = filter_var($username, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $username)->first()
            : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        if (!$user->otp_verified) {
            return response()->json([
                'status' => false,
                'message' => 'Please verify OTP before setting/resetting mPIN.',
            ], 403);
        }

        $isReset = $user->mpin ? true : false;

        $user->mpin = Crypt::encryptString($request->mpin);

        $user->otp = null;
        $user->otp_expires_at = null;
        $user->otp_verified = false;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => $isReset ? 'mPIN reset successfully.' : 'mPIN set successfully.',
        ]);
    }

    public function verifyMpin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'mpin' => 'required|digits:4',
        ]);

        $username = $request->input('username');
        $user = filter_var($username, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $username)->first()
            : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

        if (!$user || !$user->mpin || Crypt::decryptString($user->mpin) !== $request->mpin) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid mPIN.',
            ], 401);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'mPIN verified successfully!',
            'user' => $user->only(['id', 'name', 'email', 'mobile', 'user_active']),
        ]);
    }
    public function checkMpinStatus(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $username = $request->input('username');

        $user = filter_var($username, FILTER_VALIDATE_EMAIL)
            ? User::where('email', $username)->first()
            : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
                'mpin_value' => null,
            ], 404);
        }

        $mpin = null;
        $isMpinSet = false;

        if (!empty($user->mpin)) {
            try {
                $mpin = Crypt::decryptString($user->mpin);
                $isMpinSet = true;
            } catch (\Exception $e) {
                $mpin = null; // fallback if decryption fails
            }
        }

        return response()->json([
            'status' => $isMpinSet, // true if set, false if not
            'message' => $isMpinSet ? 'mPIN is set' : 'mPIN not set',
            'mpin_value' => $mpin,
        ]);
    }
}
