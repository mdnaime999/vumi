<?php

namespace App\Models;

use App\Libraries\Encryption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassifiedType extends Model
{
    use HasFactory;
    protected $guarded = [];
    public static function saveLandClassificationData($request)
    {
        ClassifiedType::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);
    }

    public static function updateLandClassificationData($request)
    {
        $classificationId = Encryption::decodeId($request->classification_id);
        $classification = ClassifiedType::findOrFail($classificationId);

        $classification->name = $request->name;
        $classification->status = $request->status;
        $classification->save();
    }
}
