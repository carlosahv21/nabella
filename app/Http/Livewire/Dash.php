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

    public $patient_id, $hospital_name, $hospital_address, $driver_name, $distance, $duration, $date, $check_in, $pick_up, $pick_up_time, $wheelchair, $ambulatory, $saturdays, $sundays_holidays, $companion, $fast_track, $out_of_hours, $aditional_waiting, $if_not_cancel, $drop_off, $drop_off_hours, $modelId = '';

    public $observations, $additional_milles = 0;

    public $comments = [];

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

            $this->title_modal = 'See Details';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeEventDetails']);
        } else if ($action == 'seeMap') {
            $this->title_modal = 'See Map';
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeMap']);
            $this->emit('showMap', $this->item);
        } else if ($action == 'seeComments') {
            $this->title_modal = 'See Comments';
            $this->showComments($this->item);
        }
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $scheduling_address = SchedulingAddress::where('id', '=', $this->modelId)->first();
        $scheduling_charge = SchedulingCharge::where('scheduling_id', '=', $scheduling_address->scheduling_id)->first();
        $scheduling = Scheduling::find($scheduling_address->scheduling_id);

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
        $this->date = $scheduling_address->date;
        $this->check_in = $scheduling_address->pick_up_hour;
        $this->pick_up = $scheduling_address->pick_up_address;
        $this->drop_off = $scheduling_address->drop_off_address;
        $this->drop_off_hours = $scheduling_address->drop_off_hour;

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
        $driver_id = SchedulingAddress::where('id', '=', $event)->first()->driver_id;
        $validate = SchedulingAddress::where('status', '=', 'In Progress')
                                    ->where('driver_id', '=', $driver_id)
                                    ->where('date', '=', date('Y-m-d'))
                                    ->get();

        if (count($validate) > 0) {
            $this->sessionAlert([
                'message' => 'You are already driving!',
                'type' => 'danger',
                'icon' => 'error',
            ]);

            return;
        }

        $scheduling_address = SchedulingAddress::where('id', '=', $event)->first();
        $scheduling_address->status = 'In Progress';

        $scheduling_address->save();

        $this->sessionAlert([
            'message' => 'You are driving!',
            'type' => 'info',
            'icon' => 'info',
        ]);
    }

    function completeDriving($event)
    {
        $this->title_modal = 'Complete Driving';
        $this->dispatchBrowserEvent('openModal', ['name' => 'CompleteDriving']);
        $this->emit('getModelId', $event);
    }

    public function finishDriving()
    {
        $scheduling_address = SchedulingAddress::where('id', '=', $this->modelId)->first();
        $scheduling_address->status = 'Completed';
        $scheduling_address->observations = $this->observations;
        $scheduling_address->additional_milles = $this->additional_milles;
        $scheduling_address->save();

        $scheduling_charge = SchedulingCharge::where('scheduling_id', '=', $scheduling_address->scheduling_id)->first();
        $scheduling_charge->wheelchair = $this->wheelchair;
        $scheduling_charge->ambulatory = $this->ambulatory;
        $scheduling_charge->saturdays = $this->saturdays;
        $scheduling_charge->sundays_holidays = $this->sundays_holidays;
        $scheduling_charge->companion = $this->companion;
        $scheduling_charge->fast_track = $this->fast_track;
        $scheduling_charge->out_of_hours = $this->out_of_hours;
        $scheduling_charge->aditional_waiting = $this->aditional_waiting;
        $scheduling_charge->save();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'CompleteDriving']);

        $this->sessionAlert([
            'message' => 'Finish Driving!',
            'type' => 'info',
            'icon' => 'info',
        ]);
    }

    public function showComments($driverId)
    {
        $this->comments = [];

        $sql = "SELECT u.id, u.name, CONCAT(p.first_name, ' ', p.last_name) as patient_name, sa.observations
            FROM
                users u
            JOIN scheduling_address sa ON
                sa.driver_id = u.id
            JOIN schedulings s ON
                s.id = sa.scheduling_id
            JOIN patients p ON
                p.id = s.patient_id
            WHERE
                sa.driver_id = $driverId
                AND DATE(sa.date) = CURDATE();";

        $data = DB::select($sql);

        if(count($data) > 0){
            foreach ($data as $comment) {
                $this->comments[] = [
                    'id' => $comment->id,
                    'name' => $comment->name,
                    'patient_name' => $comment->patient_name,
                    'observations' => $comment->observations,
                ];
            }
            $this->dispatchBrowserEvent('openModal', ['name' => 'seeComments']);
        }else{
            $this->sessionAlert([
                'message' => 'No comments found!',
                'type' => 'info',
                'icon' => 'info',
            ]);
        }
    }

    function sessionAlert($data)
    {
        session()->flash('alert', $data);

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    private function statusColor($status)
    {
        if ($status == 'Waiting') {
            return 'bg-gradient-warning';
        } else if ($status == 'Canceled') {
            return 'bg-gradient-danger';
        } else if ($status == 'Completed') {
            return 'bg-gradient-success';
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
            $sql = "SELECT scheduling_address.*,
            schedulings.patient_id, 
            scheduling_charge.wheelchair,
            scheduling_charge.ambulatory,
            scheduling_charge.out_of_hours,
            scheduling_charge.saturdays,
            scheduling_charge.sundays_holidays,
            scheduling_charge.companion,
            scheduling_charge.aditional_waiting,
            scheduling_charge.fast_track,
            scheduling_charge.if_not_cancel,
            scheduling_charge.collect_cancel,
            scheduling_charge.overcharge FROM scheduling_address 
            inner join schedulings on schedulings.id = scheduling_address.scheduling_id 
            inner join scheduling_charge  on schedulings.id = scheduling_charge.scheduling_id 
            WHERE scheduling_address.driver_id = " . auth()->user()->id . " AND scheduling_address.date = '" . Carbon::today()->format('Y-m-d') . "' ORDER BY scheduling_address.pick_up_hour";

            $events = DB::select($sql);

            $cars = DB::table('vehicles')
                ->where('user_id', '=', auth()->user()->id)
                ->get();
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
        } else {

            $events = DB::table('schedulings')
                ->join('scheduling_address', 'schedulings.id', '=', 'scheduling_address.scheduling_id')
                ->join('scheduling_charge', 'schedulings.id', '=', 'scheduling_charge.scheduling_id')
                ->select('schedulings.id', 'scheduling_address.*', 'scheduling_charge.*')
                ->where('scheduling_address.status', '=', 'Completed')
                ->get();

            $sql = "SELECT 
                    u.id,
                    u.name,
                    CASE 
                        WHEN MAX(NOW() BETWEEN CONCAT(sa.date, ' ', sa.pick_up_hour) AND CONCAT(sa.date, ' ', sa.drop_off_hour)) THEN 'Busy'
                        ELSE 'Free'
                    END AS status,
                    COUNT(CASE 
                        WHEN DATE(sa.date) = CURDATE() THEN 1 
                        ELSE NULL 
                    END) AS total_dates
                FROM users u
                LEFT JOIN scheduling_address sa ON sa.driver_id = u.id
                INNER JOIN model_has_roles mhr ON mhr.model_id = u.id
                INNER JOIN roles r ON r.id = mhr.role_id
                WHERE 
                    r.name = 'Driver'
                    
                GROUP BY u.id, u.name;";
            $drivers = DB::select($sql);

            $first_day_of_month = date('Y-m') . '-01';
            $last_day_of_month = date('Y-m-t');

            $sql_total = "SELECT 
                    SUM(
                        CASE 
                            WHEN sc.wheelchair = 1 THEN svc.wheelchair ELSE 0 END
                        + CASE 
                            WHEN sc.ambulatory = 1 THEN svc.ambulatory ELSE 0 END
                        + CASE 
                            WHEN sc.out_of_hours = 1 THEN svc.out_of_hours ELSE 0 END
                        + CASE 
                            WHEN sc.saturdays = 1 THEN svc.saturdays ELSE 0 END
                        + CASE 
                            WHEN sc.sundays_holidays = 1 THEN svc.sundays_holidays ELSE 0 END
                        + CASE 
                            WHEN sc.companion = 1 THEN svc.companion ELSE 0 END
                        + CASE 
                            WHEN sc.aditional_waiting = 1 THEN svc.additional_waiting ELSE 0 END
                        + CASE 
                            WHEN sc.fast_track = 1 THEN svc.fast_track ELSE 0 END
                        + CASE 
                            WHEN sc.overcharge = 1 THEN svc.overcharge ELSE 0 END
                        + (sa.distance + COALESCE(sa.additional_milles, 0)) * svc.rate_per_mile
                    ) AS total_facturado
                FROM 
                    schedulings s
                JOIN 
                    scheduling_charge sc ON s.id = sc.scheduling_id
                JOIN 
                    patients p ON s.patient_id = p.id
                JOIN 
                    service_contracts svc ON p.service_contract_id = svc.id
                JOIN 
                    scheduling_address sa ON s.id = sa.scheduling_id
                WHERE 
                    sa.date BETWEEN '".$first_day_of_month."' AND '".$last_day_of_month."'
                    AND sa.status = 'Completed';";

                $total_facturado = DB::select($sql_total);
                $total_facturado = ($total_facturado[0]->total_facturado != null) ? $total_facturado[0]->total_facturado : 0;

            return view(
                'livewire.dash.index',
                [
                    'events' => $events,
                    'drivers' => $drivers,
                    'total_facturado' => $total_facturado,
                ]
            );
        }
    }
}
