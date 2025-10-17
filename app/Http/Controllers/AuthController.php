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

        // Check user active flag
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
}
