<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\Facility;
use App\Models\Address;
use Illuminate\Support\Facades\DB;

class Schedulings extends Component
{
    public $distance, $duration, $patient_id, $hospital_id, $driver_id, $address_hospital, $date, $check_in, $pick_up, $pick_up_time, $modelId = '';

    public $wheelchair = false;
    public $ambulatory = false;
    public $saturdays = false;
    public $companion = false;
    public $fast_track = false;
    public $sundays_holidays = false;
    public $out_of_hours = false;
    public $auto_agend = false;
    public $type_of_trip;

    public $item, $action, $search, $title_modal, $countSchedulings = '';
    public $isEdit = false;

    public $weekdays = [];
    public $ends_schedule;
    public $ends_date;

    // Variables para la API Holidays
    public $url = 'https://holidays.abstractapi.com/v1/';
    public $api_key = '0a20ae64f61d46a583956c86895843ff';
    public $country = 'US';

    // variables para la API Google Maps
    public $map_api_key = 'AIzaSyBOx8agvT4F1RjSW4IS_zgkINQzdFZevik';
    public $url_map = 'https://maps.googleapis.com/maps/api/';

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
        'updatePatientId',
        'checkDate',
        'updateHospitalAddress',
        'getDistance',
        'editEvent',
        'updateEventDate',
        'updateEventsCalendar'
    ];

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
        $model = Scheduling::find($this->modelId);

        $this->fill([
            'patient_id' => $model->patient_id,
            'hospital_id' => $model->hospital_id,
            'driver_id' => $model->driver_id,
            'distance' => $model->distance,
            'duration' => $model->duration,
            'date' => $model->date,
            'check_in' => $model->check_in,
            'pick_up' => $model->pick_up,
            'pick_up_time' => $model->pick_up_time,
            'wheelchair' => $model->wheelchair,
            'ambulatory' => $model->ambulatory,
            'saturdays' => $model->saturdays,
            'sundays_holidays' => $model->sundays_holidays,
            'companion' => $model->companion,
            'fast_track' => $model->fast_track,
            'out_of_hours' => $model->out_of_hours,
            'auto_agend' => $model->auto_agend,
        ]);
    }

    private function clearForm()
    {
        $this->reset(['modelId', 'patient_id', 'hospital_id', 'driver_id', 'distance', 'duration', 'date', 'check_in', 'pick_up', 'pick_up_time', 'wheelchair', 'ambulatory', 'saturdays', 'sundays_holidays', 'companion', 'fast_track', 'out_of_hours', 'auto_agend']);
        $this->isEdit = false;
        $this->addresses = [];
    }

    public function save()
    {
        $this->validate();

        if ($this->modelId) {
            $scheduling = Scheduling::findOrFail($this->modelId);
            $this->isEdit = true;

            $minutes = explode(' ', $this->duration)[0];
            $date = $this->date . ' ' . $this->customHourTo;
            $endTimestamp = strtotime("+$minutes minutes", strtotime($date));
            $this->pick_up_time = date('H:i', $endTimestamp);
        } else {
            $scheduling = new Scheduling;
        }

        $scheduling->patient_id = $this->patient_id;
        $scheduling->hospital_id = $this->hospital_id;
        $scheduling->driver_id = $this->driver_id;
        $scheduling->distance = $this->distance;
        $scheduling->duration = $this->duration;
        $scheduling->date = $this->date;
        $scheduling->check_in = $this->check_in;
        $scheduling->pick_up = $this->pick_up;
        $scheduling->pick_up_time = $this->pick_up_time;
        $scheduling->wheelchair = $this->wheelchair;
        $scheduling->ambulatory = $this->ambulatory;
        $scheduling->saturdays = $this->saturdays;
        $scheduling->sundays_holidays = $this->sundays_holidays;
        $scheduling->companion = $this->companion;
        $scheduling->auto_agend = $this->auto_agend;

        $scheduling->save();

        $patient = Patient::find($scheduling->patient_id);

        $driverColors = [];

        if (!isset($driverColors[$scheduling->driver_id])) {
            $driverColors[$scheduling->driver_id] = $this->colors[$scheduling->driver_id - 1];
        }

        $color = $driverColors[$scheduling->driver_id];

        $new_event = [
            'id' => $scheduling->id,
            'title' => $patient->first_name . " " . $patient->last_name,
            'start' => $scheduling->date . " " . $scheduling->check_in,
            'end' => $scheduling->date . " " . $scheduling->pick_up_time,
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

    public function updateHospitalAddress($hospitalId)
    {
        $hospital = Facility::findOrFail($hospitalId);
        $this->address_hospital = $hospital->address;
    }

    public function updatePatientId($patientId)
    {
        $this->addresses = [['value' => '', 'text' => 'Select a address']];
        $this->patient_id = $patientId;
        $patientAddresses = Address::where('user_id', $this->patient_id)->get()->map(function ($address) {
            return ['value' => $address->id, 'text' => $address->address];
        })->toArray();
        $this->addresses = array_merge($this->addresses, $patientAddresses);
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
                $is_holiday = json_decode($this->checkHolydays($date));
                $this->sundays_holidays = is_array($is_holiday) && collect($is_holiday)->contains('type', 'National');
                $this->saturdays = false;
                break;
        }
    }

    public function checkHolydays($date)
    {
        $date = explode('-', $date);
        $year = $date[0];
        $month = $date[1];
        $day = $date[2];

        $url = "{$this->url}?api_key={$this->api_key}&country={$this->country}&year={$year}&month={$month}&day={$day}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
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

    public function getDistance($origin, $destination, $arrivalTime)
    {
        $arrivalTimestamp = strtotime($arrivalTime);
        $originCoords = $this->getCoordinates($origin);
        $destinationCoords = $this->getCoordinates($destination);

        if (!$originCoords || !$destinationCoords) {
            return false;
        }

        $origins = "{$originCoords['lat']},{$originCoords['lng']}";
        $destinations = "{$destinationCoords['lat']},{$destinationCoords['lng']}";
        $url = "{$this->url_map}distancematrix/json?origins={$origins}&destinations={$destinations}&key={$this->map_api_key}&units=imperial&arrival_time={$arrivalTimestamp}";

        $response = file_get_contents($url);
        $data = json_decode($response);

        if ($data->status == 'OK' && $data->rows[0]->elements[0]->status == 'OK') {
            $distance = $data->rows[0]->elements[0]->distance->text;
            $duration = $data->rows[0]->elements[0]->duration->text;

            $this->distance = $distance;
            $this->duration = $duration;
            $this->pick_up_time = $this->getTime($duration, $arrivalTime);
        } else {
            return false;
        }
    }

    public function getTime($duration, $arrivalTime)
    {
        $minutesToSubtract = $this->convertToMinutes($duration);
        $totalMinutesToSubtract = $minutesToSubtract + 10;

        list($date, $time) = explode(' ', $arrivalTime);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute) = explode(':', $time);

        $arrivalTimestamp = mktime($hour, $minute, 0, $month, $day, $year);
        $newTimestamp = $arrivalTimestamp - ($totalMinutesToSubtract * 60);

        return date('H:i', $newTimestamp);
    }

    public function convertToMinutes($timeString) {
        $totalMinutes = 0;
        preg_match_all('/(\d+)\s*(hours?|mins?)/', $timeString, $matches, PREG_SET_ORDER);
        
        foreach ($matches as $match) {
            $value = intval($match[1]);
            $unit = $match[2];
            
            if (strpos($unit, 'hour') !== false) {
                $totalMinutes += $value * 60;
            } elseif (strpos($unit, 'min') !== false) {
                $totalMinutes += $value;
            }
        }
        
        return $totalMinutes;
    }



    public function editEvent($id)
    {
        $this->title_modal = 'Edit Scheduling';
        $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
        $this->emit('getModelId', $id);
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

    public function updatedPickUp($value)
    {
        $this->validateFields();
    }

    public function updatedDate($value)
    {
        $this->validateFields();
    }

    public function validateFields()
    {
        if($this->patient_id && $this->hospital_id && $this->date && $this->check_in){
            $origin = Address::find($this->pick_up)->address;
            $destination = $this->address_hospital;
            $arrivalTime = $this->date . ' ' . $this->check_in;

            $this->getDistance($origin, $destination, $arrivalTime);
        }
    }

    public function updatedEndsSchedule($value)
    {
        if ($value == 'ends_check') {
            $this->ends_date = null; // Reset ends_date if 'ends_check' is selected
        } else {
            $this->ends_date = ''; // Disable ends_date if any other option is selected
        }
    }

    public function render()
    {
        $scheduling = Scheduling::all();
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
                'start' => $event->date . " " . $event->check_in,
                'end' => $event->date . " " . $event->pick_up_time,
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
