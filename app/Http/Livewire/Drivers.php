<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\User;
use App\Models\SchedulingAddress;

use App\Mail\WelcomeEmail;

use App\Services\AuditLogService;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class Drivers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $email, $phone, $password, $dob, $dl_state, $dl_number, $date_of_hire, $prefixs, $phone_prefix, $modelId = '';
    public $item, $action, $search, $title_modal, $countDrivers = '';
    public $selectedAll = false;
    public $selected = [];
    public $driver_color = '#5e72e4';
    public $role = 'Driver';
    public $isEdit = false;

    public function rules()
    {
        return [
            'name' => 'required|min:3',
            'email' => ['required', 'unique:users,email,' . $this->item],
            'driver_color' => 'required',
        ];
    }

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
        'reassignDriverAndDelete'
    ];

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'delete') {
            $this->title_modal = 'Delete Driver';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteDriver']);
        } else if ($action == 'masiveDelete') {
            $this->countDrivers = count($this->selected);
            if ($this->countDrivers > 0) {
                $this->title_modal = 'Delete Drivers';
                $this->dispatchBrowserEvent('openModal', ['name' => 'deleteDriverMasive']);
            } else {
                $this->sessionAlert([
                    'message' => 'Please select a driver!',
                    'type' => 'danger',
                    'icon' => 'error',
                ]);
            }
        } else if ($action == 'see') {
            $this->title_modal = 'See Details';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeDriver']);
            $this->emit('getModelId', $this->item);
        } else if ($action == 'create') {
            $this->title_modal = 'Create Driver';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createDriver']);
            $this->emit('clearForm');
        } else {
            $this->title_modal = 'Edit Driver';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createDriver']);
            $this->emit('getModelId', $this->item);
        }
    }

    public function updatedSelectedAll($value)
    {
        if ($value) {
            // Si selecciona el checkbox padre, selecciona todas las filas
            $this->selected = DB::table('users')
                ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('roles.name', '=', 'Driver')
                ->where('users.id', '!=', auth()->id())
                ->where('users.name', 'like', '%' . $this->search . '%')
                ->pluck('users.id')
                ->toArray();
        } else {
            // Si deselecciona el checkbox padre, vacía la selección
            $this->selected = [];
        }
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = User::find($this->modelId);
        $this->name = $model->name;
        $this->email = $model->email;

        // Valor predeterminado
        $this->phone_prefix = '+1';
        $phone = $model->phone;

        foreach (array_keys($this->prefixs) as $prefix) {
            if (str_starts_with($phone, $prefix)) {
                $this->phone_prefix = $prefix;
                $this->phone = substr($phone, strlen($prefix));
                break;
            }
        }

        if (!isset($this->phone)) {
            $this->phone = $phone;
        }

        $this->dob = $model->dob;
        $this->driver_color = $model->driver_color;
        $this->dl_state = $model->dl_state;
        $this->dl_number = $model->dl_number;
        $this->date_of_hire = $model->date_of_hire;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->dob = null;
        $this->dl_state = null;
        $this->dl_number = null;
        $this->date_of_hire = null;
        $this->password = null;
        $this->isEdit = false;
    }

    public function save()
    {
        $this->validate();

        if ($this->modelId) {
            $this->isEdit = true;
            $user = User::findOrFail($this->modelId);
        } else {
            $user = new User;
            $user->password = ('secret'); //solo cuando es un nuevo usuario 
        }

        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone_prefix . $this->phone;
        $user->dob = $this->dob;
        $user->driver_color = $this->driver_color;
        $user->dl_state = $this->dl_state;
        $user->dl_number = $this->dl_number;
        $user->date_of_hire = $this->date_of_hire;

        $user->syncRoles($this->role);

        $user->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createDriver']);

        if ($this->isEdit) {
            AuditLogService::log('update', 'user', $user->id);
            $data = [
                'message' => 'User updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            Mail::to($user->email)->send(new WelcomeEmail($user));
            
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

    public function reassignDriverAndDelete($driverId, $userId)
    {
        $scheduling_address = SchedulingAddress::where('driver_id', $userId)->get();
        foreach ($scheduling_address as $address) {
            $address->driver_id = $driverId;
            $address->save();
        }

        $user = User::findOrFail($userId);
        $this->deleteDriver($user);
    }

    public function deleteDriver($user){
        $user->deleted = true;
        $user->save();

        AuditLogService::log('delete', 'user', $user->id);
        
        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteDriver']);

        $data = [
            'message' => 'User deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
    }

    public function massiveDelete()
    {
        $drivers = User::whereKey($this->selected);
        $drivers->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteDriverMasive']);

        $data = [
            'message' => 'Drivers deleted successfully!',
            'type' => 'success',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
    }

    function sessionAlert($data)
    {
        session()->flash('alert', $data);

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function render()
    {
        $drivers = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*')
            ->where('roles.name', '=', 'Driver')
            ->where('users.id', '!=', auth()->id())
            ->where('users.name', '!=', 'Root')
            ->where(function ($query) {
                $query->where('users.name', 'like', '%' . $this->search . '%')
                    ->orWhere('users.email', 'like', '%' . $this->search . '%');
            })
            ->where('deleted',0)
            ->orderBy('users.name', 'asc')
            ->paginate(10);


        $this->prefixs = Config::get('phone_prefixes');

        return view(
            'livewire.drivers.index',
            [
                'drivers' => $drivers,
                'prefixs' => $this->prefixs
            ]
        );
    }
}
