<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Livewire\Component;

class Roles extends Component
{
    public $search, $title_modal, $item, $countRoles, $name, $permisions, $modelId = '';

    protected $rules=[
        'name' => 'required|min:3',
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Role';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteRole']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteRoleMasive']);
            $this->countRoles = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Create Role';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createRole']);
            $this->emit('clearForm');
        }else if($action == 'permitions'){
            $this->title_modal = 'Manage Permissions';
            $this->dispatchBrowserEvent('openModal', ['name' => 'rolePermitions']);
        }else{
            $this->title_modal = 'Edit Role';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createRole']);
            $this->emit('getModelId', $this->item);

        }
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Role::find($this->modelId);
        $this->name = $model->name;
    }

    public function save()
    {
        if($this->modelId){
            $role = Role::findOrFail($this->modelId);
        }else{
            $role = new Role;
            $this->validate();
        }
        
        $role->name = $this->name;
        
        $role->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createRole']);
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

    public function render()
    {
        return view('livewire.role.index', 
        ['roles' => Role::search('name', $this->search)->paginate(10)]
    );
    }
}
