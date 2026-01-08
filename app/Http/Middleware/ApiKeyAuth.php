<?php

namespace App\Http\Middleware;

use App\Models\ApiKey;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyAuth{
     public function handle($request, Closure $next)
    {
        // $key = $request->header('X-API-KEY');
        $key = $request->header('X-API-KEY');

        if (! $key) {
            return response()->json(['message' => 'API key missing'], 401);
        }

        $hashed = hash('sha256', $key);

        $apiKey = ApiKey::where('key', $hashed)
            ->where('active', true)
            ->first();

        if (! $apiKey) {
            return response()->json(['message' => 'Invalid API key'], 401);
        }

        // Update usage time
        $apiKey->update(['last_used_at' => now()]);

        return $next($request);
    }
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle(Request $request, Closure $next): Response
//     {
//         return $next($request);
//     }
}
