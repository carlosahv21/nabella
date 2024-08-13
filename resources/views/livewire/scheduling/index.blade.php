<div class="card table-settings my-4 mx-4">
    <div class="row align-items-center bg-white rounded-3">
        <div class="col-12 col-lg-8 row mt-3">
            @for($i = 0; $i < count($drivers); $i++)
                <div class="form-check form-check-inline col-6 col-lg-3" style="padding-left: 1rem; margin-right: 0;">
                    <input class="form-check-input drivers" type="checkbox" id="driver{{ $drivers[$i]->id }}" value="{{ $drivers[$i]->id }}">
                    <label class="form-check-label text-white text-bold" for="driver{{ $drivers[$i]->id }}" style="background-color: {{ $colors[$i] }}; padding: 0 1px;"> {{ $drivers[$i]->name }} </label>
                </div>
            @endfor
        </div>
        <div class="col-12 col-lg-4 d-flex justify-content-center mt-3">
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
    <div class="card-body px-2 pt-3">
        <div wire:ignore class="calendar px-1" data-bs-toggle="calendar" id="calendar" style="max-height: 735px;"></div>
    </div>
</div>
<!-- Modal Add-->
<div wire:ignore.self class="modal fade" id="createScheduling" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{$title_modal}}</h2>
            </div>
            <div class="modal-body">
                <div class="card card-plain h-100">
                    <div class="card-body p-0">
                        <form>
                            <div class="row">
                                <div class="mb-3 col-md-6">
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
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Facility</label>
                                    <select wire.ignore.self wire:model="hospital_id" class="form-select" id="hospital_id">
                                        <option value="">Select a facility</option>
                                        @foreach($hospitals as $hospital)
                                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('hospital_id'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('hospital_id') }}
                                    </div>
                                    @endif
                                </div>
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
                                <div class="col-md-12">
                                    <label class="form-label">Drop off Address</label>
                                    <button type="button" wire:click="addStop" class="btn btn-link text-dark text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Add stops">
                                        <i class="material-icons">add</i>
                                    </button>
                                </div>
                                @foreach ($stops as $index => $stop)
                                <div class="mb-3 row">
                                    <div class="col-md-11">
                                        <input class="form-control border border-2 p-2" type="text" wire:model="stops.{{ $index }}.address" placeholder="Stop {{ $index + 1 }}" wire:input="updateStopQuery({{ $index }}, $event.target.value)">
                                        @if (!empty($stops[$index]['addresses']))
                                        <ul class="list-group">
                                            @foreach ($stops[$index]['addresses'] as $address)
                                            <li class="list-group-item cursor-pointer" wire:click="selectStopAddress({{ $index }}, '{{ $address }}')">{{ $address }}</li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-link text-dark text-gradient px-3 mb-0" wire:click="removeStop({{ $index }})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                                <hr class="dark horizontal">
                                <div class="mb-3 col-md-6">
                                    <div class="input-group input-group-static">
                                        <label>Start Date</label>
                                        <input class="form-control date-input" wire:model="date" placeholder="YYYY/MM/DD">
                                    </div>
                                </div>
                                <div class="form-check mb-3 col-md-6 mt-4">
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
                                <hr class="dark horizontal">
                                @endif
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Check In</label>
                                        <input wire.ignore.self wire:model="check_in" class="form-control date-input-time" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="check_in" placeholder="HH:MM">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <div class="input-group input-group-static my-1">
                                        <label>Pick up time</label>
                                        <input wire.ignore.self wire:model="pick_up_time" class="form-control date-input-time" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="pick_up_time" placeholder="HH:MM">
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
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Wait time</label>
                                    <select wire.ignore.self wire:model="wait_time" class="form-select" id="wait_time">
                                        <option value="">Select a Wait time</option>
                                        <option value="15">15 mins</option>
                                        <option value="30">30 mins</option>
                                        <option value="45">45 mins</option>
                                        <option value="60">60 mins</option>
                                    </select>
                                    @if ($errors->has('wait_time'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('wait_time') }}
                                    </div>
                                    @endif
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
                                <div class="mb-3 col-md-6 mt-3">
                                    <label class="form-label">Type of trip</label>
                                    <div class="form-check" style="padding-left: 0px;">
                                        <input class="form-check-input" type="radio" value="one_way" wire.ignore_self wire:model="type_of_trip">
                                        <label class="custom-control-label" for="one_way">One way</label>
                                        <input class="form-check-input" type="radio" value="round_trip" wire.ignore_self wire:model="type_of_trip">
                                        <label class="custom-control-label" for="round_trip">Round trip</label>
                                    </div>
                                </div>
                                <hr class="dark horizontal">
                                <div class="row">
                                    <div class="form-check mb-3 col-md-3">
                                        <input wire.ignore.self wire:model="wheelchair" class="form-check-input" type="checkbox" id="customWheelchair">
                                        <label class="custom-control-label" for="customWheelchair">Wheelchair</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input wire.ignore.self wire:model="ambulatory" class="form-check-input" type="checkbox" id="customAmbulatory">
                                        <label class="custom-control-label" for="customAmbulatory">Ambulatory</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input wire.ignore.self wire:model="saturdays" class="form-check-input" type="checkbox" id="customSaturdays">
                                        <label class="custom-control-label" for="customSaturdays">Saturdays</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input wire.ignore.self wire:model="companion" class="form-check-input" type="checkbox" id="customCompanion">
                                        <label class="custom-control-label" for="customCompanion">Companion</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-3">
                                        <input wire.ignore.self wire:model="fast_track" class="form-check-input" type="checkbox" id="customFastTrack">
                                        <label class="custom-control-label" for="customFastTrack">Fast Track</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-4">
                                        <input wire.ignore.self wire:model="sundays_holidays" class="form-check-input" type="checkbox" id="customSundaysHolidays">
                                        <label class="custom-control-label" for="customSundaysHolidays">Sundays/Holidays</label>
                                    </div>
                                    <div class="form-check mb-3 col-md-4">
                                        <input wire.ignore.self wire:model="out_of_hours" class="form-check-input" type="checkbox" id="customOutOfHours">
                                        <label class="custom-control-label" for="customOutOfHours">After hours</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                <button wire:click="save" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>

<script>
    let calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
        // initialView: "dayGridYear",
        headerToolbar: {
            start: 'dayGridMonth,timeGridWeek,timeGridDay',
            end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
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
                initialView: "timeGridWeek",
                headerToolbar: {
                    start: 'title', // will normally be on the left. if RTL, will be on the right
                    center: '',
                    end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
                },
                events: events,
                slotMinTime: '09:00:00',
                slotMaxTime: '20:00:00',
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