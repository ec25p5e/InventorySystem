<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class CustodeMiddleware {
    public function handle($request, Closure $next)
    {
        /* if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        } */

        return redirect('/')->with('error', 'You do not have permission to access this page.');
    }
}

