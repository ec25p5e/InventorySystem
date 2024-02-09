<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportModelColumns extends Model
{
    use HasFactory;

    // Tabella associata al modello
    protected $table = 'report_model_columns';

    protected $fillable = [
        'report_id',
        'command_id',
        'column_name',
        'column_position',
        'column_signature',
    ];
}
