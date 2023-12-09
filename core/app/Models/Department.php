<?php

namespace App\Models;

use App\Modules\User\Models\RolePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function roles(){
        return $this->hasMany(RolePermission::class, 'department_id', 'id');
    }
    public function designations(){
        return $this->hasMany(Designation::class, 'department_id', 'id');
    }

    public static function saveDepartmentData($request){
        Department::create([
            'name' => $request->name,
            'status' => $request->status ? $request->status : 1,
        ]);
    }
    public static function updateDepartmentData($request){
        $id = decrypt($request->id);
        $department = Department::find($id);
        $department->name = $request->name;
        $department->status = $request->status;
        $department->save();
    }
    public static function deleteDepartmentData($request){
        $id = decrypt($request->id);
        $department = Department::find($id);
        if ($department) {
            $department->delete();
        }
    }
}
