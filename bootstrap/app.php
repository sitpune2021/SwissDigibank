<?php

use App\Http\Middleware\ApiKeyAuth;
use App\Http\Middleware\SessionProtection;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use App\Http\Middleware\WhitelistIp;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->append(RedirectIfAuthenticated::class);
        

         // 🔥 CSRF EXCLUDE (MAIN FIX)
        $middleware->validateCsrfTokens(except: [
            'biometric/register-options',
            'biometric/register',
            'biometric/login-options',
            'biometric/login',
        ]);

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'check.permission' => \App\Http\Middleware\CheckPermission::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'auth.user' => \App\Http\Middleware\AuthenticateUser::class,
            'whitelist.ip' => WhitelistIp::class,
             'api.key' => ApiKeyAuth::class,
        ]);
        // $middleware->push(\App\Http\Middleware\CheckCustomHeader::class);
    
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
