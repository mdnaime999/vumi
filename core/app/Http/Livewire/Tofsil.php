<?php

namespace App\Http\Livewire;

use App\Models\ClassifiedType;
use App\Models\LandType;
use App\Models\LSCase;
use App\Models\Port;
use App\Modules\User\Models\RolePermission;
use Carbon\Carbon;
use Livewire\Component;
use Session;
use DB;

class Tofsil extends Component
{
    public $ls_case_id = null;
    public $kotian_no = null;
    public $dag_no = null;
    public $classified_type_id = null;
    public $land_type_id = null;
    public $total_land = null;
    public $comment = null;
    public $status = null;
    public $classData = null;
    public $checkClass = 0;
    public $newClass = 0;

    public $classId = null;

    public $class_name = null;


    // land type
    public $landTypeData = null;
    public $checkLandType = 0;
    public $newLandType = 0;

    public $landTypeId = null;

    public $land_type_name = null;

    public function classNameInput()
    {
        $this->checkClass = 1;
        $this->classData = ClassifiedType::where('status', 1)->get();
    }

    public function searchClass($id)
    {
        $data = ClassifiedType::where('id', $id)->select('id', 'name')->first();

        $this->classified_type_id       = $data->name;
        $this->checkClass               = 0;
        // $this->newCompany       = 0;
        $this->classId                  = $id;
    }

    public function newClass()
    {
        $this->checkClass = 0;
        $this->newClass = 1;
    }

    public function newClassCencel()
    {
        $this->checkClass = 0;
        $this->newClass = 0;
    }

    public function classSave()
    {
        $this->validate([
            'class_name' => 'required'
        ],[
            'class_name.required' => "ফিল্ড পুরুন করতে হবে"
        ]);
        $dataInsert = ClassifiedType::create([
            'name' => $this->class_name
        ]);

        if($dataInsert == True){
            $this->checkClass           = 0;
            $this->newClass             = 0;
            $this->classified_type_id   = $dataInsert->name;
            $this->classId              = $dataInsert->id;
        }
    }

    public function resetClass()
    {
        $this->checkClass     = 0;
    }


    // land type
    public function landTypeNameInput()
    {
        $this->checkLandType = 1;
        $this->landTypeData = LandType::where('status', 1)->get();
    }

    public function searchLandType($id)
    {
        $data = LandType::where('id', $id)->select('id', 'name')->first();

        $this->land_type_id       = $data->name;
        $this->checkLandType               = 0;
        // $this->newCompany       = 0;
        $this->landTypeId                  = $id;
    }

    public function newLandType()
    {
        $this->checkLandType = 0;
        $this->newLandType = 1;
    }

    public function newLandTypeCencel()
    {
        $this->checkLandType = 0;
        $this->newLandType = 0;
    }

    public function landTypeSave()
    {
        $this->validate([
            'land_type_name' => 'required'
        ],[
            'land_type_name.required' => "ফিল্ড পুরুন করতে হবে"
        ]);
        $dataInsert = LandType::create([
            'name' => $this->land_type_name
        ]);

        if($dataInsert == True){
            $this->checkLandType           = 0;
            $this->newLandType             = 0;
            $this->land_type_id         = $dataInsert->name;
            $this->landTypeId           = $dataInsert->id;
        }

    }

    public function resetLandType()
    {
        $this->checkLandType     = 0;
    }

    // tofsil save
    public function tofsilSave()
    {
        $this->validate(
            [
                'kotian_no'             => 'required',
                'dag_no'                => 'Required',
                'classified_type_id'    => 'Required',
                'land_type_id'          => 'Required',
                'total_land'            => 'Required',
            ],
            [
                'kotian_no.required'                => "Kotian name must be fillup",
                'dag_no.required'                   => "Dag No must be fillup",
                'classified_type_id.required'       => "Classified must be fillup",
                'land_type_id.required'             => "Land must be fillup",
                'total_land.required'               => "Total land case no must be fillup",
            ]
        );

        $tofsil = DB::table('tofsils')->insert([
            'l_s_case_id'           => $this->ls_case_id,
            'kotian_no'             => $this->kotian_no,
            'dag_no'                => $this->dag_no,
            'classified_type_id'    => $this->classId,
            'land_type_id'          => $this->landTypeId,
            'total_land'            => bn_to_en($this->total_land),
            'comment'               => $this->comment,
            'created_at'            => Carbon::now(),
            'updated_at'            => Carbon::now(),
        ]);

        if($tofsil){

            $idLs = $this->ls_case_id;
            $this->ls_case_id = null;
            return redirect()->to('/admin/manage/tofsil/report/' . $idLs);
        }else{
            echo "something wrong";
        }
    }

    // from render

    public function render()
    {
        $tofsil = null;
        $this->ls_case_id = Session::get('lsCaseId');
        $ports = Port::where('status', 1)->get();
        $lsCases = LSCase::where('status', 1)->get();
        $landTypes = LandType::where('status', 1)->get();
        $classifications = ClassifiedType::where('status', 1)->get();
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('livewire.tofsil', compact('tofsil', 'permissions', 'classifications','landTypes','ports','lsCases'));
    }
}
