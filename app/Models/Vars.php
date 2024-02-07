<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vars extends Model
{
    use HasFactory;

    protected $table = 'vars';

    protected $fillable = [
        'command_code',
        'command_name',
        'command_description',
        'command_signature',
        'command_options',
        'command_body',
        'command_unity_ref',
        'command_user_ref',
        'command_date_start',
        'command_date_end'
    ];
}
