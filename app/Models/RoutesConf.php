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
        'route_parent_id',
        'order',
    ];

    public function parent()
    {
        return $this->belongsTo(RoutesConf::class, 'route_parent_id');
    }

    public function children()
    {
        return $this->hasMany(RoutesConf::class, 'route_parent_id')->with('children');
    }
}
