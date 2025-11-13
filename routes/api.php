<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\ApiTransactionController;
use App\Http\Controllers\Api\SimVerificationController;
use App\Http\Controllers\Api\ForgotLoginPasswordController;
use App\Http\Controllers\Api\TabController;

// login and logout route
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/send-otp', [AuthController::class, 'sendOtpSms']);
Route::post('/request-mpin-otp', [AuthController::class, 'requestMpinOtp']);
Route::post('/verify-mpin-otp', [AuthController::class, 'verifympinOtp']);
Route::post('/set-mpin', [AuthController::class, 'setOrResetMpin']);
Route::post('/check-mpin-status', [AuthController::class, 'checkMpinStatus']);
Route::get('/tabs', [TabController::class, 'getTabs']);


Route::post('/sim/request', [SimVerificationController::class, 'requestOtp']);
Route::post('/sim/verify', [SimVerificationController::class, 'verifyOtp']);
Route::post('/password/forgot', [ForgotLoginPasswordController::class, 'sendOtp']);
Route::post('/password/verify-otp', [ForgotLoginPasswordController::class, 'verifyOtp']);
Route::post('/password/reset', [ForgotLoginPasswordController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->prefix('accounts')->group(function () {
    Route::get('balance', [ApiTransactionController::class, 'getBalance']);
    Route::get('transactions', [ApiTransactionController::class, 'transactionHistory']);
    Route::get('/transactions/filter', [ApiTransactionController::class, 'filterTransactions']);
});

Route::middleware('auth:sanctum')->get('members/details', [MemberController::class, 'fetchMemberDetails']);
Route::middleware('auth:sanctum')->get('account/details', [AccountController::class, 'fetchAccountInfo']);
