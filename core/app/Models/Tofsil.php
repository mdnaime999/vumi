<?php

namespace App\Models;

use App\Libraries\Encryption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tofsil extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function classified_type(){
        return $this->belongsTo(ClassifiedType::class, 'classified_type_id', 'id');
    }
    public function land_type(){
        return $this->belongsTo(LandType::class, 'land_type_id', 'id');
    }
    public static function saveTofsilData($request)
    {
        Tofsil::create([
            'kotian_no' => $request->kotian_no,
            'dag_no' => $request->dag_no,
            'classified_type_id' => $request->classified_type_id,
            'land_type_id' => $request->land_type_id,
            'l_s_case_id' => $request->l_s_case_id,
            'total_land' => $request->total_land,
            'comment' => $request->comment,
            'status' => $request->status,
        ]);
    }

    public static function updateTofsilData($request)
    {
        $tofsilId = Encryption::decodeId($request->type_id);
        $tofsil = Tofsil::findOrFail($tofsilId);
        $tofsil->kotian_no = $request->kotian_no;
        $tofsil->dag_no = $request->dag_no;
        $tofsil->classified_type_id = $request->classified_type_id;
        $tofsil->land_type_id = $request->land_type_id;
        $tofsil->total_land = $request->total_land;
        $tofsil->comment = $request->comment;
        $tofsil->status = $request->status;
        $tofsil->save();
    }
}
