<?php

namespace App\Http\Controllers;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Models\LandType;
use App\Modules\User\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class LandTypeController extends Controller
{
    public function manageLandType()
    {
        return view('admin.land_type.all_land_type');
    }

    public function addLandType()
    {
        $type = null;
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('admin.land_type.add_land_type', compact('type', 'permissions'));
    }

    public function saveLandType(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        try {
            LandType::saveLandTypeData($request);
            return back()->with('success', 'সফলভাবে সংরক্ষণ করা হয়েছে');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function getLandType(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = LandType::orderby("id", "desc")->get();
            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->addColumn('action', function ($list) {
                    $access = \App\Modules\User\Models\RolePermission::where("id", \Auth::guard()->user()->role_id)->first();
                    $access = $access ? json_decode($access->permission) : [];
                    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false;
                    if (array_search("admin/manage/land/type", $access) > -1 || $checkAdmin == true) {
                        return '<a style="padding:3px;font-size:13px;" href="' . route('edit.land.type', ['id' => Encryption::encodeId($list->id)]) .
                            '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> </a> <a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deleteType(this.id,event)"> <i class="fas fa-trash"></i> </a> ';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function editLandType($id)
    {
        $typeId = Encryption::decodeId($id);

        try {
            $type = LandType::findOrFail($typeId);
            $permissions = RolePermission::orderby("id", "desc")->get();
            return view('admin.land_type.edit_land_type', compact('type', 'permissions'));
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }

    public function updateLandType(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);

        try {
            LandType::updateLandTypeData($request);
            return redirect()->route('manage.land.type')->with('success', 'সফলভাবে আপডেট করা হয়েছে!');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1006]');
            return Redirect::back()->withInput();
        }
    }

    public function deleteLandType(Request $request)
    {
        try {
            $type = LandType::findOrFail($request->id);

            $type->delete();
            Session::flash('success', 'সফলভাবে মুছে ফেলা হয়েছে');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
}
