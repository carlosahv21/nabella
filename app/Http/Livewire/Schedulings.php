<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\Facility;

use App\Models\SchedulingAddress;
use App\Models\SchedulingCharge;
use App\Models\ApisGoogle;
use App\Models\ApiHoliday;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;

class Schedulings extends Component
{
    // Campos de la tabla scheduling
    public $patient_id, $hospital_id, $wait_time, $date,$check_in, $pick_up_time = '';
    public $auto_agend = false;
    public $weekdays = [];
    public $ends_schedule;
    public $ends_date;
    public $google;
    
    // Campos de la tabla scheduling_address
    public $pick_up_driver_id, $drop_off_driver_id, $pick_up_address, $drop_off_address, $pick_up_hour, $drop_off_hour, $distance = '';

    // Campos de la tabla scheduling_charge
    public $wheelchair = false;
    public $ambulatory = false;
    public $saturdays = false;
    public $companion = false;
    public $fast_track = false;
    public $sundays_holidays = false;
    public $out_of_hours = false;
    public $aditional_waiting = false;
    public $if_not_cancel = false;
    public $type_of_trip = '';

    public $item, $action, $search, $title_modal, $countSchedulings, $modelId = '';
    public $isEdit = false;

    public $prediction_pick_up = [];
    public $prediction_drop_off = [];
    public $stops = [];
    public $distances = [];
    public $addresses = [];

    // Array de colores predefinidos
    public $colors = [
        '#D6EEEB', '#C1E9FC', '#ADACCE', '#C7E4D9', '#95DAEE', '#9990BA', '#86D0C6',
        '#6ACDE5', '#D498C6', '#74CDD1', '#00B6D3', '#C679B4', '#00BCAD', '#0085BD',
        '#7D4497', '#1294A7', '#2A348E', '#671D67', '#11686B', '#102444', '#401E5B'
    ];

    protected $rules = [
        'patient_id' => 'required',
        'hospital_id' => 'required',
        'date' => 'required',
        'check_in' => 'required'
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
        'checkDate',
        'editEvent',
        'updateEventDate',
        'updateEventsCalendar'
    ];

    public function __construct()
    {
        $this->google = new ApisGoogle();
    }

    public function selectItem($item, $action)
    {
        $this->item = $item;

        switch ($action) {
            case 'delete':
                $this->title_modal = 'Delete Scheduling';
                $this->dispatchBrowserEvent('openModal', ['name' => 'deleteScheduling']);
                break;
            case 'masiveDelete':
                $this->dispatchBrowserEvent('openModal', ['name' => 'deleteSchedulingMasive']);
                $this->countSchedulings = count($this->selected);
                break;
            case 'create':
                $this->title_modal = 'Create Scheduling';
                $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
                $this->emit('clearForm');
                break;
            default:
                $this->title_modal = 'Edit Scheduling';
                $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
                $this->emit('getModelId', $this->item);
                break;
        }
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model_scheduling = Scheduling::find($this->modelId);
        $model_scheduling_address = SchedulingAddress::where('scheduling_id', $model_scheduling->id)->first();
        $model_scheduling_charge = SchedulingCharge::where('scheduling_id', $model_scheduling->id)->first();

        $this->patient_id = $model_scheduling->patient_id;
        $this->hospital_id = $model_scheduling->hospital_id;
        $this->wait_time = $model_scheduling->wait_time;
        $this->date = $model_scheduling->date;
        $this->check_in = $model_scheduling->check_in;
        $this->pick_up_address = $model_scheduling_address->pick_up_address;
        $this->drop_off_address = $model_scheduling_address->drop_off_address;
        $this->pick_up_hour = $model_scheduling_address->pick_up_hour;
        $this->drop_off_hour = $model_scheduling_address->drop_off_hour;
        $this->distance = $model_scheduling_address->distance;
        $this->type_of_trip = $model_scheduling_charge->type_of_trip;
        $this->wheelchair = $model_scheduling_charge->wheelchair;
        $this->ambulatory = $model_scheduling_charge->ambulatory;
        $this->saturdays = $model_scheduling_charge->saturdays;
        $this->sundays_holidays = $model_scheduling_charge->sundays_holidays;
        $this->companion = $model_scheduling_charge->companion;
        $this->fast_track = $model_scheduling_charge->fast_track;
        $this->out_of_hours = $model_scheduling_charge->out_of_hours;
        $this->auto_agend = $model_scheduling_charge->auto_agend;
    }

