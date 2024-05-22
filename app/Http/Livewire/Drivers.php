<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

// /Users/carloshernandez/Sites/nabella_app/app/Http/Livewire/ExampleLaravel/UserProfile.php

class Drivers extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $name, $email, $phone, $location, $password, $modelId = '';
    public $role = 'Driver';
    public $item, $action, $search, $title_modal, $countDrivers = '';

    protected $rules=[
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Eliminar Conductor';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteDriver']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteDriverMasive']);
            $this->countDrivers = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Crear Conductor';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createDriver']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Editar Conductor';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createDriver']);
            $this->emit('getModelId', $this->item);

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
        $this->role = $model->role;
    }

    private function clearForm()
    {
        $this->modelId = null;
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->location = null;
        $this->password = null;
    }

    public function save()
    {
        if($this->modelId){
            $user = User::findOrFail($this->modelId);
        }else{
            $user = new User;
            $user->password = ('123456'); //solo cuando es un nuevo usuario 
            $this->validate();
        }
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->location = $this->location;
        $user->syncRoles($this->role);
        
        $user->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createDriver']);
        $this->clearForm();

        $data = [
            'message' => 'User deleted successfully!',
            'type' => 'danger',
            'icon' => 'delete',
        ];
        $this->sessionAlert($data);
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
        $user = User::findOrFail($this->item);
        $user->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteDriver']);
        
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
    
    public function render()
    {
        $roleName = 'Driver';

        $data = DB::table('users')
            ->leftjoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftjoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*')
            ->where('roles.name', '=', $roleName)
            ->where('users.id', '!=', auth()->id())
            ->where('users.name', 'like', '%'.$this->search.'%')
            ->paginate(10);

        return view('livewire.drivers.index', [
            'drivers' => $data
            ]
        );
    }
}
