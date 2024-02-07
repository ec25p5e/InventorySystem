<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoutesConf extends Model
{
    use HasFactory;

    protected $table = 'routes_conf';

    protected $fillable = [
        'role_id',
        'unity_id',
        'route_code',
        'route_text',
        'route_name',
        'route_uri',
        'route_method',
        'route_controller',
        'controller_method',
        'route_middleware',
        'is_menu',
    ];
}
