<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Scheduling;
use App\Models\Patient;
use App\Models\SchedulingAddress;
use App\Models\SchedulingCharge;
use App\Models\SchedulingAutoagend;
use App\Models\ApisGoogle;
use App\Models\ApiHoliday;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use App\Services\AuditLogService;

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
    public $wheelchair, $ambulatory, $cane, $walker, $bchair, $saturdays, $companion, $fast_track, $sundays_holidays, $out_of_hours, $aditional_waiting, $if_not_cancel, $flat_rate, $pick_up_cancel, $drop_off_cancel = false;

    public $type_of_trip = 'one_way';

    public $item, $action, $search, $title_modal, $countSchedulings, $modelId, $modelIdCharge = '';
    public $modelIdAddress = [];
    public $isEdit = false;

    public $saved_addresses = [];
    public $prediction_pick_up_address = [];
    public $prediction_drop_off = [];

    public $prediction_location_driver = [];
    public $prediction_return_pick_up_address = [];

    public $showReturnFields = false;

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

    protected $messages = [
        'stops.*.address.required' => 'This address is required.',
        'r_stops.*.address.required' => 'This return address is required.',
        'r_check_in.required' => 'This check out is required.',
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
        'showConfirmDelete',
        'deleteMultiple',
        'openCreateModal',
        'closePredictions',
        'showConfirmCollet'
    ];

    public function rules()
    {
        $rules = [
            'patient_id' => 'required',
            'date' => 'required',
            'check_in' => 'required',
            'pick_up_driver_id' => 'required',
            'pick_up_address' => 'required',
            'stops.*.address' => 'required',
        ];

        if($this->showReturnFields) {
            $rules['return_pick_up_address'] = 'required';
            $rules['r_stops.*.address'] = 'required';
            $rules['drop_off_driver_id'] = 'required';
            $rules['r_check_in'] = 'required';
        }

        return $rules;
    }

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
                    $this->dispatchBrowserEvent('showConfirm', [
                        'text' => 'You have unsaved changes! Do you want to continue?',
                        'icon' => 'info',
                        'confirmButtonText' => 'Yes',
                        'denyButtonText' => 'No',
                        'livewire' => 'continueScheduling',
                        'id' => false,
                    ]);
                } else {
                    $this->title_modal = 'Create Scheduling';
                    $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
                    $this->emit('clearForm');
                }
                break;
        }
    }

    public function continueScheduling($comfirm)
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
        $this->ends_date = ($model_scheduling->end_date) ? Carbon::createFromFormat('Y-m-d', $model_scheduling->end_date)->format('m-d-Y') : '';
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
                $this->pick_up_cancel = $address->cancel_drive;
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
                $this->drop_off_cancel = $address->cancel_drive;
                $count_r++;
            }
        }

        $model_scheduling_charge = SchedulingCharge::where('scheduling_id', $model_scheduling->id)->first();
        $this->modelIdCharge = $model_scheduling_charge->id;
        $this->type_of_trip = $model_scheduling_charge->type_of_trip;

        if($model_scheduling_charge->type_of_trip == 'round_trip'){
            $this->showReturnFields = true;
        }
        
        $this->wheelchair = $model_scheduling_charge->wheelchair;
        $this->ambulatory = $model_scheduling_charge->ambulatory;
        $this->out_of_hours = $model_scheduling_charge->out_of_hours;
        $this->saturdays = $model_scheduling_charge->saturdays;
        $this->sundays_holidays = $model_scheduling_charge->sundays_holidays;
        $this->companion = $model_scheduling_charge->companion;
        $this->aditional_waiting = $model_scheduling_charge->aditional_waiting;
        $this->fast_track = $model_scheduling_charge->fast_track;
        $this->flat_rate = $model_scheduling_charge->flat_rate;
    }

    private function clearForm()
    {
        $this->reset(['modelId', 'modelIdCharge', 'patient_id', 'weekdays', 'ends_schedule', 'ends_date', 'pick_up_driver_id', 'pick_up_time',  'return_pick_up_address', 'drop_off_address', 'date', 'check_in', 'drop_off_hour', 'type_of_trip', 'wheelchair', 'ambulatory', 'out_of_hours', 'saturdays', 'sundays_holidays', 'companion', 'aditional_waiting', 'fast_track', 'if_not_cancel', 'auto_agend', 'pick_up_address', 'r_check_in', 'r_pick_up_time', 'drop_off_driver_id', 'patient_name', 'errors_driver']);

        $this->isEdit = false;
        $this->showReturnFields = false;    

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

    public function formatDate($date)
    {
        $formats = ['Y-m-d', 'm-d-Y', 'd-m-Y', 'Y/m/d', 'm/d/Y', 'd/m/Y']; // Lista de formatos comunes
        foreach ($formats as $format) {
            try {
                $convertedDate = Carbon::createFromFormat($format, $date)->format('Y-m-d');
                break;
            } catch (Exception $e) {
                continue;
            }
        }
        return $convertedDate;
    }

    public function save()
    {
        $this->resetValidation();

        $this->validate();

        if ($this->modelId) {
            $this->isEdit = true;
        }

        $convertedDate = $this->formatDate($this->date);

        if (!$convertedDate) {
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
        $this->dispatchBrowserEvent('updateEvents');

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

        if($this->ends_date == ''){
            $this->ends_date = date('Y-m-d');
        }else{
            $this->ends_date = $this->formatDate($this->ends_date);
        }
        
        $scheduling->patient_id = $this->patient_id;
        $scheduling->auto_agend = $this->auto_agend;
        $scheduling->select_date = implode(',', $this->weekdays);
        $scheduling->ends_schedule = $this->ends_schedule;
        $scheduling->end_date = $this->formatDate($this->ends_date);
        $scheduling->save();

        if($this->isEdit){
            AuditLogService::log('update', 'scheduling', $scheduling->id);
        }else{
            AuditLogService::log('create', 'scheduling', $scheduling->id);
        }

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
        $scheduling_charge->flat_rate = $this->flat_rate;
        $scheduling_charge->cane = $this->cane;
        $scheduling_charge->walker = $this->walker;
        $scheduling_charge->bchair = $this->bchair;
        $scheduling_charge->save();

        $d_saved_addresses =  SchedulingAddress::where('scheduling_id', $scheduling->id)->get();
        if (count($d_saved_addresses) > 0) {
            foreach ($d_saved_addresses as $address) {
                $address->delete();
            }
        }

        if ($this->pick_up_address) {
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

        if ($this->return_pick_up_address) {
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
                    $this->deleteScheduling(true, $address->scheduling_id, false);
                }

                $this->modelId = '';
                $this->modelIdCharge = '';
            }
        }

        $start = Carbon::parse($this->date);
        if ($this->ends_schedule == 'ends_check') {
            $end = $this->formatDate($this->ends_date);
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

                if($this->isEdit){
                    AuditLogService::log('update', 'scheduling', $scheduling->id);
                }else{
                    AuditLogService::log('create', 'scheduling', $scheduling->id);
                }

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
                $scheduling_charge->flat_rate = $this->flat_rate;
                $scheduling_charge->save();

                $d_saved_addresses =  SchedulingAddress::where('scheduling_id', $scheduling->id)->get();
                foreach ($d_saved_addresses as $address) {
                    $address->delete();
                }

                if ($this->pick_up_address) {
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
                }

                if ($this->return_pick_up_address) {
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
        if ($this->auto_agend) {
            $this->dispatchBrowserEvent(
                'showMultipleOptionsConfirm',
                [
                    'html' => '<div style="text-align: left;">
                            <label><input type="radio" name="event-option" value="This-event" selected> This event</label><br>
                            <label><input type="radio" name="event-option" value="Same-date"> This and following events</label><br>
                            <label><input type="radio" name="event-option" value="All-events"> All events</label>
                        </div>',
                    'title' => 'Select an option',
                    'confirmButtonText' => 'Confirm',
                    'denyButtonText' => 'Cancel',
                    'livewire' => 'deleteMultiple',
                    'id' => $this->modelId
                ]
            );
        } else {
            $this->dispatchBrowserEvent('showConfirm', [
                'text' => "Do you want to delete this scheduling? This action cannot be undone!",
                'icon' => 'warning',
                'confirmButtonText' => 'Yes',
                'denyButtonText' => 'No',
                'livewire' => 'deleteScheduling',
                'id' => $this->modelId
            ]);
        }
    }

    public function deleteMultiple($option)
    {
        $format_date = Carbon::createFromFormat('m-d-Y', $this->date)->toDateString();

        if ($option == 'This-event') {
            $this->deleteScheduling(true, $this->modelId, true);
        } else if ($option == 'Same-date') {
            // Obtener el día de la semana del agendamiento actual
            $day_of_week = Carbon::parse($format_date)->format('l');

            // Obtener todos los IDs de agendamientos que ocurren el mismo día de la semana
            $schedulings = Scheduling::select('schedulings.id')
                ->leftJoin('scheduling_address', 'schedulings.id', '=', 'scheduling_address.scheduling_id')
                ->where('scheduling_autoagend_id', $this->schedule_autoagend_id)
                ->where('date', '>=', $format_date)
                ->whereRaw("DAYNAME(date) = ?", [$day_of_week])
                ->get();
            foreach ($schedulings as $scheduling) {
                $this->deleteScheduling(true, $scheduling->id, true);
            }
        } else if ($option == 'All-events') {
            $schedulings = Scheduling::select('schedulings.id')
                ->leftJoin('scheduling_address', 'schedulings.id', '=', 'scheduling_address.scheduling_id')->where('scheduling_autoagend_id', $this->schedule_autoagend_id)
                ->where('date', '>=', $format_date)
                ->get();
            foreach ($schedulings as $scheduling) {
                $this->deleteScheduling(true, $scheduling->id, true);
            }
        }

        $this->dispatchBrowserEvent('updateEvents');
    }

    public function deleteScheduling($comfirm, $scheduling_id, $show_message = false)
    {
        if (!$comfirm) {
            $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);
            return;
        }

        $model_scheduling = Scheduling::find($scheduling_id);

        if (!$model_scheduling) {
            return;
        }

        $model_scheduling->deleted = true;
        $model_scheduling->save();

        AuditLogService::log('delete', 'scheduling', $model_scheduling->id);

        if ($show_message) {
            $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

            $this->dispatchBrowserEvent('updateEvents');

            $this->sessionAlert([
                'message' => 'Scheduling deleted successfully!',
                'type' => 'success',
                'icon' => 'check',
            ]);
        }
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
        $minutosASumar = $duration + 0;

        return Carbon::createFromFormat('H:i', $hora)->subMinutes($minutosASumar)->format('H:i');
    }

    public function forcedCloseModal()
    {
        sleep(2);
        $this->clearForm();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function getAddresses($input)
    {
        $this->$input = $this->saved_addresses;
        if ($this->saved_addresses) {
            if (!$this->$input) {
                $this->$input = $this->saved_addresses;
            }
        }
    }

    public function closePredictions()
    {
        $this->search_patients = [];
        $this->prediction_pick_up_address = [];
        $this->prediction_drop_off = [];
        $this->prediction_location_driver = [];
        $this->prediction_return_pick_up_address = [];

        foreach ($this->stops as $index => $stop) {
            $this->stops[$index]['addresses'] = [];
        }

        foreach ($this->r_stops as $index => $stop) {
            $this->r_stops[$index]['addresses'] = [];
        }
    }

    public function toggleAutoAgend()
    {
        $this->auto_agend = !$this->auto_agend;
    }

    public function toggleReturnFields()
    {
        $this->showReturnFields = !$this->showReturnFields;
    }

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

        if ($patient->billing_code == 'A0120-Ambulatory') {
            $this->ambulatory = true;
            $this->wheelchair= false;
            $this->cane = false;
            $this->walker = false;
            $this->bchair = false;
        }

        if ($patient->billing_code == 'A0120-Cane') {
            $this->cane = true;
            $this->ambulatory = false;
            $this->wheelchair= false;
            $this->walker = false;
            $this->bchair = false;

        }

        if ($patient->billing_code == 'A0130-Wheelchair') {
            $this->wheelchair = true;
            $this->ambulatory = false;
            $this->cane = false;
            $this->walker = false;
            $this->bchair = false;
        }

        if ($patient->billing_code == 'A0130-Walker') {
            $this->walker = true;
            $this->wheelchair = false;
            $this->cane = false;
            $this->ambulatory = false;
            $this->bchair = false;
        }

        if ($patient->billing_code == 'A0140-BrodaChair') {
            $this->bchair = true;
            $this->wheelchair = false;
            $this->cane = false;
            $this->walker = false;
            $this->ambulatory = false;
        }

        $this->patient_name = $patient->first_name . ' ' . $patient->last_name;

        $sql = "SELECT * FROM addresses WHERE patient_id = '$patientId'";
        $patient_addresses = DB::select($sql);

        foreach ($patient_addresses as $address) {
            $this->saved_addresses[] = $address->address . ', ' . $address->description;
        }

        $this->search_patients = [];
    }

    public function checkPatientName($query)
    {
        if (strlen($query) >= 3) {

            $keywords = explode(' ', $query);

            $search = Patient::where(function ($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->where(function ($subQuery) use ($keyword) {
                        $subQuery->where('first_name', 'LIKE', "%$keyword%")
                            ->orWhere('last_name', 'LIKE', "%$keyword%")
                            ->orWhere('medicalid', 'LIKE', "%$keyword%");
                    });
                }
            })->get();

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

    public function updatedDate()
    {
        $this->validateFields();
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

        $this->dispatchBrowserEvent('updateEvents');

        $this->sessionAlert([
            'message' => 'Event updated successfully!',
            'type' => 'success',
            'icon' => 'edit',
        ]);
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

        if ($type == 'stops') {
            $this->validateFields();
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

    public function sessionAlert($data)
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
        if (count($addresses) < 2) {
            return;
        }

        for ($i = 0; $i < count($addresses) - 1; $i++) {
            $origin = $this->google->getCoordinates($addresses[$i]);

            if (isset($origin['error'])) {
                $this->dispatchBrowserEvent('showAlert', [
                    'text' => $origin['error'],
                    'icon' => 'error'
                ]);
                return;
            }

            $destination = $this->google->getCoordinates($addresses[$i + 1]);
            if (isset($destination['error'])) {
                $this->dispatchBrowserEvent('showAlert', [
                    'text' => $destination['error'],
                    'icon' => 'error'
                ]);
                return;
            }

            $convertedDate = Carbon::createFromFormat('m-d-Y H:i', $arrivalTime)->format('Y-m-d H:i');
            $data = $this->google->getDistance($origin, $destination, strtotime($convertedDate));

            if (isset($data['error'])) {
                $this->dispatchBrowserEvent('showAlert', [
                    'text' => $data['error'],
                    'icon' => 'error'
                ]);

                $distance = 0;
                $duration = 0;
            } else {
                $distance = $data['distance'];
                $duration = $data['duration'];
            }

            if ($type == 'return') {
                $this->r_stops[$i]['distance'] = $distance;
                if ($duration) {
                    if ($showDistance) {
                        $this->r_start_drive = $duration . "min";
                    }
                    $this->r_stops[$i]['duration'] = $duration;
                }
            } else {
                $this->stops[$i]['distance'] = $distance;
                if ($duration) {
                    if ($i == 0) {
                        $this->pick_up_time = $this->getTime($duration, $arrivalTime);
                    }
                    $this->stops[$i]['duration'] = $duration;
                }
            }
        }
    }

    public function getTime($duration, $arrivalTime)
    {   
        $totalMinutesToSubtract = $duration + 30;

        $arrivalTime = Carbon::createFromFormat('m-d-Y H:i', $arrivalTime);
        $newTime = $arrivalTime->subMinutes($totalMinutesToSubtract);

        return $newTime->format('H:i');
    }

    public function openCreateModal($date)
    {
        $dateTime = Carbon::parse($date);

        // Obtener la fecha en formato "m-d-Y"
        $this->date = $dateTime->format('m-d-Y');

        // Obtener solo la hora en formato "H:i"
        $this->check_in = $dateTime->format('H:i');

        $this->title_modal = 'Create Scheduling';
        $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
    }

    public function editEvent($id)
    {
        $this->emit('getModelId', $id);

        $this->title_modal = 'Edit Scheduling';
        $this->dispatchBrowserEvent('openModal', ['name' => 'createScheduling']);
        $this->isEdit = true;
    }

    public function revert()
    {
        $sql = "SELECT * FROM scheduling_address WHERE scheduling_id = '{$this->modelId}' AND cancel_drive = 1";

        $scheduling_address = DB::select($sql);

        foreach ($scheduling_address as $address) {
            $address = SchedulingAddress::find($address->id);
            $address->status = 'Waiting';
            $address->cancel_drive = 0;
            $address->save();
        }

        $this->dispatchBrowserEvent('updateEvents');
        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        $this->confirmCollect(false);
    }

    public function cancelScheduling()
    {
        $this->dispatchBrowserEvent(
            'showMultipleOptionsConfirm',
            [
                'html' => '<div style="text-align: left;">
                    <label><input type="radio" name="event-option" value="pick-up" selected> Cancel Pick Up</label><br>
                    <label><input type="radio" name="event-option" value="drop-off"> Cancel Drop Off</label><br>
                    <label><input type="radio" name="event-option" value="both"> Cancel Both</label>
                </div>',
                'title' => 'Select an option',
                'confirmButtonText' => 'Confirm',
                'denyButtonText' => 'Cancel',
                'livewire' => 'showConfirmCollet',
                'id' => $this->modelId
            ]
        );
    }

    public function showConfirmCollet($option)
    {
        $sql = "SELECT * FROM scheduling_address WHERE scheduling_id = '{$this->modelId}'";
        if ($option == 'pick-up') {
            $sql .= " AND type_of_trip = 'pick_up'";
        } elseif ($option == 'drop-off') {
            $sql .= " AND type_of_trip = 'return'";
        }

        $scheduling_address = DB::select($sql);

        if (count($scheduling_address) > 0) {
            foreach ($scheduling_address as $address) {
                $model_scheduling = SchedulingAddress::find($address->id);
                $model_scheduling->status = 'Canceled';
                $model_scheduling->cancel_drive = 1;
                $model_scheduling->save();
            }
        }

        $this->dispatchBrowserEvent('showConfirm', [
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

        if ($cancel) {
            AuditLogService::log('cancel', 'scheduling', $scheduling_charge->id);
        }else{
            AuditLogService::log('revert cancel', 'scheduling', $scheduling_charge->id);
        }

        $this->dispatchBrowserEvent('updateEvents');
        $this->dispatchBrowserEvent('closeModal', ['name' => 'createScheduling']);

        $this->sessionAlert([
            'message' => ($cancel) ? 'Scheduling canceled successfully!' : 'Scheduling reverted cancel successfully!',
            'type' => 'success',
            'icon' => 'check',
        ]);
    }

    public function getEventsCalendar(Request $request)
    {
        // Obtener el rango de fechas y driver_ids de la solicitud
        $startDate = $request->query('start');
        $endDate = $request->query('end');
        $driverIds = $request->query('driver_ids') ? explode(',', $request->query('driver_ids')) : null;
        $contractId = $request->query('contract_id'); // Nuevo parámetro

        // Cargar sólo los agendamientos dentro del rango de fechas
        $schedulings = Scheduling::with([
            'schedulingAddresses' => function ($query) use ($driverIds, $startDate, $endDate) {
                if ($driverIds) {
                    $query->whereIn('driver_id', $driverIds);
                }
                $query->whereBetween('date', [$startDate, $endDate])
                    ->select('id', 'scheduling_id', 'driver_id', 'date', 'pick_up_hour', 'drop_off_hour', 'status', 'type_of_trip');
            },
            'patient' => function ($query) {
                $query->selectRaw("id, 
                CONCAT(
                    CASE 
                        WHEN billing_code = 'A0120-Ambulatory' THEN '(A)'
                        WHEN billing_code = 'A0120-Cane' THEN '(C)'
                        WHEN billing_code = 'A0130-Wheelchair' THEN '(WC)'
                        WHEN billing_code = 'A0130-Walker' THEN '(W)'
                        WHEN billing_code = 'A0140-BrodaChair' THEN '(BC)'
                        ELSE '(W)'
                    END, 
                    ' ', first_name, ' ', last_name
                ) as full_name, billing_code, service_contract_id");
            },
            'schedulingAddresses.driver:id,driver_color'
        ])
            ->whereHas('schedulingAddresses', function ($query) use ($startDate, $endDate, $driverIds) {
                $query->whereBetween('date', [$startDate, $endDate]);
                if ($driverIds) {
                    $query->whereIn('driver_id', $driverIds);
                }
            })
            ->when($contractId, function ($query) use ($contractId) {
                $query->whereHas('patient', function ($query) use ($contractId) {
                    $query->where('service_contract_id', $contractId);
                });
            })
            ->where('deleted', 0)
            ->get()
            ->map(function ($scheduling) {
                $scheduling->schedulingAddresses->each(function ($address) use ($scheduling) {
                    $address->full_name = ($address->type_of_trip === 'pick_up' ? '(G)' : '(R)') . ' ' . $scheduling->patient->full_name;
                });
                return $scheduling;
            });

        $events = [];

        foreach ($schedulings as $event) {
            $patient = $event->patient;
            foreach ($event->schedulingAddresses as $address) {
                $driver = $address->driver;
                $tripPrefix = ($address->type_of_trip === 'pick_up') ? '(P)' : '(R)';

                $events[] = [
                    'id' => $event->id,
                    'driver_id' => $address->driver_id,
                    'title' => "{$tripPrefix} - {$patient->full_name}", // Incluye el prefijo en el título
                    'start' => $address->date . " " . $address->pick_up_hour,
                    'end' => $address->date . " " . $address->drop_off_hour,
                    'color' => ($driver->driver_color) ? $driver->driver_color : '#a5c3f5',
                    'className' => ($address->status == 'Canceled') ? 'cancelled-event' : '',
                ];
            }
        }

        return response()->json($events);
    }

    public function validateFields()
    {
        $hasValidAddress = collect($this->stops)->some(function ($location) {
            return !empty($location['address']) || !empty($location['addresses']);
        });

        if ($this->date == null || $this->check_in == null || empty($this->pick_up_address) || !$hasValidAddress) {
            return;
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
        $hasValidAddress = collect($this->r_stops)->some(function ($location) {
            return !empty($location['address']) || !empty($location['addresses']);
        });

        if ($this->date == null || $this->r_check_in == null || empty($this->return_pick_up_address) || !$hasValidAddress) {
            return;
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
        $driver = DB::table('users')
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->select('users.*')
            ->where('roles.name', '=', 'Driver')
            ->where('users.id', '!=', auth()->id())
            ->where('users.deleted', 0)
            ->orderBy('users.name', 'asc')
            ->get();

        $service_contracts = DB::table('service_contracts')
            ->select('service_contracts.id', 'service_contracts.company')
            ->where('service_contracts.deleted', 0)
            ->orderBy('service_contracts.company', 'asc')
            ->get();

        return view('livewire.scheduling.index', [
            'drivers' => $driver,
            'service_contracts' => $service_contracts
        ]);
    }
}
