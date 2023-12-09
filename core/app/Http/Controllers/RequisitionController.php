<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Models\Department;
use App\Models\ProductName;
use App\Models\ProductStock;
use App\Models\ProductStockDetails;
use App\Models\Requisition;
use App\Models\RequisitionDetails;
use App\Models\User;
use App\Modules\User\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Session;
use Auth;
use DB;
use Carbon\Carbon;

class RequisitionController extends Controller
{
    public function addRequisition()
    {
        $requisition = null;
        $tenders = ProductStock::all();
        $products = ProductName::all();
        return view('admin.requisition.add_requisition', compact('requisition', 'tenders', 'products'));
    }
    public function getProductStockItems(Request $request){
        $product_stocks = ProductStockDetails::where('product_stock_id', $request->tender_id)->get();

        echo '<option selected disabled value="" > পণ্য সিলেক্ট করুন </option>';
        foreach ($product_stocks as $product_stock) {
            echo '<option value="' . $product_stock->id . '">' . $product_stock->name . '</option>';
        }
    }
    public function saveRequisition(Request $request)
    {
        Requisition::saveRequisitionData($request);
        return back()->with('success', 'সফলভাবে যোগ হয়েছে');
    }
    public function manageRequisition()
    {
        $users = DB::table('users')
                ->join('role_permissions','role_permissions.id','=','users.role_id')
                ->join('designations','designations.id','=','role_permissions.designation_id')
                ->select('users.*','designations.name as designation_name')
                ->groupBy('users.id')
                ->get();
        return view('admin.requisition.manage_requisition', compact('users'));
    }
    public function getRequisition(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $check = User::where('id', Auth::guard('web')->user()->id)->first();
            if ($check->type == "superadmin") {
                $list = Requisition::orderBy('id', 'desc')->get();
            } else {
                $list = Requisition::where('user_id', Auth::guard('web')->user()->id)->orderBy('id', 'desc')->get();
            }
            return DataTables::of($list)
                ->editColumn('user_name', function ($list) {
                    return $list->users->name ?? "";
                })
                ->editColumn('product_name', function ($list) {
                    $items = array();
                    $i = 1;
                    foreach ($list->requisition_details as $key => $value) {
                        $items[] = ' ' . en_to_bn($i++) . '. ' . $value->products->name;
                    };
                    return $items;
                })
                ->editColumn('date', function ($list) {
                    if ($list->date) {
                        $date = Carbon::parse($list->date)->format('d-m-Y');
                        return en_to_bn($date);
                    } else {
                        return '';
                    }
                })
                ->editColumn('status', function ($list) {
                    if ($list->status == 0) {
                        return '<button class="btn btn-sm btn-primary">Pending</button>';
                    } elseif ($list->status == 1) {
                        return '<button class="btn btn-sm btn-warning">Manager Received</button>';
                    } elseif ($list->status == 2) {
                        return '<button class="btn btn-sm btn-success">Administration Received</button>';
                    } elseif ($list->status == 9) {
                        return '<button class="btn btn-sm btn-danger">Rejected</button>';
                    }
                })
                ->editColumn('dispatch', function ($list) {
                    return '<button type="button" id="'. $list->id .'" onclick="dispatchModal(this.id)" class="btn btn-sm btn-info"><span class="fa fa-truck"></span> প্রেরণ</button>';
                })
                ->addColumn('action', function ($list) {
                    return '<a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('view.requisition', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>';
                })
                // ->addColumn('action', function ($list) {
                //     if ($list->status == 0 && Auth::guard('web')->user()->type == "manager") {
                //         return '<a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('manager.requisition.reject', ['id' => $list->id]) . '" class="btn btn-danger btn-xs pl-1 pr-1"> <i class="fa fa-times"></i> </a>
                //             <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('manager.requisition.approve', ['id' => $list->id]) . '" class="btn btn-warning btn-xs pl-1 pr-1"> <i class="fa fa-check"></i> </a>
                //             <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('view.requisition', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>
                //             <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteRequisition(this.id,event)"> <i class="fas fa-trash"></i></a>';
                //     } elseif ($list->status == 1 && Auth::guard('web')->user()->type == "superadmin") {
                //         return '<a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('admin.requisition.reject', ['id' => $list->id]) . '" class="btn btn-danger btn-xs pl-1 pr-1"> <i class="fa fa-times"></i> </a>
                //             <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('admin.requisition.approve', ['id' => $list->id]) . '" class="btn btn-warning btn-xs pl-1 pr-1"> <i class="fa fa-check"></i> </a>
                //             <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('view.requisition', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>
                //             <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteRequisition(this.id,event)"> <i class="fas fa-trash"></i></a>';
                //     } else {
                //         return '<a style="padding:2px;font-size:15px; margin-right: 5px;" href="javascript:void(0);" class="btn btn-warning btn-xs pl-1 pr-1"> <i class="fa fa-check"></i> </a>
                //             <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('view.requisition', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>
                //             <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteRequisition(this.id,event)"> <i class="fas fa-trash"></i></a>';
                //     }
                // })
                ->addIndexColumn()
                ->rawColumns(['user_name', 'product_name', 'status', 'date', 'dispatch', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function editRequisition($id)
    {
        $requisition = Requisition::findorFail($id);
        return view('admin.requisition.edit_requisition', compact('requisition'));
    }
    public function updateRequisition(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
        ]);
        Requisition::updateRequisitionDdata($request);
        return redirect()->route('manage.requisition')->with('success', 'সফলভাবে আপডেট হয়েছে');
    }
    public function deleteRequisition(Request $request)
    {
        Requisition::deleteRequisitionData($request);
        return back()->with('success', 'সফলভাবে অপসারণ করা হয়েছে');
    }


    /* view requisition */
    public function viewRequistion($id)
    {
        $requisition = Requisition::where('id', $id)->with('requisition_details')->first();
        return view('admin.requisition.view_requisition', compact('requisition'));
    }

    public function sendSispatch(Request $request)
    {
        $requisition = Requisition::find($request->requisition_id);
        $requisition->dispatch_id = $request->user_id;
        $requisition->status = 1;
        $requisition->save();
        return back()->with('success', 'সফলভাবে প্রেরণ করা হয়েছে');
    }
    public function requisitionRequest()
    {
        $users = DB::table('users')
                ->join('role_permissions','role_permissions.id','=','users.role_id')
                ->join('designations','designations.id','=','role_permissions.designation_id')
                ->select('users.*','designations.name as designation_name')
                ->groupBy('users.id')
                ->get();
        return view('admin.requisition.requisition_request', compact('users'));
    }
    public function getRequisitionRequest(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $check = User::where('id', Auth::guard('web')->user()->id)->first();
            if ($check->type == "superadmin") {
                $list = Requisition::orderBy('id', 'desc')->get();
            } else {
                $list = Requisition::where('dispatch_id', Auth::guard('web')->user()->id)->orderBy('id', 'desc')->get();
            }
            return DataTables::of($list)
                ->editColumn('user_name', function ($list) {
                    return $list->users->name ?? "";
                })
                ->editColumn('product_name', function ($list) {
                    $items = array();
                    $i = 1;
                    foreach ($list->requisition_details as $key => $value) {
                        $items[] = ' ' . en_to_bn($i++) . '. ' . $value->products->name;
                    };
                    return $items;
                })
                ->editColumn('date', function ($list) {
                    if ($list->date) {
                        $date = Carbon::parse($list->date)->format('d-m-Y');
                        return en_to_bn($date);
                    } else {
                        return '';
                    }
                })
                ->editColumn('status', function ($list) {
                    if ($list->status == 0) {
                        return '<button class="btn btn-sm btn-primary">Pending</button>';
                    } elseif ($list->status == 1) {
                        return '<button class="btn btn-sm btn-warning">Manager Recieved</button>';
                    } elseif ($list->status == 2) {
                        return '<button class="btn btn-sm btn-success">Administration Approved</button>';
                    } elseif ($list->status == 9) {
                        return '<button class="btn btn-sm btn-danger">Rejected</button>';
                    }
                })
                ->editColumn('dispatch', function ($list) {
                    if ($list->status == 2) {
                        return '<a href="javascript:void(0);" class="btn btn-sm btn-success"><span class="fa fa-truck"></span> সম্পূর্ণ হয়েছে</a>';
                    } else {
                        return '<a href="javascript:void(0);" id="'. $list->id .'" onclick="dispatchModal(this.id, '. $list->user_id .')" class="btn btn-sm btn-info"><span class="fa fa-truck"></span> প্রেরণ</a>';
                    }
                })
                ->addColumn('action', function ($list) {
                    if ($list->status == 0 && Auth::guard('web')->user()->type == "manager") {
                        return '<a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('requisition.reject', ['id' => $list->id]) . '" class="btn btn-danger btn-xs pl-1 pr-1"> <i class="fa fa-times"></i> </a>
                            <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('requisition.approve', ['id' => $list->id]) . '" class="btn btn-warning btn-xs pl-1 pr-1"> <i class="fa fa-check"></i> </a>
                            <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('view.requisition', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>
                            <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteRequisition(this.id,event)"> <i class="fas fa-trash"></i></a>';
                    } elseif ($list->status == 1) {
                        return '<a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('requisition.reject', ['id' => $list->id]) . '" class="btn btn-danger btn-xs pl-1 pr-1"> <i class="fa fa-times"></i> </a>
                            <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('requisition.approve', ['id' => $list->id]) . '" class="btn btn-warning btn-xs pl-1 pr-1"> <i class="fa fa-check"></i> </a>
                            <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('view.requisition', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>
                            <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteRequisition(this.id,event)"> <i class="fas fa-trash"></i></a>';
                    } else {
                        return '<a style="padding:2px;font-size:15px; margin-right: 5px;" href="javascript:void(0);" class="btn btn-warning btn-xs pl-1 pr-1"> <i class="fa fa-check"></i> </a>
                            <a style="padding:2px;font-size:15px; margin-right: 5px;" href="' . route('view.requisition', ['id' => $list->id]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-eye"></i> </a>
                            <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . $list->id . '" onClick="deleteRequisition(this.id,event)"> <i class="fas fa-trash"></i></a>';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['user_name', 'product_name', 'status', 'date', 'dispatch', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
    public function requisitionApprove($id)
    {
        $requisition = Requisition::find($id);
        $requisition_details = RequisitionDetails::where('requisition_id', $id)->get();
        foreach ($requisition_details as $requisition_detail) {
            $product = ProductName::where('id', $requisition_detail->product_id)->first();
            $product->stock = $product->stock - $requisition_detail->product_need;
            $product->save();
        }
        $requisition->status = 2;
        $requisition->save();
        return back()->with('success', 'সফলভাবে অনুমোদন দেওয়া হয়েছে');
    }
    public function requisitionReject($id)
    {
        $requisition = Requisition::find($id);
        $requisition->status = 9;
        $requisition->save();
        return back()->with('success', 'সফলভাবে বাতিল করা হয়েছে');
    }
}
