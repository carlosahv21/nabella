<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\ServiceContract;
use Spatie\LaravelPdf\Facades\Pdf;

class Reports extends Component
{
    public $date_range, $service_contract_id, $invoice;
    public $conditions = [];
    public $data_report = [];
    public $loading = false;

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
        $this->loading = true;

        if ($this->date_range == '') {
            $this->sessionAlert([
                'message' => 'Please select a date range!',
                'type' => 'danger',
                'icon' => 'error',
            ]);
            $this->loading = false;
            return;
        }

        if ($this->service_contract_id == '') {
            $this->sessionAlert([
                'message' => 'Please select a service contract!',
                'type' => 'danger',
                'icon' => 'error',
            ]);
            $this->loading = false;
            return;
        }

        $range = $this->rangeDates();

        $sql = "SELECT * FROM schedulings inner join patients on patients.id = schedulings.patient_id WHERE service_contract_id = " . $this->service_contract_id . " AND date BETWEEN '" . $range['start'] . "' AND '" . $range['end'] . "'";

        $schedulings = DB::select($sql);

        $service_contract = DB::table('service_contracts')->where('id', $this->service_contract_id)->get()->first();

        $total = 0;
        $i = 1;
        foreach ($schedulings as $scheduling) {
            $scheduling->id = $i;
            $patient = DB::table('patients')->where('id', $scheduling->patient_id)->get()->first();
            $scheduling->patient_name = $patient->first_name . ' ' . $patient->last_name;
            $scheduling->description = getDescription($scheduling);
            $scheduling->amount = explode(' ', $scheduling->distance)[0] * $service_contract->rate_per_mile;

            $total = $total + $scheduling->amount;
            $i++;
        }

        $filePath = 'pdfs/'.time().'invoice.pdf';

        Pdf::view('livewire.report.pdf', [
            'data' => $schedulings,
            'service_contract' => $service_contract,
            'total' => $total
        ])
        ->save($filePath);

        $this->invoice = $filePath;

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

    function getDescription($scheduling)
    {
        $description = '';

        if ($scheduling->wheelchair) {
            $description .= 'WHEELCHAIR. ';
        }

        if ($scheduling->ambulatory) {
            $description .= 'AMBULATORY. ';
        }

        $facility = DB::table('facilities')->where('id', $scheduling->hospital_id)->get()->first();

        $address = DB::table('addresses')->where('id', $scheduling->pick_up)->get()->first();

        $description .= 'Pick up: ' . $address->address . '. Drop off: ' . $facility->address . '.';

        $charges = '';
        if ($scheduling->saturdays) {
            $charges .= ($charges) ? 'and Saturday ' : 'Saturdays ';
        }

        if ($scheduling->sundays_holidays) {
            $charges .= ($charges) ? 'and Sunday/Holiday ' : 'Sundays/Holidays ';
        }

        if ($scheduling->companion) {
            $charges .= ($charges) ? 'and Accompanist ' : 'Accompanist ';
        }

        if ($scheduling->fast_track) {
            $charges .= ($charges) ? 'and Fast Track ' : 'Fast Track ';
        }

        if ($scheduling->out_of_hours) {
            $charges .= ($charges) ? 'and Out of Hours ' : 'Out of Hours ';
        }

        if ($scheduling->aditional_waiting) {
            $charges .= ($charges) ? 'and Aditional Waiting ' : 'Aditional Waiting ';
        }

        $description .= $charges . 'charge applied. ';

        $distance_number = explode('mi', $scheduling->distance)[0];
        $description .= $distance_number . 'miles ';

        $description .= 'round trip.';

        return $description;
    }

    function sessionAlert($data)
    {
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
