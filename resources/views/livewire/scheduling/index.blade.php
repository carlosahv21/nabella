<div>
    <div class="table-settings mx-4 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-12 col-lg-8 row mt-3">
                @for($i = 0; $i < count($drivers); $i++) <div class="form-check form-check-inline col-6 col-lg-3" style="margin-right: 0;">
                    <input class="form-check-input drivers" type="checkbox" id="driver{{ $drivers[$i]->id }}" value="{{ $drivers[$i]->id }}">
                    <label class="form-check-label" for="driver{{ $drivers[$i]->id }}" style="background-color: {{ $colors[$i] }}; min-width: 114px; text-align: center;">
                        <b class="text-white"> {{ $drivers[$i]->name }} </b>
                    </label>
            </div>
            @endfor
        </div>
        <div class="col-12 col-lg-4 d-flex justify-content-end mt-3">
            <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                <i class="material-icons notranslate">add</i> Add scheduling
            </button>
        </div>
    </div>
</div>
<!-- notifications -->
<div class="position-fixed top-2 end-2 z-index-2">
    <div class="toast fade hide p-2 bg-white bg-gradient-{{ session('alert.type', 'info') }}" role="alert" aria-live="assertive" id="toast" data-bs-delay="2000">
        <div class="toast-header bg-transparent text-white border-0">
            <i class="material-icons notranslate me-2">
                {{ session('alert.icon') }}
            </i>
            <span class="me-auto font-weight-bold">Notification!</span>
            <i class="material-icons notranslate cursor-pointer" data-bs-dismiss="toast" aria-label="Close">close</i>
        </div>
        <hr class="horizontal light m-0">
        <div class="toast-body text-white ">
            {{ session('alert.message') }}
        </div>
    </div>
</div>
<!-- end notifications -->
<div class="card card-calendar mx-2">
    <div class="card-body p-3">
        <div wire:ignore class="calendar" data-bs-toggle="calendar" id="calendar" style="max-height: 735px;"></div>
    </div>
