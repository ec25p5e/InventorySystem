<?php

namespace App\Helpers;

use App\Models\Settings;

class SettingsHelper
{
    public static function getSetting($key, $default = null){
        $setting = Settings::where('key', $key)->first();

        return $setting ? $setting->value : $default;
    }

    public static function getAllSettings(){
        return Settings::all();
    }
}
