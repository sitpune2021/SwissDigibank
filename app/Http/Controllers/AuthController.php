<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    // Login API
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|email|exists:users,email',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     $user = User::where('email', $credentials['email'])->first();

    //     if (!$user || !Hash::check($credentials['password'], $user->password)) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Invalid email or password.',
    //         ], 401);
    //     }
    //     if ($user->user_active != 1) {
    //        $user['user_active']="Inactive";
    //     }
    //     else
    //     {
    //          $user['user_active']="Active";
    //     }
    //     $token = $user->createToken('api-token')->plainTextToken;

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Login successful!',
    //         'token' => $token,
    //         'user' => $user,
    //     ]);
    // }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6',
            'mobile' => 'required|digits:10|exists:users,mobile',

        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid credentials.',
            ], 401);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(5); // valid for 5 minutes
        $user->save();

        // Send OTP
        $this->sendOtpSms($user->mobile, $otp);

        return response()->json([
            'status' => true,
            'message' => 'OTP sent to your registered mobile number.',
        ]);
    }
    private function sendOtpSms($phone, $otp)
    {
        $url = "https://api.voicensms.in/SMSAPI/webresources/CreateSMSCampaignPost";

        $payload = [
            "msisdn" => [$phone],  // ✅ Correct key as per working example
            "language" => 0,
            "credittype" => 7,
            "senderid" => "SBCGLB",
            "templateid" => 123456, // ✅ Replace with actual approved DLT template ID
            "message"=> "Your OTP is {#var#}", // ✅ Should match your DLT-registered message
            "varvalues" => [
                ["varvalue" => $otp]
            ],
            "ukey" => "8ZSyxFHP9LOCSZZUotdWMdzoK",
            "isrefno" => true,
            "filetype" => 2 // ✅ Same as your working payload
        ];

        Log::info("[OTP SMS] To: $phone");
        Log::info("[OTP SMS] Payload: " . json_encode($payload));

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        Log::info("[OTP SMS] HTTP status: " . $httpStatus);
        if ($curlError) {
            Log::error("[OTP SMS] Curl error: " . $curlError);
        }
        Log::info("[OTP SMS] Raw response: " . $response);

        curl_close($ch);

        $decoded = null;
        try {
            $decoded = json_decode($response, true);
        } catch (\Exception $e) {
            Log::error("[OTP SMS] JSON decode failed: " . $e->getMessage());
        }

        return $decoded;
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10|exists:users,mobile',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user || $user->otp !== $request->otp) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid OTP.',
            ], 401);
        }

        if (now()->gt($user->otp_expires_at)) {
            return response()->json([
                'status' => false,
                'message' => 'OTP has expired.',
            ], 401);
        }
        // OTP is valid
        $user->otp = null;
        $user->otp_expires_at = null;
        $user->save();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'status' => true,
            'message' => 'Login successful!',
            'token' => $token,
            'user' => $user,
        ]);
    }

    // Temporary test function (e.g., in a route or test controller)
    public function testSendOtp()
    {
        $phone = '9503654539'; // Your mobile number
        $otp = '117143'; // Existing OTP in database

        $result = $this->sendOtpSms($phone, $otp);

        return response()->json([
            'message' => 'OTP send function called.',
            'sms_api_response' => $result,
        ]);
    }

    // Logout API
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => true,
            'message' => 'Logout successful!',
        ]);
    }
}
