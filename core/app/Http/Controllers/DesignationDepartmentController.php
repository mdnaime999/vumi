<?php

namespace App\Http\Controllers;

use App\Libraries\CommonFunction;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Modules\User\Models\RolePermission;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;
use Session;
use Symfony\Component\Console\Descriptor\Descriptor;

class DesignationDepartmentController extends Controller
{
    public function getDesignationForRole(Request $request){
        $designations = Designation::where('department_id', $request->department_id)->get();

        echo '<option selected disabled value=""> পদবী সিলেক্ট করুন </option>';
        foreach ($designations as $designation) {
            echo '<option value="' . $designation->id . '">' . $designation->name . '</option>';
        }
    }
    public function getDesignationForRoleTransfer(Request $request){
        $designations = Designation::where('department_id', $request->department_id)->get();

        echo '<option selected disabled value=""> পদবী সিলেক্ট করুন </option>';
        foreach ($designations as $designation) {
            foreach ($designation->roles as $roleD){
                foreach ($roleD->users as $userName)
                    echo '<option value="' . $userName->id . '/'. $roleD->id .'">' .$userName->name.'-'. $designation->name . '</option>';
            }
        }
    }
    /* department */
    public function addDepartment()
    {
        $department = null;
        return view('admin.department.add_department', compact('department'));
    }
    public function saveDepartment(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        Department::saveDepartmentData($request);
        return back()->with('success', 'সফলভাবে যোগ হয়েছে');
    }

    public function manageDepartment()
    {
        return view('admin.department.manage_department');
    }

    public function getDepartment(Request $request)
    {
        return $request;

        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = Department::orderBy('id', 'desc')->get();
            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->addColumn('action', function ($list) {
                    return '<a style="padding:2px;font-size:15px;" href="' . route('edit.department', ['id' => encrypt($list->id)]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-edit"></i> </a>
                            <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . encrypt($list->id) . '" onClick="deleteDepartment(this.id,event)"> <i class="fas fa-trash"></i></a>';
                })
                ->addIndexColumn()
                ->rawColumns(['status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
    public function editDepartment($id)
    {
        $id = decrypt($id);
        $department = Department::findorFail($id);
        return view('admin.department.edit_department', compact('department'));
    }
    public function updateDepartment(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        Department::updateDepartmentData($request);
        return redirect()->route('manage.department')->with('success', 'সফলভাবে আপডেট হয়েছে');
    }
    public function deleteDepartment(Request $request)
    {
        Department::deleteDepartmentData($request);
        return back()->with('success', 'সফলভাবে অপসারণ করা হয়েছে');
    }

    /* designation */
    public function addDesignation()
    {
        $designation = null;
        $departments = Department::where('status', 1)->get();
        return view('admin.designation.add_designation', compact('designation', 'departments'));
    }
    public function saveDesignation(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        Designation::saveDesignationData($request);
        return back()->with('success', 'সফলভাবে যোগ হয়েছে');
    }
    public function manageDesignation()
    {
        return view('admin.designation.manage_designation');
    }
    public function getDesignation(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = Designation::orderBy('id', 'desc')->get();
            return DataTables::of($list)
                ->editColumn('department', function ($list) {
                    if($list->department_id){
                        return $list->departments->name ?? "";
                    } else {
                        return "";
                    }
                })
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->addColumn('action', function ($list) {
                    return '<a style="padding:2px;font-size:15px;" href="' . route('edit.designation', ['id' => encrypt($list->id)]) . '" class="btn btn-primary btn-xs pl-1 pr-1"> <i class="fa fa-edit"></i> </a>
                            <a href="javascript:void(0);" style="padding:2px; font-size:15px; color: #fff" class="btn btn-danger btn-xs pl-1 pr-1" id="' . encrypt($list->id) . '" onClick="deleteDesignation(this.id,event)"> <i class="fas fa-trash"></i></a>';
                })
                ->addIndexColumn()
                ->rawColumns(['department', 'status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
    public function editDesignation($id)
    {
        $id = decrypt($id);
        $designation = Designation::findorFail($id);
        $departments = Department::where('status', 1)->get();
        return view('admin.designation.edit_designation', compact('designation', 'departments'));
    }
    public function updateDesignation(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);
        Designation::updateDesignationData($request);
        return redirect()->route('manage.designation')->with('success', 'সফলভাবে আপডেট হয়েছে');
    }
    public function deleteDesignation(Request $request)
    {
        Designation::deleteDesignationData($request);
        return back()->with('success', 'সফলভাবে অপসারণ করা হয়েছে');
    }
    public function roleTransfer()
    {
        return view('admin.designation.role_transfer');
    }

    public function roleTransferAdd()
    {
        $userType = Auth::guard('web')->user()->type;
        if($userType == 'superadmin'){
            $departments = Department::where('status', 1)->get();
            $designations = Designation::where('status', 1)->get();
            $permissions = RolePermission::all();
            return view('admin.designation.add_role_transfer', compact('departments', 'designations', 'permissions'));
        }else{
            $designations = Designation::where('status', 1)->get();
            return view('admin.designation.add_role_transfer', compact('designations'));
        }

    }

    public function roleTransferSubmit(Request $request)
    {
        $userType = Auth::guard('web')->user()->type;
        if($userType == 'superadmin'){
            $this->validate($request, [
                'department_id' => 'required',
                'role_id' => 'required',
                't_from_date' => 'required',
                't_to_date' => 'required',
            ]);
        }
        $userSave = User::RoleTransfer($request);

        return redirect()->route('manage.role.transfer');

    }

    public function roleTransferGet(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = User::where('t_role_id', '!=', null)->orderBy('id', 'desc')->get();
            return DataTables::of($list)
                ->editColumn('previous', function ($list) {
                    if ($list->role_id) {
                        return 'বিভাগঃ ' . $list->roles->departments->name . '<br>' . 'পদবীঃ ' . $list->roles->designations->name;
                    } else {
                        return "";
                    }
                })
                ->editColumn('present', function ($list) {
                    if ($list->role_id) {
                        return 'বিভাগঃ ' . $list->roles2->departments->name . '<br>' . 'পদবীঃ ' . $list->roles2->designations->name;
                    } else {
                        return "";
                    }
                })
                ->editColumn('date', function ($list) {
                    if ($list->role_id) {
                        return 'শুরুঃ ' . en_to_bn(Carbon::parse($list->t_from_date)->format('d-m-Y')) . ' - ' . 'শেষঃ ' . en_to_bn(Carbon::parse($list->t_to_date)->format('d-m-Y'));
                    } else {
                        return "";
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['date', 'previous', 'present'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }
}
