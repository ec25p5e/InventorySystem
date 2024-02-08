<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModels extends Model
{
    use HasFactory;

    // Tabella associata al modello
    protected $table = 'report_models';

    protected $fillable = [
        'unity_id',
        'user_id',
        'report_name',
        'report_description',
    ];
}
