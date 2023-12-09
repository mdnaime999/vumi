<?php

namespace App\Models;

use App\Libraries\Encryption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ls_case_no(){
        return $this->hasMany(LSCase::class, 'port_id', 'id');
    }

    public function establisment()
    {
        return $this->hasMany(Establishment::class, 'port_id', 'id');
    }
    // public function buildingDestials()
    // {
    //     return $this->hasMany(BuildingDetail::class, 'establisment_id', 'id');
    // }
    public static function savePortData($request)
    {
        Port::create([
            'port_name' => $request->port_name,
            'district' => $request->district,
            'description' => $request->description,
            'land_area' => $request->land_area,
            'status' => $request->status,
        ]);
    }

    public static function updatePortData($request)
    {
        $portId = Encryption::decodeId($request->port_id);
        $port = Port::findOrFail($portId);
        $port->port_name = $request->port_name;
        $port->description = $request->description;
        $port->district = $request->district;
        $port->land_area = $request->land_area;
        $port->status = $request->status;
        $port->save();
    }
}
