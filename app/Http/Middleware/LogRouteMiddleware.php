<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRouteMiddleware
{
    public function handle($request, Closure $next)
    {
        Log::info('Route accessed: ' . $request->method() . ' ' . $request->url());

        return $next($request);
    }
}
