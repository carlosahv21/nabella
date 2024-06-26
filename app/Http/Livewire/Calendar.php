<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Support\Facades\DB;

class Calendar extends Component
{
    public $patientId, $service_contract_id, $hospital_id, $pick_up, $pick_up_time, $check_in, $modelId = '';
    public $item, $action, $search, $title_modal, $countSchedulings = '';
    public $isEdit = false;
    public $driverIds = [];
    public $colors = ['#FF0000', '#00FF00', '#0000FF']; // Definir colores aquí

    protected $rules=[
        'patientId' => 'required',
        'service_contract_id' => 'required',
        'hospital_id' => 'required'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
        'showCalendarDriver',
    ];

    // Método para actualizar los eventos según los conductores seleccionados
    public function updateEvents()
    {
        
        $scheduling = !empty($this->driverIds) 
            ? Scheduling::whereIn('driver_id', $this->driverIds)->get()
            : Scheduling::all();
        dd($this->driverIds); 
        $events = [];
        $driverColors = []; // Array para almacenar los colores generados para cada driver_id

        foreach ($scheduling as $event) {
            $patient = Patient::find($event->patient_id);

            // Si el driver_id no tiene un color asignado, generar uno nuevo
            if (!isset($driverColors[$event->driver_id])) {
                $driverColors[$event->driver_id] = $this->colors[$event->driver_id - 1];
            }

            // Obtener el color asignado al driver_id
            $color = $driverColors[$event->driver_id];
            $events[] =  [
                'id' => $event->id,
                'driver_id' => $event->driver_id,
                'title' => $patient->first_name . " " . $patient->last_name,
                'start' => $event->date . " " . $event->check_in,
                'end' => $event->date . " " .$event->pick_up_time,
                'color' => $color, 
            ];
        }

        $this->emit('updateEvents', $events);
    }

    // Método para escuchar los cambios en driverIds
    public function updatedDriverIds()
    {
        $this->updateEvents();
    }

    public function render()
    {
        $scheduling = Scheduling::all();
        $events = [];
        $driverColors = []; // Array para almacenar los colores generados para cada driver_id

        foreach ($scheduling as $event) {
            $patient = Patient::find($event->patient_id);

            // Si el driver_id no tiene un color asignado, generar uno nuevo
            if (!isset($driverColors[$event->driver_id])) {
                $driverColors[$event->driver_id] = $this->colors[$event->driver_id - 1];
            }

            // Obtener el color asignado al driver_id
            $color = $driverColors[$event->driver_id];
            $events[] =  [
                'id' => $event->id,
                'driver_id' => $event->driver_id,
                'title' => $patient->first_name . " " . $patient->last_name,
                'start' => $event->date . " " . $event->check_in,
                'end' => $event->date . " " .$event->pick_up_time,
                'color' => $color, 
            ];
        }

        $driver = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*')
            ->where('roles.name', '=', 'Driver')
            ->where('users.id', '!=', auth()->id())
            ->get();

        return view(
            'livewire.calendar.index',
            [
                'patients' => Patient::all(),
                'hospitals' => Hospital::all(),
                'drivers' => $driver,
                'events' => $events,
            ],
        );
    }
}
