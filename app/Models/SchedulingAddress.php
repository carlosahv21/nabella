<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulingAddress extends Model
{
    use HasFactory;

    protected $table = 'scheduling_address';

    /**
     * Get the scheduling that owns the shceduling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function scheduling()
    {
        return $this->belongsTo('App\Models\Scheduling');
    }
}
