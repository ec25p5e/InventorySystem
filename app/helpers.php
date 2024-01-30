<?php

use App\Models\Settings;
use App\Models\Unities;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        if($date != null) {
            return Carbon::parse($date)->format('Y-m-d');
        }

        return '';
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date)
    {
        if($date != null) {
            return Carbon::parse($date)->format('d.m.Y H:i');
        }

        return '';
    }
}

if(!function_exists('getUserById')) {
    function getUserById($userId) {

        $user = User::where('id', $userId)->value('username');
        return $user;
    }
}

if(!function_exists('getSettings')) {
    function getSettings($key) {

        $user = Settings::where('key', $key)->value('value');
        return $user;
    }
}


if(!function_exists('getUserRoles')) {
    function getUserRoles($userId, $roleMatch) {
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

if(!function_exists('hasRole')) {
    function hasRole($userId, $roleMatch) {
        $roles = DB::table('users as u')
            ->join('user_roles as ur', 'ur.user_id', '=', 'u.id')
            ->join('roles as r', 'r.id', '=', 'ur.role_id')
            ->where('u.id', $userId)
            ->where('r.role_code', '=', $roleMatch)
            ->count();

        return $roles;
    }
}

if(!function_exists('getPrimaryRole')) {
    function getPrimaryRole($userId) {
        $roleName = DB::table('user_roles as ur')
            ->join('roles as r', 'r.id', '=', 'ur.role_id')
            ->where('ur.user_id', $userId)
            ->where('ur.is_primary', 1)
            ->select('r.role_name')
            ->first();

        return $roleName;
    }
}

if(!function_exists('getRoute')) {
    function getRoute($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.route_name')
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1);
            })
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->first();

        return ($routeValue) ? $routeValue->route_name : "";
    }
}

if(!function_exists('getRouteUri')) {
    function getRouteUri($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.route_uri')
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1);
            })
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->first();

        return ($routeValue) ? $routeValue->route_uri : "";
    }
}

if(!function_exists('getRouteController')) {
    function getRouteController($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.route_uri')
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1);
            })
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->first();

        return ($routeValue) ? $routeValue->route_controller : "";
    }
}

if(!function_exists('getRouteMethod')) {
    function getRouteMethod($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.route_controller')
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1);
            })
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->first();

        return ($routeValue) ? $routeValue->route_method : "";
    }
}

if(!function_exists('getRouteMiddleware')) {
    function getRouteMiddleware($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.route_middleware')
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1);
            })
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->first();

        return ($routeValue) ? $routeValue->route_middleware : "";
    }
}

if(!function_exists('getControllerMethod')) {
    function getControllerMethod($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.controller_method')
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1);
            })
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->first();

        return ($routeValue) ? $routeValue->controller_method : "";
    }
}
