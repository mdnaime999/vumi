<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Models\Department;
use App\Models\Designation;
use App\Modules\User\Models\RolePermission;
use App\Modules\User\Repositories\PermissionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Session;
use DB;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class RolePermissionController extends Controller
{
    private $permissionRepo;

    public function __construct(PermissionRepository $permissionRepo)
    {
        $this->permissionRepo = $permissionRepo;
    }
    public function viewUserRolePermission()
    {
        $departments = Department::where('status', 1)->get();
        return view('User::rolepermission.view_user_role_permission', compact('departments'));
    }
    public function viewRolePermissions()
    {
        return view('User::rolepermission.view_role_permissions');
    }

    public function AddRolePermission()
    {
        $permission = null;
        $departments = Department::where('status', 1)->get();
        $dept = Department::where('status', 1)->first();
        $designations = Designation::where('department_id', $dept->id)->get();
        return view('User::rolepermission.add_role_permission', compact('permission', 'departments', 'designations'));
    }

    public function SaveRolePermission(Request $request)
    {
        $this->validate($request,[
            'department_id' => 'required',
            'designation_id' => 'required',
        ]);
        $data = new RolePermission();
        $data->department_id = $request->department_id;
        $data->designation_id = $request->designation_id;
        $data->name = $request->name;
        $data->permission = json_encode($request->access);
        $data->created_by = Auth::guard("web")->user()->id;
        $res = $this->permissionRepo->Insert($data);
        if ($res->code == 200) {
            Session::flash('success', 'Role Permission has been added Successfully');
            return redirect()->route('view_role_permissions');
        } else {
            Session::flash('error', CommonFunction::showErrorPublic($res->message) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function GetRolePermissions(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = RolePermission::RolePermissionList();
            return DataTables::of($list)
                ->editColumn('designation', function ($list) {
                    if($list->designation_id){
                        return 'বিভাগঃ ' . $list->departments->name . '<br>' . 'পদবীঃ ' . $list->designations->name;
                    } else {
                        return "";
                    }
                })
                ->editColumn('permission', function ($list) {
                    $permissions = json_decode($list->permission);
                    $output = "";
                    foreach ($permissions as $sl => $permission) {
                        if ($sl % 3 == 1) {
                            $output .= '</br>';
                        }
                        $output .= $permission . ", ";
                    }
                    return $output;
                })
                ->addColumn('action', function ($list) {
                    return '<a style="padding:3px;font-size:13px;" href="' . route('edit_role_permission', ['id' => Encryption::encodeId($list->id)]) .
                        '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i>  </a> <a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deletebrand(this.id,event)"> <i class="fas fa-trash"></i>  </a> ';
                })
                ->addIndexColumn()
                ->rawColumns(['designation', 'permission', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function EditRolePermission($id)
    {
        $permission_id = Encryption::decodeId($id);
        try {
            $permission = RolePermission::findOrFail($permission_id);
            $access = json_decode($permission->permission);
            $departments = Department::where('status', 1)->get();
            $designations = Designation::where('department_id', $permission->department_id)->get();
            return view('User::rolepermission.edit_role_permission', compact('permission','access', 'departments', 'designations'));
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
    public function UpdateRolePermission(Request $request)
    {
        $permission_id = Encryption::decodeId($request->permission_id);
        $data = RolePermission::findOrFail($permission_id);
        $data->department_id = $request->department_id;
        $data->designation_id = $request->designation_id;
        $data->name = $request->name;
        $data->permission = json_encode($request->access);
        $data->updated_by = Auth::guard("web")->user()->id;
        $res = $this->permissionRepo->Update($data);
        if ($res->code == 200) {
            Session::flash('success', 'Role Permission has been updated Successfully');
            return redirect()->route('view_role_permissions');
        } else {
            Session::flash('error', CommonFunction::showErrorPublic($res->message) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function DeleteRolePermission(Request $request)
    {
        try {
            $permission = RolePermission::findOrFail($request->id);
            $permission->delete();
            Session::flash('success', 'Role Permission has been deleted Successfully');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
}
