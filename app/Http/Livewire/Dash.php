<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\Hospital;
use App\Models\Driver;
use App\Models\Address;

use Carbon\Carbon;

use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Dash extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $patient_id, $hospital_name, $hospital_address, $driver_name, $distance, $duration, $date, $check_in, $pick_up, $pick_up_time, $wheelchair, $ambulatory, $saturdays, $sundays_holidays, $companion, $fast_track, $out_of_hours, $aditional_waiting, $if_not_cancel, $modelId = '';

    public $item, $action, $search, $title_modal, $countDrivers = '';

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
        'showMap'
    ];

    // variables para la API Google Maps
    public $map_api_key = 'AIzaSyBOx8agvT4F1RjSW4IS_zgkINQzdFZevik';
    public $url_map = 'https://maps.googleapis.com/maps/api/';

    public function selectItem($item, $action)
    {
        $this->item = $item;

        if ($action == 'seeDetails') {
            $this->title_modal = 'See Event Details';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeEventDetails']);
            $this->emit('getModelId', $this->item);
        } else if ($action == 'seeMap') {
            $this->title_modal = 'See Map';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeMap']);
            $this->emit('showMap', $this->item);
        }
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Scheduling::find($this->modelId);

        $patient = Patient::find($model->patient_id);
        $hospital = Hospital::find($model->hospital_id);
        $driver = Driver::find($model->driver_id);
        $address = Address::find($model->pick_up);

        $this->patient_id = $patient->first_name . ' ' . $patient->last_name;
        $this->hospital_name = $hospital->name;
        $this->hospital_address = $hospital->address;
        $this->driver_name = $driver->name;
        $this->distance = $model->distance;
        $this->duration = $model->duration;
        $this->date = $model->date;
        $this->check_in = $model->check_in;
        $this->pick_up = $address->address;
        $this->pick_up_time = $model->pick_up_time;
        $this->wheelchair = $model->wheelchair;
        $this->ambulatory = $model->ambulatory;
        $this->saturdays = $model->saturdays;
        $this->sundays_holidays = $model->sundays_holidays;
        $this->companion = $model->companion;
        $this->fast_track = $model->fast_track;
        $this->out_of_hours = $model->out_of_hours;
        $this->aditional_waiting = $model->aditional_waiting;
        $this->if_not_cancel = $model->if_not_cancel;
    }

    private function clearForm()
    {
        $this->reset(['modelId', 'patient_id', 'hospital_name', 'hospital_address', 'driver_name', 'distance', 'duration', 'date', 'check_in', 'pick_up', 'pick_up_time', 'wheelchair', 'ambulatory', 'saturdays', 'sundays_holidays', 'companion', 'fast_track', 'out_of_hours']);
    }


    public function forcedCloseModal()
    {
        sleep(2);
        // This is to <re></re>set our public variables
        $this->clearForm();

        // These will reset our error bags
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getCoordinates($address)
    {
        $address = urlencode($address);
        $url = "{$this->url_map}geocode/json?address={$address}&key={$this->map_api_key}";

        $response = file_get_contents($url);
        $data = json_decode($response);

        if ($data->status == 'OK') {
            return ['lat' => $data->results[0]->geometry->location->lat, 'lng' => $data->results[0]->geometry->location->lng];
        } else {
            return false;
        }
    }

    public function showMap($event)
    {
        $events = DB::table('schedulings')
            ->where('id', '=', $event)
            ->get();
            
        $routes = [];

        foreach ($events as $event) {
            $pick_up = DB::table('addresses')
                ->where('id', '=', $event->pick_up)
                ->get();
            $hospital = DB::table('hospitals')
                ->where('id', '=', $event->hospital_id)
                ->get();

            $pick_up_address = $pick_up->first()->address;
            $hospital_address = $hospital->first()->address;

            if ($pick_up_address && $hospital_address) {
                $route = [
                    'id' => $event->id,
                    'path' => json_encode([
                        $this->getCoordinates($pick_up_address),
                        $this->getCoordinates($hospital_address)
                    ]),
                ];
            }
            $routes[] = $route;
        }
        
        $this->dispatchBrowserEvent('showMap', ['routes' => $routes]);
    }

    public function render()
    {
        $routes = [];
        $events = [];
        $all_events = [];

        if (auth()->user()->roles->first()->name == 'Driver') {
            $events = DB::table('schedulings')
                ->where('driver_id', '=', auth()->user()->id)
                ->where('date', '=', Carbon::now()->format('Y-m-d'))
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

            $driver = DB::table('users')
                ->where('id', '=', $event->driver_id)
                ->get();

            $hospital_address = $hospital->first()->address;
            $picl_up_address = $pick_up->first()->address;

            $all_events[] = [
                'id' => $event->id,
                'distance' => $event->distance,
                'pick_up' => $picl_up_address,
                'hospital_name' => $hospital->first()->name,
                'hospital_address' => $hospital_address,
                'driver_name' => $driver->first()->name,
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


        return view(
            'livewire.dash.index',
            [
                'events' => $all_events,
                'cars' => $cars,
                'routes' => $routes
            ]
        );
    }
}
