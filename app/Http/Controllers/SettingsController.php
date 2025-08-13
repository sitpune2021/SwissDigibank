<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Needed for Auth::user()
use Illuminate\Support\Facades\Hash;


class SettingsController extends Controller
{
    public function profile()
    {
        return view('settings.profile');
    }

    public function security()
    {
        return view('settings.security');
    }

    public function updatePassword(Request $request)
    {
        try {
            $request->validate([
                'old_password' => ['required'],
                'new_password' => [
                    'required',
                    'min:8',
                    'confirmed', // This checks new_password_confirmation
                    'regex:/[a-z]/',         // at least one lowercase
                    'regex:/[A-Z]/',         // at least one uppercase
                    'regex:/[0-9]/',         // at least one digit
                    'regex:/[@$!%*#?&]/',    // at least one special character
                ],
            ]);

            $user = Auth::user();

            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'Old password is incorrect.']);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return back()->with('success', 'Password updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
        } catch (\Throwable $e) {
            abort(500);
        }
    }


    public function socialNetwork()
    {
        return view('settings.social-network');
    }

    public function notification()
    {
        return view('settings.notification');
    }

    public function paymentLimit()
    {
        return view('settings.payment-limit');
    }
}
