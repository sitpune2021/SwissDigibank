<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * CSRF se exclude routes
     */
    protected $except = [
        'biometric/register-options',
        'biometric/register',
        'biometric/login-options',
        'biometric/login',
    ];
}