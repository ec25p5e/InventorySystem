<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Logs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogRouteMiddleware
{
    public function handle($request, Closure $next)
    {
        Logs::create([
            'log_type' => 'ROUTE_ACCESSED_MIDDLEWARE',
            'method' => $request->method(),
            'uri' => $request->url(),
            'message' => '',
            'user_id' => Auth::id() ?? 0,
            'app_mode' => env('APP_ENV')
        ]);

        return $next($request);
    }
}
