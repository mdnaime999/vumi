<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;
use stdClass;

class CategoryRepository
{


    public function Insert(Category $category)
    {
        $res = new stdClass();
        try {
            $category->save();
            $res->message = "Category inserted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Update(Category $category)
    {
        $res = new stdClass();

        try {
            $category->save();
            $res->message = "Category updated";
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
            Category::where('id', $id)->delete();
            $res->message = "Category deleted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}
