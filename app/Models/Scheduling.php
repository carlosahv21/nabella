<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Scheduling extends Model
{
    use HasFactory;

    /**
     * Get the patient that owns the shceduling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }

    /**
     * Get the hospital that owns the shceduling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hospital()
    {
        return $this->belongsTo('App\Models\Hospital');
    }

    /**
     * Get the driver that owns the shceduling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo('App\Models\Driver');
    }

    /*
    * Get the amount of the shceduling
    */
    public function getAmount($scheduling){
        
        $service_contract = DB::table('service_contracts')->where('id', $scheduling['service_contract'])->get()->first();

        if ($scheduling['charge']['wheelchair']) {
            $base_amount = $service_contract->wheelchair;
        }

        if ($scheduling['charge']['ambulatory']) {
            $base_amount = $service_contract->ambulatory;
        }

        if ($scheduling['charge']['type_of_trip'] == 'round_trip') {
            $distance_number = array_sum(array_column($scheduling['address'], 'distance'));
            $amount = $distance_number * $service_contract->rate_per_mile;
        }else{
            $pick_up = $scheduling['address']['pick_up']['distance'] * $service_contract->rate_per_mile;
            $drop_off = $scheduling['address']['pick_up']['distance'] * $service_contract->rate_per_mile;
            
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
}
