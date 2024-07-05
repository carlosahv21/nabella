<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Reports extends Component
{

    function sessionAlert($data) {
        session()->flash('alert', $data); 

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }
    
    public function render()
    {

        return view('livewire.report.index', []
        );
    }
}
