<?php

namespace App\Http\Livewire;

use App\Libraries\CommonFunction;
use App\Models\LSCase;
use App\Models\Port;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddPort extends Component
{
    use WithFileUploads;
    public $port_name = null;
    public $district = null;
    public $upzilla = null;
    public $checkCountry = 0;
    public $countryData = null;
    public $portId = null;

    public $checkPort = 0;
    public $newPort = 0;
    public $portData = null;
    public $portHighlightIndex = -1;

    public $number              = null;
    public $possession_date     = null;
    public $gazette_date        = null;
    public $namjari_case_id     = null;
    public $total_land          = null;
    public $namjari_file        = null;

    public $project_name = null;
    public $land_owner = null;
    public $land_price = null;
    public $jote_no = null;
    public $kotian_no = null;

    public function updatedPort_name()
    {
        // $this->portHighlightIndex = -1;
        if ($this->port_name == null) {
            $this->checkPort = 0;
        } else {
            $this->checkPort = 1;
            $this->portData = Port::where('name', 'LIKE', '%' . $this->port_name . '%')
                ->get();
        }
    }

    public function searchPort($id)
    {
        $data = Port::where('id', $id)->select('id', 'port_name')->first();

        $this->port_name        = $data->port_name;
        $this->checkPort        = 0;
        // $this->newCompany       = 0;
        $this->portId           = $id;
    }
    public function portNameInput()
    {
        $this->checkPort = 1;
        $this->portData = Port::get();
    }

    public function resetPort()
    {
        $this->checkPort     = 0;
    }

    // new port add
    public function newPort()
    {
        $this->checkPort = 0;
        $this->newPort = 1;
    }

    // new port add cencel
    public function newPortCencel()
    {
        $this->checkPort = 0;
        $this->newPort = 0;
    }

    // save port
    public function portSave()
    {
        $this->validate(
            [
                'port_name'      => 'required',
                'district'       => 'Required',
                'upzilla'        => 'Required',
            ],
            [
                'port_name.required'    => "Port name must be fillup",
                'district.required'     => "District must be fillup",
                'upzilla.required'      => "Upzilla must be fillup",
            ]
        );

        $dataInsert = Port::create([
            'port_name'      => $this->port_name,
            'district'       => $this->district,
            'upzilla'        => $this->upzilla,
        ]);

        if ($dataInsert == true) {


            $this->checkPort     = 0;
            $this->newPort       = 0;
            $this->port_name     = $dataInsert->port_name;
            $this->portId        = $dataInsert->id;
        }
    }

    public function incrementHighlightCountry()
    {
        if ($this->portHighlightIndex === count($this->countryData) - 1) {
            $this->portHighlightIndex = 0;
            return;
        }
        $this->portHighlightIndex++;
        $this->port_name = $this->portData[$this->portHighlightIndex]->name . "(" . $this->portData[$this->portHighlightIndex]->currency_code . "," . $this->countryData[$this->portHighlightIndex]->currency_symbol . ")";
    }

    public function decrementHighlightCountry()
    {
        if ($this->portHighlightIndex === 0) {
            $this->portHighlightIndex = count($this->countryData) - 1;
            return;
        }
        $this->portHighlightIndex--;
        $this->port_name = $this->countryData[$this->portHighlightIndex]->name . "(" . $this->countryData[$this->portHighlightIndex]->currency_code . "," . $this->countryData[$this->portHighlightIndex]->currency_symbol . ")";
    }

    public function countryEnter()
    {
        $this->port_name = $this->countryData[$this->portHighlightIndex]->name . "(" . $this->countryData[$this->portHighlightIndex]->currency_code . "," . $this->countryData[$this->portHighlightIndex]->currency_symbol . ")";
        $this->portId = $this->countryData[$this->portHighlightIndex]->id;
        $this->checkPort = 0;
    }


    // port submit validation rules
    // public function rules()
    // {
    //     $rules = [];
    //     $rules['port_name']         = 'required';
    //     $rules['number']            = 'required';
    //     $rules['possession_date']   = 'required';
    //     $rules['gazette_date']      = 'required';
    //     $rules['namjari_case_id']   = 'required';
    //     $rules['total_land']        = 'required';
    //     return $rules;
    // }


    public $pdfCase = null;
    public function portsubmit()
    {
        $this->validate(
            [
                'port_name'         => 'required',
                'number'            => 'Required',
                'possession_date'   => 'Required',
                'gazette_date'      => 'Required',
                'namjari_case_id'   => 'Required',
                'total_land'        => 'Required',
            ],
            [
                'port_name.required'        => "Port name must be fillup",
                'number.required'           => "Number must be fillup",
                'possession_date.required'  => "Possession date must be fillup",
                'gazette_date.required'     => "gazette date must be fillup",
                'namjari_case_id.required'  => "Namjari case no must be fillup",
                'total_land.required'       => "Total land must be fillup",
            ]
        );

        // dd($this->namjari_file->hashName());
        if ($this->namjari_file) {
            // $request->validate(['image' => 'required|image|mimes:jpeg,jpg,png,webp']);
            $path = 'core/storage/app/public/documents/';
            // if (!file_exists($path)) {
            //     mkdir($path, 0777, true);
            //     $new_file = fopen($path . '/index.html', 'w') or die('Cannot create file:  [UC-1001]');
            //     fclose($new_file);
            // }
            // $root_path = CommonFunction::getProjectRootDirectory(); // Path to the project's root folder
            // $image = $this->namjari_file;
            // $imageName = time() . '.' . "pdf";
            // $image->move($root_path . '/' . $path, $this->namjari_file->hashName());

            $this->namjari_file->store('documents','public');
            $this->pdfCase = $path . $this->namjari_file->hashName();



        }

        // $image      = $this->companyLogo;
        // $filename    = "image-" . time() . ".png";
        // $new_location = 'assets/uploads/' . $filename;
        // Image::make($image)->save($new_location);


        $lsCase = LSCase::create([
            'port_id'           => $this->portId,
            'number'            => $this->number,
            'possession_date'   => bn_to_en($this->possession_date),
            'gazette_date'      => bn_to_en($this->gazette_date),
            'namjari_case_id'   => $this->namjari_case_id,
            'total_land'        => bn_to_en($this->total_land),
            'project_name'      => $this->project_name,
            'land_owner'        => $this->land_owner,
            'land_price'        => bn_to_en($this->land_price),
            'jote_no'           => $this->jote_no,
            'kotian_no'         => $this->kotian_no,
            'moja'              => "লক্ষীদাড়ি, জে. এল. নং  - ২৬",
            'pdf'               => $this->pdfCase,
        ]);

        if($lsCase){
            return redirect()->to('/admin/manage/port/report');
        }else{
            echo "something wrong";
        }

    }



    public function render()
    {
        return view('livewire.add-port');
    }
}
