<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class Patients extends Component
{
    public $name, $birthdate, $description, $modelId = '';
    public $item, $action, $search, $title_modal, $countPatients = '';
    public $isEdit = false;

    protected $rules=[
        'name' => 'required',
        'description' => 'required'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Patient';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deletePatient']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deletePatientMasive']);
            $this->countPatients = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Create Patient';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createPatient']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Patient';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createPatient']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Patient::find($this->modelId);
        $this->name = $model->name;
        $this->birthdate = $model->birthdate;
        $this->description = $model->description;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->birthdate = null;
        $this->description = null;
        $this->isEdit = false;
    }

    public function save()
    {
        if($this->modelId){
            $patient = Patient::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $patient = new Patient;
            $this->validate();
        }
        
        $patient->name = $this->name;
        $patient->birthdate = $this->birthdate;
        $patient->description = $this->description;
        
        $patient->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createPatient']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Patient updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Patient created successfully!',
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
        $Patient = Patient::findOrFail($this->item);
        $Patient->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deletePatient']);

        $data = [
            'message' => 'Patient deleted successfully!',
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
        return view('livewire.patient.index', 
            [
                'patients' => Patient::search('company', $this->search)->paginate(10),
                'clients' => DB::table('clients')->get()
            ],
        );
    }
}
