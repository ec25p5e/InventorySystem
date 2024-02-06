<?php

use App\Models\Notifications;
use App\Models\ProductAttributesDef;
use App\Models\Roles;
use App\Models\RoutesConf;
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

        return ($role) ? $role->role_name : "null";
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

        return ($routeValue) ? $routeValue->route_name : "null";
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

        return ($routeValue) ? $routeValue->route_uri : null;
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

        return ($unities) ? $unities : null;
    }
}

if(!function_exists('getCurrentUnityForUser')) {
    function getCurrentUnityForUser($userId) {
        $unityName = User::select('unities.unity_name')
            ->join('unities', 'unities.id', '=', 'users.unity_id')
            ->where('users.id', $userId)
            ->first();

        return ($unityName) ? $unityName->unity_name : null;
    }
}

if(!function_exists('getUnityName')) {
    function getUnityName($unityId) {
        $unity = Unities::find($unityId);

        return ($unity) ? $unity->unity_name : null;
    }
}

if(!function_exists('getUnityCode')) {
    function getUnityCode($unityId) {
        $unity = Unities::find($unityId);

        return ($unity) ? $unity->unity_code : null;
    }
}

if(!function_exists('getRoleName')) {
    function getRoleName($roleId) {
        $role = Roles::find($roleId);

        return ($role) ? $role->role_name : null;
    }
}

if(!function_exists('getRouteCode')) {
    function getRouteCode($routeId) {
        $route = RoutesConf::find($routeId);

        return ($route) ? $route->route_code : null;
    }
}

if(!function_exists('getNotifications')) {
    function getNotifications($userId) {
        $notifications = Notifications::where('user_id_ref', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return ($notifications) ? $notifications : null;
    }
}

if(!function_exists('getAttributeName')) {
    function getAttributeName($defId)
    {
        $attributeDef = ProductAttributesDef::where('id', $defId)->first();

        return $attributeDef ? $attributeDef->def_name : null;
    }
}

if(!function_exists('getAttributeIdByCode')) {
    function getAttributeIdByCode($code)
    {
        $attributeDef = ProductAttributesDef::where('def_code', $code)->first();

        return $attributeDef ? $attributeDef->id : null;
    }
}
