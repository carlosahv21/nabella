<?php

namespace App\Http\Livewire;

use App\Models\Vehicle;
use Livewire\Component;

class Vehicles extends Component
{
    public $search, $title_modal, $item, $countVehicles, $modelId = '';
    public $brand, $model, $year, $color, $car_plate = '';

    protected $rules=[
        'brand' => 'required|min:3',
        'model' => 'required|min:3',
        'year' => 'required|numeric|min:4',
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Vehicle';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteVehicle']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteVehicleMasive']);
        }else if($action == 'create'){
            $this->title_modal = 'Create Vehicle';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createVehicle']);
            $this->emit('clearForm');
        }else if($action == 'see'){
            $this->title_modal = 'See File';
            $this->dispatchBrowserEvent('openModal', ['name' => 'SeeFileVehicle']);
            $this->emit('getModelId', $this->item);
        }else{
            $this->title_modal = 'Edit Vehicle';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createVehicle']);
            $this->emit('getModelId', $this->item);

        }
    }


    private function clearForm()
    {
        $this->modelId = null;
        $this->brand = null;
        $this->model = null;
        $this->year = null;
        $this->color = null;
        $this->car_plate = null;

    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Vehicle::find($this->modelId);
        $this->brand = $model->brand;
        $this->model = $model->model;
        $this->year = $model->year;
        $this->color = $model->color;
        $this->car_plate = $model->car_plate;

    }

    public function save()
    {
        if($this->modelId){
            $vehicle = Vehicle::findOrFail($this->modelId);
        }else{
            $vehicle = new Vehicle;
            $this->validate();
        }

        $vehicle->brand = $this->brand;
        $vehicle->model = $this->model;
        $vehicle->year = $this->year;
        $vehicle->color = $this->color;
        $vehicle->car_plate = $this->car_plate;
        
        $vehicle->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createVehicle']);
        $this->clearForm();
    }

    public function forcedCloseModal()
    {
        // This is to <re></re>set our public variables
        $this->clearForm();

        // These will reset our error bags
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.vehicle.index', 
        ['vehicles' => Vehicle::search('name', $this->search)->paginate(10)]
    );
    }
}
