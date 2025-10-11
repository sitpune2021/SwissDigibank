<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ApiTransactionController;

// login and logout route
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']); 
// Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::get('/test-send-otp', [AuthController::class, 'testSendOtp']);
Route::prefix('accounts')->group(function () {
    Route::get('{account}/transactions', [ApiTransactionController::class, 'transactionHistory']);
    Route::get('{account}/passbook', [ApiTransactionController::class, 'viewPassbook']);
});

//member  api route
// Route::get('members/{id}', [MemberController::class, 'fetchMemberDetails']);
Route::get('members/profile', [MemberController::class, 'fetchMemberDetails'])->middleware('auth:api');

//Account 
Route::get('account/{id}', [AccountController::class, 'fetchAccountInfo']);


