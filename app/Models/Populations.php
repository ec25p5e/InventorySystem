<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Populations extends Model
{
    use HasFactory;

    protected $table = 'populations';

    protected $fillable = [
        'population_code',
        'population_name',
        'user_id_ref',
        'user_mod',
        'unity_id'
    ];

    public function populationFilters()
    {
        return $this->hasMany(PopulationFilters::class, 'population_id', 'id');
    }
}
