<?php

namespace App\Http\Livewire;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\Component;

class Roles extends Component
{
    public $search, $title_modal, $item, $countRoles, $name, $modelId = '';
    public $isEdit = false;
    public $checkPermitions = [];

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

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = Role::find($this->modelId);
        $this->checkPermitions = $model->permissions()->pluck('id')->toArray();
        $this->name = $model->name;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->checkPermitions = [];
        $this->name = null;
        $this->isEdit = false;
    }

    public function save()
    {
        if($this->modelId){
            $role = Role::findOrFail($this->modelId);
            $this->isEdit = true;
        }else{
            $role = new Role;
            $this->validate();
        }
        
        $role->name = $this->name;
        $role->guard_name = 'web';
        $role->save();

        $role->permissions()->sync($this->checkPermitions);
        
        $this->dispatchBrowserEvent('closeModal', ['name' => 'createRole']);

        if ($this->isEdit) {
            $data = [
                'message' => 'Role updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Role created successfully!',
                'type' => 'info',
                'icon' => 'check',
            ];
        }

        if ($data) {
            $this->sessionAlert($data);
        }

        $this->clearForm();
    }

    public function delete()
    {   
        $role = Role::findOrFail($this->item);
        $role->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteRole']);
        
        $data = [        
            'message' => 'Role deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
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


    public function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function render()
    {
        $permissions = Permission::all(['id', 'name']);

        return view('livewire.role.index', 
        [
            'roles' => Role::search('name', $this->search)->paginate(10),
            'permissions' => $permissions
        ]
    );
    }
}
