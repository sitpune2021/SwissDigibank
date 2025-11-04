<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ApiTransactionController;
use App\Http\Controllers\Api\SimVerificationController;
use App\Http\Controllers\Api\ForgotLoginPasswordController;

// login and logout route
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->middleware('auth:sanctum');
Route::post('/send-otp', [AuthController::class, 'sendOtpSms'])->middleware('auth:sanctum');
Route::post('/request-mpin-otp', [AuthController::class, 'requestMpinOtp'])->middleware('auth:sanctum');
Route::post('/verify-mpin-otp', [AuthController::class, 'verifympinOtp'])->middleware('auth:sanctum');
Route::post('/set-mpin', [AuthController::class, 'setOrResetMpin'])->middleware('auth:sanctum');
// Route::post('/check-mpin-status', [AuthController::class, 'checkMpinStatus']);
Route::post('/check-mpin-status', [AuthController::class, 'checkMpinStatus'])->middleware('auth:sanctum');

Route::post('/sim/request', [SimVerificationController::class, 'requestOtp'])->middleware('auth:sanctum');
Route::post('/sim/verify', [SimVerificationController::class, 'verifyOtp'])->middleware('auth:sanctum');
Route::post('/password/forgot', [ForgotLoginPasswordController::class, 'sendOtp'])->middleware('auth:sanctum');
Route::post('/password/verify-otp', [ForgotLoginPasswordController::class, 'verifyOtp'])->middleware('auth:sanctum');
Route::post('/password/reset', [ForgotLoginPasswordController::class, 'resetPassword'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('accounts')->group(function () {
    Route::get('transactions', [ApiTransactionController::class, 'transactionHistory']);
    Route::get('passbook', [ApiTransactionController::class, 'viewPassbook']);
    Route::get('balance', [ApiTransactionController::class, 'getBalance']); 
});

//member  api route
Route::middleware('auth:sanctum')->get('members/details', [MemberController::class, 'fetchMemberDetails']);
//Account 
Route::middleware('auth:sanctum')->get('account/details', [AccountController::class, 'fetchAccountInfo']);