</div>
<!-- Modal Add-->
<div wire:ignore.self class="modal fade" id="createScheduling" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title_modal}}</h5>
                <div class="d-flex justify-content-between pt-2">
                    <div class="d-flex justify-content-end">
                        @if(!$if_not_cancel)
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        <button wire:click="save" type="button" class="btn btn-primary">Save changes</button>
                        @elseif($isEdit)
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        @if($if_not_cancel)
                        <button wire:click="revert" type="button" class="btn btn-primary">Revert cancel</button>
                        @endif
                        @else
                        <button wire:click="revert" type="button" class="btn btn-primary">Revert cancel</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="card card-plain h-100">
                    <div class="card-body p-0">
                        <form>
                            <div class="row">
                                <!-- PATIENT -->
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Patient</label>
                                    <input class="form-control border border-2 p-2" type="text" wire:model="patient_name" wire:input="checkPatientName($event.target.value)" placeholder="Patient" @if($if_not_cancel) disabled @endif>
                                    @if (!empty($search_patients))
                                    <ul class="list-group predictions shadow-sm">
                                        @foreach ($search_patients as $patient)
                                        <li class="list-group-item cursor-pointer" wire:click="selectPatient({{ $patient['id'] }})">{{ $patient['name'] }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                    @if ($errors->has('patient_id'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('patient_id') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Start Date</label>
                                    <input wire:model="date" class="form-control border border-1 p-2 date-input active" placeholder="MM-DD-YYYY" @if($if_not_cancel) disabled @endif>
                                    @if ($errors->has('date'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('date') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="form-check mb-3 col-md-4 ">
                                    <input wire.ignore.self wire:model="auto_agend" class="form-check-input" type="checkbox" id="auto_agend" @if($if_not_cancel) disabled @endif>
                                    <label class="custom-control-label" for="auto_agend">Auto Agend</label>
                                    <br>
                                    <input class="form-check-input" type="radio" value="one_way" wire.ignore_self="" wire:model="type_of_trip">
                                    <label class="custom-control-label text-10" for="one_way">OW</label>
                                    <br>
                                    <input class="form-check-input" type="radio" value="round_trip" wire.ignore_self="" wire:model="type_of_trip">
                                    <label class="custom-control-label text-10" for="round_trip">RT</label>
                                </div>
                                @if($auto_agend)
                                <hr class="dark horizontal">
                                <label class="form-label">Select Days</label>
                                <div class="row">
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customMon day" value="Monday" wire:model="weekdays">
                                        <label class="form-check-label" for="customMonday">Monday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customTuesday" value="Tuesday" wire:model="weekdays">
                                        <label class="form-check-label" for="customTuesday">Tuesday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customWednesday" value="Wednesday" wire:model="weekdays">
                                        <label class="form-check-label" for="customWednesday">Wednesday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customThursday" value="Thursday" wire:model="weekdays">
                                        <label class="form-check-label" for="customThursday">Thursday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customFriday" value="Friday" wire:model="weekdays">
                                        <label class="form-check-label" for="customFriday">Friday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customSaturday" value="Saturday" wire:model="weekdays">
                                        <label class="form-check-label" for="customSaturday">Saturday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customSunday" value="Sunday" wire:model="weekdays">
                                        <label class="form-check-label" for="customSunday">Sunday</label>
                                    </div>
                                </div>
                                <hr class="dark horizontal">
                                <label class="form-label">Ends</label>
                                <div class="row">
                                    <div class="form-check col-md-3">
                                        <input class="form-check-input" type="radio" name="ends_date" id="customRadio1" value="never" wire:model="ends_schedule">
                                        <label class="custom-control-label" for="customRadio1">Never</label>
                                    </div>
                                    <div class="form-check col-md-3">
                                        <input class="form-check-input" type="radio" name="ends_date" id="customRadio2" value="ends_check" wire:model="ends_schedule">
                                        <label class="custom-control-label" for="customRadio2">End Date</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-6">
                                        <div class="input-group input-group-static">
                                            <label>Date</label>
                                            <input type="date" class="form-control" id="date_end" wire:model="ends_date" {{ $ends_schedule !== 'ends_check' ? 'disabled' : '' }}>
                                        </div>
                                    </div>
                                </div>
                                <!-- GOING -->
                                <hr class="dark horizontal">
                                @endif
                                <h6 class="text-center">GOING</h6>
                                <div class="mb-3 col-md-12">
                                    <input class="form-control border border-2 p-2" type="text" wire:model="pick_up_address" wire:click="getAddresses('prediction_pick_up_address')" placeholder="Pick up address" @if($if_not_cancel) disabled @endif>
                                    @if (!empty($prediction_pick_up_address))
                                    <ul class="list-group predictions shadow-sm">
                                        @foreach ($prediction_pick_up_address as $address_pick_up)
                                        <li class="list-group-item cursor-pointer" wire:click="addPickUp('{{ $address_pick_up }}', 'pick_up_address', 'prediction_pick_up_address')">{{ $address_pick_up }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                @foreach ($stops as $index => $stop)
                                <div class="mb-3 row">
                                    <div class="col-md-10">
                                        <input class="form-control border border-2 p-2" type="text" wire:model="stops.{{ $index }}.address" placeholder="Drop off Address Stop {{ $index + 1 }}" wire:input="updateStopQuery({{ $index }}, $event.target.value, 'stops')" @if($if_not_cancel) disabled @endif>
                                        @if (!empty($stops[$index]['addresses']))
                                        <ul class="list-group predictions shadow-sm">
                                            @foreach ($stops[$index]['addresses'] as $address)
                                            <li class="list-group-item cursor-pointer" wire:click="selectStopAddress({{ $index }}, '{{ $address }}', 'stops')">{{ $address }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-md-2 d-flex">
                                        @if ($index == count($stops) - 1)
                                        <button type="button" wire:click="addStop('stops')" class="btn btn-link text-dark text-gradient px-3 mb-0" @if($if_not_cancel) disabled @endif>
                                            <i class="material-icons notranslate">add</i>
                                        </button>
                                        @endif
                                        @if ($index > 0)
                                        <button type="button" class="btn btn-link text-dark text-gradient px-3 mb-0" wire:click="removeStop({{ $index }}, 'stops')" @if($if_not_cancel) disabled @endif>
                                            <i class="material-icons notranslate">delete</i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Check In</label>
                                        <input type="time" wire.ignore.self wire:model="check_in" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="check_in" @if($if_not_cancel) disabled @endif>
                                        @if ($errors->has('check_in'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('check_in') }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3 col-md-4">
                                    <div class="input-group input-group-static my-1">
                                        <label>Estimated Pickup Time</label>
                                        <input type="time" wire.ignore.self wire:model="pick_up_time" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="pick_up_time" @if($if_not_cancel) disabled @endif>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Pick up driver</label>
                                    <select wire.ignore.self wire:model="pick_up_driver_id" class="form-select" id="pick_up_driver_id" @if($if_not_cancel) disabled @endif>
                                        <option value="">Select a Driver</option>
                                        @foreach($drivers as $drive)
                                        <option value="{{ $drive->id }}">{{ $drive->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors_driver)
                                    <div class="text-danger inputerror">
                                        {{ $errors_driver }}
                                    </div>
                                    @endif
                                    @if ($errors->has('pick_up_driver_id'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('pick_up_driver_id') }}
                                    </div>
                                    @endif
                                </div>

                                <!-- RETURN -->
                                @if($type_of_trip == 'round_trip')
                                <h6 class="text-center">RETURN</h6>
                                <div class="mb-3 col-md-12">
                                    <input class="form-control border border-2 p-2" type="text" wire:model="location_driver" wire:click="getAddresses('prediction_location_driver')" placeholder="Driver´s Location" @if($if_not_cancel) disabled @endif>
                                    @if (!empty($prediction_location_driver))
                                    <ul class="list-group predictions shadow-sm">
                                        @foreach ($prediction_location_driver as $address_location_driver)
                                        <li class="list-group-item cursor-pointer" wire:click="addPickUp('{{ $address_location_driver }}', 'location_driver', 'prediction_location_driver')">{{ $address_location_driver }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-10">
                                        <input class="form-control border border-2 p-2" type="text" wire:model="return_pick_up_address" wire:click="getAddresses('prediction_return_pick_up_address')" placeholder="Pick up address" @if($if_not_cancel) disabled @endif>
                                        @if (!empty($prediction_return_pick_up_address))
                                        <ul class="list-group predictions shadow-sm">
                                            @foreach ($prediction_return_pick_up_address as $address_pick_up)
                                            <li class="list-group-item cursor-pointer" wire:click="addPickUp('{{ $address_pick_up }}', 'return_pick_up_address', 'prediction_return_pick_up_address')">{{ $address_pick_up }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-md-2">
                                        <div class="input-group input-group-static my-1">
                                            <input type="text" wire.ignore.self wire:model="r_start_drive" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="r_start_drive" disabled placeholder="Time">
                                        </div>
                                    </div>
                                </div>
                                @foreach ($r_stops as $r_index => $r_stop)
                                <div class="mb-3 row">
                                    <div class="col-md-10">
                                        <input class="form-control border border-2 p-2" type="text" wire:model="r_stops.{{ $r_index }}.address" placeholder="Drop off Address Stop {{ $r_index + 1 }}" wire:input="updateStopQuery({{ $r_index }}, $event.target.value, 'r_stops')" @if($if_not_cancel) disabled @endif>
                                        @if (!empty($r_stops[$r_index]['addresses']))
                                        <ul class="list-group predictions shadow-sm">
                                            @foreach ($r_stops[$r_index]['addresses'] as $address)
                                            <li class="list-group-item cursor-pointer" wire:click="selectStopAddress({{ $r_index }}, '{{ $address }}', 'r_stops')">{{ $address }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-md-2 d-flex">
                                        @if ($r_index == count($r_stops) - 1)
                                        <button type="button" wire:click="addStop('r_stops')" class="btn btn-link text-dark text-gradient px-3 mb-0" @if($if_not_cancel) disabled @endif>
                                            <i class="material-icons notranslate">add</i>
                                        </button>
                                        @endif
                                        @if ($r_index > 0)
                                        <button type="button" class="btn btn-link text-dark text-gradient px-3 mb-0" wire:click="removeStop({{ $r_index }}, 'r_stops')">
                                            <i class="material-icons notranslate">delete</i>
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Check Out</label>
                                        <input type="time" wire.ignore.self wire:model="r_check_in" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="r_check_in" @if($if_not_cancel) disabled @endif>
                                    </div>
                                    @if ($errors_r_check_in)
                                    <div class="text-danger inputerror">
                                        {{ $errors_r_check_in }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-4">
                                    <div class="input-group input-group-static my-1">
                                        <label>Estimated Pickup Time</label>
                                        <input type="time" wire.ignore.self wire:model="r_pick_up_time" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="r_pick_up_time" @if($if_not_cancel) disabled @endif>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Drop off driver</label>
                                    <select wire.ignore.self wire:model="drop_off_driver_id" class="form-select" id="drop_off_driver_id" @if($if_not_cancel) disabled @endif>
                                        <option value="">Select a Driver</option>
                                        @foreach($drivers as $drive)
                                        <option value="{{ $drive->id }}">{{ $drive->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('drop_off_driver_id'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('drop_off_driver_id') }}
                                    </div>
                                    @endif
                                </div>
                                @endif
                                <!-- CHARGES -->
                                <h6 class="text-center">CHARGES</h6>
                                <div class="row col-md-12 mx-3 px-2">
                                    <div class="form-check mb-3 col-md-3 p-1">
                                        <input wire.ignore.self="" wire:model="wheelchair" class="form-check-input" type="checkbox" id="customWheelchair">
                                        <label class="custom-control-label text-10" for="customWheelchair">Wheelchair</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3 p-1">
                                        <input wire.ignore.self="" wire:model="ambulatory" class="form-check-input" type="checkbox" id="customAmbulatory">
                                        <label class="custom-control-label text-10" for="customAmbulatory">Ambulatory</label>
                                    </div>
                                    <div class="form-check mb-4 col-md-3 p-1">
                                        <input wire.ignore.self="" wire:model="saturdays" class="form-check-input" type="checkbox" id="customSaturdays">
                                        <label class="custom-control-label text-10" for="customSaturdays">Saturdays</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3 p-1">
                                        <input wire.ignore.self="" wire:model="companion" class="form-check-input" type="checkbox" id="customCompanion">
                                        <label class="custom-control-label text-10" for="customCompanion">Accompanist</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3 p-1">
                                        <input wire.ignore.self="" wire:model="fast_track" class="form-check-input" type="checkbox" id="customFastTrack">
                                        <label class="custom-control-label text-10" for="customFastTrack">Quick Pass</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3 p-1">
                                        <input wire.ignore.self="" wire:model="sundays_holidays" class="form-check-input" type="checkbox" id="customSundaysHolidays">
                                        <label class="custom-control-label text-10" for="customSundaysHolidays">Sund / Holid</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3 p-1">
                                        <input wire.ignore.self="" wire:model="out_of_hours" class="form-check-input" type="checkbox" id="customOutOfHours">
                                        <label class="custom-control-label text-10" for="customOutOfHours">After hours</label>
                                    </div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Request by</label>
                                    <input class="form-control border border-2 p-2" type="text" wire:model="request_by" placeholder="Jhon Doe" @if($if_not_cancel) disabled @endif>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <!-- Botón en el inicio/izquierda -->
                    @if($isEdit && !$if_not_cancel)
                    <button type="button" class="btn" wire:click="cancelScheduling">Cancel Scheduling</button>
                    @else
                    <p>&nbsp;</p>
                    @endif

                    <div class="d-flex justify-content-end">
                        @if($isEdit)
                        <button type="button" class="btn" wire:click="showConfirmDelete">Delete</button>
                        @else
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        @endif

                        @if(!$if_not_cancel)
                        <button wire:click="save" type="button" class="btn btn-primary">Save changes</button>
                        @else
                        <button wire:click="revert" type="button" class="btn btn-primary">Revert cancel</button>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>

<script>
    let calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
        headerToolbar: {
            start: 'dayGridMonth,timeGridDay',
            center: 'title',
            end: 'prev,next',
        },
        events: @json($events),
        editable: true,
        selectable: true,
        views: {
            timeGrid: {
                dayMaxEventRows: 1 // adjust to 6 only for timeGridWeek/timeGridDay
            }
        },
        dayMaxEventRows: true, // for all non-TimeGrid views
        eventoMaxStack: true,
        eventClick: function(info) {
            Livewire.emit('editEvent', info.event.id);
        },
        eventDrop: function(info) {
            Livewire.emit('updateEventDate', info.event.id, formatDateToYmdHis(info.event.start), formatDateToYmdHis(info.event.end));
        }
    });

    calendar.render();

    document.addEventListener('livewire:load', function() {
        Livewire.on('updateEvents', events => {
            const calendarEl = document.getElementById('calendar');

            if (calendar) {
                calendar.destroy();
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    start: 'dayGridMonth,timeGridWeek,timeGridDay',
                    center: 'title',
                    end: 'today prev,next',
                },
                dayMaxEventRows: true, // for all non-TimeGrid views
                views: {
                    timeGrid: {
                        dayMaxEventRows: 6 // adjust to 6 only for timeGridWeek/timeGridDay
                    }
                },
                eventoMaxStack: true,
                events: events,
                editable: true,
                selectable: true,
                eventClick: function(info) {
                    Livewire.emit('editEvent', info.event.id);
                },
                eventDrop: function(info) {
                    Livewire.emit('updateEventDate', info.event.id, formatDateToYmdHis(info.event.start), formatDateToYmdHis(info.event.end));
                }
            });
            calendar.render();
        });
    });

    window.addEventListener('eventAdded', event => {
        calendar.addEvent(event.detail);
    });

    window.addEventListener('eventUpdated', event => {
        var eventObj = calendar.getEventById(event.detail.id);

        eventObj.setProp('title', event.detail.title);
        eventObj.setStart(event.detail.start_time);
        eventObj.setEnd(event.detail.end_time);
    });

    window.addEventListener('eventDeleted', eventId => {
        let eventObj = calendar.getEventById(eventId);
        eventObj.remove();
    });

    function formatDateToYmdHis(date) {
        let d = new Date(date);
        let yyyy = d.getFullYear();
        let mm = ('0' + (d.getMonth() + 1)).slice(-2);
        let dd = ('0' + d.getDate()).slice(-2);
        let hh = ('0' + d.getHours()).slice(-2);
        let ii = ('0' + d.getMinutes()).slice(-2);
        let ss = ('0' + d.getSeconds()).slice(-2);

        return `${yyyy}-${mm}-${dd} ${hh}:${ii}:${ss}`;
    }

    $(document).ready(function() {

        $("#date").on("change", function() {
            let date = $(this).val();

            Livewire.emit('checkDate', date);
        });

        document.querySelectorAll('.drivers').forEach(function(driverCheckbox) {
            driverCheckbox.addEventListener('change', function() {
                const driverIds = Array.from(document.querySelectorAll('.drivers:checked')).map(checkbox => checkbox.value);
                Livewire.emit('updateEventsCalendar', driverIds);
            });
        });
    });
</script>