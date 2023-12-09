<?php

namespace App\Repositories;

use App\Models\Slider;
use Exception;
use stdClass;

class SliderRepository
{


    public function Insert(Slider $slider)
    {
        $res = new stdClass();
        try {
            $slider->save();
            $res->message = "Slider inserted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }
        return $res;
    }

    public function Update(Slider $slider)
    {
        $res = new stdClass();

        try {
            $slider->save();
            $res->message = "Slider updated";
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
            Slider::where('id', $id)->delete();
            $res->message = "Slider deleted";
            $res->code = 200;
        } catch(Exception $ex) {
            $res->message = $ex->getMessage();
            $res->code = 500;
        }

        return $res;
    }
}
