<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Models\ClassifiedType;
use App\Models\LandType;
use App\Models\LSCase;
use App\Models\Port;
use App\Models\Tofsil;
use App\Modules\User\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Session;

class TofsilController extends Controller
{
    // ajax call
    public function getLsCaseNo(Request $request)
    {
        $lsCases = LSCase::where('port_id', $request->portId)
            ->orderBy('name')
            ->get()->toArray();
        return response()->json($lsCases);
    }

    public function manageTofsil()
    {
        return view('admin.tofsil.all_tofsil');
    }

    public function addTofsil($id = null)
    {
        $tofsil = null;
        Session::put('lsCaseId', $id);
        $ports = Port::where('status', 1)->get();
        $lsCases = LSCase::where('status', 1)->get();
        $landTypes = LandType::where('status', 1)->get();
        $classifications = ClassifiedType::where('status', 1)->get();
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('admin.tofsil.add_tofsil', compact('tofsil', 'permissions', 'classifications','landTypes','ports','lsCases'));
    }

    public function saveTofsil(Request $request)
    {
        try {
            Tofsil::saveTofsilData($request);
            return back()->with('success', 'সফলভাবে সংরক্ষণ করা হয়েছে');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function getTofsil(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = Tofsil::orderby("id", "desc")->get();
            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->editColumn('classified_type', function ($list) {
                    return $list->classified_type->name ?? '';
                })
                ->editColumn('land_type', function ($list) {
                    return $list->land_type->name ?? '';
                })
                ->addColumn('action', function ($list) {
                    $access = \App\Modules\User\Models\RolePermission::where("id", \Auth::guard()->user()->role_id)->first();
                    $access = $access ? json_decode($access->permission) : [];
                    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false;
                    if (array_search("admin/manage/tofsil", $access) > -1 || $checkAdmin == true) {
                        return '<a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deleteTofsil(this.id,event)"> <i class="fas fa-trash"></i> </a> ';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'action','classified_type','land_type'])
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

    public function deleteTofsil(Request $request)
    {
        try {
            $tofsil = Tofsil::findOrFail($request->id);

            $tofsil->delete();
            Session::flash('success', 'সফলভাবে মুছে ফেলা হয়েছে');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
}
