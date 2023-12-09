<?php

namespace App\Models;

use App\Modules\User\Models\RolePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function departments(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

    public function roles(){
        return $this->hasMany(RolePermission::class, 'designation_id', 'id');
    }

    public static function saveDesignationData($request){
        Designation::create([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'status' => $request->status ? $request->status : 1,
        ]);
    }
    public static function updateDesignationData($request){
        $id = decrypt($request->id);
        $designation = Designation::find($id);
        $designation->department_id = $request->department_id;
        $designation->name = $request->name;
        $designation->status = $request->status;
        $designation->save();
    }
    public static function deleteDesignationData($request){
        $id = decrypt($request->id);
        $designation = Designation::find($id);
        if ($designation) {
            $designation->delete();
        }
    }
}
