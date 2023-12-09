<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Models\Establishment;
use App\Models\LSCase;
use App\Models\Port;
use App\Modules\User\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;

class EstablishmentController extends Controller
{
    public function manageEstablishment()
    {
        return view('admin.establishment.all_establishment');
    }

    public function addEstablishment()
    {
        $establishment = null;
        $lsCases = LSCase::where('status', 1)->get();
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('admin.establishment.add_establishment', compact('establishment', 'permissions', 'lsCases'));
    }

    public function saveEstablishment(Request $request)
    {
        // dd($request->all());
        try {
            Establishment::saveEstablishmentData($request);
            return back()->with('success', 'সফলভাবে সংরক্ষণ করা হয়েছে');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function getEstablishment(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = Port::with('establisment')->get();
            return DataTables::of($list)
                ->editColumn('portName', function ($list) {
                    return ($list->port_name);
                })
                ->editColumn('builidingCount', function ($list) {
                    return count($list->establisment);
                })
                ->addColumn('action', function ($list) {
                    $access = \App\Modules\User\Models\RolePermission::where("id", \Auth::guard()->user()->role_id)->first();
                    $access = $access ? json_decode($access->permission) : [];
                    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false;
                    if (array_search("admin/manage/establishment", $access) > -1 || $checkAdmin == true) {
                        return '
                        <a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-primary btn-xs" href="'. route('building.details', ['id' => $list->id]).'"> <i class="fas fa-eye"></i> </a>
                        <a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deleteEstablishment(this.id,event)"> <i class="fas fa-trash"></i> </a>
                        ';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'action','ls_case'])
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

    public function deleteEstablishment(Request $request)
    {
        try {
            $establishment = Establishment::findOrFail($request->id);

            $establishment->delete();
            Session::flash('success', 'সফলভাবে মুছে ফেলা হয়েছে');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
}
