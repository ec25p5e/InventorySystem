<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronJob extends Model
{
    use HasFactory;

    protected $table = 'cron_jobs';

    protected $fillable = [
        'name',
        'command',
        'schedule',
        'is_active'
    ];
}
