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
Route::post('/send-otp', [AuthController::class, 'sendOtpSms']);
Route::middleware('auth:sanctum')->prefix('accounts')->group(function () {
    Route::get('transactions', [ApiTransactionController::class, 'transactionHistory']);
    Route::get('passbook', [ApiTransactionController::class, 'viewPassbook']);
});

//member  api route
Route::middleware('auth:sanctum')->get('members/details', [MemberController::class, 'fetchMemberDetails']);

//Account 
Route::middleware('auth:sanctum')->get('account/details', [AccountController::class, 'fetchAccountInfo']);

