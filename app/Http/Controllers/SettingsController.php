<?php

namespace App\Http\Controllers;

use App\Models\ProfilePhoto;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Needed for Auth::user()
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
class SettingsController extends Controller
{
    public function profile()
    {
         $user = Auth::user(); // fetch currently logged-in user
        return view('settings.profile', compact('user'));
    }
    
     public function change_password()
    {
       
        return view('settings.change-password');
    }

   public function updatePasswordFromProfile(Request $request)
{
    // Call the existing method
    $response = $this->updatePassword($request);

    // If validation failed or old password wrong,
    // Laravel already redirected back with errors.
    if ($response instanceof \Illuminate\Http\RedirectResponse && session()->has('errors')) {
        return $response;
    }

    // If success, redirect to profile page instead
    return redirect()->route('settings.profile')
        ->with('success', 'Password updated successfully.');
}

public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Get existing record
        $profilePhoto = ProfilePhoto::where('user_id', $user->id)->first();

        // Delete old image file if exists
        if ($profilePhoto && Storage::disk('public')->exists('profile_photos/' . $profilePhoto->filename)) {
            Storage::disk('public')->delete('profile_photos/' . $profilePhoto->filename);
        }

        // Store new file
        $filename = time() . '.' . $request->photo->extension();
        $request->photo->storeAs('profile_photos', $filename, 'public');

        if ($profilePhoto) {
            // Update same row (ID does not change)
            $profilePhoto->filename = $filename;
            $profilePhoto->save();
        } else {
            // Create first record
            ProfilePhoto::create([
                'user_id' => $user->id,
                'filename' => $filename,
            ]);
        }

        return back()->with('success', 'Profile photo updated successfully.');
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
             Log::info('Password updated successfully', [
                'user_id' => $user->id,
                'email' => $user->email,
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Password updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404);
            Log::error('Password update error', [
                'user_id' => Auth::id(),
                'exception' => $e->getMessage(),
            ]);
             return back()->withErrors(['new_password' => 'Something went wrong. Please try again.']);
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
