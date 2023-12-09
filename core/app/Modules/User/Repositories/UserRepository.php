<?php

namespace App\Modules\User\Repositories;

use App\Models\User;
use Exception;
use stdClass;

class UserRepository
{
    public function Insert(User $user)
    {
        $res = new stdClass();
        try {
            $user->save();
            $res->message = "User inserted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Update(User $user)
    {
        $res = new stdClass();

        try {
            $user->save();
            $res->message = "User has been updated";
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
            User::where('id', $id)->delete();
            $res->message = "User has been deleted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}
