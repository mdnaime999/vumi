<?php

namespace App\Modules\User\Repositories;
use App\Modules\User\Models\RolePermission;
use Exception;
use stdClass;

class PermissionRepository
{


    public function Insert(RolePermission $permission)
    {
        $res = new stdClass();
        try {
            $permission->save();
            $res->message = "Role Permission inserted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Update(RolePermission $permission)
    {
        $res = new stdClass();

        try {
            $permission->save();
            $res->message = "Role Permission updated";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Delete($id)
    {
        $res = new stdClass();

        try {
            RolePermission::where('id', $id)->delete();
            $res->message = "Role Permission deleted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}
