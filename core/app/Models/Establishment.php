<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function port(){
        return $this->belongsTo(Port::class, 'port_id', 'id');
    }

    public function buildingDetials()
    {
        return $this->hasMany(BuildingDetail::class, 'establisment_id', 'id');
    }
    public static function saveEstablishmentData($request)
    {
        Establishment::create([
            'l_s_case_id' => $request->l_s_case_id,
            'name' => $request->name,
            'floor_num' => $request->floor_num,
            'room_num' => $request->room_num,
            'details' => $request->details,
            'status' => $request->status,
        ]);
    }
}
