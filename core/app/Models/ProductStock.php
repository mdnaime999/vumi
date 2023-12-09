<?php

namespace App\Models;

use App\Libraries\Encryption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ports(){
        return $this->belongsTo(Port::class, 'port_id', 'id');
    }

    public static function saveProductStockData($request)
    {
        $product_stock = ProductStock::create([
            'port_id' => $request->port_id,
            'tender_type' => $request->tender_type,
            'tender_number' => $request->tender_number,
            'asset_type' => $request->asset_type,
            'total_price' => $request->total_price,
            'all_date' => $request->all_date,
        ]);
        if ($request->name && is_array($request->name)) {
            foreach ($request->name as $key => $value) {
                if ($request->asset_type == 1) {
                    ProductStockDetails::create([
                        'product_stock_id' => $product_stock->id,
                        'name' => $request->name[$key],
                        'stock' => $request->stock[$key],
                        'type' => $request->type[$key],
                        'price' => $request->price[$key],
                        'date' => $request->date[$key],
                        'warranty_date' => $request->warranty_date[$key],
                    ]);
                    
                } elseif ($request->asset_type == 2) {
                    ProductStockDetails::create([
                        'product_stock_id' => $product_stock->id,
                        'name' => $request->name[$key],
                        'stock' => $request->stock[$key],
                        'type' => $request->type[$key],
                        'price' => $request->price[$key],
                        'date' => $request->date2[$key],
                    ]);
                    
                }
            }
        }
    }
    public static function updateProductStockdata($request)
    {
        $id = Encryption::decodeId($request->id);
        $news = ProductStock::find($id);
        $news->name = $request->name;
        $news->stock = $request->stock;
        $news->type = $request->type;
        $news->status = $request->status;
        $news->save();
    }

    public static function deleteProductStockData($request)
    {
        $product_stock = ProductStock::find($request->id);
        if ($product_stock) {
            $product_stock->delete();
        }
    }
}
