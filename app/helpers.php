<?php

use App\Models\Settings;
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

        $user = User::where('id', $userId)->value('first_name') . ' ' . User::where('id', $userId)->value('last_name');
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
            ->count();

        return $roles;
    }
}
