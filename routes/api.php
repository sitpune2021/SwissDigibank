<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\MemberController;
use App\Http\Controllers\Api\AccountController;

// login and logout route
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


//member  api route
Route::get('members/{id}', [MemberController::class, 'fetchMemberDetails']);

//Account 
Route::get('account/{id}', [AccountController::class, 'fetchAccountInfo']);


