<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Facility;
use App\Models\Address;
use App\Models\ServiceContract;
use App\Models\ApisGoogle;

use Livewire\WithPagination;

class Facilities extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $name, $service_contract_id, $address, $city, $state, $modelId = '';
    public $item, $action, $search, $title_modal, $countFacilities = '';
    public $selectedAll = false;
    public $selected = [];
    public $isEdit = false;

    public $stops = [
        [
            'address' => '',
            'addresses' => []
        ]
    ];

    public $inputs_view = [];
    public $type = 'Facility';

    public $google;

    protected $rules=[
        'name' => 'required',
        'service_contract_id' => 'required'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];

    public function __construct()
    {
        $this->google = new ApisGoogle();
    }
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Facility';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteFacility']);
        }else if($action == 'masiveDelete'){
            $this->countFacilities = count($this->selected);
            if($this->countFacilities > 0){
                $this->title_modal = 'Delete Facilities';
                $this->dispatchBrowserEvent('openModal', ['name' => 'deleteFacilityMasive']);
            }else{
                $this->sessionAlert([
                    'message' => 'Please select a facility!',
                    'type' => 'danger',
                    'icon' => 'error',
                ]);
            }
        }else if($action == 'create'){
            $this->clearForm();
            $this->title_modal = 'Create Facility';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createFacility']);
        }else{
            $this->title_modal = 'Edit Facility';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createFacility']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            // Si selecciona el checkbox padre, selecciona todas las filas
            $this->selected = Facility::all()
                ->pluck('id')
                ->toArray();
        } else {
            // Si deselecciona el checkbox padre, vacía la selección
            $this->selected = [];
        }
    }

    public function updateStop($index, $query)
    {
        $this->stops[$index]['address'] = $query;

        if (strlen($query) >= 3) {
            $googlePredictions = $this->google->getPlacePredictions($query);
            $this->stops[$index]['addresses'] = $googlePredictions;
        } else {
            $this->stops[$index]['addresses'] = [];
        }
    }

    public function selectStopAddress($index, $address)
    {
        $this->stops[$index]['address'] = $address;
        $this->stops[$index]['addresses'] = [];
    }


    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Facility::find($this->modelId);
        $this->name = $model->name;
        $this->service_contract_id = $model->service_contract_id;
        $this->address = $model->address;
        $this->city = $model->city;
        $this->state = $model->state;

        $this->inputs_view = Address::where('facility_id', $this->modelId)->get();

    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->service_contract_id = null;
        $this->address = null;
        $this->city = null;
        $this->state = null;
        $this->isEdit = false;
        $this->inputs_view = [];

        $this->stops = [
            [
                'address' => '',
                'addresses' => []
            ]
        ];
    }

    public function removeAddress($index, $id)
    {
        $address = Address::find($id);
        $address->delete();
        unset($this->inputs_view[$index]);
    }

    public function save()
    {
        $this->validate();

        if (count($this->stops) == 0 && count($this->inputs_view) == 0) {
            $this->dispatchBrowserEvent('showAlert', [
                'text' => 'Please add at least one address!',
                'icon' => 'warning'
            ]);
            return;
        }
        
        if($this->modelId){
            $facility = Facility::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $facility = new Facility;
        }
        
        $facility->name = $this->name;
        $facility->service_contract_id = $this->service_contract_id;
        $facility->save();

        for ($i=0; $i < count($this->stops); $i++) {
            if (empty($this->stops[$i]['address'])) {
                continue;
            }

            $address = new Address;

            $address->facility_id = $facility->id;
            $address->address = $this->stops[$i]['address'];
            $address->entity_type = $this->type;

            $address->save();
        }

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createFacility']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Facility updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Facility created successfully!',
                'type' => 'info',
                'icon' => 'check',
            ];
        }

        if ($data) {
            $this->sessionAlert($data);
        }

        $this->clearForm();

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

    public function delete()
    {
        $facility = Facility::findOrFail($this->item);
        
        $action = $this->actionDelete($facility);
        if($action){
            $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteFacility']);

            $data = [
                'message' => 'Facility deleted successfully!',
                'type' => 'danger',
                'icon' => 'delete',
            ];
            $this->sessionAlert($data);
        }else{
            $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteFacility']);

            $data = [
                'message' => 'Facility not deleted!',
                'type' => 'danger',
                'icon' => 'delete',
            ];
            $this->sessionAlert($data);
        }

    }

    public function masiveDelete()
    {
        $data = [];
        foreach ($this->selected as $facility) {
            $facility = Facility::findOrFail($facility);
            $action = $this->actionDelete($facility);
            if($action){
                $data = [
                    'message' => 'Facilities deleted successfully!',
                    'type' => 'success',
                    'icon' => 'delete',
                ];
            }else{
                $data = [
                    'message' => 'Facilities not deleted!',
                    'type' => 'danger',
                    'icon' => 'delete',
                ];
            }
        }
        $this->sessionAlert($data);

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteFacilityMasive']);

    }

    public function actionDelete($facility){

        $facility = Facility::findOrFail($facility->id);
        $address = Address::where('facility_id', $facility->id)->get();
        foreach ($address as $addr) {
            $addr->delete();
        }

        if($facility->delete()){
            return true;
        }

        return false;
    }

    public function addStop()
    {
        $this->stops[] = ['address' => '', 'addresses' => []];
    }

    public function removeStop($index)
    {
        unset($this->stops[$index]);
        $this->stops = array_values($this->stops); // Reindex array
    }

    function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }
    
    public function render()
    {
        return view('livewire.facility.index', 
        [
            'facilities' => Facility::search('name', $this->search)->paginate(10),
            'service_contracts' => ServiceContract::all()
        ],
    );
    }
}
