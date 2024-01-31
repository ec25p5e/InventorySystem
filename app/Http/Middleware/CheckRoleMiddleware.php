<?php

namespace App\Http\Middleware;

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
            return $next($request);
        }

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

