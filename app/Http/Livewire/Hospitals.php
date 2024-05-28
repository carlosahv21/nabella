<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Hospital;

class Hospitals extends Component
{
    public $name, $address, $city, $state, $modelId = '';
    public $item, $action, $search, $title_modal, $countHospitals = '';
    public $isEdit = false;

    protected $rules=[
        'name' => 'required',
        'address' => 'required',
        'city' => 'required',
        'state' => 'required',
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Hospital';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteHospital']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteHospitalMasive']);
            $this->countHospitals = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Create Hospital';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createHospital']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Hospital';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createHospital']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Hospital::find($this->modelId);
        $this->name = $model->name;
        $this->address = $model->address;
        $this->city = $model->city;
        $this->state = $model->state;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->address = null;
        $this->city = null;
        $this->state = null;
        $this->isEdit = false;
    }

    public function save()
    {
        if($this->modelId){
            $hospital = Hospital::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $hospital = new Hospital;
            $this->validate();
        }
        
        $hospital->name = $this->name;
        $hospital->address = $this->address;
        $hospital->city = $this->city;
        $hospital->state = $this->state;
        
        $hospital->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createHospital']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Hospital updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Hospital created successfully!',
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
        $hospital = Hospital::findOrFail($this->item);
        $hospital->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteHospital']);
        
        $data = [        
            'message' => 'Hospital deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);

    }

    function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }
    
    public function render()
    {
        return view('livewire.hospital.index', 
        [
            'hospitals' => Hospital::search('name', $this->search)->paginate(10)
        ],
    );
    }
}
