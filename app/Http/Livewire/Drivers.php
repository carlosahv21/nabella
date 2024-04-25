<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
// /Users/carloshernandez/Sites/nabella_app/app/Http/Livewire/ExampleLaravel/UserProfile.php

class Drivers extends Component
{
    public $name, $email, $phone, $location, $password, $modelId = '';
    public $role = 'client';
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
        $this->role = null;
        $this->password = null;
    }

    public function save()
    {
        if($this->modelId){
            $user = User::findOrFail($this->modelId);
        }else{
            $user = new User;
            $user->password = Hash::make('123456'); //solo cuando es un nuevo usuario 
            $this->validate();
        }
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->location = $this->location;
        $user->role = $this->role;    
        
        $user->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createDriver']);
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
        $user = User::findOrFail($this->item);
        $user->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteDriver']);
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Usuario eliminado!']);

    }
    
    public function render()
    {
        return view('livewire.drivers.index', [
            'drivers' => User::search('name', $this->search)->where('role', '=', 'client')->get()
            ]
    );
    }
}
