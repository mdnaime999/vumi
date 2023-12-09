<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Models\District;
use App\Models\LSCase;
use App\Models\Port;
use App\Modules\User\Models\RolePermission;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class LsCaseController extends Controller
{
    public function manageLsCase()
    {
        return view('admin.ls_case.all_ls_case');
    }

    public function addLsCase()
    {
        $lsCase = null;
        $ports = Port::where('status', 1)->get();
        // $districts = District::get();
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('admin.ls_case.add_ls_case', compact('lsCase', 'permissions', 'ports'));
    }

    public function saveLsCase(Request $request)
    {
        // $this->validate($request, [
        //     'port_id' => 'required',
        //     'number' => 'required',
        //     'possession_date' => 'required',
        //     'gazette_date' => 'required',
        //     'land_owner' => 'required',
        //     'land_price' => 'required',
        //     'status' => 'required',
        // ]);
        try {
            LSCase::saveLsCaseData($request);
            return back()->with('success', 'সফলভাবে সংরক্ষণ করা হয়েছে');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function getLsCase(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = LSCase::orderby("id", "desc")->get();
            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->editColumn('port', function ($list) {
                    if($list->port_id){
                        return $list->port->name ?? '';
                    } else {
                        return 'Null';
                    }
                })
                ->addColumn('action', function ($list) {
                    $access = \App\Modules\User\Models\RolePermission::where("id", \Auth::guard()->user()->role_id)->first();
                    $access = $access ? json_decode($access->permission) : [];
                    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false;
                    if (array_search("admin/manage/ls/case", $access) > -1 || $checkAdmin == true) {
                        return '<a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deleteLsCase(this.id,event)"> <i class="fas fa-trash"></i> </a> ';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'action','port'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    // public function editLandType($id)
    // {
    //     $lsCaseId = Encryption::decodeId($id);

    //     try {
    //         $lsCase = LandType::findOrFail($lsCaseId);
    //         $permissions = RolePermission::orderby("id", "desc")->get();
    //         return view('admin.land_type.edit_land_type', compact('type', 'permissions'));
    //     } catch (\Exception $e) {
    //         Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
    //         return Redirect::back();
    //     }
    // }

    // public function updateLandType(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required',
    //         'status' => 'required',
    //     ]);

    //     try {
    //         LandType::updateLandTypeData($request);
    //         return redirect()->route('manage.land.type')->with('success', 'সফলভাবে আপডেট করা হয়েছে!');
    //     } catch (\Exception $e) {
    //         Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1006]');
    //         return Redirect::back()->withInput();
    //     }
    // }

    public function deleteLsCase(Request $request)
    {
        try {
            $lsCase = LSCase::findOrFail($request->id);

            $lsCase->delete();
            Session::flash('success', 'সফলভাবে মুছে ফেলা হয়েছে');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
}
