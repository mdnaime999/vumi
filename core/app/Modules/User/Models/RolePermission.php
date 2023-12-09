<?php

namespace App\Modules\User\Models;

use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    public function departments()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function designations()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'role_id', 'id');
    // }

    public static function RolePermissionList(){
        return RolePermission::orderby("id","desc")->get([
            "id",
            "name",
            "permission",
            "department_id",
            "designation_id",
        ]);
    }

}
