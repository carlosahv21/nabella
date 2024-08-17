<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;

class Profile extends Component
{
    public $user, $role, $confirmationPassword, $new_password, $old_password;

    public function mount($id)
    {
        $this->user = User::find($id);
        $this->role = Role::find($this->user->roles->first()->id);
    }

    public function passwordUpdate()
    {
        if ($this->new_password == $this->confirmationPassword) {
            $this->user->password = $this->new_password;
            $this->user->save();
            $data = [
                'message' => 'Password updated successfully!',
                'type' => 'success',
                'icon' => 'edit',
            ];
        } else {
            $data = [
                'message' => 'Passwords do not match!',
                'type' => 'danger',
                'icon' => 'error',
            ];
        }

        $this->sessionAlert($data);
    }

    function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function render()
    {
        return view('livewire.profile.index');
    }
}
