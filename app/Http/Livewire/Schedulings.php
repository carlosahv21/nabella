<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\Event;
use App\Models\Hospital;

class Schedulings extends Component
{
    public $patient_id, $service_contract_id, $hospital_id, $pick_up, $pick_up_time, $check_in, $modelId = '';
    public $item, $action, $search, $title_modal, $countSchedulings = '';
    public $isEdit = false;

    protected $rules=[
        'patient_id' => 'required',
        'service_contract_id' => 'required',
        'hospital_id' => 'required'
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
        $this->patient_id = $model->patient_id;
        $this->service_contract_id = $model->service_contract_id;
        $this->hospital_id = $model->hospital_id;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->patient_id = null;
        $this->service_contract_id = null;
        $this->hospital_id = null;
        $this->isEdit = false;
    }

    public function save()
    {
        if($this->modelId){
            $scheduling = Scheduling::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $scheduling = new Scheduling;
            $this->validate();
        }
        
        $scheduling->patient_id = $this->patient_id;
        $scheduling->service_contract_id = $this->service_contract_id;
        $scheduling->hospital_id = $this->hospital_id;
        
        $scheduling->save();

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
        $scheduling = Scheduling::findOrFail($this->item);
        $scheduling->delete();

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
        $events = Event::all();

        foreach ($events as $event) {
            $events[] =  [
                'id' => $event->id,
                'title' => $event->name,
                'start' => $event->start_time,
                'end' => $event->end_time,
            ];
        }

        return view('livewire.scheduling.index',
        [
            'schedulings' => Scheduling::search('company', $this->search)->paginate(10),
            'patients' => Patient::all(),
            'hospitals' => Hospital::all(),
            'events' => $events,
        ],
    );
    }
}
