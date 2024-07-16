<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Address;

use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class Patients extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $service_contract_id, $first_name, $last_name, $birth_date, $phone1, $phone2, $medicalid, $billing_code, $emergency_contact, $date_start, $date_end, $observations, $modelId = '';
    
    public $inputs = [];
    public $inputs_view = [];

    public $item, $action, $search, $title_modal, $countPatients = '';
    public $isEdit = false;

    protected $rules=[
        'first_name' => 'required',
        'last_name' => 'required',
        'phone1' => 'required',
        'observations' => 'required'
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
        $this->service_contract_id = $model->service_contract_id;
        $this->first_name = $model->first_name;
        $this->last_name = $model->last_name;
        $this->birth_date = $model->birth_date;
        $this->phone1 = $model->phone1;
        $this->phone2 = $model->phone2;
        $this->medicalid = $model->medicalid;
        $this->billing_code = $model->billing_code;
        $this->emergency_contact = $model->emergency_contact;
        $this->date_start = $model->date_start;
        $this->date_end = $model->date_end;
        $this->observations = $model->observations;

        $this->inputs_view = Address::where('user_id', $this->modelId)->get();

    }

    private function clearForm()
    {
        $this->service_contract_id = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->birth_date = null;
        $this->phone1 = null;
        $this->phone2 = null;
        $this->medicalid = null;
        $this->billing_code = null;
        $this->emergency_contact = null;
        $this->date_start = null;
        $this->date_end = null;
        $this->observations = null;
        $this->isEdit = false;
        $this->inputs = [];
        $this->inputs_view = [];
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
        
        $patient->service_contract_id = $this->service_contract_id;
        $patient->first_name = $this->first_name;
        $patient->last_name = $this->last_name;
        $patient->birth_date = $this->birth_date;
        $patient->phone1 = $this->phone1;
        $patient->phone2 = ($this->phone2) ? $this->phone2 : '';
        $patient->medicalid = $this->medicalid;
        $patient->billing_code = $this->billing_code;
        $patient->emergency_contact = $this->emergency_contact;
        $patient->date_start = $this->date_start;
        $patient->date_end = $this->date_end;
        $patient->observations = $this->observations;

        $patient->save();

        for ($i=0; $i < count($this->inputs); $i++) { 
            $address = new Address;

            $address->user_id = $patient->id;
            $address->address = $this->inputs[$i];

            $address->save();
        }

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

    public function addInput()
    {
        $this->inputs[] = '';
    }

    public function removeInput($index)
    {
        unset($this->inputs[$index]);
        $this->inputs = array_values($this->inputs); // Reindex array
    }
    
    public function render()
    {
        return view('livewire.patient.index', 
            [
                'patients' => Patient::search('first_name', $this->search)->paginate(10),
                'service_contracts' => DB::table('service_contracts')->get()
            ],
        );
    }
}
