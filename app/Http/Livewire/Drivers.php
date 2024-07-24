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

    public $name, $email, $phone, $password, $dob, $dl_state, $dl_number, $date_of_hire, $modelId = '';
    public $item, $action, $search, $title_modal, $countDrivers = '';
    public $role = 'Driver';
    public $isEdit = false;


    public function rules()
    {
        if ($this->isEdit) {
            return [
                'name' => 'required|min:3',
                'email' => 'required|email',
            ];
        } else {
            return [
                'name' => 'required|min:3',
                'email' => 'required|email|unique:users,email',
            ];
        }
    }

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];
    
    public function selectItem($item, $action)
    {
        $this->item = $item;

        if($action == 'delete'){
            $this->title_modal = 'Delete Driver';
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteDriver']);
        }else if($action == 'masiveDelete'){
            $this->dispatchBrowserEvent('openModal', ['name' => 'deleteDriverMasive']);
            $this->countDrivers = count($this->selected);
        }else if($action == 'create'){
            $this->title_modal = 'Create Driver';
            $this->dispatchBrowserEvent('openModal', ['name' => 'createDriver']);
            $this->emit('clearForm');
        }else{
            $this->title_modal = 'Edit Driver';
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
        $this->dob = $model->dob;
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

        if($this->modelId){
            $this->isEdit = true;
            $this->validate();
            
            $user = User::findOrFail($this->modelId);
        }else{
            $this->validate();

            $user = new User;
            $user->password = ('123456'); //solo cuando es un nuevo usuario 
        }
        
        $user->name = $this->name;
        $user->email = $this->email;
        $user->phone = $this->phone;
        $user->dob = $this->dob;
        $user->dl_state = $this->dl_state;
        $user->dl_number = $this->dl_number;
        $user->date_of_hire = $this->date_of_hire;
        $user->syncRoles($this->role);
        
        $user->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createDriver']);

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
