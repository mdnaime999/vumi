<?php

namespace App\Http\Livewire;

use App\Models\Port;
use App\Models\ProductName;
use App\Models\ProductStock as ModelsProductStock;
use App\Models\ProductStockDetails;
use Livewire\Component;

class ProductStock extends Component
{
    public $port_id = null;
    public $tender_type = null;
    public $tender_number = null;
    public $asset_type = null;
    public $total_price = null;
    public $all_date = null;

    public $name = null;
    public $inputField = null;
    public $productId = null;

    public $checkProduct = 0;
    public $newProduct = 0;
    public $keyCheck = 0;
    public $keyCheck2 = 0;
    public $productData = null;

    public function productNameInput($key)
    {
        $this->keyCheck = $key;
        $this->productData = "";
        $this->checkProduct = 1;

        $this->productData = ProductName::get();
    }
    public function newProduct($key)
    {
        $this->keyCheck2 = $key;
        $this->checkProduct = 0;
        $this->newProduct = 1;
    }
    public function searchProduct($id, $key)
    {

        $data = ProductName::where('id', $id)->select('id', 'name')->first();

        $this->products[$key]['product_name'] = $data->name;
        $this->checkProduct = 0;
        $this->products[$key]['productId'] = $id;
    }
    public function productSave($key)
    {
        $this->validate([
            'name' => 'required'
        ], [
            'name.required' => "ফিল্ড পুরুন করতে হবে"
        ]);
        $dataInsert = ProductName::create([
            'name' => $this->name
        ]);

        if ($dataInsert == True) {
            $this->keyCheck2 = $key;
            $this->name = null;
            $this->checkProduct = 0;
            $this->newProduct = 0;
            $this->products[$key]['product_name'] = $dataInsert->name;
            $this->products[$key]['productId'] = $dataInsert->id;
        }
    }
    public function updatedInputField()
    {
        $data = ProductName::where('name', 'LIKE', '%' . $this->inputField . '%')->select('id', 'name')->get();
        $this->productData = $data;
    }
    public function newProductCencel($key)
    {
        $this->keyCheck2 = $key;
        $this->name = null;
        $this->checkProduct = 0;
        $this->newProduct = 0;
    }

    public $products = [
        [
            'productId' => '',
            'product_name' => '',
            'stock' => '',
            'type' => "",
            'price' => "",
            'date' => "",
            'warranty_date' => "",
        ]
    ];
    public function addProductStockContent()
    {
        $this->productData = null;
        $this->checkProduct = 0;
        $this->newProduct = 0;
        array_push($this->products, [
            'productId' => '',
            'product_name' => '',
            'stock' => '',
            'type' => "",
            'price' => "",
            'date' => "",
            'warranty_date' => "",
        ]);
    }
    public function rules()
    {
        $rules = [];
        $rules['port_id'] = 'required';
        $rules['tender_type'] = 'required';
        $rules['tender_number'] = 'required';
        $rules['asset_type'] = 'required';
        for ($i = 0; $i < count($this->products); $i++) {
            $rules['products.' . $i . '.product_name'] = 'required';
            $rules['products.' . $i . '.stock'] = 'required';
            $rules['products.' . $i . '.type'] = 'required';
        }
        return $rules;
    }
    public function saveProductStock()
    {
        $this->validate();
        $product_stock = ModelsProductStock::create([
            'port_id' => $this->port_id,
            'tender_type' => $this->tender_type,
            'tender_number' => bn_to_en($this->tender_number),
            'asset_type' => $this->asset_type,
            'total_price' => bn_to_en($this->total_price),
            'all_date' => $this->all_date,
        ]);
        foreach ($this->products as $value) {
            $stock_details = ProductStockDetails::create([
                'product_stock_id' => $product_stock->id,
                'product_id' => $value['productId'],
                'stock' => bn_to_en($value['stock']),
                'type' => $value['type'] ? $value['type'] : null,
                'price' => $value['price'] ? bn_to_en($value['price']) : null,
                'date' => $value['date'] ? $value['date'] : null,
                'warranty_date' => $value['warranty_date'] ? $value['warranty_date'] : null,
            ]);
            $product = ProductName::find($stock_details->product_id);
            $product->stock = $product->stock + $stock_details->stock;
            $product->save();
        }
        if(!$this->total_price){
            $stock = ModelsProductStock::find($product_stock->id);
            $stock->total_price = $stock_details->sum('price');
            $stock->save();
        }
        return redirect()->route('add.product.stock')->with('success', 'সফলভাবে যোগ করা হয়েছে');
    }
    public $assetTypeCheck = 0;
    public function updatedAssetType()
    {
        if ($this->asset_type == 1) {
            $this->assetTypeCheck = 1;
        } else {
            $this->assetTypeCheck = 0;
        }
    }
    public function deleteProductStockContent($key)
    {
        unset($this->products[$key]);
    }
    public function render()
    {
        $ports = Port::where('status', 1)->get();
        return view('livewire.product-stock', compact('ports'));
    }
}
