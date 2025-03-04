<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

use Exception;

class Reports extends Component
{
    public $date_range, $service_contract_id, $invoice, $terms;
    public $data_report = [];

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

            return;
        }

        $range = explode(' to', $this->date_range);

        $initialDate = Carbon::createFromFormat('m-d-Y', $range[0])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('m-d-Y', str_replace(' ', '', $range[1]))->format('Y-m-d');

        $sql = "SELECT scheduling_address.* FROM scheduling_address inner join schedulings on schedulings.id = scheduling_address.scheduling_id inner join patients on patients.id = schedulings.patient_id WHERE service_contract_id = " . $this->service_contract_id . " AND scheduling_address.date BETWEEN '". $initialDate. "' AND '".$endDate. "' AND scheduling_address.status = 'Completed' AND schedulings.deleted = 0 ORDER BY scheduling_address.date";

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
        $facility = DB::select('SELECT * FROM facilities f inner join addresses a on a.facility_id = f.id WHERE f.service_contract_id = '.$this->service_contract_id.'  LIMIT 1');

        foreach ($schedulings as $scheduling) {
            
            $data[$scheduling->scheduling_id]['id'] = $scheduling->scheduling_id;
            $data[$scheduling->scheduling_id]['date'] = $scheduling->date;
            $data[$scheduling->scheduling_id]['patient_name'] = $this->getPatient($scheduling);
            $data[$scheduling->scheduling_id]['request_by'] = $scheduling->request_by;
            $data[$scheduling->scheduling_id]['service_contract'] = $service_contract->id;
            $data[$scheduling->scheduling_id]['address'][$scheduling->type_of_trip] = [
                'pick_up_address' => $scheduling->pick_up_address,
                'drop_off_address' => $scheduling->drop_off_address,
                'driver' => $scheduling->driver_id,
                'distance' => $scheduling->distance,
                'pick_up_hour' => $scheduling->pick_up_hour,
            ];
            $data[$scheduling->scheduling_id]['charge'] = $this->getCharge($scheduling);

        }

        $data = $this->sanitizeData($data);

        $filePath = 'pdfs/'.time().'-invoice.pdf';

        if( $this->terms == 'Due on receipt'){
            $day_terms = '0';
        }else{
            $day_terms = explode(' ', $this->terms)[1];
        }

        $pdf = Pdf::loadView('livewire.report.pdf', [
            'data' => $data,
            'service_contract' => $service_contract,
            'facility' => $facility[0],
            'total' => array_sum(array_column($data, 'amount')),
            'terms' => $this->terms,
            'day_terms' => $day_terms
        ]);
    
        $pdf->save($filePath);
        $this->invoice = $filePath;

    }

    public function getPatient($scheduling_address){
        $scheduling = DB::table('schedulings')->where('id', $scheduling_address->scheduling_id)->get()->first();
        $patient = DB::table('patients')->where('id', $scheduling->patient_id)->get()->first();
        return $patient->first_name . ' ' . $patient->last_name;
    }

    public function getCharge($scheduling){
        $scheduling_charge = DB::table('scheduling_charge')->where('scheduling_id', $scheduling->scheduling_id)->get()->first();

        return [
            'type_of_trip' => $scheduling_charge->type_of_trip,
            'wheelchair' => $scheduling_charge->wheelchair,
            'ambulatory' => $scheduling_charge->ambulatory,
            'companion' => $scheduling_charge->companion,
            'fast_track' => $scheduling_charge->fast_track,
            'out_of_hours' => $scheduling_charge->out_of_hours,
            'aditional_waiting' => $scheduling_charge->aditional_waiting,
            'saturdays' => $scheduling_charge->saturdays,
            'sundays_holidays' => $scheduling_charge->sundays_holidays,
            'flat_rate' => $scheduling_charge->flat_rate,
            'cane' => $scheduling_charge->cane,
            'walker' => $scheduling_charge->walker,
            'bchair' => $scheduling_charge->bchair,
        ];
    }

    public function sanitizeData($schedulings){

        foreach ($schedulings as $key => $scheduling) {
            $schedulings[$key]['description'] = $this->getDescription($scheduling);
            $schedulings[$key]['amount'] = $this->getAmount($scheduling);

            unset($schedulings[$key]['charge']);
            unset($schedulings[$key]['address']);
            unset($schedulings[$key]['request_by']);
            unset($schedulings[$key]['service_contract']);
        }   

        return $schedulings;
    }

    public function getAmount($scheduling){
        $service_contract = DB::table('service_contracts')->where('id', $scheduling['service_contract'])->get()->first();

        if ($scheduling['charge']['flat_rate']) {
            return $service_contract->flat_rate;
        }

        if ($scheduling['charge']['wheelchair']) {
            $base_amount = $service_contract->wheelchair;
        }

        if ($scheduling['charge']['ambulatory']) {
            $base_amount = $service_contract->ambulatory;
        }

        if ($scheduling['charge']['cane']) {
            $base_amount = $service_contract->cane;
        }

        if ($scheduling['charge']['walker']) {
            $base_amount = $service_contract->walker;
        }

        if ($scheduling['charge']['bchair']) {
            $base_amount = $service_contract->bchair;
        }

        if ($scheduling['charge']['type_of_trip'] == 'round_trip') {
            $distance_number = array_sum(array_column($scheduling['address'], 'distance'));
            $amount = $distance_number * $service_contract->rate_per_mile;
        }else{
            $distance = $scheduling['address']['pick_up']['distance'] ?? 0;
            $pick_up = $distance * $service_contract->rate_per_mile;
            $drop_off = $distance * $service_contract->rate_per_mile;;
            
            $amount = $pick_up + $drop_off;
        }

        if ($scheduling['charge']['sundays_holidays']) {
            $amount = $amount + $service_contract->sundays_holidays;
        }

        if ($scheduling['charge']['companion']) {
            $amount = $amount + $service_contract->companion;
        }

        if ($scheduling['charge']['fast_track']) {
            $amount = $amount + $service_contract->fast_track;
        }

        if ($scheduling['charge']['out_of_hours']) {
            $amount = $amount + $service_contract->out_of_hours;
        }

        if ($scheduling['charge']['aditional_waiting']) {
            $amount = $amount + $service_contract->aditional_waiting;
        }

        $amount = $amount + $base_amount;

        return $amount;
    }

    public function getDescription($scheduling)
    {
        $description= '';

        if ($scheduling['charge']['wheelchair']) {
            $description .= 'WHEELCHAIR. ';
        }

        if ($scheduling['charge']['ambulatory']) {
            $description .= 'AMBULATORY. ';
        }

        if ($scheduling['charge']['cane']) {
            $description .= 'CANE. ';
        }

        if ($scheduling['charge']['walker']) {
            $description .= 'WALKER. ';
        }

        if ($scheduling['charge']['bchair']) {
            $description .= 'BRODA CHAIR. ';
        }

        if ($scheduling['charge']['type_of_trip'] == 'round_trip') {
            $pickUpAddress = $scheduling['address']['pick_up']['pick_up_address'] ?? null;
            $description .= 'Pick up: ' . ($pickUpAddress ?? 'Not specified');

            $dropOffAddress = $scheduling['address']['pick_up']['drop_off_address'] ?? null;
            $description .= '. Drop off: ' . ($dropOffAddress.". " ?? 'Not specified. ');
        }else{
            $pickUpAddress = $scheduling['address']['pick_up']['pick_up_address'] ?? null;
            $description .= 'Pick up: ' . ($pickUpAddress ?? 'Not specified');

            $dropOffAddress = $scheduling['address']['pick_up']['drop_off_address'] ?? null;
            $description .= '. Drop off: ' . ($dropOffAddress.". " ?? 'Not specified. ');

            if(in_array('return', $scheduling['address'])){
                $description .= '. And return to: ' . $scheduling['address']['return']['drop_off_address'] . '. ';
            }
        }

        $charges = '';
        if ($scheduling['charge']['saturdays']) {
            $charges .= ($charges) ? 'and Saturday ' : 'Saturdays ';
        }

        if ($scheduling['charge']['sundays_holidays']) {
            $charges .= ($charges) ? 'and Sunday/Holiday ' : 'Sundays/Holidays ';
        }

        if ($scheduling['charge']['companion']) {
            $charges .= ($charges) ? 'and Accompanist ' : 'Accompanist ';
        }

        if ($scheduling['charge']['fast_track']) {
            $charges .= ($charges) ? 'and Fast Track ' : 'Fast Track ';
        }

        if ($scheduling['charge']['out_of_hours']) {
            $charges .= ($charges) ? 'and After Hours ' : 'After Hours ';
        }

        if ($scheduling['charge']['aditional_waiting']) {
            $charges .= ($charges) ? 'and Aditional Waiting ' : 'Aditional Waiting ';
        }

        if ($charges) {
            $description .= $charges . 'charge applied. ';
        }

        if ($scheduling['request_by']) {
            $description .= 'Transportation was requested by ' . $scheduling['request_by'] . '. Patient was picked up at '. $scheduling['address']['pick_up']['pick_up_hour'] . '. ';
        }

        $distance_number = array_sum(array_column($scheduling['address'], 'distance'));

        $description .= ($scheduling['charge']['type_of_trip'] == 'round_trip') ? $distance_number  . ' miles round trip.' : $distance_number . ' miles.';

        return $description;
    }

    function sessionAlert($data)
    {
        session()->flash('alert', $data);
        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function render()
    {
        $service_contracts = DB::table('service_contracts')
            ->select('service_contracts.id', 'service_contracts.company')
            ->orderBy('service_contracts.company', 'asc')
            ->get();

        return view('livewire.report.index', [
            'service_contracts' => $service_contracts
        ]);
    }
}
