<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\ServiceContract;
use App\Models\Scheduling;

use Faker\Factory as Faker;

class Reports extends Component
{
    public $date_range, $service_contract_id;
    public $conditions = [];
    public $data_report = [];

    public $date_ranges = [
        'Today',
        'Yesterday',
        'Last 7 Days',
        'Last 14 Days',
        'Last 3 Months',
        'This Week',
        'This Month',
        'This Year',
    ];

    public function generateReport()
    {
        if ($this->date_range == '') {
            $this->sessionAlert([
                'message' => 'Please select a date range!',
                'type' => 'danger',
                'icon' => 'error',
            ]);
            return;
        }

        if($this->service_contract_id == ''){
            $this->sessionAlert([
                'message' => 'Please select a service contract!',
                'type' => 'danger',
                'icon' => 'error',
            ]);
            return;
        }

        $range = $this->rangeDates();
        
        $sql = "SELECT * FROM schedulings inner join patients on patients.id = schedulings.patient_id WHERE service_contract_id = ".$this->service_contract_id." AND date BETWEEN '".$range['start']."' AND '".$range['end']."'";

        $data_report = DB::select($sql);
        
        $this->$data_report = $data_report;
    }

    public function rangeDates()
    {
        $range = [];

        switch ($this->date_range) {
            case 'Today':
                $range['start'] = date('Y-m-d');
                $range['end'] = date('Y-m-d');
                break;
            case 'Yesterday':
                $range['start'] = date('Y-m-d', strtotime('-1 day'));
                $range['end'] = date('Y-m-d', strtotime('-1 day'));
                break;
            case 'Last 7 Days':
                $range['start'] = date('Y-m-d', strtotime('-7 day'));
                $range['end'] = date('Y-m-d');
                break;
            case 'Last 14 Days':
                $range['start'] = date('Y-m-d', strtotime('-14 day'));
                $range['end'] = date('Y-m-d');
                break;
            case 'Last 3 Months':
                $range['start'] = date('Y-m-d', strtotime('-3 month'));
                $range['end'] = date('Y-m-d');
                break;
            case 'This Week':
                $range['start'] = date('Y-m-d', strtotime('-1 week'));
                $range['end'] = date('Y-m-d');
                break;
            case 'This Month':
                $range['start'] = date('Y-m-d', strtotime('-1 month'));
                $range['end'] = date('Y-m-d');
                break;
            case 'This Year':
                $range['start'] = date('Y-m-d', strtotime('-1 year'));
                $range['end'] = date('Y-m-d');
                break;
        }
        return $range;
    }

    function sessionAlert($data) {
        session()->flash('alert', $data); 
        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function render()
    {
        $driver = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*')
            ->where('roles.name', '=', 'Driver')
            ->where('users.id', '!=', auth()->id())
            ->get();

        return view('livewire.report.index', [
            'patients' => Patient::all(),
            'service_contracts' => ServiceContract::all(),
            'drivers' => $driver,
        ]);
    }
}
