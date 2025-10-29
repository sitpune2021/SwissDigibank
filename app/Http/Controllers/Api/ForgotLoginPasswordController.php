<?php
namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Helpers\SmsHelper;

class ForgotLoginPasswordController extends Controller
{
   
    public function sendOtp(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
        ]);

        $username = trim($data['username']);

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

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        if ($user->user_active != 1) {
            return response()->json([
                'status' => false,
                'message' => 'User account is inactive.',
            ], 403);
        }

        $otp = rand(100000, 999999);
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(2);
        $user->save();

        try {
            if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
                Mail::raw("Your password reset OTP is $otp (valid for 5 minutes).", function ($message) use ($user) {
                    $message->to($user->email)
                            ->subject('Password Reset OTP');
                });
            } else {
                $dlttemplateid = 1707172234357375605;
                $mobile = $user->mobile;
                $message = "Your Reset Password OTP is $otp. OTP valid for 2 minutes. SBC GLOBAL";

                SmsHelper::sendSms($mobile, $message, $dlttemplateid);
            }
        } catch (\Exception $e) {
            Log::error('Error sending reset password OTP', ['error' => $e->getMessage()]);
        }

        return response()->json([
            'status' => true,
            'message' => 'OTP sent successfully for password reset.',
            'otp' => $otp,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'otp' => 'required|digits:6',
        ]);

        $user = User::where('email', $data['username'])
                    ->orWhere('mobile', $data['username'])
                    ->first();

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found.'], 404);
        }

        if ($user->otp !== $data['otp'] || now()->greaterThan($user->otp_expires_at)) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired OTP.'], 400);
        }

        return response()->json(['status' => true, 'message' => 'OTP verified successfully.']);
    }

   public function resetPassword(Request $request)
{
    $data = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Find user by email or mobile
    $user = User::where('email', $data['username'])
                ->orWhere('mobile', $data['username'])
                ->first();

    if (!$user) {
        return response()->json(['status' => false, 'message' => 'User not found.'], 404);
    }

    // Optional: If you want to skip OTP check entirely, comment this out
    /*
    if ($user->otp !== $data['otp'] || now()->greaterThan($user->otp_expires_at)) {
        return response()->json(['status' => false, 'message' => 'Invalid or expired OTP.'], 400);
    }
    */

    $user->password = Hash::make($data['password']);
    $user->otp = null;
    $user->otp_expires_at = null;
    $user->save();

    return response()->json(['status' => true, 'message' => 'Password reset successfully.']);
}

}
