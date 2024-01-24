<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    // Tabella associata al modello
    protected $table = 'products';

    protected $fillable = [
        'product_num_ceap',
        'product_num_intern',
        'product_name',
        'product_start',
        'product_end',
        'product_image'
    ];

    // Relazioni
    public function product_attributes() {
        return $this->hasMany(ProductAttributes::class);
    }
}
