<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttributeDef extends Model
{
    use HasFactory;

    protected $table = 'user_attributes_def';

    protected $fillable = [
        'def_code',
        'def_name',
    ];
}
