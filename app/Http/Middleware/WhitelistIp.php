<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WhitelistIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */


    public function handle($request, Closure $next)
    {
        $allowedIps = [
            '127.0.0.1',
            // akash .4
            '192.168.1.4',
            // shrutika .36
            '192.168.1.36', 

        ];

        if (!in_array($request->ip(), $allowedIps)) {
            abort(403, 'Unauthorized IP address');
        }

        return $next($request);
    }

    // public function handle(Request $request, Closure $next): Response
    // {


    //     return $next($request);
    // }
}
