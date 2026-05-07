<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Models\WebauthnCredential;
use Illuminate\Support\Str;


class AuthenticationController extends Controller
{


    public function index()
    {
        // if (!auth()->user()->hasRole('admin')) {
        //     abort(403);
        // }

        // return view('admin.dashboard');
    }

    public function signUp()
    {
        return view('authentication.singup');
    }

    public function signIn()
    {
        return view('authentication.signin');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'type' => 'validation',
                'errors' => $validator->errors()
            ]);
        }

        $user = User::where('email', $request->login)
            ->orWhere('mobile', $request->login)
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'type' => 'error',
                'message' => 'Invalid credentials'
            ]);
        }

        // OTP logic same
        $user->otp = rand(1000, 9999);
        $user->otp_verified = 0;
        $user->otp_expires_at = now()->addMinutes(1);
        $user->otp_attempts = 0;
        $user->otp_blocked_until = null;
        $user->save();

        Mail::raw("Your OTP is: " . $user->otp, function ($message) use ($user) {
            $message->to($user->email)->subject('Login OTP');
        });

        return response()->json([
            'status' => true,
            'user_id' => $user->id,
            'expires_in' => 60
        ]);
    }
    
    public function verifyLoginOtp(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'otp' => 'required|digits:4'
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }

        // ❌ BLOCK CHECK
        if ($user->otp_blocked_until && now()->lt($user->otp_blocked_until)) {
            return response()->json([
                'status' => false,
                'message' => 'Too many attempts. Try again after 2 minutes'
            ]);
        }

        if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
            $user->otp = null;
            $user->save();

            return response()->json([
                'status' => false,
                'message' => 'OTP expired'
            ]);
        }

        if ($user->otp == $request->otp) 
        {

            $user->otp_verified = 1;
            $user->otp = null;
            $user->otp_attempts = 0;
            $user->otp_blocked_until = null;
            $user->save();

            // ✅ LOGIN
            Auth::login($user);
            $request->session()->regenerate();

            // 🔥 CORRECT CHECK biomatrix unable (IMPORTANT)
            $hasBiometric = WebauthnCredential::where('user_id', $user->id)->exists();

            return response()->json([
                'status' => true,
                'user_id' => $user->id,
                'has_biometric' => $hasBiometric, // ✅ FIXED
                'redirect' => route('index1')
            ]);
        }

       // ❌ WRONG OTP
        $user->otp_attempts += 1;

        // 🔥 LIMIT = 5
        if ($user->otp_attempts >= 5) {
            $user->otp_blocked_until = now()->addMinutes(2); // 2 min block
            $user->otp_attempts = 0; // reset
        }

        $user->save();

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ]);
    }

    public function resendOtp(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ]);
        }

        // 🔥 NEW OTP
        $user->otp = rand(1000, 9999);
        $user->otp_verified = 0; // 🔥 reset
        $user->otp_expires_at = now()->addMinutes(1);
        $user->otp_attempts = 0;
        $user->otp_blocked_until = null;
        $user->save();

        // 🔥 MAIL SEND
        Mail::raw("Your OTP is: " . $user->otp, function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Resend OTP');
        });

        return response()->json([
            'status' => true,
            'expires_in' => 60
        ]);
    }

    public function register(Request $request)
    {
        try {
            // Validate input
            $validated = $request->validate([
                'fname' => 'required|string|max:50',
                'lname' => 'required|string|max:50',
                'role_id' => 'required|integer',
                'email' => 'required|email|unique:users,email',
                'mobile' => 'required|integer|unique:users,mobile',
                'password' => ['required', Password::min(6)],
            ]);

            $user = User::create([
                'name' => $validated['fname'] . ' ' . $validated['lname'],
                'email' => $validated['email'],
                'mobile' => $validated['mobile'],
                'role_id' => $validated['role_id'],
                'password' => Hash::make($validated['password']),
            ]);

            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user
            ], 201);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }

        // return redirect()->route('/')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        try {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('sign.in')->with('session_expired', 'You have been logged out successfully.');;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function biometricRegisterOptions(Request $request)
    {
        if (!$request->user_id) {
            return response()->json(['error' => 'User ID missing'], 400);
        }

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $challenge = base64_encode(random_bytes(32));  // security token - send on browser
        session(['challenge' => $challenge]);  // store in session

        return response()->json([
            'challenge' => $challenge,
            'rp' => ['name' => 'Swiss Payment'],
            'user' => [
                'id' => base64_encode((string)$user->id),
                'name' => $user->email,
                'displayName' => $user->name
            ],
            'pubKeyCredParams' => [
                ['type' => 'public-key', 'alg' => -7]
            ],
            'timeout' => 60000,

            // ✅ IMPORTANT Force for fingerprint / face use
            // 'authenticatorSelection' => [
            //     'residentKey' => 'required',
            //     'userVerification' => 'required'
            // ]
            'authenticatorSelection' => [
                'residentKey' => 'required'
            ],

            'userVerification' => 'required',
        ]);
    }

    public function biometricRegister(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'rawId' => 'required',
            'attestationObject' => 'required',
            'clientDataJSON' => 'required',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // WebauthnCredential::create([
        //     'user_id' => $user->id,
        //     'credential_id' => $request->rawId,  // unique biometric ID
        //     'public_key' => json_encode([
        //         'attestationObject' => $request->attestationObject,  // actual cryptographic data
        //         'clientDataJSON' => $request->clientDataJSON
        //     ])
        // ]);

        // 🔥 SAME DEVICE CHECK
        // 🔥 DEVICE ALREADY USED CHECK
        $deviceExists = WebauthnCredential::where('browser', $request->userAgent())
            ->exists();

        if ($deviceExists) {

            return response()->json([
                'status' => false,
                'message' => 'Another account already using biometric on this device'
            ]);
        }

        WebauthnCredential::create([

            'user_id' => $user->id,

            'credential_id' => $request->rawId,

            'public_key' => json_encode([
                'attestationObject' => $request->attestationObject,
                'clientDataJSON' => $request->clientDataJSON
            ]),

            // 🔥 DEVICE SECURITY
            'device_name' => $request->header('User-Agent'),

            'browser' => $request->userAgent(),

            'ip_address' => $request->ip(),

            'last_used_at' => now()

        ]);

        return response()->json([
            'status' => true,
            'message' => 'Biometric saved'
        ]);
    }

    public function biometricLoginOptions(Request $request)
    {
        $request->validate([
            'login' => 'required'
        ]);

        $user = User::where('email', $request->login)
            ->orWhere('mobile', $request->login)
            ->first();

        if (!$user) {
            return response()->json(['error' => 'User not found']);
        }

        $credentials = WebauthnCredential::where('user_id', $user->id)->get();

        if ($credentials->isEmpty()) {
            return response()->json(['error' => 'No passkey registered']);
        }

        $challenge = base64_encode(random_bytes(32));
        session(['challenge' => $challenge]);

        return response()->json([
            'challenge' => $challenge,
            'timeout' => 60000,
            'userVerification' => 'required',

            // 🔥 MULTIPLE PASSKEY SUPPORT
            'allowCredentials' => $credentials->map(function ($cred) {
                return [
                    'id' => $cred->credential_id,
                    'type' => 'public-key'
                ];
            })->values()
        ]);
    }

    public function biometricLogin(Request $request)
    {
        $credential = WebauthnCredential::where('credential_id', $request->id)->first();

        if (!$credential) {
            return response()->json(['status' => false]);
        }

        // 🔥 UPDATE DEVICE INFO
        $credential->update([

            'ip_address' => $request->ip(),

            'last_used_at' => now(),

            'browser' => $request->userAgent()

        ]);

        $user = User::find($credential->user_id);

        Auth::login($user);

        return response()->json([
            'status' => true,
            'redirect' => route('index1')
        ]);
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (!$request->has('email')) {
                return back()->with('error', 'Email is required.');
            }
            if (!$request->has('password')) {
                return back()->with('error', 'Password is required.');
            }
            $user = User::where('email', $request->email)

                ->where('role_id', 1)->first();
            if (!$user) {
                return back()->with('error', 'User not found.');
            }
            if ($user) {
                $user->password = Hash::make($request->password);
                $user->save();
                return redirect()->back()->with('success', 'Password reset successfully.');
            } else {
                return redirect()->back()->with('error', 'User not found.');
            }
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        }
    }

    public function signInQrcode()
    {
        return view('authentication.signin-qrcode');
    }

    public function error()
    {
        return view('authentication.error');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email not found');
        }

        $token = Str::random(64);

        $user->reset_token = $token;
        $user->reset_token_expires_at = now()->addMinutes(30);
        $user->save();

        $link = url('/reset-password/' . $token);

        Mail::raw("Click here to reset password: $link", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Reset Password');
        });

        return back()->with('success', 'Reset link sent to email');
    }

    public function showResetForm($token)
    {
        $user = User::where('reset_token', $token)->first();

        if (!$user || now()->gt($user->reset_token_expires_at)) {
            return "Link expired";
        }

        return view('authentication.reset-password', compact('token'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = User::where('reset_token', $request->token)->first();

        if (!$user) {
            return back()->with('error', 'Invalid token');
        }

        if (now()->gt($user->reset_token_expires_at)) {
            return back()->with('error', 'Token expired');
        }

        $user->password = Hash::make($request->password);
        $user->reset_token = null;
        $user->reset_token_expires_at = null;
        $user->save();

        return redirect('/')->with('success', 'Password updated');
    }

    
}
