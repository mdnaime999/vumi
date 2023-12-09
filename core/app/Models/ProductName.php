<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductName extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product_stocks(){
        return $this->hasMany(ProductStockDetails::class, 'product_id', 'id');
    }
}
