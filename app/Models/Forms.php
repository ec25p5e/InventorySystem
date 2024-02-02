<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forms extends Model
{
    use HasFactory;

    // Tabella associata al modello
    protected $table = 'forms';

    protected $fillable = [
        'form_code',
        'form_name',
        'form_description',
        'unity_id',
        'created_by',
        'updated_by'
    ];
}
