<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use App\Models\ServiceContract;
use Barryvdh\DomPDF\Facade\Pdf;

class Reports extends Component
{
    public $date_range, $service_contract_id, $invoice, $terms;
    public $conditions = [];
    public $data_report = [];
    public $loading = false;
    public $total = 0;

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
        $this->invoice = null;

        if ($this->date_range == '') {
            $this->sessionAlert([
                'message' => 'Please select a date range!',
                'type' => 'danger',
                'icon' => 'error',
            ]);

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

        $range = explode(' to', $this->date_range);

        $sql = "SELECT schedulings.* FROM schedulings inner join patients on patients.id = schedulings.patient_id WHERE service_contract_id = " . $this->service_contract_id . " AND date BETWEEN '" . $range[0] . "' AND '" . $range[1] . "'";

        $schedulings = DB::select($sql);

        if(count($schedulings) == 0) {
            $this->sessionAlert([
                'message' => 'No schedulings found for the selected date range!',
                'type' => 'danger',
                'icon' => 'info',
            ]);
            return;
        }

        $service_contract = DB::table('service_contracts')->where('id', $this->service_contract_id)->get()->first();

        foreach ($schedulings as $scheduling) {
            $data[] = $this->getData($scheduling,  $service_contract);
        }

        $filePath = 'pdfs/'.time().'-invoice.pdf';

        $pdf = Pdf::loadView('livewire.report.pdf', [
            'data' => $data,
            'service_contract' => $service_contract,
            'total' => array_sum(array_column($data, 'amount')),
            'terms' => $this->terms
        ]);
    
        $pdf->save($filePath);
        $this->invoice = $filePath;

    }

    public function getData($scheduling, $service_contract){
        
        $data = [];
        $data['id'] = $scheduling->id;

        $patient = DB::table('patients')->where('id', $scheduling->patient_id)->get()->first();

        $data['date'] = $scheduling->date;
        $data['patient_name'] = $patient->first_name . ' ' . $patient->last_name;
        $data['description'] = $this->getDescription($scheduling);
        $data['amount'] = $this->getAmount($scheduling, $service_contract);

        return $data;
    }

    public function getAmount($scheduling, $service_contract){

        $scheduling_address = DB::table('scheduling_address')->where('scheduling_id', $scheduling->id)->get()->first();
        $scheduling_charge = DB::table('scheduling_charge')->where('scheduling_id', $scheduling->id)->get()->first();

        if ($scheduling_charge->wheelchair) {
            $base_amount = $service_contract->wheelchair;
        }

        if ($scheduling_charge->ambulatory) {
            $base_amount = $service_contract->ambulatory;
        }
        
        $amount = $scheduling_address->distance * $service_contract->rate_per_mile;

        if ($scheduling_charge->type_of_trip == 'round_trip') {
            $amount = $amount * 2;
        }

        if ($scheduling_charge->sundays_holidays) {
            $amount = $amount + $service_contract->sundays_holidays;
        }

        if ($scheduling_charge->companion) {
            $amount = $amount + $service_contract->companion;
        }

        if ($scheduling_charge->fast_track) {
            $amount = $amount + $service_contract->fast_track;
        }

        if ($scheduling_charge->out_of_hours) {
            $amount = $amount + $service_contract->out_of_hours;
        }

        if ($scheduling_charge->aditional_waiting) {
            $amount = $amount + $service_contract->aditional_waiting;
        }

        $amount = $amount + $base_amount;

        return $amount;
    }

    public function getDescription($scheduling)
    {
        $description = '';
        $scheduling_address = DB::table('scheduling_address')->where('scheduling_id', $scheduling->id)->get()->first();
        $scheduling_charge = DB::table('scheduling_charge')->where('scheduling_id', $scheduling->id)->get()->first();

        if ($scheduling_charge->wheelchair) {
            $description .= 'WHEELCHAIR. ';
        }

        if ($scheduling_charge->ambulatory) {
            $description .= 'AMBULATORY. ';
        }

        $description .= 'Pick up: ' . $scheduling_address->pick_up_address . '. Drop off: ' . $scheduling_address->drop_off_address . '. ';

        $charges = '';
        if ($scheduling_charge->saturdays) {
            $charges .= ($charges) ? 'and Saturday ' : 'Saturdays ';
        }

        if ($scheduling_charge->sundays_holidays) {
            $charges .= ($charges) ? 'and Sunday/Holiday ' : 'Sundays/Holidays ';
        }

        if ($scheduling_charge->companion) {
            $charges .= ($charges) ? 'and Accompanist ' : 'Accompanist ';
        }

        if ($scheduling_charge->fast_track) {
            $charges .= ($charges) ? 'and Fast Track ' : 'Fast Track ';
        }

        if ($scheduling_charge->out_of_hours) {
            $charges .= ($charges) ? 'and Out of Hours ' : 'Out of Hours ';
        }

        if ($scheduling_charge->aditional_waiting) {
            $charges .= ($charges) ? 'and Aditional Waiting ' : 'Aditional Waiting ';
        }

        $description .= $charges . 'charge applied. ';

        $distance_number = $scheduling_address->distance;
        $description .= ($scheduling_charge->type_of_trip == 'round_trip') ? $distance_number * 2 . ' miles round trip.' : $distance_number . 'miles.';

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
