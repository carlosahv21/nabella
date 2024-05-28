<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;

class Schedulings extends Component
{
    public $company, $contact_name, $rate_per_mile, $modelId = '';
    public $item, $action, $search, $title_modal, $countSchedulings = '';
    public $isEdit = false;

    protected $rules=[
        'company' => 'required',
        'contact_name' => 'required',
        'rate_per_mile' => 'required'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Scheduling';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteScheduling']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteSchedulingMasive']);
            $this->countSchedulings = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Create Scheduling';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Scheduling';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Scheduling::find($this->modelId);
        $this->company = $model->company;
        $this->contact_name = $model->contact_name;
        $this->rate_per_mile = $model->rate_per_mile;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->company = null;
        $this->contact_name = null;
        $this->rate_per_mile = null;
        $this->isEdit = false;
    }

    public function save()
    {
        if($this->modelId){
            $client = Scheduling::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $client = new Scheduling;
            $this->validate();
        }
        
        $client->company = $this->company;
        $client->contact_name = $this->contact_name;
        $client->rate_per_mile = $this->rate_per_mile;
        
        $client->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Scheduling updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Scheduling created successfully!',
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
        $client = Scheduling::findOrFail($this->item);
        $client->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteScheduling']);
        
        $data = [        
            'message' => 'Scheduling deleted successfully!',
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
        return view('livewire.scheduling.index',
        [
            'schedulings' => Scheduling::search('company', $this->search)->paginate(10)
        ],
    );
    }
}
