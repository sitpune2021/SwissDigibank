<?php

namespace App\Http\Controllers;

use App\Models\logo_letterhead_img_uploads;
use App\Models\LogoImgUpload;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
//    public function index()
// {
//     $adminId = auth()->id();

//     // Only fetch images uploaded by the current Super Admin
//     $logo = logo_letterhead_img_uploads::where('type', 'logo')
//         ->where('uploaded_by', $adminId)
//         ->first();

//     $letterhead = logo_letterhead_img_uploads::where('type', 'letterhead')
//         ->where('uploaded_by', $adminId)
//         ->first();

//     return view('pdf-images.index', compact('logo', 'letterhead'));
// }
  

    public function store(Request $request)
{
    if (!auth()->user()?->isSuperAdmin()) {
        abort(403, 'Only Super Admin can upload images.');
    }

    $request->validate([
        'type'  => 'required|in:logo,letterhead',
        'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Optional: delete previous image of this type for this Super Admin
    $existing = logo_letterhead_img_uploads::where('type', $request->type)
        ->where('uploaded_by', auth()->id())
        ->first();

    if ($existing) {
        $oldPath = public_path($existing->image_path);
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }
        $existing->delete();
    }

    // Save new image in public/assets/images/admin_imgs
    $filename = $request->type . '_' . auth()->id() . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
    $request->file('image')->move(public_path('assets/images/admin_imgs'), $filename);

    $path = 'assets/images/admin_imgs/' . $filename;

    logo_letterhead_img_uploads::create([
        'type'        => $request->type,
        'image_path'  => $path,
        'uploaded_by' => auth()->id(),
    ]);

    return back()->with('success', ucfirst($request->type) . ' updated successfully.');
}

    // public function store(Request $request)
    // {
    //     if (!auth()->user()?->isSuperAdmin()) {
    //         abort(403, 'Only Super Admin can upload images.');
    //     }

    //     $request->validate([
    //         'type' => 'required|in:logo,letterhead',
    //         'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    //     ]);

    //     // Remove existing image of same type
    //     $existing = logo_letterhead_img_uploads::where('type', $request->type)->first();
    //     // if ($existing) {
    //     //     Storage::disk('public')->delete($existing->image_path);
    //     //     $existing->delete();
    //     // }
    //     if ($existing) {
    //         $oldPath = public_path($existing->image_path);
    //         if (file_exists($oldPath)) {
    //             unlink($oldPath);
    //         }
    //         $existing->delete();
    //     }
    //      // Store new image in public/assets/images/admin_imgs
    // $filename = $request->type . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();

    // $request->file('image')->move(
    //     public_path('assets/images/admin_imgs'),
    //     $filename
    // );

    // // Save relative path in DB
    // $path = 'assets/images/admin_imgs/' . $filename;
    //     // $path = $request->file('image')->store('pdf-images', 'public');

    //     logo_letterhead_img_uploads::create([
    //         'type' => $request->type,
    //         'image_path' => $path,
    //         'uploaded_by' => auth()->id(), // REQUIRED
    //     ]);

    //     return back()->with('success', ucfirst($request->type) . ' updated successfully.');
    // }
}
