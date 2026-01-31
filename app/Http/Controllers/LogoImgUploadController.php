<?php

namespace App\Http\Controllers;

use App\Models\logo_letterhead_img_uploads;
use App\Models\LogoImgUpload;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
class LogoImgUploadController extends Controller
{

    public function index()
{
    // 🔹 Get Super Admin user (role_id = 1)
    $superAdmin = User::where('role_id', 1)->first();

    $logo = null;
    $letterhead = null;

    if ($superAdmin) {
        $logo = logo_letterhead_img_uploads::where('type', 'logo')
            ->where('uploaded_by', $superAdmin->id)
            ->latest()
            ->first();

        $letterhead = logo_letterhead_img_uploads::where('type', 'letterhead')
            ->where('uploaded_by', $superAdmin->id)
            ->latest()
            ->first();
    }

    return view('pdf-images.index', compact('logo', 'letterhead'));
}



public function store(Request $request)
{
    if (!auth()->user()?->isSuperAdmin()) {
        abort(403, 'Only Super Admin can upload images.');
    }

    $request->validate([
        'type'  => 'required|in:logo,letterhead',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $file = $request->file('image');

    // Keep SAME filename pattern (so path updates cleanly)
    $filename = $request->type . '_' . auth()->id() . '.' . $file->getClientOriginalExtension();
    $path = 'admin_imgs/' . $filename;

    // Check if record already exists
    $record = logo_letterhead_img_uploads::where('type', $request->type)
        ->where('uploaded_by', auth()->id())
        ->first();

    if ($record) {
        // Delete old file if exists
        if (Storage::disk('public')->exists($record->image_path)) {
            Storage::disk('public')->delete($record->image_path);
        }

        // Store new file
        $file->storeAs('admin_imgs', $filename, 'public');

        // Update same row (ID remains same)
        $record->update([
            'image_path' => $path,
        ]);

    } else {
        // First time upload → create row
        $file->storeAs('admin_imgs', $filename, 'public');

        logo_letterhead_img_uploads::create([
            'type'        => $request->type,
            'image_path'  => $path,
            'uploaded_by' => auth()->id(),
        ]);
    }

    return back()->with('success', ucfirst($request->type) . ' updated successfully.');
}

// public function store(Request $request)
// {
//     Log::info('Image upload request received', [
//         'user_id' => auth()->id(),
//         'payload' => $request->except('image'),
//     ]);

//     if (!auth()->user()?->isSuperAdmin()) {
//         Log::warning('Unauthorized image upload attempt', [
//             'user_id' => auth()->id(),
//         ]);
//         abort(403, 'Only Super Admin can upload images.');
//     }

//     $request->validate([
//         'type'  => 'required|in:logo,letterhead',
//         'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
//     ]);

//     Log::info('Image upload validation passed', [
//         'type' => $request->type,
//     ]);

//     // 🔥 Delete old image (same type, same super admin)
//     $existing = logo_letterhead_img_uploads::where('type', $request->type)
//         ->where('uploaded_by', auth()->id())
//         ->first();

//     if ($existing) {
//         Log::info('Existing image found, deleting', [
//             'existing_image_path' => $existing->image_path,
//         ]);

//         Storage::disk('public')->delete($existing->image_path);
//         $existing->delete();
//     } else {
//         Log::info('No existing image found for this type');
//     }

//     // ✅ Store image using Laravel Storage
//     $path = $request->file('image')->store(
//         'admin_imgs',
//         'public'
//     );

//     Log::info('New image stored successfully', [
//         'stored_path' => $path,
//     ]);

//     logo_letterhead_img_uploads::create([
//         'type'        => $request->type,
//         'image_path'  => $path,
//         'uploaded_by' => auth()->id(),
//     ]);

//     Log::info('Image record saved to database', [
//         'type'       => $request->type,
//         'image_path' => $path,
//         'user_id'    => auth()->id(),
//     ]);

//     return back()->with('success', ucfirst($request->type) . ' updated successfully.');
// }

}
