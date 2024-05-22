<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ServiceContract;
use Illuminate\Support\Facades\DB;

class ServiceContracts extends Component
{
    public $subject, $state, $date_start, $date_end, $client_id, $modelId = '';
    public $item, $action, $search, $title_modal, $countServiceContracts = '';

    protected $rules=[
        'subject' => 'required',
        'state' => 'required',
        'date_start' => 'required',
        'date_end' => 'required',
        'client_id' => 'required',
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
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteServiceContractMasive']);
            $this->countServiceContracts = count($this->selected);
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
        $this->subject = $model->subject;
        $this->state = $model->state;
        $this->date_start = $model->date_start;
        $this->date_end = $model->date_end;
        $this->client_id = $model->client_id;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->subject = null;
        $this->state = null;
        $this->date_start = null;
        $this->date_end = null;
        $this->client_id = null;
    }

    public function save()
    {
        if($this->modelId){
            $servicecontract = ServiceContract::findOrFail($this->modelId);
        }else{
            $servicecontract = new ServiceContract;
            $this->validate();
        }
        
        $servicecontract->subject = $this->subject;
        $servicecontract->state = $this->state;
        $servicecontract->date_start = $this->date_start;
        $servicecontract->date_end = $this->date_end;
        $servicecontract->client_id = $this->client_id;
        
        $servicecontract->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createServiceContract']);
        $this->clearForm();
    }

    public function forcedCloseModal()
    {
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
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'ServiceContract delete!']);

    }
    
    public function render()
    {
        return view('livewire.servicecontract.index', 
            [
                'servicecontracts' => ServiceContract::search('company', $this->search)->paginate(10),
                'clients' => DB::table('clients')->get()
            ],
        );
    }
}