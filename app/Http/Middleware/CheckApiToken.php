<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class CheckApiToken
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();
        if (!$token || !Cache::has('api_token_' . $token)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
