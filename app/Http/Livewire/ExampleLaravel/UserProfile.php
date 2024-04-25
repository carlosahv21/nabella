<?php

namespace App\Http\Livewire\ExampleLaravel;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\DB;

class UserProfile extends Component
{

    public $name, $email, $phone, $location, $role, $password, $modelId = '';
    public $item, $action, $search, $countUsers, $title_modal = '';

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
            $this->title_modal = 'Eliminar Usuario';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteUser']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteUserMasive']);
            $this->countUsers = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Crear Usuario';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createUser']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Editar Usuario';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createUser']);
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

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createUser']);
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

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteUser']);
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Usuario eliminado!']);

    }

public function render()
    {
        // sleep(1);
        return view('livewire.user.index', 
            ['users' => User::search('name', $this->search)->paginate(10)]
        );
    }

}
