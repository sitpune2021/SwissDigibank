<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

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
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
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
            'otp' => $otp,
        ]);
    }
    public function verifyOtp(Request $request)
    {
        // Validate input: username (email or mobile) and otp
        $request->validate([
            'username' => 'required|string',  // This will accept either email or mobile
            'otp' => 'required|digits:6', // OTP should be exactly 6 digits
        ]);

        // Initialize the user variable
        $user = null;
        $loginType = '';

        // Check if the provided username is a valid email or mobile
        if (filter_var($request->username, FILTER_VALIDATE_EMAIL)) {
            // Handle login via email
            $user = User::where('email', $request->username)->first();
            $loginType = 'email';
        } else {
            // Handle login via mobile number (normalize mobile number)
            $normalizedMobile = preg_replace('/[^\d\+]/', '', $request->username);  // Strip non-numeric characters
            if (!preg_match('/^\+?\d{7,15}$/', $normalizedMobile)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid mobile number format.',
                ], 422);
            }
            $user = User::where('mobile', $normalizedMobile)->first();
            $loginType = 'mobile';
        }

        // If user not found, return error
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Check if the OTP entered matches the stored OTP
        if ($user->otp !== $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP.',
            ], 401);
        }

        // Check if the OTP has expired
        if (now()->gt($user->otp_expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'OTP has expired.',
            ], 401);
        }

        // OTP is valid, clear the OTP fields to prevent reuse
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        // Generate a new API token for the user (assuming using Laravel Sanctum or Passport)
        $token = $user->createToken('api-token')->plainTextToken;

        // Return success response with token and user details, including username
        return response()->json([
            'status' => true,
            'message' => 'Login successful!',
            'token' => $token,  // API token to authenticate the user
            'username' => $loginType === 'email' ? $user->email : $user->mobile,  // Return the correct username (email or mobile)
            'user' => $user->only(['id', 'name', 'email', 'mobile', 'user_active']),
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
    // public function requestMpinOtp(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //     ]);

    //     $username = $request->input('username');

    //     $user = filter_var($username, FILTER_VALIDATE_EMAIL)
    //         ? User::where('email', $username)->first()
    //         : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User not found.',
    //         ], 404);
    //     }

    //     // Generate OTP
    //     $otp = rand(100000, 999999);
    //     $user->otp = $otp;
    //     $user->otp_expires_at = now()->addMinutes(5);
    //     $user->otp_verified = false;
    //     $user->save();

    //     try {
    //         $dlttemplateid = '1707172240212439291';

    //         $mobile = preg_replace('/\D/', '', $user->mobile);
    //         if (strlen($mobile) == 10) {
    //             $mobile = "91" . $mobile;
    //         }


    //         $message = "Your OTP is {$otp} which is valid for 5 min. Do not disclose OTP to anyone. SBC GLOBAL";

    //         Log::info("Sending OTP to {$mobile}", [
    //             'message' => $message,
    //             'dlttemplateid' => $dlttemplateid,
    //         ]);

    //         $response = \App\Helpers\SmsHelper::sendSms($mobile, $message, $dlttemplateid);
    //         Log::info("VoiceNSMS Response", ['response' => $response]);
    //     } catch (\Exception $e) {
    //         Log::error('Error while sending OTP', ['error' => $e->getMessage()]);
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Failed to send OTP. Please try again later.',
    //         ], 500);
    //     }

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'OTP sent successfully to your registered mobile number. Please verify to set or reset mPIN.',
    //         'otp' => $otp, // Development only
    //     ]);
    // }

    // public function verifympinOtp(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'otp' => 'required|digits:6',
    //     ]);

    //     $username = $request->input('username');
    //     $otp = $request->input('otp');

    //     $user = filter_var($username, FILTER_VALIDATE_EMAIL)
    //         ? User::where('email', $username)->first()
    //         : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User not found.',
    //         ], 404);
    //     }

    //     if (!$user->otp || $user->otp_expires_at->isPast()) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'OTP expired or not found. Please request a new one.',
    //         ], 400);
    //     }

    //     if ($user->otp != $otp) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid OTP.',
    //         ], 401);
    //     }

    //     $user->otp = null;
    //     $user->otp_expires_at = null;
    //     $user->otp_verified = true;
    //     $user->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'OTP verified successfully. You can now set or reset your mPIN.',
    //     ]);
    // }

    // public function setMpin(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'mpin' => 'required|digits:4|confirmed', // requires mpin_confirmation
    //     ]);

    //     $username = $request->input('username');

    //     $user = filter_var($username, FILTER_VALIDATE_EMAIL)
    //         ? User::where('email', $username)->first()
    //         : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User not found.',
    //         ], 404);
    //     }

    //     // OTP must be verified before setting or resetting mPIN
    //     if (!$user->otp_verified) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Please verify OTP before setting mPIN.',
    //         ], 403);
    //     }

    //     // Save hashed mPIN
    //     $user->mpin = bcrypt($request->mpin);
    //     $user->otp_verified = false;
    //     $user->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'mPIN set/reset successfully.',
    //     ]);
    // }

    // public function verifyMpin(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'mpin' => 'required|digits:4',
    //     ]);

    //     $username = $request->input('username');
    //     $user = filter_var($username, FILTER_VALIDATE_EMAIL)
    //         ? User::where('email', $username)->first()
    //         : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

    //     if (!$user || !$user->mpin || !Hash::check($request->mpin, $user->mpin)) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid mPIN.',
    //         ], 401);
    //     }

    //     $token = $user->createToken('api-token')->plainTextToken;

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'mPIN verified successfully!',
    //         'user' => $user->only(['id', 'name', 'email', 'mobile', 'user_active']),
    //     ]);
    // }

//otp base

    public function requestMpinOtp(Request $request)
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
            'otp' => $otp, 
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

    // public function setMpin(Request $request)
    // {
    //     $request->validate([
    //         'username' => 'required|string',
    //         'mpin' => 'required|digits:4|confirmed', // requires mpin_confirmation
    //     ]);

    //     $username = $request->input('username');

    //     // Find user by email or mobile
    //     if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
    //         $user = User::where('email', $username)->first();
    //     } else {
    //         $normalizedMobile = preg_replace('/[^\d\+]/', '', $username);
    //         $user = User::where('mobile', $normalizedMobile)->first();
    //     }

    //     if (!$user) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'User not found.',
    //         ], 404);
    //     }

    //     // Check if OTP was verified
    //     if (!$user->otp_verified) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Please verify OTP before setting mPIN.',
    //         ], 403);
    //     }

    //     // Save hashed mPIN
    //     $user->mpin = bcrypt($request->mpin);
    //     $user->save();

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'mPIN set successfully.',
    //     ]);
    // }
public function setOrResetMpin(Request $request)
{
    $request->validate([
        'username' => 'required|string',
        'mpin' => 'required|digits:4|confirmed', // requires mpin_confirmation
    ]);

    $username = $request->input('username');

    // Find user by email or mobile
    $user = filter_var($username, FILTER_VALIDATE_EMAIL)
        ? User::where('email', $username)->first()
        : User::where('mobile', preg_replace('/[^\d\+]/', '', $username))->first();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
        ], 404);
    }

    // Ensure OTP is verified before setting/resetting mPIN
    if (!$user->otp_verified) {
        return response()->json([
            'status' => false,
            'message' => 'Please verify OTP before setting/resetting mPIN.',
        ], 403);
    }

    // Check if this is a reset or first-time set
    $isReset = $user->mpin ? true : false;

    // Save hashed mPIN
    $user->mpin = bcrypt($request->mpin);

    // Clear OTP after successful operation
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

        if (!$user || !$user->mpin || !Hash::check($request->mpin, $user->mpin)) {
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
}
