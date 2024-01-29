<?php

use App\Models\Settings;
use App\Models\User;
use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date)
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}

if (!function_exists('formatDateTime')) {
    function formatDateTime($date)
    {
        return Carbon::parse($date)->format('d.m.Y h:m');
    }
}

if(!function_exists('getUserById')) {
    function getUserById($userId) {

        $user = User::where('id', $userId)->value('first_name');
        return $user;
    }
}

if(!function_exists('getSettings')) {
    function getSettings($key) {

        $user = Settings::where('key', $key)->value('value');
        return $user;
    }
}
