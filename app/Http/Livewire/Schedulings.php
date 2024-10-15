<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\Facility;
use App\Models\Address;

use App\Models\SchedulingAddress;
use App\Models\SchedulingCharge;
use App\Models\SchedulingAutoagend;
use App\Models\ApisGoogle;
use App\Models\ApiHoliday;
use Illuminate\Support\Carbon;
use Exception;

use Illuminate\Support\Facades\DB;

class Schedulings extends Component
{
    // Campos de la tabla scheduling
    public $patient_id, $date, $check_in, $pick_up_time, $status, $ends_date, $end_date = '';
    public $auto_agend = false;
    public $weekdays = [];
    public $search_patients = [];
    public $ends_schedule;
    public $google;

    // Campos de la tabla scheduling_address
    public $pick_up_driver_id, $drop_off_driver_id, $pick_up_address, $drop_off_address, $pick_up_hour, $drop_off_hour, $distance, $location_driver, $return_pick_up_address, $r_check_in, $r_start_drive, $r_pick_up_time, $request_by, $errors_r_check_in, $errors_driver, $schedule_autoagend_id, $patient_name = '';

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
    public $type_of_trip = 'one_way';

    public $item, $action, $search, $title_modal, $countSchedulings, $modelId, $modelIdCharge = '';
    public $modelIdAddress = [];
    public $isEdit = false;

