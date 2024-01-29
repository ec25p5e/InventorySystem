<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unities extends Model
{
    use HasFactory;

    protected $table = 'unities';

    protected $fillable = [
        'unity_code',
        'unity_name'
    ];

}
