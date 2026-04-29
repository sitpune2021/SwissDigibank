<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Mail;


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
    $request->validate([
    'login' => 'required',
    'password' => 'required'
    ]);

    // Email ya mobile se login
    $user = User::where('email', $request->login)
    ->orWhere('mobile', $request->login)
    ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
    return back()->withErrors(['login' => 'Invalid credentials']);
    }

    // ✅ OTP GENERATE
    $user->otp = rand(1000, 9999);
    $user->otp_verified = 0;
    $user->otp_expires_at = now()->addMinutes(1);
    $user->save();

    // ✅ MAIL SEND
    Mail::raw("Your OTP is: " . $user->otp, function ($message) use ($user) {
    $message->to($user->email)
            ->subject('Login OTP');
    });

    // ❌ LOGIN MAT KARO ABHI
    // Auth::login($user); ❌ REMOVE

    // ✅ Popup trigger
   return response()->json([
    'status' => true,
    'user_id' => $user->id,
    'expires_in' => 60 // 🔥 seconds
]);
    }

    public function verifyLoginOtp(Request $request)
    {
    try {

        $request->validate([
            'user_id' => 'required',
            'otp' => 'required|digits:4'
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found']);
        }

        if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {

            // 🔥 OTP invalidate
            $user->otp = null;
            $user->save();

            return response()->json([
                'status' => false,
                'message' => 'OTP expired'
            ]);
        }

        if ($user->otp == $request->otp) {

            $user->otp_verified = 1;
            $user->otp = null; // 🔥 reuse na ho
            $user->save();

            Auth::login($user);

            return response()->json([
                'status' => true,
                'redirect' => route('index1')
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Invalid OTP'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => false,
            'message' => $e->getMessage() // 🔥 REAL ERROR
        ]);
    }
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

    // public function login(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'login' => 'required',
    //             'password' => 'required',
    //         ]);

    //         $loginInput = trim($request->login);
    //         $password = $request->password;

    //         $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
    //         if ($field === 'mobile') {
    //             $loginInput = preg_replace('/\D/', '', $loginInput); // keep only digits
    //             if (str_starts_with($loginInput, '91') && strlen($loginInput) > 10) {
    //                 $loginInput = substr($loginInput, -10);
    //             }
    //         }

    //         $user = User::where($field, $loginInput)->first();
    //         if (!$user) {
    //             return back()->with('error', ucfirst($field) . ' not found')->withInput();
    //         }

    //         if (!Hash::check($password, $user->password)) {
    //             return back()->with('error', 'Incorrect password')->withInput();
    //         }

    //         Auth::login($user);
    //         $request->session()->regenerate();
    //         // Save login log
    //         LoginLog::create([
    //             'user_id' => $user->id,
    //             'ip_address' => $request->ip(),
    //             'user_agent' => $request->userAgent(),
    //             'login_at' => now(),
    //         ]);

    //         return redirect()->intended('dashboard')->with('success', 'Login successful');
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return back()->withErrors($e->errors())->withInput();
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    //     }
    // }

     

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

    
}
