<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Models\ClassifiedType;
use App\Modules\User\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class LandClassificationController extends Controller
{
    public function manageLandClassification()
    {
        return view('admin.land_classification.all_land_classification');
    }

    public function addLandClassification()
    {
        $classification = null;
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('admin.land_classification.add_land_classification', compact('classification', 'permissions'));
    }

    public function saveLandClassification(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);
        try {
            ClassifiedType::saveLandClassificationData($request);
            return back()->with('success', 'সফলভাবে সংরক্ষণ করা হয়েছে');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function getLandClassification(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = ClassifiedType::orderby("id", "desc")->get();
            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->addColumn('action', function ($list) {
                    $access = \App\Modules\User\Models\RolePermission::where("id", \Auth::guard()->user()->role_id)->first();
                    $access = $access ? json_decode($access->permission) : [];
                    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false;
                    if (array_search("admin/manage/land/classification", $access) > -1 || $checkAdmin == true) {
                        return '<a style="padding:3px;font-size:13px;" href="' . route('edit.land.classification', ['id' => Encryption::encodeId($list->id)]) .
                            '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> </a> <a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deleteClassification(this.id,event)"> <i class="fas fa-trash"></i> </a> ';
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

    public function editLandClassification($id)
    {
        $classificationId = Encryption::decodeId($id);

        try {
            $classification = ClassifiedType::findOrFail($classificationId);
            $permissions = RolePermission::orderby("id", "desc")->get();
            return view('admin.land_classification.edit_land_classification', compact('classification', 'permissions'));
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }

    public function updateLandClassification(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'status' => 'required',
        ]);

        try {
            ClassifiedType::updateLandClassificationData($request);
            return redirect()->route('manage.land.classification')->with('success', 'সফলভাবে আপডেট করা হয়েছে!');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1006]');
            return Redirect::back()->withInput();
        }
    }

    public function deleteLandClassification(Request $request)
    {
        try {
            $classification = ClassifiedType::findOrFail($request->id);

            $classification->delete();
            Session::flash('success', 'সফলভাবে মুছে ফেলা হয়েছে');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
}
