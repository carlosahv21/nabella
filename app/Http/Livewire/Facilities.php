<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Facility;
use App\Models\Address;

use Livewire\WithPagination;

class Facilities extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $name, $address, $city, $state, $modelId = '';
    public $item, $action, $search, $title_modal, $countFacilities = '';
    public $isEdit = false;

    public $inputs = [];
    public $zipcode = [];
    public $inputs_view = [];
    public $type = 'Facility';

    protected $rules=[
        'name' => 'required'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Facility';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteFacility']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteFacilityMasive']);
            $this->countFacilities = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Create Facility';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createFacility']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Facility';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createFacility']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Facility::find($this->modelId);
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
            $facility = Facility::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $facility = new Facility;
            $this->validate();
        }
        
        $facility->name = $this->name;
        $facility->save();

        for ($i=0; $i < count($this->inputs); $i++) { 
            $address = new Address;

            $address->facility_id = $facility->id;
            $address->address = $this->inputs[$i].', '.$this->state[$i].', '.$this->zipcode[$i];
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
        $facility->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteFacility']);
        
        $data = [        
            'message' => 'Facility deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);

    }

    public function addInput()
    {
        $this->inputs[] = '';
    }

    public function removeInput($index)
    {
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs); // Reindex array
    }

    function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }
    
    public function render()
    {
        return view('livewire.facility.index', 
        [
            'facilities' => Facility::search('name', $this->search)->paginate(10)
        ],
    );
    }
}
