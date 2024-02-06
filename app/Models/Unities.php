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

    public function parent()
    {
        return $this->belongsTo(Unities::class, 'unity_ref_id');
    }

    public function childrenRecursive()
    {
        return $this->hasMany(Unities::class, 'unity_ref_id')->with('childrenRecursive');
    }
}
