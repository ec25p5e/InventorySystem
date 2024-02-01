<?php

namespace App\Http\Middleware;

use App\Models\Logs;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckRoleMiddleware {
    public function handle($request, Closure $next, $role)
    {
        if (
            auth()->check() &&
            ($this->getUserRoles(Auth::id(), $role) > 0 ||
                $this->getUserRoles(Auth::id(), $role) > 0)) {

            Logs::create([
                'log_type' => 'CHECK_ROLE_MIDDLEWARE',
                'method' => $request->method(),
                'uri' => $request->url(),
                'message' => 'ACCESS_GRANTED',
                'user_id' => Auth::id(),
                'app_mode' => env('APP_ENV')
            ]);

            return $next($request);
        }

        Logs::create([
            'log_type' => 'CHECK_ROLE_MIDDLEWARE',
            'method' => $request->method(),
            'uri' => $request->url(),
            'message' => 'ACCESSD_DENIED',
            'user_id' => Auth::id(),
            'app_mode' => env('APP_ENV')
        ]);

        return response()->view('errors.403', [], 403);
    }


    private function getUserRoles($userId, $roleMatch) {
        $roles = DB::table('users as u')
            ->join('user_roles as ur', 'ur.user_id', '=', 'u.id')
            ->join('roles as r', 'r.id', '=', 'ur.role_id')
            ->where('u.id', $userId)
            ->where('r.role_code', 'LIKE', '%'. $roleMatch . '%')
            ->where('ur.is_primary', '=', 1)
            ->count();

        return $roles;
    }
}

