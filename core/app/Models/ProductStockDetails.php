<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockDetails extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product_stock_details()
    {
        return $this->belongsTo(ProductStock::class, 'product_stock_id', 'id');
    }
    public function products()
    {
        return $this->belongsTo(ProductName::class, 'product_id', 'id');
    }

    public static function updateProductStockDetailsData($request)
    {
        $product_stock = ProductStockDetails::find($request->id);
        $product_stock->name = $request->name;
        $product_stock->stock = $request->stock;
        $product_stock->type = $request->type;
        $product_stock->price = $request->price;
        $product_stock->date = $request->date;
        $product_stock->warranty_date = $request->warranty_date;
        $product_stock->save();
    }
    public static function deleteProductStockDetailsData($request){
        $product_stock = ProductStockDetails::find($request->id);
        $product_stock->delete();
    }
}
