<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory;

    // Tabella associata al modello
    protected $table = 'product_attributes';

    // Indica i campi riempibili massivamente
    protected $fillable = [
        'attribute_code',
        'attribute_name',
        'attribute_value',
        'attribute_hidden',
        'attribute_unique',
        'attribute_log',
        'attribute_date_start',
        'attribute_date_end',
        'product_ref_id',
        'user_id'
    ];

    // Relazione tra attributo e prodotto
    public function product(){
        return $this->belongsTo(Products::class);
    }
}