    private function clearForm()
    {
        $this->reset(['modelId', 'patient_id', 'hospital_id', 'pick_up_address', 'drop_off_address', 'date', 'check_in', 'drop_off_hour', 'wait_time', 'wheelchair', 'ambulatory', 'saturdays', 'sundays_holidays', 'companion', 'fast_track', 'out_of_hours', 'auto_agend']);

        $this->isEdit = false;
        $this->addresses = [];
    }

    public function save()
    {
        $this->validate();

        if ($this->modelId) {
            $scheduling = Scheduling::findOrFail($this->modelId);
            $this->isEdit = true;
        } else {
            $scheduling = new Scheduling;
        }

        // Guardamos los datos de la tabla scheduling
        $scheduling->patient_id = $this->patient_id;
        $scheduling->hospital_id = $this->hospital_id;
        $scheduling->wait_time = $this->wait_time;
        $scheduling->date = $this->date;
        $scheduling->auto_agend = $this->auto_agend;
        $scheduling->status = 'Waiting';

        $scheduling->save();

        // Guardamos los datos de la tabla scheduling_charge
        $scheduling_charge = new SchedulingCharge;
        $scheduling_charge->scheduling_id = $scheduling->id;
        $scheduling_charge->type_of_trip = $this->type_of_trip;
        $scheduling_charge->wheelchair = $this->wheelchair;
        $scheduling_charge->ambulatory = $this->ambulatory;
        $scheduling_charge->out_of_hours = $this->out_of_hours;
        $scheduling_charge->saturdays = $this->saturdays;
        $scheduling_charge->sundays_holidays = $this->sundays_holidays;
        $scheduling_charge->companion = $this->companion;
        $scheduling_charge->aditional_waiting = $this->aditional_waiting;
        $scheduling_charge->fast_track = $this->fast_track;
        $scheduling_charge->if_not_cancel = $this->if_not_cancel;

        $scheduling_charge->save();

        // Guardamos los datos de la tabla scheduling_address
        $newStop = [
            "address" => $this->pick_up_address,
            "addresses" => [],
            "distance" => "0",
            "duration" => "0"
        ];
        array_unshift($this->stops, $newStop);

        for ($i = 0; $i < count($this->stops) - 1; $i++) {
            $scheduling_address = new SchedulingAddress;

            $check_in = ($i == 0) ? $this->check_in : $this->sumWaitTime($this->check_in, $this->wait_time, $this->stops[$i]['duration']);
            $drop_off = ($i == 0) ? $this->sumWaitTime($this->check_in, false, $this->stops[$i]['duration']) : $this->sumWaitTime($this->check_in, $this->wait_time, $this->stops[$i]['duration']);

            $scheduling_address->scheduling_id = $scheduling->id;
            $scheduling_address->driver_id = ($i == 0) ? $this->pick_up_driver_id : $this->drop_off_driver_id;
            $scheduling_address->pick_up_address = $this->stops[$i]['address'];
            $scheduling_address->drop_off_address = $this->stops[$i + 1]['address'];
            $scheduling_address->pick_up_hour = $check_in;
            $scheduling_address->drop_off_hour = $drop_off;
            $scheduling_address->distance = $this->stops[$i + 1]['distance'];
            $scheduling_address->duration = $this->stops[$i + 1]['duration'];

            $scheduling_address->save();
        }

        $patient = Patient::find($scheduling->patient_id);

        $driverColors = [];

        if (!isset($driverColors[$scheduling_address->driver_id])) {
            $driverColors[$scheduling_address->driver_id] = $this->colors[$scheduling_address->driver_id - 1];
        }

        $color = $driverColors[$scheduling_address->driver_id];

        $new_event = [
            'id' => $scheduling->id,
            'title' => $patient->first_name . " " . $patient->last_name,
            'start' => $scheduling->date . " " . $scheduling_address->pick_up_hour,
            'end' => $scheduling->date . " " . $scheduling_address->drop_off_hour,
            'color' => $color
        ];

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        $data = $this->isEdit
            ? ['message' => 'Scheduling updated successfully!', 'type' => 'success', 'icon' => 'edit']
            : ['message' => 'Scheduling created successfully!', 'type' => 'info', 'icon' => 'check'];

        $this->dispatchBrowserEvent($this->isEdit ? 'eventUpdated' : 'eventAdded', $new_event);

        session()->flash('alert', $data);

        $this->clearForm();
    }

