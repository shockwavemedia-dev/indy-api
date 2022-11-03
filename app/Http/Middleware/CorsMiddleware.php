<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

final class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     */
    public function handle($request, Closure $next)
    {
        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'HEAD, GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept')
            ->header('Access-Control-Expose-Headers', 'Content-Type, Authorization, Accept');
    }
}
