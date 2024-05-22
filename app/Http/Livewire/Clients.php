<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Client;

class Clients extends Component
{
    public $company, $contact_name, $rate_per_mile, $modelId = '';
    public $item, $action, $search, $title_modal, $countClients = '';
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
            $this->title_modal = 'Delete Client';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteClient']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteClientMasive']);
            $this->countClients = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Create Client';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createClient']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Client';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createClient']);
            $this->emit('getModelId', $this->item);

        }
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Client::find($this->modelId);
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
            $client = Client::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $client = new Client;
            $this->validate();
        }
        
        $client->company = $this->company;
        $client->contact_name = $this->contact_name;
        $client->rate_per_mile = $this->rate_per_mile;
        
        $client->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createClient']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Client updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Client created successfully!',
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
        $client = Client::findOrFail($this->item);
        $client->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteClient']);
        
        $data = [        
            'message' => 'Client deleted successfully!',
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
        return view('livewire.client.index', 
        [
            'clients' => Client::search('company', $this->search)->paginate(10)
        ],
    );
    }
}
