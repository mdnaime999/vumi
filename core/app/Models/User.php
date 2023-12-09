<?php

namespace App\Models;

use App\Modules\User\Models\RolePermission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public function roles(){
        return $this->belongsTo(RolePermission::class, 'role_id', 'id');
    }
    public function roles2(){
        return $this->belongsTo(RolePermission::class, 't_role_id', 'id');
    }
    public function designations(){
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function departments(){
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function requisitions(){
        return $this->hasMany(Requisition::class, 'user_id', 'id')->where('status', 2);
    }

    public static function RoleTransfer($request)
    {
        $user_id = $request->role_id;
        $role_id = explode('/', $user_id);
        $user = User::find($role_id[0]);
        $user->t_role_id  = $request->permission_id;
        $user->t_from_date = $request->t_from_date;
        $user->t_to_date = $request->t_to_date;
        $user->save();
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function UserList(){
        return User::orderby("id","desc")->get([
            "id",
            "name",
            "email",
            "phone",
            "type",
            "role_id",
            "status"
        ]);
    }
}
