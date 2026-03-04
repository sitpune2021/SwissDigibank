<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

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

    public function login(Request $request)
    {
        try {
            $request->validate([
                'login' => 'required',
                'password' => 'required',
            ]);

            $loginInput = trim($request->login);
            $password = $request->password;

            $field = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'mobile';
            if ($field === 'mobile') {
                $loginInput = preg_replace('/\D/', '', $loginInput); // keep only digits
                if (str_starts_with($loginInput, '91') && strlen($loginInput) > 10) {
                    $loginInput = substr($loginInput, -10);
                }
            }

            $user = User::where($field, $loginInput)->first();
            if (!$user) {
                return back()->with('error', ucfirst($field) . ' not found')->withInput();
            }

            if (!Hash::check($password, $user->password)) {
                return back()->with('error', 'Incorrect password')->withInput();
            }

            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('success', 'Login successful');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
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