    public $saved_addresses = [];
    public $prediction_pick_up_address = [];
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
    ];

    protected $listeners = [
        'getModelId',
        'forcedCloseModal',
        'checkDate',
        'editEvent',
        'updateEventDate',
        'updateEventsCalendar',
        'confirmCollect',
        'continueScheduling',
        'deleteScheduling',
        'showConfirmDelete'
    ];

    public function __construct()
    {
        $this->google = new ApisGoogle();
    }

    public function selectItem($item, $action)
    {
        $this->item = $item;

        switch ($action) {
            case 'create':
                if (cache()->get('autoagendamiento_form')) {
                    $this->dispatchBrowserEvent(
                        'showConfirm',
                        [
                            'text' => 'You have unsaved changes! Do you want to continue?',
                            'icon' => 'info',
                            'confirmButtonText' => 'Yes',
                            'denyButtonText' => 'No',
                            'livewire' => 'continueScheduling',
                            'id' => false,
                        ]
                    );
                } else {
                    $this->title_modal = 'Create Scheduling';
                    $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
                    $this->emit('clearForm');
                }
                break;
        }
    }

    function continueScheduling($comfirm)
    {
        if ($comfirm) {
            $data = cache()->get('autoagendamiento_form');
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }
            $this->updatedPatientId($this->patient_id);
        } else {
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

        $patient = Patient::find($model_scheduling->patient_id);
        $this->patient_name = $patient->first_name . ' ' . $patient->last_name;

        $this->patient_id = $model_scheduling->patient_id;
        $this->auto_agend = $model_scheduling->auto_agend;
        $this->weekdays = explode(',', $model_scheduling->select_date);
        $this->ends_schedule = $model_scheduling->ends_schedule;
        $this->ends_date = $model_scheduling->end_date;
        $this->status = $model_scheduling->status;

        $model_scheduling_address = SchedulingAddress::where('scheduling_id', $model_scheduling->id)->get();

        $count = 0;
        $count_r = 0;
        foreach ($model_scheduling_address as $address) {
            $this->date = Carbon::createFromFormat('Y-m-d', $address->date)->format('m-d-Y');
            $this->schedule_autoagend_id = $address->scheduling_autoagend_id;
            if ($address->type_of_trip == 'pick_up') {
                $this->modelIdAddress[$address->type_of_trip] = $address->id;
                if (!$this->pick_up_address) {
                    $this->pick_up_address = $address->pick_up_address;
                }
                if (!$this->check_in) {
                    $this->check_in = $address->drop_off_hour;
                    $this->pick_up_time = $address->pick_up_hour;
                }
                $this->pick_up_driver_id = $address->driver_id;
                $this->stops[$count]['address'] = $address->drop_off_address;
                $this->stops[$count]['duration'] = $address->duration;
                $this->stops[$count]['distance'] = $address->distance;

                $count++;
            } elseif ($address->type_of_trip == 'return') {
                $this->modelIdAddress[$address->type_of_trip] = $address->id;
                $this->return_pick_up_address = $address->pick_up_address;
                $this->r_check_in = $address->drop_off_hour;
                $this->r_pick_up_time = $address->pick_up_hour;
                $this->drop_off_driver_id = $address->driver_id;

                $this->r_stops[$count_r]['address'] = $address->drop_off_address;
                $this->r_stops[$count_r]['duration'] = $address->duration;
                $this->r_stops[$count_r]['distance'] = $address->distance;
                $count_r++;
            }
        }

        $model_scheduling_charge = SchedulingCharge::where('scheduling_id', $model_scheduling->id)->first();
        $this->modelIdCharge = $model_scheduling_charge->id;
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
        $this->reset(['modelId', 'modelIdAddress', 'modelIdCharge', 'patient_id', 'weekdays', 'ends_schedule', 'ends_date', 'pick_up_driver_id', 'pick_up_time',  'return_pick_up_address', 'drop_off_address', 'date', 'check_in', 'drop_off_hour', 'type_of_trip', 'wheelchair', 'ambulatory', 'out_of_hours', 'saturdays', 'sundays_holidays', 'companion', 'aditional_waiting', 'fast_track', 'if_not_cancel', 'auto_agend', 'pick_up_address', 'r_check_in', 'r_pick_up_time', 'drop_off_driver_id', 'patient_name', 'errors_driver']);

        $this->isEdit = false;

        $this->prediction_pick_up_address = [];
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
        $formats = ['Y-m-d', 'm-d-Y', 'd-m-Y', 'Y/m/d', 'm/d/Y', 'd/m/Y']; // Lista de formatos comunes

        foreach ($formats as $format) {
            try {
                // Intentamos crear la fecha con cada formato
                $convertedDate = Carbon::createFromFormat($format, $this->date)->format('Y-m-d');
                break; // Si logra convertir, se sale del ciclo
            } catch (Exception $e) {
                // Si falla, continúa con el siguiente formato
                continue;
            }
        }

        if (!$convertedDate) {
            // Si no logró convertir la fecha, puedes manejar el error de alguna forma
            // Por ejemplo, asignando una fecha por defecto
            $convertedDate = Carbon::now()->format('Y-m-d');
        }
        
        $this->date = $convertedDate;


        if ($this->auto_agend) {
            $this->saveAutoAgend();

            $auto = SchedulingAutoagend::get()->first();
            $auto->id = $auto->id + 1;
            $auto->save();
        } else {
            $this->saveManualAgend();
        }

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);
        
        $events = $this->getEventsCalendar('');
        $this->emit('updateEvents', $events);

        $data = ($this->isEdit)
            ? ['message' => 'Scheduling updated successfully!', 'type' => 'success', 'icon' => 'edit']
            : ['message' => 'Scheduling created successfully!', 'type' => 'info', 'icon' => 'check'];
        $this->sessionAlert($data);

        cache()->forget('autoagendamiento_form');
        $this->clearForm();
    }

    public function saveManualAgend()
    {
        if ($this->modelId) {
            $scheduling = Scheduling::find($this->modelId);
        } else {
            $scheduling = new Scheduling;
        }
        $scheduling->patient_id = $this->patient_id;
        $scheduling->auto_agend = $this->auto_agend;
        $scheduling->select_date = implode(',', $this->weekdays);
        $scheduling->ends_schedule = $this->ends_schedule;
        $scheduling->end_date = $this->ends_date;
        $scheduling->save();

        if ($this->modelIdCharge) {
            $scheduling_charge = SchedulingCharge::find($this->modelIdCharge);
        } else {
            $scheduling_charge = new SchedulingCharge();
        }
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

        $d_saved_addresses =  SchedulingAddress::where('scheduling_id', $scheduling->id)->get();
        if(count($d_saved_addresses) > 0){
            foreach ($d_saved_addresses as $address) {
                $address->delete();
            }
        }
        
        if($this->pick_up_address){
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
        }

        if($this->return_pick_up_address){
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
    }

    public function saveAutoAgend()
    {
        if ($this->auto_agend) {
            $scheduling_address = SchedulingAddress::where('scheduling_autoagend_id', $this->schedule_autoagend_id)
                ->where('date', '>=', $this->date)
                ->get();

            if (count($scheduling_address) > 0) {

                foreach ($scheduling_address as $address) {
                    $d_schedulings = Scheduling::where('id', $address->scheduling_id)->get();
                    foreach ($d_schedulings as $d_scheduling) {
                        $d_scheduling->delete();
                    }

                    $d_scheduling_charge = SchedulingCharge::where('scheduling_id', $address->scheduling_id)->get();
                    foreach ($d_scheduling_charge as $charge) {
                        $charge->delete();
                    }

                    $address->delete();
                }

                $this->modelId = '';
                $this->modelIdAddress = [];
                $this->modelIdCharge = '';
            }
        }

        $start = Carbon::parse($this->date);
        if ($this->ends_schedule == 'ends_check') {
            $end = Carbon::parse($this->ends_date);
        } else {
            $lastDayOfYear = Carbon::now()->endOfYear();
            $end = Carbon::parse($lastDayOfYear->format('Y-m-d'));
        }

        while ($start->lessThanOrEqualTo($end)) {            
            if (in_array($start->format('l'), $this->weekdays)) {
                if ($this->modelId) {
                    $scheduling = Scheduling::find($this->modelId);
                } else {
                    $scheduling = new Scheduling;
                }

                $scheduling->patient_id = $this->patient_id;
                $scheduling->auto_agend = $this->auto_agend;
                $scheduling->select_date = implode(',', $this->weekdays);
                $scheduling->ends_schedule = $this->ends_schedule;
                $scheduling->end_date = $end;
                $scheduling->save();

                if ($this->modelIdCharge) {
                    $scheduling_charge = SchedulingCharge::find($this->modelIdCharge);
                } else {
                    $scheduling_charge = new SchedulingCharge();
                }

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

                $d_saved_addresses =  SchedulingAddress::where('scheduling_id', $scheduling->id)->get();
                foreach ($d_saved_addresses as $address) {
                    $address->delete();
                }

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

    private function saveAddresses($addresses, $scheduling, $type, $date, $auto_agend)
    {
        for ($i = 0; $i < count($addresses) - 1; $i++) {
            if ($type == 'pick_up') {
                $check_in = ($i == 0) ? $this->pick_up_time : $this->sumWaitTime($this->pick_up_time, $addresses[$i]['duration']);
                $drop_off = $this->check_in;
            } else {
                $check_in = ($i == 0) ? $this->r_pick_up_time : $this->sumWaitTime($this->r_pick_up_time, $addresses[$i]['duration']);
                $drop_off = $this->r_check_in;
            }

            $scheduling_address = new SchedulingAddress;
            $scheduling_address->scheduling_id = $scheduling->id;
            $scheduling_address->scheduling_autoagend_id = SchedulingAutoagend::get()->first()->id;
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

    public function showConfirmDelete()
    {
        $this->dispatchBrowserEvent('showConfirm', [
            'text' => "Do you want to delete this scheduling? This action cannot be undone!",
            'icon' => 'warning',
            'confirmButtonText' => 'Yes',
            'denyButtonText' => 'No',
            'livewire' => 'deleteScheduling',
        ]);
    }

    public function deleteScheduling()
    {
        $model_scheduling = Scheduling::find($this->modelId);
        
        $scheduling_address = SchedulingAddress::where('scheduling_id', $model_scheduling->id)->get();
        foreach ($scheduling_address as $address) {
            $address->delete();
        }
        $scheduling_charge = SchedulingCharge::where('scheduling_id', $model_scheduling->id)->get();
        foreach ($scheduling_charge as $charge) {
            $charge->delete();
        }

        $model_scheduling->delete();

        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        $events = $this->getEventsCalendar('');
        $this->emit('updateEvents', $events);

        $this->sessionAlert([
            'message' => 'Scheduling deleted successfully!',
            'type' => 'success',
            'icon' => 'check',
        ]);
    }

    public function sumWaitTime($pick_up_hour, $duration)
    {
        $hora = Carbon::parse($pick_up_hour)->format('H:i');
        $minutosASumar = $duration + 30;

        return Carbon::createFromFormat('H:i', $hora)->addMinutes($minutosASumar)->format('H:i');
    }

    public function subtractTime($pick_up_hour, $duration)
    {
        $hora = Carbon::parse($pick_up_hour)->format('H:i');
        $minutosASumar = $duration + 30;

        return Carbon::createFromFormat('H:i', $hora)->subMinutes($minutosASumar)->format('H:i');
    }

    public function forcedCloseModal()
    {
        sleep(2);
        $this->clearForm();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    // Click en el input para obtener las direcciones guardadas
    public function getAddresses($input)
    {
        $this->$input = $this->saved_addresses;
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
            'patient_name' => $this->patient_name,
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

    public function selectPatient($patientId)
    {
        $this->saved_addresses = [];

        $patient = Patient::find($patientId);
        if (!$patient) {
            return;
        }

        $this->patient_id = $patient->id;
        if ($patient->billing_code == 'A0100') {
            $this->wheelchair = true;
        }elseif ($patient->billing_code == 'A0120-Ambulatory') {
            $this->ambulatory = true;
        }else{
            $this->wheelchair = true;
        }
        $this->patient_name = $patient->first_name . ' ' . $patient->last_name;
        $address_patient = Address::where('patient_id', $patientId)->get();
        foreach ($address_patient as $address) {
            $this->saved_addresses[] = $address->address;
        }

        if (!$patient->service_contract_id) {
            return;
        }

        $facilities = Facility::where('service_contract_id', $patient->service_contract_id)->get();
        foreach ($facilities as $facility) {
            $address_facility = Address::where('facility_id', $facility->id)->get();
            foreach ($address_facility as $address) {
                $this->saved_addresses[] = $address->address;
            }
        }

        $this->search_patients = [];
    }

    public function checkPatientName($query)
    {
        if ( strlen($query) >= 3) {
            $search = Patient::where('first_name', 'LIKE', "%$query%")
                ->orWhere('last_name', 'LIKE', "%$query%")
                ->orWhere('medicalid', 'LIKE', "%$query%")
                ->get();
                
            // Obtener los IDs ya presentes en $this->search_patients
            $existingIds = array_column($this->search_patients, 'id');

            foreach ($search as $patient) {
                // Verificar si el paciente ya está en el arreglo
                if (!in_array($patient->id, $existingIds)) {
                    $this->search_patients[] = [
                        'name' => $patient->first_name . ' ' . $patient->last_name,
                        'id' => $patient->id
                    ];
                }
            }
        } else {
            $this->search_patients = [];
        }
    }

    public function updatedPickUpAddress()
    {
        $this->predictionLocation('pick_up_address');
    }

    public function updatedReturnPickUpAddress()
    {
        $this->predictionLocation('return_pick_up_address');
    }

    public function updatedLocationDriver()
    {
        $this->predictionLocation('location_driver');
    }

    public function predictionLocation($type)
    {
        if (strlen($this->$type) >= 3) {
            $googlePredictions = $this->google->getPlacePredictions($this->$type);

            $type = 'prediction_' . $type;
            if (count($this->saved_addresses) > 0) {
                $this->$type = array_merge($this->saved_addresses, $googlePredictions);
            } else {
                $this->$type = $googlePredictions;
            }
        } else {
            $type = 'prediction_' . $type;
            $this->$type = [];
        }
    }

    public function updateDropOffAddress($dropOffId)
    {
        $this->drop_off_address = $dropOffId;
        $this->validateAddresses('drop_off');
    }

    public function updateEventDate($id, $start)
    {
        $array_start = explode(' ', $start);

        $scheduling = Scheduling::find($id);

        $scheduling_address = SchedulingAddress::where('scheduling_id', $scheduling->id)->get();

        foreach ($scheduling_address as $address) {
            $address->date = $array_start[0];
            $address->pick_up_hour = $array_start[1];
            $address->save();
        }

        $events = $this->getEventsCalendar('');

        $this->emit('updateEvents', $events);

        $this->sessionAlert([
            'message' => 'Event updated successfully!',
            'type' => 'success',
            'icon' => 'edit',
        ]);
    }

    public function updateEventsCalendar($driverIds)
    {
        $events = !empty($driverIds)
            ? $this->getEventsCalendar($driverIds)
            : $this->getEventsCalendar('');

        $this->emit('updateEvents', $events);
    }

    public function updatedCheckIn()
    {
        $this->validateFields();
    }

    public function updatedRCheckin()
    {

        if ($this->r_check_in < $this->check_in) {
            $this->errors_r_check_in = 'Check out must be greater than check in time!';
            return;
        }
        $this->r_pick_up_time = $this->subtractTime($this->r_check_in, '0');

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
        if($this->validateDriverHour() > 0){
            $this->errors_driver = 'Pick up driver must be available between pick up time and check in time';
            return;
        }else{
            $this->errors_driver = '';
        }
    }

    public function addPickUp($address, $input, $prediction)
    {
        $this->$input = $address;
        $this->validateAddresses($input);
        $this->$prediction = [];

        if ($input == 'return_pick_up_address' || $input == 'location_driver') {
            if ($this->return_pick_up_address != null && $this->location_driver != null)
                $this->calculateTimeDriver();
        }
    }

    public function addStop($type)
    {
        $this->$type[] = ['address' => '', 'addresses' => []];
    }

    public function removeStop($index, $type)
    {
        unset($this->$type[$index]);
        $this->$type = array_values($this->$type);
    }

    public function updateStopQuery($index, $query, $type)
    {
        $this->$type[$index]['address'] = $query;

        if (strlen($query) >= 3) {
            $googlePredictions = $this->google->getPlacePredictions($query);

            if (count($this->saved_addresses) > 0) {
                $this->$type[$index]['addresses'] = array_merge($this->saved_addresses, $googlePredictions);
            } else {
                $this->$type[$index]['addresses'] = $googlePredictions;
            }
        } else {
            $this->$type[$index]['addresses'] = [];
        }
    }

    public function selectStopAddress($index, $address, $type)
    {
        $this->$type[$index]['address'] = $address;
        $this->$type[$index]['addresses'] = [];

        if($type == 'stops'){
            $this->updatedCheckIn();
        }
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
        $totalMinutesToSubtract = $duration + 30;

        list($date, $time) = explode(' ', $arrivalTime);
        list($year, $month, $day) = explode('-', $date);
        list($hour, $minute) = explode(':', $time);

        $arrivalTimestamp = mktime($hour, $minute, 0, $month, $day, $year);
        $newTimestamp = $arrivalTimestamp - ($totalMinutesToSubtract * 60);

        return date('H:i', $newTimestamp);
    }

    public function editEvent($id)
    {
        $this->emit('getModelId', $id);

        $this->title_modal = 'Edit Scheduling';
        $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
        $this->isEdit = true;
    }

    public function cancelScheduling()
    {
        $this->dispatchBrowserEvent('showConfirm', [
            'text' => "This scheduling will be canceled! Do you want to collect the cancellation?",
            'icon' => 'warning',
            'confirmButtonText' => 'Yes',
            'denyButtonText' => 'No',
            'livewire' => 'confirmCollect',
        ]);
    }

    public function revert()
    {
        $this->saveStatus(false);
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

        $events = $this->getEventsCalendar('');

        $this->emit('updateEvents', $events);
        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        $this->sessionAlert([
            'message' => ($cancel) ? 'Scheduling canceled successfully!' : 'Scheduling reverted cancel successfully!',
            'type' => 'success',
            'icon' => 'check',
        ]);
    }

    public function getEventsCalendar($driver_ids)
    {
        $scheduling = Scheduling::all();
        $events = [];
        $driverColors = $this->assignColorsToDrivers();

        foreach ($scheduling as $event) {
            $sql = "SELECT * FROM scheduling_address WHERE scheduling_id = '$event->id'";

            if($driver_ids){
                $sql .= " AND scheduling_address.driver_id IN (". implode(',', $driver_ids) . ")";
            } 

            $scheduling_address = DB::select($sql);

            $patient = Patient::find($event->patient_id);
            
            if(!$scheduling_address){
                continue;
            }

            foreach ($scheduling_address as $address) {
                $driver_id = $address->driver_id;

                $events[] = [
                    'id' => $event->id,
                    'driver_id' => $driver_id,
                    'title' => $patient->first_name . " " . $patient->last_name,
                    'start' => $address->date . " " . $address->pick_up_hour,
                    'end' => $address->date . " " . $address->drop_off_hour,
                    'color' => $driverColors[$driver_id],
                    'className' => ($address->status == 'Canceled') ? 'cancelled-event' : '',
                ];
            }
        }

        return $events;
    }

    function assignColorsToDrivers() {
        // Definir una paleta de colores atractivos para un calendario
        $driverColors = [];
        $paletteSize = count($this->colors);
    
        $drivers = DB::table('users')
        ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
        ->select('users.*')
        ->where('roles.name', '=', 'Driver')
        ->where('users.id', '!=', auth()->id())
        ->get();

        // Asignar colores cíclicamente a cada conductor
        foreach ($drivers as $index => $driverId) {
            $colorIndex = $index % $paletteSize; // Ciclar sobre la paleta
            $driverColors[$driverId->id] = $this->colors[$colorIndex];
        }
    
        return $driverColors;
    }

    public function validateFields()
    {
        if (!$this->date) {
            $this->date = Carbon::now()->format('Y-m-d');
        }
        if (!$this->check_in) {
            $this->check_in = Carbon::now()->format('H:i');
        }

        if (count($this->stops) == 0 || $this->pick_up_address == null) {
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
        if (count($this->r_stops) == 0 || $this->return_pick_up_address == null || $this->r_check_in == null || $this->date == null) {
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

    public function validateDriverHour(){
        $date = Carbon::createFromFormat('m-d-Y', '10-14-2024')->toDateString();
        $sql = "SELECT id FROM scheduling_address 
            WHERE driver_id = '$this->pick_up_driver_id' 
                AND date = '$date' 
                AND pick_up_hour >= '$this->pick_up_time'
                AND pick_up_hour <= '$this->check_in'
                AND status = 'Waiting'";
        $validation = DB::select($sql);

        return count($validation);
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
        $events = $this->getEventsCalendar('');

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
