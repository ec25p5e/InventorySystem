<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'notification_code',
        'notification_title',
        'notification_message',
        'user_id_ref',
        'is_checked',
    ];
}
