<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\Facility;
use App\Models\Address;

use App\Models\SchedulingAddress;
use App\Models\SchedulingCharge;
use App\Models\ApisGoogle;
use App\Models\ApiHoliday;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Schedulings extends Component
{
    // Campos de la tabla scheduling
    public $patient_id, $date, $check_in, $pick_up_time, $status = '';
    public $auto_agend = false;
    public $weekdays = [];
    public $ends_schedule;
    public $ends_date;
    public $google;

    // Campos de la tabla scheduling_address
    public $pick_up_driver_id, $drop_off_driver_id, $pick_up_address, $drop_off_address, $pick_up_hour, $drop_off_hour, $distance, $location_driver, $return_pick_up_address, $r_check_in, $r_start_drive, $request_by, $errors_r_check_in, $errors_driver = '';

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

    public $saved_addresses = [];
    public $prediction_pick_up = [];
    public $prediction_drop_off = [];

    public $prediction_location_driver = [];
    public $prediction_return_pick_up_address = [];

    public $stops = [
        [
            'address' => '',
            'addresses' => []
        ]
    ];
    public $r_stops = [
        [
            'address' => '',
            'addresses' => []
        ]
    ];

    public $distances = [];
    public $addresses = [];

    // Array de colores predefinidos
    public $colors = [
        '#D6EEEB',
        '#C1E9FC',
        '#ADACCE',
        '#C7E4D9',
        '#95DAEE',
        '#9990BA',
        '#86D0C6',
        '#6ACDE5',
        '#D498C6',
        '#74CDD1',
        '#00B6D3',
        '#C679B4',
        '#00BCAD',
        '#0085BD',
        '#7D4497',
        '#1294A7',
        '#2A348E',
        '#671D67',
        '#11686B',
        '#102444',
        '#401E5B'
    ];

    protected $rules = [
        'patient_id' => 'required',
        'date' => 'required',
        'check_in' => 'required',
        'pick_up_driver_id' => 'required',
        'drop_off_driver_id' => 'required',
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
        'checkDate',
        'editEvent',
        'updateEventDate',
        'updateEventsCalendar',
        'confirmCollect',
        'continueScheduling'
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
                if(cache()->get('autoagendamiento_form')){
                    $this->dispatchBrowserEvent('showAlert', 
                    [
                        'text' => 'You have unsaved changes! Do you want to continue?',
                        'icon' => 'info',
                        'confirmButtonText' => 'Yes',
                        'denyButtonText' => 'No',
                        'livewire' => 'continueScheduling',
                        'id' => false,
                    ]);
                }else{
                    $this->title_modal = 'Create Scheduling';
                    $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
                    $this->emit('clearForm');
                }
                break;
            default:
                $this->title_modal = 'Edit Scheduling';
                $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
                $this->emit('getModelId', $this->item);
                break;
        }
    }

    function continueScheduling($comfirm){
        if($comfirm){
            $data = cache()->get('autoagendamiento_form');
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
        }else{
            cache()->forget('autoagendamiento_form');
            $this->clearForm();
        }

        $this->title_modal = 'Create Scheduling';
        $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
    }

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;
        $model_scheduling = Scheduling::find($this->modelId);

        $this->patient_id = $model_scheduling->patient_id;
        $this->auto_agend = $model_scheduling->auto_agend;
        $this->status = $model_scheduling->status;

        $model_scheduling_address = SchedulingAddress::where('scheduling_id', $model_scheduling->id)->first();
        $this->pick_up_address = $model_scheduling_address->pick_up_address;
        $this->drop_off_address = $model_scheduling_address->drop_off_address;
        $this->date = $model_scheduling_address->date;
        $this->check_in = $model_scheduling_address->pick_up_hour;
        $this->pick_up_driver_id = $model_scheduling_address->pick_up_driver_id;
        $this->pick_up_time = $model_scheduling_address->drop_off_hour;
        $this->distance = $model_scheduling_address->distance;

        $model_scheduling_charge = SchedulingCharge::where('scheduling_id', $model_scheduling->id)->first();
        $this->type_of_trip = $model_scheduling_charge->type_of_trip;
        $this->wheelchair = $model_scheduling_charge->wheelchair;
        $this->ambulatory = $model_scheduling_charge->ambulatory;
        $this->out_of_hours = $model_scheduling_charge->out_of_hours;
        $this->saturdays = $model_scheduling_charge->saturdays;
        $this->sundays_holidays = $model_scheduling_charge->sundays_holidays;
        $this->companion = $model_scheduling_charge->companion;
        $this->aditional_waiting = $model_scheduling_charge->aditional_waiting;
        $this->fast_track = $model_scheduling_charge->fast_track;
        $this->if_not_cancel = $model_scheduling_charge->if_not_cancel;
    }

    private function clearForm()
    {
        $this->reset(['modelId', 'patient_id', 'pick_up_address', 'pick_up_time', 'return_pick_up_address', 'drop_off_address', 'date', 'check_in', 'drop_off_hour', 'wheelchair', 'ambulatory', 'saturdays', 'sundays_holidays', 'companion', 'fast_track', 'out_of_hours', 'auto_agend']);

        $this->isEdit = false;

        $this->prediction_pick_up = [];
        $this->prediction_drop_off = [];
        $this->prediction_location_driver = [];
        $this->prediction_return_pick_up_address = [];

        $this->stops = [
            [
                'address' => '',
                'addresses' => []
            ]
        ];
        $this->r_stops = [
            [
                'address' => '',
                'addresses' => []
            ]
        ];
        $this->addresses = [];
        $this->errors_r_check_in = '';
    }

    public function save()
    {
        $this->validate();

        if ($this->modelId) {
            $this->isEdit = true;
        }

        if ($this->auto_agend) {
            $this->saveAutoAgend();
        } else {
            $this->saveManualAgend();
        }

        $events = $this->getEventsCalendar();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        $data = ($this->isEdit)
            ? ['message' => 'Scheduling updated successfully!', 'type' => 'success', 'icon' => 'edit']
            : ['message' => 'Scheduling created successfully!', 'type' => 'info', 'icon' => 'check'];

        $this->emit('updateEvents', $events);


        session()->flash('alert', $data);

        $this->clearForm();
    }

    private function saveAddresses($addresses, $scheduling, $type, $date, $auto_agend)
    {
        for ($i = 0; $i < count($addresses) - 1; $i++) {

            if ($type == 'pick_up') {
                $check_in = ($i == 0) ? $this->check_in : $this->sumWaitTime($this->check_in, $addresses[$i]['duration']);
                $drop_off = $this->sumWaitTime($this->check_in, $addresses[$i]['duration']);
            } else {
                $check_in = ($i == 0) ? $this->r_check_in : $this->sumWaitTime($this->r_check_in, $addresses[$i]['duration']);
                $drop_off = $this->sumWaitTime($this->r_check_in, $addresses[$i]['duration']);
            }

            $scheduling_address = new SchedulingAddress;

            $scheduling_address->scheduling_id = $scheduling->id;
            $scheduling_address->driver_id = ($type == 'pick_up') ? $this->pick_up_driver_id : $this->drop_off_driver_id;
            $scheduling_address->date = ($auto_agend) ? $date : $this->date;
            $scheduling_address->pick_up_address = $addresses[$i]['address'];
            $scheduling_address->drop_off_address = $addresses[$i + 1]['address'];
            $scheduling_address->pick_up_hour = $check_in;
            $scheduling_address->drop_off_hour = $drop_off;
            $scheduling_address->distance = $addresses[$i + 1]['distance'];
            $scheduling_address->duration = $addresses[$i + 1]['duration'];
            $scheduling_address->type_of_trip = $type;
            $scheduling_address->request_by = $this->request_by;
            $scheduling_address->status = 'Waiting';

            $scheduling_address->save();
        }
    }

    public function saveManualAgend()
    {
        $scheduling = new Scheduling;
        $scheduling->patient_id = $this->patient_id;
        $scheduling->auto_agend = $this->auto_agend;
        $scheduling->save();

        $scheduling_charge = new SchedulingCharge();
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

        $newStop = [
            "address" => $this->pick_up_address,
            "addresses" => [],
            "distance" => "0",
            "duration" => "0"
        ];

        if (!in_array($newStop, $this->stops)) {
            array_unshift($this->stops, $newStop);
        }

        $this->saveAddresses($this->stops, $scheduling, 'pick_up', '', $this->auto_agend);

        $nerReturnStop = [
            "address" => $this->return_pick_up_address,
            "addresses" => [],
            "distance" => "0",
            "duration" => "0"
        ];

        if (!in_array($nerReturnStop, $this->r_stops)) {
            array_unshift($this->r_stops, $nerReturnStop);
        }

        $this->saveAddresses($this->r_stops, $scheduling, 'return', '', $this->auto_agend);
    }

    public function saveAutoAgend()
    {

        $start = Carbon::parse($this->date);
        if ($this->ends_schedule == 'ends_check') {
            $end = Carbon::parse($this->ends_date);
        } else {
            $lastDayOfYear = Carbon::now()->endOfYear();
            $end = Carbon::parse($lastDayOfYear->format('Y-m-d'));
        }

        while ($start->lessThanOrEqualTo($end)) {
            if (in_array($start->format('l'), $this->weekdays)) {
                $scheduling = new Scheduling;
                $scheduling->patient_id = $this->patient_id;
                $scheduling->auto_agend = $this->auto_agend;
                $scheduling->save();

                $scheduling_charge = new SchedulingCharge();
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

                $newStop = [
                    "address" => $this->pick_up_address,
                    "addresses" => [],
                    "distance" => "0",
                    "duration" => "0"
                ];

                if (!in_array($newStop, $this->stops)) {
                    array_unshift($this->stops, $newStop);
                }

                $this->saveAddresses($this->stops, $scheduling, 'pick_up', $start->format('Y-m-d'), $this->auto_agend);

                $nerReturnStop = [
                    "address" => $this->return_pick_up_address,
                    "addresses" => [],
                    "distance" => "0",
                    "duration" => "0"
                ];

                if (!in_array($nerReturnStop, $this->r_stops)) {
                    array_unshift($this->r_stops, $nerReturnStop);
                }

                $this->saveAddresses($this->r_stops, $scheduling, 'return', $start->format('Y-m-d'), $this->auto_agend);
            }

            $start->addDay();
        }
    }

    public function sumWaitTime($pick_up_hour, $duration)
    {
        $hora = $pick_up_hour;
        $minutosASumar = $duration + 10;

        return Carbon::createFromFormat('H:i', $hora)->addMinutes($minutosASumar)->format('H:i');
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

    // Click en el input para obtener las direcciones guardadas
    public function getAddresses($input)
    {
        if ($this->saved_addresses) {
            if (!$this->$input) {
                $this->$input = $this->saved_addresses;
            }
        }
    }

    // Funciones que validan la actualización de algun campo

    public function updated()
    {
        $data = [
            'patient_id' => $this->patient_id,
            'auto_agend' => $this->auto_agend,
            'date' => $this->date,
            'check_in' => $this->check_in,
            'pick_up_driver_id' => $this->pick_up_driver_id,
            'drop_off_driver_id' => $this->drop_off_driver_id,
            'pick_up_address' => $this->pick_up_address,
            'drop_off_address' => $this->drop_off_address,
            'pick_up_time' => $this->pick_up_time,
            'drop_off_hour' => $this->drop_off_hour,
            'distance' => $this->distance,
            'type_of_trip' => $this->type_of_trip,
            'wheelchair' => $this->wheelchair,
            'ambulatory' => $this->ambulatory,
            'saturdays' => $this->saturdays,
            'sundays_holidays' => $this->sundays_holidays,
            'companion' => $this->companion,
            'fast_track' => $this->fast_track,
            'if_not_cancel' => $this->if_not_cancel,
            'ends_schedule' => $this->ends_schedule,
            'ends_date' => $this->ends_date,
            'weekdays' => $this->weekdays,
        ];

        cache()->put('autoagendamiento_form', $data, now()->addMinutes(30)); // Guardar por 30 minutos
    }

    public function updatedPickUpAddress()
    {
        if (strlen($this->pick_up_address) >= 3) {
            $googlePredictions = $this->google->getPlacePredictions($this->pick_up_address);

            if (count($this->saved_addresses) > 0) {
                $this->prediction_pick_up = array_merge($this->saved_addresses, $googlePredictions);
            } else {
                $this->prediction_pick_up = $googlePredictions;
            }
        } else {
            $this->prediction_pick_up = [];
        }
    }

    public function updatedPatientId($patientId)
    {
        $this->saved_addresses = [];

        $patient = Patient::find($patientId);
        $facility = Facility::findorFail($patient->service_contract_id);

        $address_patient = Address::where('patient_id', $patientId)->get();
        $address_facility = Address::where('facility_id', $facility->id)->get();

        foreach ($address_patient as $address) {
            $this->saved_addresses[] = $address->address;
        }
        foreach ($address_facility as $address) {
            $this->saved_addresses[] = $address->address;
        }
    }

    public function updatedReturnPickUpAddress()
    {
        if (strlen($this->return_pick_up_address) >= 3) {
            $googlePredictions = $this->google->getPlacePredictions($this->return_pick_up_address);

            if (count($this->saved_addresses) > 0) {
                $this->prediction_return_pick_up_address = array_merge($this->saved_addresses, $googlePredictions);
            } else {
                $this->prediction_return_pick_up_address = $googlePredictions;
            }
        } else {
            $this->prediction_return_pick_up_address = [];
        }
    }

    public function updateDropOffAddress($dropOffId)
    {
        $this->drop_off_address = $dropOffId;
        $this->validateAddresses('drop_off');
    }

    public function updatedLocationDriver()
    {
        if (strlen($this->location_driver) >= 3) {
            $this->prediction_location_driver = $this->google->getPlacePredictions($this->location_driver);
        } else {
            $this->prediction_location_driver = [];
        }
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
            ? DB::select('SELECT * FROM schedulings INNER JOIN scheduling_address ON schedulings.id = scheduling_address.scheduling_id INNER JOIN scheduling_charge ON schedulings.id = scheduling_charge.scheduling_id WHERE scheduling_address.driver_id IN (' . implode(',', $driverIds) . ')')
            : Scheduling::all();

        $new_events = [];
        $driverColors = [];

        foreach ($scheduling as $event) {
            $scheduling_address = SchedulingAddress::find($event->id);

            $patient = Patient::find($event->patient_id);

            if (!isset($driverColors[$scheduling_address->driver_id])) {
                $driverColors[$scheduling_address->driver_id] = $this->colors[$scheduling_address->driver_id - 1];
            }

            $color = $driverColors[$scheduling_address->driver_id];
            $new_events[] = [
                'id' => $event->id,
                'driver_id' => $scheduling_address->driver_id,
                'title' => $patient->first_name . " " . $patient->last_name,
                'start' => $scheduling_address->date . " " . $scheduling_address->pick_up_hour,
                'end' => $scheduling_address->date . " " . $scheduling_address->drop_off_hour,
                'color' => $color,
            ];
        }

        $this->emit('updateEvents', $new_events);
    }

    public function updatedCheckIn()
    {
        $this->validateFields();
    }

    public function updatedRCheckin()
    {

        if ($this->r_check_in < $this->check_in) {
            $this->errors_r_check_in = 'Check in must be greater than pick up time!';
            $this->r_check_in = '';

            return;
        }

        $this->validateFieldsReturn();
        $this->errors_r_check_in = '';
    }

    public function updatedEndsSchedule($value)
    {
        if ($value == 'ends_check') {
            $this->ends_date = null; // Reset ends_date if 'ends_check' is selected
        } else {
            $this->ends_date = ''; // Disable ends_date if any other option is selected
        }
    }

    public function updatedPickUpDriverId()
    {

        $sql = "SELECT * FROM scheduling_address WHERE driver_id = '$this->pick_up_driver_id' AND pick_up_hour BETWEEN '$this->pick_up_time' AND '$this->check_in'";
        $validation = DB::select($sql);

        if (count($validation) > 0) {
            $this->errors_driver = 'Pick up driver must be available between pick up time and check in time';
        } else {
            $this->errors_driver = '';
        }
    }

    public function addPickUp($address)
    {
        $this->pick_up_address = $address;
        $this->validateAddresses('pick_up');
        $this->prediction_pick_up = [];
    }

    public function addLocationDriver($address)
    {
        $this->location_driver = $address;
        $this->validateAddresses('location_driver');
        $this->prediction_location_driver = [];
    }

    public function addReturnPickUp($address)
    {
        $this->return_pick_up_address = $address;
        $this->validateAddresses('return_pick_up');
        $this->prediction_return_pick_up_address = [];

        if ($this->location_driver) {
            $this->calculateTimeDriver();
        }
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

    public function addStopReturn()
    {
        $this->r_stops[] = ['address' => '', 'addresses' => []];
    }

    public function removeStop($index)
    {
        unset($this->stops[$index]);
        $this->stops = array_values($this->stops);
    }

    public function removeStopReturn($index)
    {
        unset($this->r_stops[$index]);
        $this->r_stops = array_values($this->r_stops);
    }

    public function updateStopQuery($index, $query)
    {
        $this->stops[$index]['address'] = $query;

        if (strlen($query) >= 3) {
            $googlePredictions = $this->google->getPlacePredictions($query);

            if (count($this->saved_addresses) > 0) {
                $this->stops[$index]['addresses'] = array_merge($this->saved_addresses, $googlePredictions);
            } else {
                $this->stops[$index]['addresses'] = $googlePredictions;
            }
        } else {
            $this->stops[$index]['addresses'] = [];
        }
    }

    public function updateStopQueryReturn($index, $query)
    {
        $this->r_stops[$index]['address'] = $query;

        if (strlen($query) >= 3) {
            $googlePredictions = $this->google->getPlacePredictions($query);

            if (count($this->saved_addresses) > 0) {
                $this->r_stops[$index]['addresses'] = array_merge($this->saved_addresses, $googlePredictions);
            } else {
                $this->r_stops[$index]['addresses'] = $googlePredictions;
            }
        } else {
            $this->r_stops[$index]['addresses'] = [];
        }
    }

    public function selectStopAddress($index, $address)
    {
        $this->stops[$index]['address'] = $address;
        $this->stops[$index]['addresses'] = [];
    }

    public function selectStopAddressReturn($index, $address)
    {
        $this->r_stops[$index]['address'] = $address;
        $this->r_stops[$index]['addresses'] = [];
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

    public function getDistance($addresses, $arrivalTime, $type, $showDistance = false)
    {
        $arrivalTimestamp = strtotime($arrivalTime);

        for ($i = 0; $i < count($addresses) - 1; $i++) {
            $origin = $this->google->getCoordinates($addresses[$i]);
            $destination = $this->google->getCoordinates($addresses[$i + 1]);

            if (!$origin || !$destination) {
                return false;
            }

            $data = $this->google->getDistance($origin, $destination, $arrivalTimestamp);

            if ($type == 'return') {
                if ($data['distance']) {
                    $this->r_stops[$i]['distance'] = $data['distance'];
                } else {
                    $this->r_stops[$i]['distance'] = 0;
                }

                if ($data['duration']) {
                    if ($showDistance) {
                        $this->r_start_drive = $data['duration'] . "min";
                    }

                    $this->r_stops[$i]['duration'] = $data['duration'];
                }
            } else {
                if ($data['distance']) {
                    $this->stops[$i]['distance'] = $data['distance'];
                } else {
                    $this->stops[$i]['distance'] = 0;
                }

                if ($data['duration']) {
                    if ($i == 0) {
                        $this->pick_up_time = $this->getTime($data['duration'], $arrivalTime);
                    }
                    $this->stops[$i]['duration'] = $data['duration'];
                }
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
        $this->isEdit = true;
        $this->emit('getModelId', $id);
    }

    public function revert()
    {
        $this->saveStatus(false);
    }

    public function cancelScheduling()
    {
        $this->dispatchBrowserEvent('showAlert', [
            'text' => "This scheduling will be canceled! Do you want to collect the cancellation?",
            'icon' => 'warning',
            'confirmButtonText' => 'Yes',
            'denyButtonText' => 'No',
            'livewire' => 'confirmCollect',
        ]);
    }

    public function confirmCollect($cancel)
    {
        $scheduling_charge = SchedulingCharge::where('scheduling_id', $this->modelId)->first();
        $scheduling_charge->collect_cancel = ($cancel) ? true : false;
        $scheduling_charge->save();

        $this->saveStatus(true);
    }

    private function saveStatus($cancel)
    {
        $scheduling_address = SchedulingAddress::where('scheduling_id', $this->modelId)->first();
        $scheduling_address->status = ($cancel) ? 'Canceled' : 'Waiting';
        $scheduling_address->save();

        $scheduling_charge = SchedulingCharge::findOrFail($scheduling_address->scheduling_id);
        $scheduling_charge->if_not_cancel = ($cancel) ? true : false;
        $scheduling_charge->save();

        $events = $this->getEventsCalendar();

        $this->emit('updateEvents', $events);
        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        $this->sessionAlert([
            'message' => ($cancel) ? 'Scheduling canceled successfully!' : 'Scheduling reverted cancel successfully!',
            'type' => 'success',
            'icon' => 'check',
        ]);
    }

    public function getEventsCalendar()
    {
        $scheduling = Scheduling::all();
        $events = [];
        $driverColors = [];

        foreach ($scheduling as $event) {
            $scheduling_address = SchedulingAddress::where('scheduling_id', $event->id)->first();
            $patient = Patient::find($event->patient_id);

            $driver_id = $scheduling_address->driver_id;
            if (!isset($driverColors[$driver_id])) {
                $driverColors[$driver_id] = $this->colors[$driver_id - 1];
            }

            $color = $driverColors[$driver_id];
            $events[] = [
                'id' => $event->id,
                'driver_id' => $driver_id,
                'title' => $patient->first_name . " " . $patient->last_name,
                'start' => $scheduling_address->date . " " . $scheduling_address->pick_up_hour,
                'end' => $scheduling_address->date . " " . $scheduling_address->drop_off_hour,
                'color' => $color,
                'className' => ($scheduling_address->status == 'Canceled') ? 'cancelled-event' : '',
            ];
        }

        return $events;
    }

    public function validateFields()
    {
        if (count($this->stops) == 0 && $this->pick_up_address == null && $this->check_in == null && $this->date == null) {
            return false;
        }

        $addresses = [];
        $addresses[] = $this->pick_up_address;
        foreach ($this->stops as $stop) {
            $addresses[] = $stop['address'];
        }

        $arrivalTime = $this->date . ' ' . $this->check_in;

        $this->getDistance($addresses, $arrivalTime, 'pick_up');
    }

    public function validateFieldsReturn()
    {
        if (count($this->r_stops) == 0 && $this->return_pick_up_address == null && $this->r_check_in == null && $this->date == null) {
            return false;
        }

        $addresses = [];
        $addresses[] = $this->return_pick_up_address;
        foreach ($this->r_stops as $stop) {
            $addresses[] = $stop['address'];
        }

        $arrivalTime = $this->date . ' ' . $this->r_check_in;

        $this->getDistance($addresses, $arrivalTime, 'return');
    }

    public function calculateTimeDriver()
    {
        if ($this->location_driver == null && $this->return_pick_up_address == null && $this->date == null) {
            return false;
        }

        $addresses = [];
        $addresses = [
            $this->location_driver,
            $this->return_pick_up_address
        ];

        $arrivalTime = $this->date . ' ' . date('H:i');

        $this->getDistance($addresses, $arrivalTime, 'return', true);
    }

    public function render()
    {
        $events = $this->getEventsCalendar();

        $driver = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*')
            ->where('roles.name', '=', 'Driver')
            ->where('users.id', '!=', auth()->id())
            ->get();

        return view('livewire.scheduling.index', [
            'patients' => Patient::all(),
            'drivers' => $driver,
            'events' => $events
        ]);
    }
}
