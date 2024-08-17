<div>
    <div class="table-settings mx-4 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-8 col-lg-8 row mt-3">
                @for($i = 0; $i < count($drivers); $i++) <div class="form-check form-check-inline col-3 col-lg-3">
                    <input class="form-check-input drivers" type="checkbox" id="driver{{ $drivers[$i]->id }}" value="{{ $drivers[$i]->id }}">
                    <label class="form-check-label" for="driver{{ $drivers[$i]->id }}" style="background-color: {{ $colors[$i] }};">
                        <b class="text-white"> {{ $drivers[$i]->name }} </b>
                    </label>
            </div>
            @endfor
        </div>
        <div class="col-4 col-lg-4 d-flex justify-content-end mt-3">
            <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                <i class="material-icons">add</i> Add scheduling
            </button>
        </div>
    </div>
</div>
<!-- notifications -->
<div class="position-fixed top-2 end-2 z-index-2">
    <div class="toast fade hide p-2 bg-white bg-gradient-{{ session('alert.type', 'info') }}" role="alert" aria-live="assertive" id="toast" data-bs-delay="2000">
        <div class="toast-header bg-transparent text-white border-0">
            <i class="material-icons me-2">
                {{ session('alert.icon') }}
            </i>
            <span class="me-auto font-weight-bold">Notification!</span>
            <i class="material-icons cursor-pointer" data-bs-dismiss="toast" aria-label="Close">close</i>
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
            </div>
            <div class="modal-body">
                <div class="card card-plain h-100">
                    <div class="card-body p-0">
                        <form>
                            <div class="row">
                                <!-- PATIENT -->
                                <div class="mb-3 col-md-5">
                                    <label class="form-label">Patient</label>
                                    <select wire.ignore.self wire:model="patient_id" class="form-select" id="patientId">
                                        <option value="">Select a patient</option>
                                        @foreach($patients as $patient)
                                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('patientId'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('patientId') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Start Date</label>
                                    <input wire:model="date" class="form-control border border-1 p-2 date-input active" placeholder="YYYY/MM/DD">
                                </div>
                                <div class="form-check mb-3 col-md-4 " style="margin-top: 2.4rem !important;">
                                    <input wire.ignore.self wire:model="auto_agend" class="form-check-input" type="checkbox" id="auto_agend">
                                    <label class="custom-control-label" for="auto_agend">Auto Agend</label>
                                </div>
                                @if($auto_agend)
                                <hr class="dark horizontal">
                                <label class="form-label">Select Days</label>
                                <div class="row">
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customMon day" value="1" wire:model="weekdays">
                                        <label class="form-check-label" for="customMonday">Monday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customTuesday" value="2" wire:model="weekdays">
                                        <label class="form-check-label" for="customTuesday">Tuesday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customWednesday" value="3" wire:model="weekdays">
                                        <label class="form-check-label" for="customWednesday">Wednesday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customThursday" value="4" wire:model="weekdays">
                                        <label class="form-check-label" for="customThursday">Thursday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customFriday" value="5" wire:model="weekdays">
                                        <label class="form-check-label" for="customFriday">Friday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customSaturday" value="6" wire:model="weekdays">
                                        <label class="form-check-label" for="customSaturday">Saturday</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input class="form-check-input" type="checkbox" id="customSunday" value="7" wire:model="weekdays">
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
                                    <input class="form-control border border-2 p-2" type="text" wire:model="pick_up_address" placeholder="Pick up address">
                                    @if (!empty($prediction_pick_up))
                                    <ul class="list-group">
                                        @foreach ($prediction_pick_up as $address_pick_up)
                                        <li class="list-group-item cursor-pointer" wire:click="addPickUp('{{ $address_pick_up }}')">{{ $address_pick_up }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                @foreach ($stops as $index => $stop)
                                <div class="mb-3 row">
                                    <div class="col-md-10">
                                        <input class="form-control border border-2 p-2" type="text" wire:model="stops.{{ $index }}.address" placeholder="Drop off Address Stop {{ $index + 1 }}" wire:input="updateStopQuery({{ $index }}, $event.target.value)">
                                        @if (!empty($stops[$index]['addresses']))
                                        <ul class="list-group">
                                            @foreach ($stops[$index]['addresses'] as $address)
                                            <li class="list-group-item cursor-pointer" wire:click="selectStopAddress({{ $index }}, '{{ $address }}')">{{ $address }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-md-2 d-flex">
                                        @if ($index == count($stops) - 1)
                                        <button type="button" wire:click="addStop" class="btn btn-link text-dark text-gradient px-3 mb-0"
                                            data-bs-toggle="tooltip" data-bs-original-title="Add stops">
                                            <i class="material-icons">add</i>
                                        </button>
                                        @endif
                                        <button type="button" class="btn btn-link text-dark text-gradient px-3 mb-0" wire:click="removeStop({{ $index }})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Check In</label>
                                        <input type="time" wire.ignore.self wire:model="check_in" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="check_in">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Pick up time</label>
                                        <input type="time" wire.ignore.self wire:model="pick_up_time" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="pick_up_time">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Pick up driver</label>
                                    <select wire.ignore.self wire:model="pick_up_driver_id" class="form-select" id="pick_up_driver_id">
                                        <option value="">Select a Driver</option>
                                        @foreach($drivers as $drive)
                                        <option value="{{ $drive->id }}">{{ $drive->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('pick_up_driver_id'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('pick_up_driver_id') }}
                                    </div>
                                    @endif
                                </div>

                                <!-- RETURN -->
                                <h6 class="text-center">RETURN</h6>
                                <div class="mb-3 col-md-12">
                                    <input class="form-control border border-2 p-2" type="text" wire:model="location_driver" placeholder="Location Driver">
                                    @if (!empty($prediction_location_driver))
                                    <ul class="list-group">
                                        @foreach ($prediction_location_driver as $address_location_driver)
                                        <li class="list-group-item cursor-pointer" wire:click="addLocationDriver('{{ $address_location_driver }}')">{{ $address_location_driver }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-12">
                                    <input class="form-control border border-2 p-2" type="text" wire:model="return_pick_up_address" placeholder="Pick up address">
                                    @if (!empty($prediction_return_pick_up_address))
                                    <ul class="list-group">
                                        @foreach ($prediction_return_pick_up_address as $p_address_pick_up)
                                        <li class="list-group-item cursor-pointer" wire:click="addReturnPickUp('{{ $p_address_pick_up }}')">{{ $p_address_pick_up }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
                                @foreach ($r_stops as $r_index => $r_stop)
                                <div class="mb-3 row">
                                    <div class="col-md-10">
                                        <input class="form-control border border-2 p-2" type="text" wire:model="r_stops.{{ $r_index }}.address" placeholder="Drop off Address Stop {{ $r_index + 1 }}" wire:input="updateStopQueryReturn({{ $r_index }}, $event.target.value)">
                                        @if (!empty($r_stops[$r_index]['addresses']))
                                        <ul class="list-group">
                                            @foreach ($r_stops[$r_index]['addresses'] as $r_address)
                                            <li class="list-group-item cursor-pointer" wire:click="selectStopAddressReturn({{ $r_index }}, '{{ $r_address }}')">{{ $address }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-md-2 d-flex">
                                        @if ($r_index == count($r_stops) - 1)
                                        <button type="button" wire:click="addStopReturn" class="btn btn-link text-dark text-gradient px-3 mb-0"
                                            data-bs-toggle="tooltip" data-bs-original-title="Add stops">
                                            <i class="material-icons">add</i>
                                        </button>
                                        @endif
                                        <button type="button" class="btn btn-link text-dark text-gradient px-3 mb-0" wire:click="removeStopReturn({{ $r_index }})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Check Out</label>
                                        <input type="time" wire.ignore.self wire:model="r_check_in" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="r_check_in">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Pick up time</label>
                                        <input type="time" wire.ignore.self wire:model="r_start_drive" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="r_start_drive">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Drop off driver</label>
                                    <select wire.ignore.self wire:model="drop_off_driver_id" class="form-select" id="drop_off_driver_id">
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
                                <!-- CHARGES -->
                                <h6 class="text-center">CHARGES</h6>
                                <div class="row">
                                    <div class="col-md-2">
                                    </div>
                                    <div class="col-md-8 row text-center">
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input class="form-check-input" type="radio" value="one_way" wire.ignore_self wire:model="type_of_trip">
                                            <label class="custom-control-label text-10" for="one_way">One way</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input class="form-check-input" type="radio" value="round_trip" wire.ignore_self wire:model="type_of_trip">
                                            <label class="custom-control-label text-10" for="round_trip">Round trip</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input wire.ignore.self wire:model="wheelchair" class="form-check-input" type="checkbox" id="customWheelchair">
                                            <label class="custom-control-label text-10" for="customWheelchair">Wheelchair</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input wire.ignore.self wire:model="ambulatory" class="form-check-input" type="checkbox" id="customAmbulatory">
                                            <label class="custom-control-label text-10" for="customAmbulatory">Ambulatory</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input wire.ignore.self wire:model="saturdays" class="form-check-input" type="checkbox" id="customSaturdays">
                                            <label class="custom-control-label text-10" for="customSaturdays">Saturdays</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input wire.ignore.self wire:model="companion" class="form-check-input" type="checkbox" id="customCompanion">
                                            <label class="custom-control-label text-10" for="customCompanion">Companion</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input wire.ignore.self wire:model="fast_track" class="form-check-input" type="checkbox" id="customFastTrack">
                                            <label class="custom-control-label text-10" for="customFastTrack">Fast Track</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input wire.ignore.self wire:model="sundays_holidays" class="form-check-input" type="checkbox" id="customSundaysHolidays">
                                            <label class="custom-control-label text-10" for="customSundaysHolidays">Sund / Holid</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4" style="padding-left: 0px;padding-right: 0px;">
                                            <input wire.ignore.self wire:model="out_of_hours" class="form-check-input" type="checkbox" id="customOutOfHours">
                                            <label class="custom-control-label text-10" for="customOutOfHours">After hours</label>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                    </div>
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
                        <button type="button" class="btn" data-bs-dismiss="modal" wire:click="cancelScheduling">Cancel Scheduling</button>
                    @else
                        <p>&nbsp;</p>
                    @endif

                    <div>
                        <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                        <button wire:click="save" type="button" class="btn btn-primary">Save changes</button>
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
            start: 'dayGridMonth,timeGridWeek,timeGridDay',
            end: 'today prev,next'
        },
        events: @json($events),
        editable: true,
        selectable: true,
        eventClick: function(info) {
            Livewire.emit('editEvent', info.event.id);
        },
        eventDrop: function(info) {
            console.log(info);
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
                    end: 'today prev,next'
                },
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