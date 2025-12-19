<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionProtection
{
    public function handle(Request $request, Closure $next)
    {
        // -----------------------------
        // Auto logout after inactivity
        // -----------------------------
        if (Auth::check()) {
            $timeout = config('session.lifetime') * 60; // minutes → seconds
            $lastActivity = session('last_activity_time', time());

            if ((time() - $lastActivity) > $timeout) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('sign.in')
                    ->with('session_expired', 'You have been logged out due to inactivity.');
            }

            // Update last activity time
            session(['last_activity_time' => time()]);
        }

        // Continue request
        $response = $next($request);

        // -----------------------------
        // Prevent browser caching
        // -----------------------------
        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
