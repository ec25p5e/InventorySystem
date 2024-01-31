<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttributes extends Model
{
    use HasFactory;

    protected $table = 'user_attributes';

    protected $fillable = [
        'attribute_code',
        'attribute_name',
        'attribute_value',
        'attribute_hidden',
        'attribute_unique',
        'attribute_log',
        'attribute_date_start',
        'attribute_date_end',
        'user_id',
        'user_mod',
    ];
}
