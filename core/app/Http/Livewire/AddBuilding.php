<?php

namespace App\Http\Livewire;

use App\Models\BuildingDetail;
use App\Models\Establishment;
use App\Models\Infrastructure;
use App\Models\LSCase;
use App\Models\Port;
use App\Modules\User\Models\RolePermission;
use Livewire\Component;

class AddBuilding extends Component
{

    public $port_name = null;
    public $district = null;
    public $upzilla = null;
    public $portId = null;

    public $checkPort = 0;
    public $newPort = 0;
    public $portData = null;
    public $portHighlightIndex = -1;

    public $infrastures = null;

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

    // new item input
    public $buildingItems = [
        [
            "building_id"     => 1,
            "detailItems" => [
                [
                    'details'   => 'সংখ্যা',
                    'number'    => '',
                ],
                [
                    'details'   => 'আয়তন',
                    'number'    => '',
                ],
                [
                    'details'   => 'নির্মাণ সাল',
                    'number'    => '',
                ],
                [
                    'details'   => 'নির্মাণ ব্যয়',
                    'number'    => '',
                ],
                [
                    'details'   => 'ধারণ ক্ষমতা',
                    'number'    => '',
                ],
                [
                    'details'   => 'ব্যবহৃত',
                    'number'    => '',
                ]
            ]
        ]
    ];

    public function addNewBuildingItem()
    {

        array_push($this->buildingItems, [
            "building_id"     => 1,
            "detailItems" => [
                [
                    'details'   => 'সংখ্যা',
                    'number'    => '',
                ],
                [
                    'details'   => 'আয়তন',
                    'number'    => '',
                ],
                [
                    'details'   => 'নির্মাণ সাল',
                    'number'    => '',
                ],
                [
                    'details'   => 'নির্মাণ ব্যয়',
                    'number'    => '',
                ],
                [
                    'details'   => 'ধারণ ক্ষমতা',
                    'number'    => '',
                ],
                [
                    'details'   => 'ব্যবহৃত',
                    'number'    => '',
                ]
            ]
        ]);
    }

    public function addNewDetails($key)
    {
        // dd($this->buildingItems[0]['detailItems']);
        array_push($this->buildingItems[$key]['detailItems'], [
            "details"       => "",
            "number"        => "",
        ]);
    }

    public function removeBuilding($index)
    {
        unset($this->buildingItems[$index]);
    }

    public function removeDetails($key, $index)
    {
        unset($this->buildingItems[$key]['detailItems'][$index]);
    }

    public function buildingsSubmit()
    {
        foreach ($this->buildingItems as $key => $value)
        {
            $name = Infrastructure::where('id', $value['building_id'])->first();
          	
            $buildings = Establishment::create([
                'port_id'   => $this->portId,
                'infrasture_id'      => $value['building_id'],
                'name'          => $name->name,
            ]);
            foreach($value['detailItems'] as $key => $item)
            {
                $details = BuildingDetail::create([
                    'establisment_id' => $buildings->id,
                    'details'         => $item['details'],
                    'number'          => bn_to_en($item['number']),
                ]);
            }
        }

        return redirect()->to('/admin/manage/establishment');
    }

    public function mount()
    {
        $this->infrastures = Infrastructure::get();
    }

    public function render()
    {
        $establishment = null;
        $lsCases = LSCase::where('status', 1)->get();
        $permissions = RolePermission::orderby("id", "desc")->get();
        return view('livewire.add-building', compact('establishment', 'permissions', 'lsCases'));
    }
}
