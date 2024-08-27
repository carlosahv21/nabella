<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\SchedulingAddress;
use App\Models\SchedulingCharge;
use App\Models\Patient;
use App\Models\Facility;
use App\Models\Driver;
use App\Models\Address;

use Carbon\Carbon;

use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class Dash extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $patient_id, $hospital_name, $hospital_address, $driver_name, $distance, $duration, $date, $check_in, $pick_up, $pick_up_time, $wheelchair, $ambulatory, $saturdays, $sundays_holidays, $companion, $fast_track, $out_of_hours, $aditional_waiting, $if_not_cancel, $drop_off, $modelId = '';

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
            $this->emit('getModelId', $this->item);

            $this->title_modal = 'See Event Details';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeEventDetails']);
        } else if ($action == 'seeMap') {
            $this->title_modal = 'See Map';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeMap']);
            $this->emit('showMap', $this->item);
        }
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $scheduling = Scheduling::find($this->modelId);
        $scheduling_address = SchedulingAddress::where('scheduling_id', '=', $this->modelId)->first();
        $scheduling_charge = SchedulingCharge::where('scheduling_id', '=', $this->modelId)->first();

        $patient = Patient::find($scheduling->patient_id);
        $facility = Facility::where('service_contract_id', '=', $patient->service_contract_id)->first();
        $facility_address = Address::where('facility_id', '=', $facility->id)->first();

        $driver = Driver::find($scheduling_address->driver_id);

        $this->patient_id = $patient->first_name . ' ' . $patient->last_name;
        $this->hospital_name = $facility->name;
        $this->hospital_address = $facility_address->address;
        $this->driver_name = $driver->name;

        $this->distance = $scheduling_address->distance;
        $this->duration = $scheduling_address->duration;
        $this->date = $scheduling->date;
        $this->check_in = $scheduling_address->pick_up_hour;
        $this->pick_up = $scheduling_address->pick_up_address;
        $this->drop_off = $scheduling_address->drop_off_address;
        
        $this->wheelchair = $scheduling_charge->wheelchair;
        $this->ambulatory = $scheduling_charge->ambulatory;
        $this->saturdays = $scheduling_charge->saturdays;
        $this->sundays_holidays = $scheduling_charge->sundays_holidays;
        $this->companion = $scheduling_charge->companion;
        $this->fast_track = $scheduling_charge->fast_track;
        $this->out_of_hours = $scheduling_charge->out_of_hours;
        $this->aditional_waiting = $scheduling_charge->aditional_waiting;
        $this->if_not_cancel = $scheduling_charge->if_not_cancel;
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
            $hospital = DB::table('facilities')
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

    function startDriving($event)
    {
        $scheduling_address = SchedulingAddress::where('scheduling_id', '=', $event)->first();
        $scheduling_address->status = 'In Progress';
        $scheduling_address->save();
        
    }

    function finishDriving($event)
    {
        $scheduling_address = SchedulingAddress::where('scheduling_id', '=', $event)->first();
        $scheduling_address->status = 'Completed';
        $scheduling_address->save();
    }

    private function statusColor($status)
    {
        if ($status == 'Waiting') {
            return 'bg-gradient-success';
        } else if ($status == 'Canceled') {
            return 'bg-gradient-danger';
        } else if ($status == 'Completed') {
            return 'bg-gradient-warning';
        } else if ($status == 'In Progress') {
            return 'bg-gradient-info';
        }
    }

    public function render()
    {
        $routes = [];
        $events = [];
        $all_events = [];

        if (auth()->user()->roles->first()->name == 'Driver') {
            $events = DB::table('schedulings')
                ->join('scheduling_address', 'schedulings.id', '=', 'scheduling_address.scheduling_id')
                ->join('scheduling_charge', 'schedulings.id', '=', 'scheduling_charge.scheduling_id')
                ->where('scheduling_address.driver_id', '=', auth()->user()->id)
                ->where('date', '=', Carbon::today()->format('Y-m-d'))
                ->orderBy('pick_up_hour')
                ->get();
            $cars = DB::table('vehicles')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
        } else {
            $events = DB::table('schedulings')
                ->join('scheduling_address', 'schedulings.id', '=', 'scheduling_address.scheduling_id')
                ->join('scheduling_charge', 'schedulings.id', '=', 'scheduling_charge.scheduling_id')
                ->get();

            $cars = DB::table('vehicles')
                ->get();
        }

        foreach ($events as $event) {
            $pick_up_address = $event->pick_up_address;

            $drop_off_address = $event->drop_off_address;

            $patient = Patient::where('id', '=', $event->patient_id)->first();
            $facility = Facility::where('service_contract_id', '=', $patient->service_contract_id)->first();
            $driver = Driver::where('id', '=', $event->driver_id)->first();

            $all_events[] = [
                'id' => $event->id,
                'distance' => $event->distance,
                'pick_up_address' => $pick_up_address,
                'drop_off_address' => $drop_off_address,
                'hospital_name' => $facility->name,
                'driver_name' => $driver->name,
                'status' => $event->status,
                'status_color' => $this->statusColor($event->status), 
                'date' => $event->date,
                'pick_up_hour' => $event->pick_up_hour,
                'drop_off_hour' => $event->drop_off_hour,
                'patient_name' => $patient->first_name . ' ' . $patient->last_name,
                'observations' => $patient->observations,
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
