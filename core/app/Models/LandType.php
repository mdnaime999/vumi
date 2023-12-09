<?php

namespace App\Models;

use App\Libraries\Encryption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandType extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function saveLandTypeData($request)
    {
        LandType::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }

    public static function updateLandTypeData($request)
    {
        $landTypeId = Encryption::decodeId($request->type_id);
        $landType = LandType::findOrFail($landTypeId);

        $landType->name = $request->name;
        $landType->status = $request->status;
        $landType->save();
    }
}
