<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;

use Illuminate\Support\Facades\DB;

class Dashboard extends Component
{
    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
    ];

    public $item, $action, $modelId, $patient_id, $hospital_id, $driver_id, $distance, $duration, $date, $check_in, $pick_up, $pick_up_time, $status, $title_modal = '';

    public $data_event = [];

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'see') {
            $this->title_modal = 'See Event Details';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeEvent']);
            $this->emit('getModelId', $this->item);
        }
    }


    public function forcedCloseModal()
    {
        sleep(2);
        $this->clearForm();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        // variable para traer los contros de servicios de la aplicacion
        $service_contracts = DB::table('service_contracts');

        // variable para traer el carro asignado
        $cars = DB::table('vehicles')
            ->where('user_id', '=', auth()->user()->id)
            ->get();


        if (auth()->user()->roles->first()->name == 'Driver') {
            $events = DB::table('schedulings')
                ->where('driver_id', '=', auth()->user()->id)
                ->get();
            $cars = DB::table('vehicles')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
        } else {
            $events = DB::table('schedulings')
                ->get();

            $cars = DB::table('vehicles')
                ->get();
        }

        foreach ($events as $event) {
            $pick_up = DB::table('addresses')
                ->where('id', '=', $event->pick_up)
                ->get();
            $hospital = DB::table('hospitals')
                ->where('id', '=', $event->hospital_id)
                ->get();

            $patient = DB::table('patients')
                ->where('id', '=', $event->patient_id)
                ->get();

            $this->data_event[] = [
                'id' => $event->id,
                'distance' => $event->distance,
                'pick_up' => $pick_up->first()->address,
                'hospital' => $hospital->first()->address,
                'date' => $event->date,
                'check_in' => $event->check_in,
                'pick_up_time' => $event->pick_up_time,
                'patient_name' => $patient->first()->first_name . ' ' . $patient->first()->last_name,
                'observations' => $patient->first()->observations,
                'wheelchair' => $event->wheelchair ? true : false,
                'ambulatory' => $event->ambulatory ? true : false,
                'saturdays' => $event->saturdays ? true : false,
                'companion' => $event->companion ? true : false,
                'fast_track' => $event->fast_track ? true : false,
                'sundays_holidays' => $event->sundays_holidays ? true : false,
                'out_of_hours' => $event->out_of_hours ? true : false,
            ];
        }

        return view('livewire.dashboard.index', [
            'service_contracts' => $service_contracts,
            'cars' => $cars,
            'events' => $this->data_event
        ]);
    }
}
