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

    public function schedulingAddresses()
    {
        return $this->hasMany(SchedulingAddress::class, 'scheduling_id');
    }
}
