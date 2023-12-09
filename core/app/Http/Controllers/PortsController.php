<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Models\BuildingDetail;
use App\Models\Establishment;
use App\Models\Infrastructure;
use App\Models\LSCase;
use App\Models\Port;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Modules\User\Models\RolePermission;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PortsController extends Controller
{
    public function viewPorts()
    {
        return view('admin.port.view_ports');
    }

    public function addPort()
    {
        $port = null;
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('admin.port.add_port', compact('port', 'permissions'));
    }

    public function savePort(Request $request)
    {
        $this->validate($request, [
            'port_name' => 'required',
            'district' => 'required',
            'status' => 'required',
        ]);
        try {
            Port::savePortData($request);
            return back()->with('success', 'সফলভাবে সংরক্ষণ করা হয়েছে');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function getPorts(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }

        try {

            $list = Port::orderby("id", "desc")->get();
            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->editColumn('name', function ($list) {
                    return $list->port_name;
                })
                ->addColumn('action', function ($list) {
                    $access = \App\Modules\User\Models\RolePermission::where("id", \Auth::guard()->user()->role_id)->first();
                    $access = $access ? json_decode($access->permission) : [];
                    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false;
                    if (array_search("user/manage", $access) > -1 || $checkAdmin == true) {
                        return '<a style="padding:3px;font-size:13px;" href="' . route('edit_port', ['id' => Encryption::encodeId($list->id)]) .
                            '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> </a> <a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deletePort(this.id,event)"> <i class="fas fa-trash"></i> </a> ';
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

    public function editPort($id)
    {
        $port_id = Encryption::decodeId($id);

        try {
            $port = Port::findOrFail($port_id);
            $permissions = RolePermission::orderby("id", "desc")->get();
            return view('admin.port.edit_port', compact('port', 'permissions'));
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }

    public function updatePort(Request $request)
    {
        $this->validate($request, [
            'port_name' => 'required',
            'district' => 'required',
            'status' => 'required',
        ]);

        try {
            Port::updatePortData($request);
            return redirect()->route('view_port')->with('success', 'সফলভাবে আপডেট করা হয়েছে!');
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1006]');
            return Redirect::back()->withInput();
        }
    }

    public function deletePort(Request $request)
    {
        try {
            $port = Port::findOrFail($request->id);
            $port->delete();
            Session::flash('success', 'সফলভাবে মুছে ফেলা হয়েছে');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }

    public function portList()
    {
        $ports = Port::with('ls_case_no')->get();
        return view('admin.port_manage.index', compact('ports'));
    }


    // tofsil table
    public function tofsilList($id)
    {
        $ls_case = LSCase::where('id', $id)->with('tofsil_data')->first();
        return view('admin.port_manage.tofsil', compact('ls_case'));
    }

    // building details

    public function buildingDetails($id)
    {
        $port_name = Port::where('id', $id)->first();
        $buildings = Establishment::where('port_id', $id)->with('buildingDetials')->get();
        return view('admin.port_manage.building_details', compact('buildings', 'port_name'));
    }

    public function infrastureDetails($id)
    {
        $infrastures = BuildingDetail::where('establisment_id', $id)->get();
        $building = Establishment::where('id', $id)->first();
        return view('admin.port_manage.details', compact('infrastures', 'building'));
    }

    public function DepreciationCalclution($number)
    {
        return view('admin.port_manage.depreciation', compact('number'));
    }

    public function PortDataGet(Request $request)
    {
        if($request->port_id == []){
            $ports = Port::with('ls_case_no')->get();
        }else{
            $ports = Port::whereIn('id', $request->port_id)->with('ls_case_no')->get();
        }

        $result['portData'] = view('admin.port_manage.ajax_data', compact('ports'))->render();
        return $result;
    }

    
}
