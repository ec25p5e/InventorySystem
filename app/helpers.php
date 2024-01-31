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

if (!function_exists('formatDatePortal')) {
    function formatDatePortal($date)
    {
        if($date != null) {
            return Carbon::parse($date)->format('d.m.Y');
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

if(!function_exists('checkPrimaryRole')) {
    function checkPrimaryRole($userId, $roleCode) {
        $role = DB::table('user_roles as ur')
            ->join('roles as r', 'r.id', '=', 'ur.role_id')
            ->join('users as u', 'u.unity_id', '=', 'ur.unity_id')
            ->where('ur.user_id', $userId)
            ->where('ur.is_primary', 1)
            ->where('r.role_code', $roleCode)
            ->count();

        return $role;
    }
}

if(!function_exists('getPrimaryRoleForUnity')) {
    function getPrimaryRoleForUnity($userId) {
        $role = DB::table('user_roles as ur')
            ->join('roles as r', 'r.id', '=', 'ur.role_id')
            ->join('users as u', 'u.unity_id', '=', 'ur.unity_id')
            ->where('ur.user_id', $userId)
            ->where('ur.is_primary', 1)
            ->select('r.role_name')
            ->first();

        return ($role) ? $role->role_name : "";
    }
}

if(!function_exists('getRoute')) {
    function getRoute($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.route_name')
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1)
                    ->whereRaw('ur.unity_id = rc.unity_id');
            })
            ->first();

        return ($routeValue) ? $routeValue->route_name : "";
    }
}

if(!function_exists('getRouteUri')) {
    function getRouteUri($userId, $route) {
        $routeValue = DB::table('routes_conf as rc')
            ->select('rc.route_uri')
            ->where('rc.route_code', $route)
            ->where('rc.unity_id', function ($query) use ($userId) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', $userId);
            })
            ->where('rc.role_id', function ($query) use ($userId) {
                $query->select('ur.role_id')
                    ->from('user_roles as ur')
                    ->where('ur.user_id', $userId)
                    ->where('ur.is_primary', 1)
                    ->whereRaw('ur.unity_id = rc.unity_id');
            })
            ->first();

        return ($routeValue) ? $routeValue->route_uri : "";
    }
}

if(!function_exists('getUserUnities')) {
    function getUserUnities($userId) {
        $unities = DB::table('user_roles as ur')
            ->select('u.id', 'u.unity_code', 'u.unity_name')
            ->join('unities as u', 'u.id', '=', 'ur.unity_id')
            ->where('ur.user_id', $userId)
            ->where('ur.is_primary', 1)
            ->whereNotIn('ur.unity_id', function ($query) {
                $query->select('u.unity_id')
                    ->from('users as u')
                    ->where('u.id', 1);
            })
            ->get();

        return ($unities) ? $unities : "";
    }
}

if(!function_exists('getCurrentUnityForUser')) {
    function getCurrentUnityForUser($userId) {
        $unityName = User::select('unities.unity_name')
            ->join('unities', 'unities.id', '=', 'users.unity_id')
            ->where('users.id', $userId)
            ->first();

        return ($unityName) ? $unityName->unity_name : "";
    }
}
