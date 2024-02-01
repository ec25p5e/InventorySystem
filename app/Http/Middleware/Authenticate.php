<?php

namespace App\Http\Middleware;

use App\Models\Logs;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            Logs::create([
                'log_type' => 'AUTHENTICATE_MIDDLEWARE',
                'method' => $request->method(),
                'uri' => $request->url(),
                'user_id' => Auth::id(),
                'app_mode' => env('APP_ENV')
            ]);

            return route('login');
        }
    }
}
