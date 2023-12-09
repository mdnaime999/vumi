<?php

namespace App\Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Modules\User\Models\RolePermission;
use App\Modules\User\Repositories\UserRepository;
use Illuminate\Http\Request;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{

    /**
     * Display the module welcome screen
     *
     * @return \Illuminate\Http\Response
     */

    private $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function viewUsers()
    {
        return view('User::user.view_users');
    }

    public function AddUser()
    {
        $user = null;
        $designations = Designation::where('status', 1)->get();
        $departments = Department::where('status', 1)->get();
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('User::user.add_user', compact('user', 'designations', 'departments', 'permissions'));
    }

    public function SaveUser(Request $request)
    {

        $data = new User();
        $data->name = $request->name;
        $data->room_desk = $request->room_desk;
        $data->type = $request->type;
        $data->email = $request->email;
        $data->role_id = $request->role_id;
        $data->phone = $request->phone;
        $data->password = bcrypt($request->password);
        if ($request->has('image') && $request->image != '') {
            $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png,webp']);
            $path = 'assets/uploads/users/' . date("Y") . "/" . date("m") . "/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
                $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                fclose($new_file);
            }
            $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
            $image = $request->image;
            $imageName = time() . '.' . $image->extension();
            $image->move($root_path . '/' . $path, $imageName);
            $data->image = $path . $imageName;
        }
        $data->status = $request->status;
        $res = $this->userRepo->insert($data);
        if ($res->code == 200) {
            Session::flash('success', 'সফলভাবে যোগ হয়েছে');
            return redirect()->route('view_users');
        } else {
            Session::flash('error', CommonFunction::showErrorPublic($res->message) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function GetUsers(Request $request)
    {
        if (!$request->ajax()) {
            return 'Sorry! this is a request without proper way.';
        }
        try {
            $list = User::UserList();
            return DataTables::of($list)
                ->editColumn('status', function ($list) {
                    return CommonFunction::getStatus($list->status);
                })
                ->editColumn('role', function ($list) {
                    if ($list->role_id) {
                        return 'বিভাগঃ ' . $list->roles->departments->name . '<br>' . 'পদবীঃ ' . $list->roles->designations->name;
                    } else {
                        return "";
                    }
                })
                ->addColumn('action', function ($list) {
                    $access = \App\Modules\User\Models\RolePermission::where("id", \Auth::guard()->user()->role_id)->first();
                    $access = $access ? json_decode($access->permission) : [];
                    $checkAdmin = Auth::guard("web")->user()->type == "admin" || Auth::guard("web")->user()->type == "superadmin" ? true : false;
                    if (array_search("user/manage", $access) > -1 || $checkAdmin == true) {
                        return '<a style="padding:3px;font-size:13px;" href="' . route('edit_user', ['id' => Encryption::encodeId($list->id)]) .
                            '" class="btn btn-primary btn-xs"> <i class="fa fa-edit"></i> </a> <a style="padding:3px!important; font-size:13px; color: #fff" class="btn btn-danger btn-xs" id="' . $list->id . '" onclick="deleteuser(this.id,event)"> <i class="fas fa-trash"></i> </a> ';
                    }
                })
                ->addIndexColumn()
                ->rawColumns(['role', 'status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1001]');
            return Redirect::back();
        }
    }

    public function EditUser($id)
    {
        $user_id = Encryption::decodeId($id);

        try {
            $user = User::findOrFail($user_id);
            $designations = Designation::where('status', 1)->get();
            $departments = Department::where('status', 1)->get();
            $permissions = RolePermission::orderby("id", "desc")->get();
            return view('User::user.edit_user', compact('user', 'designations', 'departments', 'permissions'));
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }

    public function UpdateUser(Request $request)
    {
        $user_id = Encryption::decodeId($request->user_id);
        $data = User::findOrFail($user_id);
        $data->name = $request->name;
        $data->room_desk = $request->room_desk;
        $data->type = $request->type;
        $data->email = $request->email;
        $data->role_id = $request->role_id;
        $data->phone = $request->phone;
        $data->status = $request->status;
        if ($request->has('image') && $request->image != '') {
            CommonFunction::imageDelete($data->image);
            $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png,webp']);
            $path = 'assets/uploads/users/' . date("Y") . "/" . date("m") . "/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
                $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                fclose($new_file);
            }
            $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
            $image = $request->image;
            $imageName = time() . '.' . $image->extension();
            $image->move($root_path . '/' . $path, $imageName);
            $data->image = $path . $imageName;
        }
        $res = $this->userRepo->Update($data);
        if ($res->code == 200) {
            Session::flash('success', 'সফলভাবে আপডেট হয়েছে');
            return redirect()->route('view_users');
        } else {
            Session::flash('error', CommonFunction::showErrorPublic($res->message) . '[UC-1005]');
            return Redirect::back()->withInput();
        }
    }

    public function DeleteUser(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);

            $user->delete();
            Session::flash('success', 'সফলভাবে অপসারণ করা হয়েছে');
            $msg = "success";
            return response()->json($msg);
        } catch (\Exception $e) {
            DB::rollback();
            Session::flash('error', CommonFunction::showErrorPublic($e->getMessage()) . '[UC-1010]');
            return Redirect::back();
        }
    }
}
