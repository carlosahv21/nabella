<?php

namespace App\Http\Livewire\ExampleLaravel;

use App\Models\User;
use Livewire\Component;

use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class UserProfile extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $email, $phone, $location, $role, $password, $modelId = '';
    public $item, $action, $search, $countUsers, $title_modal = '';
    public $isEdit = false;

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'delete') {
            $this->title_modal = 'Eliminar Usuario';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteUser']);
        } else if ($action == 'masiveDelete') {
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteUserMasive']);
            $this->countUsers = count($this->selected);
        } else if ($action == 'create') {
            $this->title_modal = 'Crear Usuario';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createUser']);
            $this->emit('clearForm');
        } else {
            $this->title_modal = 'Editar Usuario';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createUser']);
            $this->emit('getModelId', $this->item);
        }
    }

    public function rules()
    {
        if ($this->isEdit) {
            return [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'role' => 'required|string|exists:roles,name',
            ];
        } else {
            
            return [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|string|exists:roles,name',
            ];
        }
    }

    public function getModelId($modelId)
    {

        $this->modelId = $modelId;

        $model = User::find($this->modelId);
        $this->name = $model->name;
        $this->email = $model->email;
        $this->phone = $model->phone;
        $this->location = $model->location;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->location = null;
        $this->role = null;
        $this->password = null;
    }

    public function save()
    {
        $this->validate();

        if ($this->modelId) {
            $this->isEdit = true;
            $user = User::findOrFail($this->modelId);
        } else {
            $user = new User;
            $user->password = ('123456'); //solo cuando es un nuevo usuario 
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->location = $this->location;
        $user->syncRoles($this->role);

        $user->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createUser']);
        $this->clearForm();

        if ($this->isEdit) {
            $data = [
                'message' => 'User updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'User created successfully!',
                'type' => 'info',
                'icon' => 'check',
            ];
        }

        if ($data) {
            $this->sessionAlert($data);
        }
    }

    public function forcedCloseModal()
    {
        // This is to <re></re>set our public variables
        $this->clearForm();

        // These will reset our error bags
        $this->resetErrorBag();
        $this->resetValidation();
        $this->isEdit = false;
    }

    public function delete()
    {
        $user = User::findOrFail($this->item);
        $user->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteUser']);
        
        $data = [
            'message' => 'User deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);

    }

    function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatinDelete()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view(
            'livewire.user.index',
            [
                'users' => User::where('name', "like", "%$this->search%")
                    ->orWhere('email', "like", "%$this->search%")
                    ->paginate(10),
                'roles' => Role::all(),
            ]
        );
    }
}