    public function sumWaitTime($pick_up_hour, $wait_time, $duration)
    {
        $hora = $pick_up_hour;
        $minutosASumar = $duration + 10;

        
        if($wait_time){
            $minutosASumar = $wait_time + $duration;
        }

        $dateTime = Carbon::createFromFormat('H:i', $hora);
        $dateTime->addMinutes($minutosASumar);
        $horaResultado = $dateTime->format('H:i');

        return $horaResultado;
    }

    public function forcedCloseModal()
    {
        sleep(2);
        $this->clearForm();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function delete()
    {
        $scheduling = Scheduling::findOrFail($this->item);
        $scheduling->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'deleteScheduling']);
        session()->flash('alert', ['message' => 'Scheduling deleted successfully!', 'type' => 'danger', 'icon' => 'delete']);
    }

    // Funciones que validan la actualización de algun campo
    public function updatedPickUpAddress()
    {
        if (strlen($this->pick_up_address) >= 3) {
            $this->prediction_pick_up = $this->google->getPlacePredictions($this->pick_up_address);
        } else {
            $this->prediction_pick_up = [];
        }
    }

    public function updateDropOffAddress($dropOffId)
    {
        $this->drop_off_address = $dropOffId;
        $this->validateAddresses('drop_off');
    }

    public function updatePickUpAddress($pickUpId)
    {
        $this->pick_up_address = $pickUpId;
        $this->validateAddresses('pick_up');
    }

    public function updateEventDate($id, $start, $end)
    {
        $array_start = explode(' ', $start);

        $event = Scheduling::findOrFail($id);
        $event->date = $array_start[0];
        $event->check_in = $array_start[1];
        $event->save();

        session()->flash('alert', ['message' => 'Event updated successfully!', 'type' => 'success', 'icon' => 'edit']);
    }

    public function updateEventsCalendar($driverIds)
    {
        $scheduling = !empty($driverIds)
            ? Scheduling::whereIn('driver_id', $driverIds)->get()
            : Scheduling::all();
        $new_events = [];
        $driverColors = [];

        foreach ($scheduling as $event) {
            $patient = Patient::find($event->patient_id);

            if (!isset($driverColors[$event->driver_id])) {
                $driverColors[$event->driver_id] = $this->colors[$event->driver_id - 1];
            }

            $color = $driverColors[$event->driver_id];
            $new_events[] = [
                'id' => $event->id,
                'driver_id' => $event->driver_id,
                'title' => $patient->first_name . " " . $patient->last_name,
                'start' => $event->date . " " . $event->check_in,
                'end' => $event->date . " " . $event->pick_up_time,
                'color' => $color,
            ];
        }

        $this->emit('updateEvents', $new_events);
    }

    public function updatedCheckIn($value)
    {
        $this->validateFields();
    }

    public function updatedEndsSchedule($value)
    {
        if ($value == 'ends_check') {
            $this->ends_date = null; // Reset ends_date if 'ends_check' is selected
        } else {
            $this->ends_date = ''; // Disable ends_date if any other option is selected
        }
    }

    public function addPickUp($address)
    {
        $this->pick_up_address = $address;
        $this->validateAddresses('pick_up');
        $this->prediction_pick_up = [];
    }

    public function addDropOff($address)
    {
        $this->drop_off_address = $address;
        $this->validateAddresses('drop_off');
        $this->prediction_drop_off = [];
    }

    public function addStop()
    {
        $this->stops[] = ['address' => '', 'addresses' => []];
    }

    public function removeStop($index)
    {
        unset($this->stops[$index]);
        $this->stops = array_values($this->stops);
    }

    public function updateStopQuery($index, $query)
    {
        $this->stops[$index]['address'] = $query;

        if (strlen($query) >= 3) {
            $this->stops[$index]['addresses'] = $this->google->getPlacePredictions($query);
        } else {
            $this->stops[$index]['addresses'] = [];
        }
    }

    public function selectStopAddress($index, $address)
    {
        $this->stops[$index]['address'] = $address;
        $this->stops[$index]['addresses'] = [];
    }

    public function validateAddresses($inptu)
    {
        if (!$this->pick_up_address || !$this->drop_off_address) {
            return false;
        }
        if ($this->pick_up_address == $this->drop_off_address) {
            if ($inptu == 'pick_up') {
                $this->pick_up_address = null;
            } else {
                $this->drop_off_address = null;
            }
            $this->sessionAlert([
                'message' => 'Pick up and drop off addresses cannot be the same!',
                'type' => 'danger',
                'icon' => 'error',
            ]);
        }
    }

    function sessionAlert($data)
    {
        session()->flash('alert', $data);

        $this->dispatchBrowserEvent('showToast', ['name' => 'toast']);
    }

    public function checkDate($date)
    {
        $timestamp = strtotime($date);
        $weekday = date('w', $timestamp);

        switch ($weekday) {
            case 0:
                $this->sundays_holidays = true;
                $this->saturdays = false;
                break;
            case 6:
                $this->sundays_holidays = false;
                $this->saturdays = true;
                break;
            default:
                $holidays = new ApiHoliday();
                $is_holiday = json_decode($holidays->getHolidays($date));
                $this->sundays_holidays = is_array($is_holiday) && collect($is_holiday)->contains('type', 'National');
                $this->saturdays = false;
                break;
        }
    }

    public function getDistance($addresses, $arrivalTime)
    {
        $arrivalTimestamp = strtotime($arrivalTime);

        for ($i = 0; $i < count($addresses) - 1; $i++) {
            $origin = $this->google->getCoordinates($addresses[$i]);
            $destination = $this->google->getCoordinates($addresses[$i + 1]);
            
            if (!$origin || !$destination) {
                return false;
            }

            $data = $this->google->getDistance($origin, $destination, $arrivalTimestamp);

            if ($data['distance']) {
                $this->stops[$i]['distance'] = $data['distance'];
            }
            if ($data['duration']) {
                if($i == 0){
                    $this->pick_up_time = $this->getTime($data['duration'], $arrivalTime);
                }
                $this->stops[$i]['duration'] = $data['duration'];
            }
        }
    }

    public function getTime($duration, $arrivalTime)
    {
        $totalMinutesToSubtract = $duration + 10;

        list($date, $time) = explode(' ', $arrivalTime);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute) = explode(':', $time);

        $arrivalTimestamp = mktime($hour, $minute, 0, $month, $day, $year);
        $newTimestamp = $arrivalTimestamp - ($totalMinutesToSubtract * 60);

        return date('H:i', $newTimestamp);
    }

    public function editEvent($id)
    {
        $this->title_modal = 'Edit Scheduling';
        $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
        $this->emit('getModelId', $id);
    }

    public function validateFields()
    {
        if ($this->patient_id && $this->hospital_id && $this->date && $this->check_in) {
            $addresses = [];
            $addresses[] = $this->pick_up_address;
            foreach ($this->stops as $stop) {
                $addresses[] = $stop['address'];
            }

            $arrivalTime = $this->date . ' ' . $this->check_in;

            $this->getDistance($addresses, $arrivalTime);
        }
    }

    public function render()
    {
        $scheduling = DB::table('schedulings')
            ->join('scheduling_address', 'schedulings.id', '=', 'scheduling_address.scheduling_id')
            ->join('scheduling_charge', 'schedulings.id', '=', 'scheduling_charge.scheduling_id')
            ->get();
        $events = [];
        $driverColors = [];

        foreach ($scheduling as $event) {
            $patient = Patient::find($event->patient_id);

            if (!isset($driverColors[$event->driver_id])) {
                $driverColors[$event->driver_id] = $this->colors[$event->driver_id - 1];
            }

            $color = $driverColors[$event->driver_id];
            $events[] = [
                'id' => $event->id,
                'driver_id' => $event->driver_id,
                'title' => $patient->first_name . " " . $patient->last_name,
                'start' => $event->date . " " . $event->pick_up_hour,
                'end' => $event->date . " " . $event->drop_off_hour,
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

        return view('livewire.scheduling.index', [
            'patients' => Patient::all(),
            'hospitals' => Facility::all(),
            'drivers' => $driver,
            'events' => $events
        ]);
    }
}
