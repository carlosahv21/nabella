<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Patient;
use App\Models\Address;
use App\Models\Scheduling;
use App\Models\SchedulingAddress;
use App\Models\SchedulingCharge;
use App\Models\ApisGoogle;

use Illuminate\Support\Facades\DB;

use Livewire\WithPagination;

class Patients extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $service_contract_id, $first_name, $last_name, $birth_date, $phone1, $phone2, $medicalid, $billing_code, $emergency_contact, $date_start, $date_end, $observations, $modelId = '';
    public $selectedAll = false;

    public $stops = [
        [
            'address' => '',
            'addresses' => []
        ]
    ];

    public $description = [];
    
    public $inputs_view = [];
    public $type = 'Patient';

    public $selected = [];
    public $item, $action, $search, $title_modal, $countPatients = '';
    public $isEdit = false;

    public $google;

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];

    public function __construct()
    {
        $this->google = new ApisGoogle();
    }

    protected function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone1' => 'required',
            'medicalid' => ['required', 'unique:patients,medicalid,' . $this->item],
        ];
    }

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'delete') {
            $this->title_modal = 'Delete Patient';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deletePatient']);
        } else if ($action == 'masiveDelete') {
            $this->countPatients = count($this->selected);
            if ($this->countPatients > 0) {
                $this->title_modal = 'Delete Patients';
                $this->dispatchBrowserEvent('openModal', ['name' => 'deletePatientMasive']);
            } else {
                $this->sessionAlert([
                    'message' => 'Please select a patient!',
                    'type' => 'danger',
                    'icon' => 'error',
                ]);
            }
        } else if ($action == 'create') {
            $this->title_modal = 'Create Patient';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createPatient']);
            $this->emit('clearForm');
        } else {
            $this->title_modal = 'Edit Patient';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createPatient']);
            $this->emit('getModelId', $this->item);
        }
    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            // Si selecciona el checkbox padre, selecciona todas las filas
            $this->selected = Patient::all()
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

        $sql = "SELECT * FROM addresses WHERE patient_id = '$this->modelId'";
        $patient_addresses = DB::select($sql);
        
        foreach ($patient_addresses as $address) {
            $this->inputs_view[] = [
                'id' => $address->id,
                'address' => $address->address.', '.$address->description
            ];
        }

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
        $this->inputs_view = [];
        $this->modelId = null;

        $this->stops = [
            [
                'address' => '',
                'addresses' => []
            ]
        ];

        $this->description = [];
    }

    public function save()
    {
        $this->validate();

        if ($this->modelId) {
            $patient = Patient::findOrFail($this->modelId);
            $this->isEdit = true;
        } else {
            $patient = new Patient;
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

        if ($this->stops) {
            for ($i = 0; $i < count($this->stops); $i++) {
                if (empty($this->stops[$i]['address'])) {
                    continue;
                }

                $address = new Address;

                $address->patient_id = $patient->id;
                $address->address = $this->stops[$i]['address'];
                $address->description = $this->description[$i];
                $address->entity_type = $this->type;

                $address->save();
            }
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

    public function removeAddress($index, $id)
    {
        $address = Address::find($id);
        $address->delete();
        unset($this->inputs_view[$index]);
    }

    public function delete()
    {
        $patient = Patient::findOrFail($this->item);

        $action = $this->actionDelete($patient);
        if ($action) {
            $this->dispatchBrowserEvent('closeModal', ['name' => 'deletePatient']);

            $data = [
                'message' => 'Patient deleted successfully!',
                'type' => 'danger',
                'icon' => 'delete',
            ];
            $this->sessionAlert($data);
        } else {
            $this->dispatchBrowserEvent('closeModal', ['name' => 'deletePatient']);

            $data = [
                'message' => 'Patient not deleted!',
                'type' => 'danger',
                'icon' => 'delete',
            ];
            $this->sessionAlert($data);
        }
    }

    public function masiveDelete()
    {
        foreach ($this->selected as $patient) {
            $patient = Patient::findOrFail($patient);
            $action = $this->actionDelete($patient);
            if ($action) {
                $this->dispatchBrowserEvent('closeModal', ['name' => 'deletePatientMasive']);

                $data = [
                    'message' => 'Patients deleted successfully!',
                    'type' => 'success',
                    'icon' => 'delete',
                ];
                $this->sessionAlert($data);
            } else {
                $this->dispatchBrowserEvent('closeModal', ['name' => 'deletePatientMasive']);

                $data = [
                    'message' => 'Patients not deleted!',
                    'type' => 'danger',
                    'icon' => 'delete',
                ];
                $this->sessionAlert($data);
            }
        }
    }

    public function actionDelete($patient)
    {

        $schedulings = Scheduling::where('patient_id', $patient->id)->get();
        if (count($schedulings) > 0) {
            foreach ($schedulings as $scheduling) {
                $scheduling_charge = SchedulingCharge::where('scheduling_id', $scheduling->id)->get();
                foreach ($scheduling_charge as $charge) {
                    $charge->delete();
                }

                $scheduling_address = SchedulingAddress::where('scheduling_id', $scheduling->id)->get();
                foreach ($scheduling_address as $address) {
                    $address->delete();
                }
                $scheduling->delete();
            }
        }
        $address = Address::where('patient_id', $patient->id)->get();
        foreach ($address as $addr) {
            $addr->delete();
        }

        if ($patient->delete()) {
            return true;
        }

        return false;
    }

    function sessionAlert($data)
    {
        session()->flash('alert', $data);

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
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

    public function render()
    {
        return view(
            'livewire.patient.index',
            [
                'patients' => Patient::search('first_name', $this->search)->paginate(10),
                'service_contracts' => DB::table('service_contracts')->get()
            ],
        );
    }
}
