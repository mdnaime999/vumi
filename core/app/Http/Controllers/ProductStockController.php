<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Models\Port;
use App\Models\ProductName;
use App\Models\ProductStock;
use App\Models\ProductStockDetails;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Session;
use DB;

class ProductStockController extends Controller
{
    public function addProductStock()
    {
        $product_stock = null;
        $ports = Port::where('status', 1)->get();
        return view('admin.product_stock.add_product_stock', compact('product_stock', 'ports'));
    }
    public function saveProductStock(Request $request)
    {
        $this->validate($request, [
            'tender_type' => 'required',
            'stock' => 'required|max:10',
        ]);
        ProductStock::saveProductStockData($request);
        return back()->with('success', 'সফলভাবে যোগ হয়েছে');
    }
    public function manageProductStock()
    {
        return view('admin.product_stock.manage_product_stock');
    }
    public function getProductStock(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = ProductStock::orderBy('id', 'desc')->get();
            return DataTables::of($list)

                ->editColumn('tender_type', function ($list) {
                    if ($list->tender_type == 1) {
                        return "উন্মুক্ত টেন্ডার";
                    } elseif ($list->tender_type == 2) {
                        return "সরাসরি টেন্ডার";
                    }
                })
                ->editColumn('asset_type', function ($list) {
                    if ($list->asset_type == 1) {
                        return "অফিস সরঞ্জাম";
                    } elseif ($list->asset_type == 2) {
                        return "স্টেশনারি";
                    }
                })
                ->editColumn('tender_number', function ($list) {
                    return en_to_bn($list->tender_number);
                })
                ->editColumn('total_price', function ($list) {
                    return en_to_bn(number_format($list->total_price));
                })
                ->addColumn('action', function ($list) {
                    return '<a style="padding:2px;font-size:15px;" target="_blank" href="' . route('manage.product.stock.details', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>
                            <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteProductStock(this.id,event)"> <i class="fas fa-trash"></i></a>';
                })
                ->addIndexColumn()
                ->rawColumns(['tender_type', 'asset_type', 'tender_number', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
    public function editProductStock($id)
    {
        $product_stock = ProductStock::findorFail($id);
        return view('admin.product_stock.edit_product_stock', compact('product_stock'));
    }
    public function updateProductStock(Request $request)
    {
        $this->validate($request, [
            'tender_type' => 'required',
            'stock' => 'required|max:10',
        ]);
        ProductStock::updateProductStockData($request);
        return redirect()->route('manage.product.stock')->with('success', 'সফলভাবে আপডেট হয়েছে');
    }
    public function deleteProductStock(Request $request)
    {
        ProductStock::deleteProductStockData($request);
        return back()->with('success', 'সফলভাবে অপসারণ করা হয়েছে');
    }

    public function manageProductStockDetails($id)
    {
        $id = $id;
        $product_stock = ProductStock::findorFail($id);
        if ($product_stock->tender_type == 1) {
            $tender_type = "অফিস সরঞ্জাম";
        } elseif ($product_stock->tender_type == 2) {
            $tender_type = "স্টেশনারি";
        }
        return view('admin.product_stock.manage_product_stock_details', compact('id', 'tender_type', 'product_stock'));
    }
    public function getProductStockDetails(Request $request)
    {
        $product_stock_id = $request->product_stock_id;
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = ProductStockDetails::where('product_stock_id', $product_stock_id)->orderBy('id', 'desc')->get();
            return DataTables::of($list)
                ->editColumn('product_name', function ($list) {
                    if ($list->product_id) {
                        return $list->products->name ?? "";
                    } else {
                        return "";
                    }
                })
                ->editColumn('stock', function ($list) {
                    return en_to_bn($list->stock);
                })
                ->editColumn('type', function ($list) {
                    if ($list->type) {
                        if ($list->type == 1) {
                            return "প্যাঃ";
                        } elseif ($list->type == 2) {
                            return "বক্স";
                        } elseif ($list->type == 3) {
                            return "রোল";
                        } elseif ($list->type == 4) {
                            return "বোতল";
                        } elseif ($list->type == 5) {
                            return "সংখ্যা";
                        }
                    } else {
                        return "";
                    }
                })
                ->editColumn('price', function ($list) {
                    if ($list->price) {
                        return en_to_bn(number_format($list->price));
                    } else {
                        return "";
                    }
                })
                ->editColumn('date', function ($list) {
                    $date = Carbon::parse($list->date)->format('d-m-Y');
                    return en_to_bn($date);
                })
                // ->addColumn('action', function ($list) {
                //     return '<a style="padding:2px;font-size:15px;" href="' . route('edit.product.stock.details', ['id' => $list->id]) . '" class="btn btn-info btn-xs pl-1 pr-1"> <i class="fa fa-edit"></i> </a>
                //             <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteProductStock(this.id,event)"> <i class="fas fa-trash"></i></a>';
                // })
                ->addIndexColumn()
                ->rawColumns(['product_name', 'stock', 'type', 'price', 'date', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function editProductStockDetails($id)
    {
        $product_stock = ProductStockDetails::findorFail($id);
        $ports = Port::where('status', 1)->get();
        return view('admin.product_stock.edit_product_stock_details', compact('product_stock', 'ports'));
    }
    public function updateProductStockDetails(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'stock' => 'required',
        ]);
        ProductStockDetails::updateProductStockDetailsData($request);
        $product_stock_details = ProductStockDetails::find($request->id);
        return redirect()->route('manage.product.stock.details', ['id' => $product_stock_details->product_stock_id])->with('success', 'সফলভাবে আপডেট হয়েছে');
    }
    public function deleteProductStockDetails(Request $request)
    {
        ProductStockDetails::deleteProductStockDetailsData($request);
        $product_stock = ProductStockDetails::find($request->id);
        return redirect()->route('manage.product.stock.details', ['id' => $product_stock->product_stock_id])->with('success', 'সফলভাবে অপসারণ করা হয়েছে');
    }

    /* product stock information */
    public function manageProductStockInfo($id)
    {
        $id = $id;
        return view('admin.product_stock.manage_product_stock_info', compact('id'));
    }
    public function getProductStockInfo(Request $request)
    {

        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            if($request->type_id == 2){
                $list = DB::table('product_names')
                        ->join('product_stock_details', 'product_names.id', '=', 'product_stock_details.product_id')
                        ->join('product_stocks', 'product_stock_details.product_stock_id', '=', 'product_stocks.id')
                        ->where('product_names.asset_type', 2)


                        ->groupBy('product_names.id')
                        ->select('product_names.*')
                        ->get();
            } else if ($request->type_id == 1){
                $list = DB::table('product_names')
                        ->join('product_stock_details', 'product_names.id', '=', 'product_stock_details.product_id')
                        ->join('product_stocks', 'product_stock_details.product_stock_id', '=', 'product_stocks.id')
                        ->where('product_names.asset_type', 1)

                        ->groupBy('product_names.id')
                        ->select('product_names.*')
                        ->get();
            }
            return DataTables::of($list)
                ->editColumn('product', function ($list) {
                    return '<a href="'. route('product.tender.details', ['id' => encrypt($list->id)]) .'">'.$list->name.'</a>';
                })
                ->editColumn('stock', function ($list) {
                    if ($list->stock) {
                        return en_to_bn($list->stock);
                    } else {
                        return "-";
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['product', 'stock'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
    public function productTenderDetails($id)
    {
        $id = decrypt($id);
        $product = ProductName::find($id);
        $product_use = DB::table('product_names')
                    ->join('requisition_details', 'product_names.id', '=', 'requisition_details.product_id')
                    ->join('requisitions', 'requisition_details.requisition_id', '=', 'requisitions.id')
                    ->where('product_names.id', $id)
                    ->where('requisitions.status', 2)
                    ->select('requisition_details.product_need')
                    ->get();
        return view('admin.product_stock.product_tender_details', compact('id', 'product', 'product_use'));
    }
    public function getProductTenderDetails(Request $request)
    {
        $product_id = $request->product_id;
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = ProductStockDetails::where('product_id', $product_id)->get();
            return DataTables::of($list)
                ->editColumn('port_name', function ($list) {
                    if ($list->product_stock_id) {
                        return $list->product_stock_details->ports->port_name ?? "";
                    } else {
                        return "";
                    }
                })
                ->editColumn('tender_type', function ($list) {
                    if ($list->product_stock_details->tender_type == 1) {
                        return  "উন্মুক্ত টেন্ডার";
                    } elseif($list->product_stock_details->tender_type == 2) {
                        return "সরাসরি টেন্ডার";
                    }
                })
                ->editColumn('tender_number', function ($list) {
                    return en_to_bn($list->product_stock_details->tender_number) ?? "";
                })
                ->editColumn('stock', function ($list) {
                    return en_to_bn($list->stock);
                })
                ->editColumn('price', function ($list) {
                    if ($list->price) {
                        return en_to_bn(number_format($list->price));
                    } else {
                        return "";
                    }
                })
                ->editColumn('date', function ($list) {
                    $date = Carbon::parse($list->date)->format('d-m-Y');
                    return en_to_bn($date);
                })
                ->addIndexColumn()
                ->rawColumns(['port_name', 'tender_type', 'tender_number', 'stock', 'price', 'date'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    /* user stock information */
    public function userStockInfo()
    {
        return view('admin.product_stock.user_stock_info');
    }
    public function getUserStockInfo(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = User::where("type", null)->get();
            return DataTables::of($list)
                ->editColumn('name', function ($list) {
                    return 'নামঃ ' . $list->name . '<br>' . 'বিভাগঃ ' . $list->roles->departments->name . '<br>' . 'পদবীঃ ' . $list->roles->designations->name;
                })
                ->editColumn('stock', function ($list) {
                    $stocks = DB::table('requisitions')
                            ->join('requisition_details', 'requisitions.id', '=', 'requisition_details.requisition_id')
                            ->join('product_names', 'requisition_details.product_id', '=', 'product_names.id')
                            ->where('requisitions.user_id', $list->id)
                            ->where('requisitions.status', 2)
                            ->select('product_names.name', 'requisition_details.product_need', 'requisitions.updated_at')
                            ->get();
                            $items = array();
                            $i = 1;
                            foreach ($stocks as $key => $stock) {
                                // $items[] = ' ' . en_to_bn($i++) . '. ' . $stock->name . ' - ' . en_to_bn($stock->product_need) . ' (' . en_to_bn(Carbon::parse($stock->updated_at)->format('d-m-Y')).')';
                                $items[] = ' ' . en_to_bn($i++) . '. ' . $stock->name . ' - ' . en_to_bn($stock->product_need);
                            };
                            return $items;
                })
                ->addIndexColumn()
                ->rawColumns(['name', 'stock'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
    public function searchUserStockInfo(Request $request)
    {
        $user_name = $request->user_name;
        if ($user_name) {
            $products = ProductStock::all();
            $users = User::where(function ($query) use ($user_name) {
                $query->where('name', 'LIKE', '%' . $user_name . '%');
            })->take(20)->get();
            return view('admin.product_stock.search_user_stock', compact('products', 'users'))->render();
        }
    }
}
