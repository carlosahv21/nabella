<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceContract;
use Carbon\Carbon;
use Exception;

use Livewire\WithPagination;

class ServiceContracts extends Component
{

    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $company, $contact_name, $wheelchair, $ambulatory, $out_of_hours, $saturdays, $sundays_holidays, $companion, $additional_waiting, $after, $fast_track, $if_not_cancel, $rate_per_mile, $overcharge, $address, $phone, $state, $email, $date_start, $date_end, $modelId = '';
    public $selectedAll = false;
    public $selected = [];
    public $item, $action, $search, $title_modal, $countServiceContracts = '';
    public $isEdit = false;

    protected $rules=[
        'state' => 'required',
        'date_start' => 'required',
        'date_end' => 'required',
        'email' => 'email'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Service Contract';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteServiceContract']);
        }else if($action == 'masiveDelete'){
            $this->countServiceContracts = count($this->selected);
            if($this->countServiceContracts > 0){
                $this->title_modal = 'Delete Contracts';
                $this->dispatchBrowserEvent('openModal', ['name' => 'deleteServiceContractMasive']);
            }else{
                $this->sessionAlert([
                    'message' => 'Please select a service contract!',
                    'type' => 'danger',
                    'icon' => 'error',
                ]);
            }
        }else if($action == 'create'){
            $this->title_modal = 'Create Service Contract';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createServiceContract']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Service Contract';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createServiceContract']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = ServiceContract::find($this->modelId);
        $this->company = $model->company;
        $this->contact_name = $model->contact_name;
        $this->wheelchair = $model->wheelchair;
        $this->ambulatory = $model->ambulatory;
        $this->out_of_hours = $model->out_of_hours;
        $this->saturdays = $model->saturdays;
        $this->sundays_holidays = $model->sundays_holidays;
        $this->companion = $model->companion;
        $this->additional_waiting = $model->additional_waiting;
        $this->after = $model->after;
        $this->fast_track = $model->fast_track;
        $this->if_not_cancel = $model->if_not_cancel;
        $this->rate_per_mile = $model->rate_per_mile;
        $this->overcharge = $model->overcharge;
        $this->address = $model->address;
        $this->phone = $model->phone;
        $this->state = $model->state;
        $this->email = $model->email;
        $this->date_start = Carbon::createFromFormat('Y-m-d', $model->date_start)->format('m-d-Y');
        $this->date_end = Carbon::createFromFormat('Y-m-d', $model->date_end)->format('m-d-Y');
    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            // Si selecciona el checkbox padre, selecciona todas las filas
            $this->selected = ServiceContract::all()
                ->pluck('id')
                ->toArray();
        } else {
            // Si deselecciona el checkbox padre, vacía la selección
            $this->selected = [];
        }
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->company = null;
        $this->wheelchair = null;
        $this->ambulatory = null;
        $this->out_of_hours = null;
        $this->saturdays = null;
        $this->sundays_holidays = null;
        $this->companion = null;
        $this->additional_waiting = null;
        $this->after = null;
        $this->fast_track = null;
        $this->if_not_cancel = null;
        $this->contact_name = null;
        $this->rate_per_mile = null;
        $this->overcharge = null;
        $this->address = null;
        $this->phone = null;
        $this->state = null;
        $this->email = null;
        $this->date_start = null;
        $this->date_end = null;
        $this->isEdit = false;
    }

    public function save()
    {
        if($this->modelId){
            $servicecontract = ServiceContract::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $servicecontract = new ServiceContract;
            $this->validate();
        }

        $formats = ['Y-m-d', 'm-d-Y', 'd-m-Y', 'Y/m/d', 'm/d/Y', 'd/m/Y']; // Lista de formatos comunes

        foreach ($formats as $format) {
            try {
                // Intentamos crear la fecha con cada formato
                $convertedDateStart = Carbon::createFromFormat($format, $this->date_start)->format('Y-m-d');
                $convertedDateEnd = Carbon::createFromFormat($format, $this->date_start)->format('Y-m-d');

                break; // Si logra convertir, se sale del ciclo
            } catch (Exception $e) {
                // Si falla, continúa con el siguiente formato
                continue;
            }
        }

        if (!$convertedDateStart) {
            $convertedDateStart = Carbon::now()->format('Y-m-d');
        }

        if(!$convertedDateEnd){
            $convertedDateEnd = Carbon::now()->format('Y-m-d');
        }

        $servicecontract->company = $this->company;
        $servicecontract->contact_name = $this->contact_name;
        $servicecontract->wheelchair = ($this->wheelchair) ? $this->wheelchair : 0;
        $servicecontract->ambulatory = ($this->ambulatory) ? $this->ambulatory : 0;
        $servicecontract->out_of_hours = ($this->out_of_hours) ? $this->out_of_hours : 0;
        $servicecontract->saturdays = ($this->saturdays) ? $this->saturdays : 0;
        $servicecontract->sundays_holidays = ($this->sundays_holidays) ? $this->sundays_holidays : 0;
        $servicecontract->companion = ($this->companion) ? $this->companion : 0;
        $servicecontract->additional_waiting = ($this->additional_waiting) ? $this->additional_waiting : 0;
        $servicecontract->after = ($this->after) ? $this->after : 0;
        $servicecontract->fast_track = ($this->fast_track) ? $this->fast_track : 0;
        $servicecontract->if_not_cancel = ($this->if_not_cancel) ? $this->if_not_cancel : 0;
        $servicecontract->rate_per_mile = ($this->rate_per_mile) ? $this->rate_per_mile : 0;
        $servicecontract->overcharge = ($this->overcharge) ? $this->overcharge : 0;
        $servicecontract->address = $this->address;
        $servicecontract->phone = $this->phone;
        $servicecontract->date_start = $convertedDateStart;
        $servicecontract->date_end = $convertedDateEnd;
        $servicecontract->state = $this->state;
        $servicecontract->email = $this->email;
        
        $servicecontract->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createServiceContract']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Service Contract updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Service Contract created successfully!',
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
        $ServiceContract = ServiceContract::findOrFail($this->item);
        $ServiceContract->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteServiceContract']);

        $data = [
            'message' => 'Service Contract deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);

    }

    public function massiveDelete()
    {
        $servicecontracts = ServiceContract::whereKey($this->selected);
        $servicecontracts->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteServiceContractMasive']);

        $data = [
            'message' => 'Contracts deleted successfully!',
            'type' => 'success',
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
        return view('livewire.servicecontract.index', 
            [
                'servicecontracts' => ServiceContract::search('company', $this->search)->orderBy('company', 'asc')->paginate(10)
            ],
        );
    }
}
