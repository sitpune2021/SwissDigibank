<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Models\Member;
// Admin register api
Route::post('/register', [AuthenticationController::class, 'register']);
Route::get('/my-api/{id}', function ($id) {
    $member = Member::findOrFail($id);

    return response()->json([
        'status' => true,
        'message' => 'data retrive suu',
        'data' => $member
    ]);
});
