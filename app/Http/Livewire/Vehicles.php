<?php

namespace App\Http\Livewire;

use App\Models\Vehicle;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

use Livewire\WithPagination;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\DB;

class Vehicles extends Component
{

    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search, $title_modal, $item, $countVehicles, $user_id, $driver, $modelId, $number_vehicle, $fileVehicle, $seeFileVehicle, $image_key = '';

    public $selected = [];
    public $selectedAll = false;
    public $make, $model, $year, $vin = '';
    public $action, $isEdit = false;

    protected $rules=[
        'make' => 'required|min:3',
        'model' => 'required|min:3',
        'year' => 'required|numeric|min_digits:4',
        'fileVehicle' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048'
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
            $this->countVehicles = count($this->selected);
            if($this->countVehicles > 0){
                $this->title_modal = 'Delete Vehicles';
                $this->dispatchBrowserEvent('openModal', ['name' => 'deleteVehicleMasive']);
            }else{
                $this->sessionAlert([
                    'message' => 'Please select a vehicle!',
                    'type' => 'danger',
                    'icon' => 'error',
                ]);
            }
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
        $this->year = null;
        $this->make = null;
        $this->model = null;
        $this->vin = null;
        $this->number_vehicle = null;
        $this->user_id = null;
        $this->seeFileVehicle = null;
        $this->image_key = rand();
        $this->driver = null;
        $this->isEdit = false;

    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            // Si selecciona el checkbox padre, selecciona todas las filas
            $this->selected = DB::table('vehicles')
                ->pluck('id')
                ->toArray();
        } else {
            // Si deselecciona el checkbox padre, vacía la selección
            $this->selected = [];
        }
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Vehicle::find($this->modelId);
        $this->make = $model->make;
        $this->model = $model->model;
        $this->year = $model->year;
        $this->vin = $model->vin;
        $this->seeFileVehicle = $model->image;
        $this->number_vehicle = $model->number_vehicle;
        $this->user_id = $model->user_id;
        $this->driver = User::find($this->user_id)->name ?? '';
    }

    public function save()
    {
        if($this->user_id){
            if($this->checkIfUserHasVehicle()){
                return;
            }
        }

        $this->validate();

        if($this->modelId){
            $vehicle = Vehicle::findOrFail($this->modelId);
            $this->isEdit = true;
            // Delete old image
            if($vehicle->image){
                Storage::delete('public/' . $vehicle->image);
            }
        }else{
            $vehicle = new Vehicle;
        }
        $filename = $this->fileVehicle->store('images/vehicle', 'public');

        $vehicle->make = $this->make;
        $vehicle->model = $this->model;
        $vehicle->year = $this->year;
        $vehicle->vin = $this->vin;
        $vehicle->image = $filename;
        $vehicle->user_id = $this->user_id;
        
        $vehicle->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createVehicle']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Vehicle updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Vehicle created successfully!',
                'type' => 'info',
                'icon' => 'check',
            ];
        }

        if ($data) {
            $this->sessionAlert($data);
        }

        $this->clearForm();

    }

    public function delete()
    {
        $vehicle = Vehicle::findOrFail($this->item);
        $vehicle->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteVehicle']);
        
        $data = [
            'message' => 'Vehicle deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
    }

    public function massiveDelete()
    {
        $vehicles = Vehicle::whereKey($this->selected);
        $vehicles->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteVehicleMasive']);

        $data = [
            'message' => 'Vehicles deleted successfully!',
            'type' => 'success',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
    }

    public function forcedCloseModal()
    {
        sleep(2);
        // This is to <re></re>set our public variables
        $this->clearForm();

        // These will reset our error bags
        $this->resetErrorBag();
        $this->resetValidation();
    }

    function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    // funcion que valide si un usuario ya tiene asignado un vehiculo
    public function checkIfUserHasVehicle()
    {
        $user = User::find($this->user_id);
        if (!$user->vehicles) {
            return false;
        }

        if ($user->vehicles && $user->vehicles->count() > 0 && $user->vehicles->id != $this->modelId) {
            $this->dispatchBrowserEvent('closeModal', ['name' => 'createVehicle']);
            $this->sessionAlert([
                'message' => 'You already have a vehicle assigned to you!',
                'type' => 'danger',
                'icon' => 'delete',
            ]);
            return true;
        }
    }

    public function deleteImage(){
        if($this->fileVehicle){
            $this->fileVehicle = null;
        }

        if($this->seeFileVehicle){
            $this->seeFileVehicle = null;
        }
        $this->image_key = rand();
    }

    public function render()
    {
        $roleName = 'Driver';

        $data = DB::table('users')
        ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->select('users.*')
        ->where('roles.name', '=', $roleName)
        ->get();

        return view('livewire.vehicle.index', 
            [
                'vehicles' => Vehicle::where('make', 'like', '%'.$this->search.'%')
                ->paginate(10),
                'drivers' => $data
            ]
        );
    }
}
