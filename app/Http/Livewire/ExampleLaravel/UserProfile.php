<?php

namespace App\Http\Livewire\ExampleLaravel;

use App\Models\User;
use App\Models\SchedulingAddress;

use App\Services\AuditLogService;

use Livewire\Component;
use Livewire\WithPagination;

use Illuminate\Support\Facades\DB;

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
        $this->isEdit = false;
    }

    public function save()
    {
        if ($this->modelId) {
            $this->isEdit = true;
            $this->validate();

            $user = User::findOrFail($this->modelId);
        } else {
            $this->validate();
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

        if ($this->isEdit) {
            AuditLogService::log('update', 'user', $user->id);
            $data = [
                'message' => 'User updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            AuditLogService::log('create', 'user', $user->id);
            $data = [
                'message' => 'User created successfully!',
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
        $this->isEdit = false;
    }

    public function delete()
    {
        $user = User::findOrFail($this->item);

        $validation = SchedulingAddress::where('driver_id', $user->id)->get();
        if (count($validation) > 0) {
            $drivers = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*')
            ->where('roles.name', '=', 'Driver')
            ->where('users.id', '!=', $user->id)
            ->get();

            $this->dispatchBrowserEvent('showReasignedDriver', ['options' => $drivers, 'id' => $user->id]);
            return;
        }else{
            $this->deleteDriver($user);
        }
    }

    public function deleteDriver($user){
        $user->deleted = true;
        $user->save();
        AuditLogService::log('delete', 'user', $user->id);
        
        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteUser']);

        $data = [
            'message' => 'User deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
    }

    function sessionAlert($data)
    {
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
        $users = User::where('name', '!=', 'Root')
            ->where(function ($query) {
                $query->where('name', 'like', "%$this->search%")
                    ->orWhere('email', 'like', "%$this->search%");
            })
            ->where('deleted', 0)
            ->paginate(10);


        return view(
            'livewire.user.index',
            [
                'users' => $users,
                'roles' => Role::all(),
            ]
        );
    }
}
