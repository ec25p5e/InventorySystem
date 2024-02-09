<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopulationFilters extends Model
{
    use HasFactory;

    protected $table = 'population_filters';

    protected $fillable = [
        'code_ref',
        'filter_operator',
        'filter_value',
        'user_mod',
        'population_id'
    ];

    public function population()
    {
        return $this->belongsTo(Populations::class, 'population_id', 'id');
    }
}
