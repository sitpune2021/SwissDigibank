<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


// Route::post('/register', [AuthenticationController::class, 'register']);
// Route::get('/my-api/{id}', function ($id) {
//     $member = Member::findOrFail($id);

//     return response()->json([
//         'status' => true,
//         'message' => 'data retrive suu',
//         'data' => $member
//     ]);
// });
