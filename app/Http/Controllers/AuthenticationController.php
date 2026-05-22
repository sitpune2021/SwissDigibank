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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
        $user->otp_expires_at = now()->addSeconds(60);
        $user->otp_attempts = 0;
        $user->otp_blocked_until = null;
        $user->save();

        // Mail::raw("Your OTP is: " . $user->otp, function ($message) use ($user) {
        //     $message->to($user->email)->subject('Login OTP');
        // });

        Mail::send([], [], function ($message) use ($user) {

            $message->to($user->email)
                ->subject('🔐 Secure Banking OTP')
                ->html('
                
                <div style="
                    
                    padding:40px 20px;
                    font-family:Arial,sans-serif;
                ">

                    <div style="
                        max-width:520px;
                        margin:auto;

                        background:linear-gradient(
                            145deg,
                            rgba(15,23,42,0.98),
                            rgba(2,6,23,0.95)
                        );

                        border-radius:28px;
                        overflow:hidden;

                        border:1px solid rgba(34,211,238,0.25);

                        box-shadow:
                            0 25px 80px rgba(0,0,0,0.7);
                    ">

                        <!-- TOP GLOW -->
                        <div style="
                            height:5px;
                            background:linear-gradient(
                                90deg,
                                #06b6d4,
                                #3b82f6
                            );
                        "></div>

                        <div style="padding:38px; color:white;">

                            <!-- ICON -->
                            <div style="text-align:center;">

                                <div style="
                                    width:78px;
                                    height:78px;
                                    margin:auto;
                                    border-radius:50%;

                                    background:rgba(34,211,238,0.10);

                                    border:1px solid rgba(34,211,238,0.35);

                                    display:flex;
                                    align-items:center;
                                    justify-content:center;

                                    font-size:34px;

                                    box-shadow:
                                        0 0 30px rgba(34,211,238,0.25);
                                ">
                                    🔐
                                </div>

                            </div>

                            <!-- TITLE -->
                            <h2 style="
                                text-align:center;
                                margin-top:22px;
                                margin-bottom:10px;

                                font-size:28px;
                                font-weight:700;

                                letter-spacing:0.5px;
                            ">
                                Secure OTP Verification
                            </h2>

                            <!-- TEXT -->
                            <p style="
                                text-align:center;
                                color:#cbd5e1;
                                font-size:14px;
                                line-height:24px;
                            ">
                                Use the OTP below to securely access your banking account.
                            </p>

                            <!-- OTP BOX -->
                            <div style="
                                margin:35px 0;
                                text-align:center;
                            ">

                                <div style="
                                    display:inline-block;

                                    padding:18px 40px;

                                    border-radius:24px;

                                    background:
                                        linear-gradient(
                                            145deg,
                                            rgba(34,211,238,0.16),
                                            rgba(59,130,246,0.10)
                                        );

                                    border:1px solid rgba(34,211,238,0.30);

                                    box-shadow:
                                        0 0 35px rgba(34,211,238,0.18);
                                ">

                                    <span style="
                                        font-size:44px;
                                        font-weight:800;

                                        letter-spacing:12px;

                                        color:#22d3ee;

                                        text-shadow:
                                            0 0 25px rgba(34,211,238,0.45);
                                    ">
                                        '.$user->otp.'
                                    </span>

                                </div>

                            </div>

                            <!-- EXPIRY -->
                            <div style="
                                text-align:center;
                                color:#facc15;
                                font-size:13px;
                                margin-top:-8px;
                            ">
                                ⏳ OTP valid for only 60 seconds
                            </div>

                            <!-- SECURITY BOX -->
                            <div style="
                                margin-top:30px;

                                background:rgba(255,255,255,0.04);

                                border:1px solid rgba(255,255,255,0.06);

                                border-radius:18px;

                                padding:18px;
                            ">

                                <div style="
                                    color:#22d3ee;
                                    font-size:13px;
                                    font-weight:700;
                                    margin-bottom:8px;
                                ">
                                    SECURITY NOTICE
                                </div>

                                <div style="
                                    color:#cbd5e1;
                                    font-size:13px;
                                    line-height:22px;
                                ">
                                    Never share this OTP with anyone.
                                    Our bank never asks for OTP or passwords.
                                </div>

                            </div>

                            <!-- FOOTER -->
                            <div style="
                                margin-top:30px;
                                text-align:center;

                                color:#94a3b8;
                                font-size:12px;
                                line-height:22px;
                            ">
                                © '.date('Y').' Secure Banking System<br>
                                End-to-End Encrypted Authentication
                            </div>

                        </div>

                    </div>

                </div>

                ');
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


            // 🔥 CURRENT LOGIN DETAILS  (suspicious login detect)
            $currentBrowser = $request->userAgent();

            $currentIp = $request->ip();

            // 🔥 LOCALHOST FIX
            // 🔥 DEFAULT
            $currentCity = 'Unknown';

            try {

                // 🔥 LOCALHOST
                if (
                    $currentIp == "127.0.0.1" ||
                    $currentIp == "::1"
                ) {

                    $currentCity = "Localhost";

                } else {

                    // 🔥 TIMEOUT IMPORTANT
                    $response = Http::timeout(5)
                        ->get("http://ip-api.com/json/" . $currentIp);

                    // 🔥 RESPONSE CHECK
                    if ($response->successful()) {

                        $location = $response->json();

                        $currentCity = $location['city'] ?? 'Unknown';
                    }
                }

            } catch (\Exception $e) {

                // 🔥 ERROR LOG
                Log::error('IP API ERROR: ' . $e->getMessage());

                $currentCity = 'Unknown';
            }

            // 🔥 SUSPICIOUS CHECK
            $isSuspicious = false;

            if (
                $user->last_login_browser &&
                $user->last_login_browser != $currentBrowser
            ) {
                $isSuspicious = true;
            }

            if (
                $user->last_login_ip &&
                $user->last_login_ip != $currentIp
            ) {
                $isSuspicious = true;
            }

            if (
                $user->last_login_city &&
                $user->last_login_city != $currentCity
            ) {
                $isSuspicious = true;
            }

            // 🔥 SEND ALERT MAIL
            if ($isSuspicious) {

                Mail::raw(
                    "⚠ Suspicious Login Detected

                New Login Details:

                Browser:
                $currentBrowser

                IP:
                $currentIp

                City:
                $currentCity

                Time:
                " . now(),

                        function ($message) use ($user) {

                            $message->to($user->email)
                                ->subject('Suspicious Login Alert');
                        }
                    );
            }

                // 🔥 UPDATE LOGIN DETAILS
                $user->update([

                    'last_login_browser' => $currentBrowser,

                    'last_login_ip' => $currentIp,

                    'last_login_city' => $currentCity,

                    'last_login_at' => now()

                ]);

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
        $user->otp_expires_at = now()->addSeconds(60);
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
        $user->reset_token_expires_at = now()->addMinutes(5);
        $user->save();

        $link = url('/reset-password/' . $token);

        // Mail::raw("Click here to reset password: $link", function ($message) use ($user) {
        //     $message->to($user->email)
        //             ->subject('Reset Password');
        // });

        Mail::send([], [], function ($message) use ($user, $link) {

            $message->to($user->email)
                ->subject('🔐 Secure Password Reset')
                ->html('

                <div style="
                    padding:40px 20px;
                    font-family:Arial,sans-serif;
                ">

                    <div style="
                        max-width:540px;
                        margin:auto;

                        background:linear-gradient(
                            145deg,
                            rgba(15,23,42,0.98),
                            rgba(2,6,23,0.95)
                        );

                        border-radius:30px;
                        overflow:hidden;

                        border:1px solid rgba(34,211,238,0.22);

                        box-shadow:
                            0 25px 80px rgba(0,0,0,0.7);
                    ">

                        <!-- TOP BAR -->
                        <div style="
                            height:5px;

                            background:linear-gradient(
                                90deg,
                                #06b6d4,
                                #3b82f6
                            );
                        "></div>

                        <div style="
                            padding:40px;
                            color:white;
                        ">

                            <!-- ICON -->
                            <div style="text-align:center;">

                                <div style="
                                    width:82px;
                                    height:82px;
                                    margin:auto;

                                    border-radius:50%;

                                    background:rgba(34,211,238,0.10);

                                    border:1px solid rgba(34,211,238,0.35);

                                    display:flex;
                                    align-items:center;
                                    justify-content:center;

                                    font-size:36px;

                                    box-shadow:
                                        0 0 35px rgba(34,211,238,0.25);
                                ">
                                    🔐
                                </div>

                            </div>

                            <!-- TITLE -->
                            <h2 style="
                                text-align:center;
                                margin-top:24px;
                                margin-bottom:10px;

                                font-size:28px;
                                font-weight:700;

                                letter-spacing:0.5px;
                            ">
                                Reset Your Password
                            </h2>

                            <!-- TEXT -->
                            <p style="
                                text-align:center;
                                color:#cbd5e1;
                                font-size:14px;
                                line-height:25px;
                            ">
                                We received a secure request to reset your account password.
                                Click the button below to continue.
                            </p>

                            <!-- BUTTON -->
                            <div style="
                                text-align:center;
                                margin:38px 0;
                            ">

                                <a href="'.$link.'" style="
                                    display:inline-block;

                                    padding:16px 34px;

                                    border-radius:18px;

                                    background:linear-gradient(
                                        90deg,
                                        #06b6d4,
                                        #3b82f6
                                    );

                                    color:white;

                                    text-decoration:none;

                                    font-size:15px;
                                    font-weight:700;
                                    letter-spacing:0.5px;

                                    box-shadow:
                                        0 10px 30px rgba(34,211,238,0.35);
                                ">
                                    Reset Password →
                                </a>

                            </div>

                            <!-- EXPIRY -->
                            <div style="
                                text-align:center;
                                color:#facc15;
                                font-size:13px;
                                margin-top:-10px;
                            ">
                                ⏳ This secure link expires in 5 minutes
                            </div>

                            <!-- SECURITY -->
                            <div style="
                                margin-top:32px;

                                background:rgba(255,255,255,0.04);

                                border:1px solid rgba(255,255,255,0.06);

                                border-radius:18px;

                                padding:18px;
                            ">

                                <div style="
                                    color:#22d3ee;
                                    font-size:13px;
                                    font-weight:700;
                                    margin-bottom:8px;
                                ">
                                    SECURITY NOTICE
                                </div>

                                <div style="
                                    color:#cbd5e1;
                                    font-size:13px;
                                    line-height:22px;
                                ">
                                    If you did not request a password reset,
                                    please ignore this email immediately.
                                    Your account remains secure.
                                </div>

                            </div>

                            <!-- FOOTER -->
                            <div style="
                                margin-top:34px;

                                text-align:center;

                                color:#94a3b8;

                                font-size:12px;
                                line-height:22px;
                            ">
                                © '.date('Y').' Secure Banking System<br>
                                End-to-End Encrypted Security
                            </div>

                        </div>

                    </div>

                </div>

                ');
        });

        return back()->with('success', 'Reset link sent to email');
    }

    public function showResetForm($token)
    {
        $user = User::where('reset_token', $token)->first();

        if (!$user || now()->gt($user->reset_token_expires_at)) {
            return view('authentication.link-expired');
        }

        // ⏰ expiry format
        $expiresAt = \Carbon\Carbon::parse($user->reset_token_expires_at)
                        ->format('d M Y • h:i A');

        return view('authentication.reset-password', compact(
            'token',
            'expiresAt'
        ));
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
