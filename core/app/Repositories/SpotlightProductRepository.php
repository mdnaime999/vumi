<?php

namespace App\Repositories;

use App\Models\SpotlightProduct;
use Exception;
use stdClass;

class SpotlightProductRepository
{


    public function Insert(SpotlightProduct $product)
    {
        $res = new stdClass();
        try {
            $product->save();
            $res->message = "Spotlight Product inserted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Update(SpotlightProduct $product)
    {
        $res = new stdClass();

        try {
            $product->save();
            $res->message = "Spotlight Product updated";
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
            SpotlightProduct::where('id', $id)->delete();
            $res->message = "Spotlight Product deleted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}
