<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;

// Admin register api
Route::post('/register', [AuthenticationController::class, 'register']);

?>
