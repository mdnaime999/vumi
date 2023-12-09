<?php

namespace App\Models;

use App\Libraries\CommonFunction;
use App\Libraries\Encryption;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LSCase extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function port(){
        return $this->belongsTo(Port::class, 'port_id', 'id');
    }

    public function tofsil_data()
    {
        return $this->hasMany(Tofsil::class, 'l_s_case_id', 'id');
    }
    public static function saveLsCaseData($request)
    {
        if ($request->has('pdf') && $request->pdf != '') {
            // $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png,webp']);
            $path = 'assets/uploads/lsCase/' . date("Y") . "/" . date("m") . "/";
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
                $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
                fclose($new_file);
            }
            $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
            $image = $request->pdf;
            $imageName = time() . '.' . $image->extension();
            $image->move($root_path . '/' . $path, $imageName);
            $pdfCase = $path . $imageName;
        }

        LSCase::create([
            'port_id' => $request->port_id,
            'number' => $request->number,
            'project_name' => $request->project_name,
            'possession_date' => $request->possession_date,
            'gazette_date' => $request->gazette_date,
            'namjari_case_id' => $request->namjari_case_id,
            'total_land' => $request->total_land,
            'land_owner' => $request->land_owner,
            'land_price' => $request->land_price,
            'kotian_no' => $request->kotian_no,
            'jote_no' => $request->jote_no,
            'district' => $request->district,
            'upzilla' => $request->upzilla,
            'moja' => $request->moja,
            'pdf' => $request->has('pdf') ? $pdfCase : '',
            'status' => $request->status,
        ]);
    }

    public static function updateLsCaseData($request)
    {
        $landTypeId = Encryption::decodeId($request->type_id);
        $landType = LandType::findOrFail($landTypeId);

        $landType->name = $request->name;
        $landType->status = $request->status;
        $landType->save();
    }
}
