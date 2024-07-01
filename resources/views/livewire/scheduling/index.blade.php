<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-8 col-lg-8 row mt-3">
                @for($i = 0; $i < count($drivers); $i++) 
                <div class="form-check form-check-inline col-3 col-lg-3">
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
<div class="card card-calendar">
    <div class="card-body p-3">
        <div wire:ignore class="calendar" data-bs-toggle="calendar" id="calendar" style="max-height: 735px;"></div>
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
                                    <input type="hidden" wire:model="address_hospital" id="address_hospital">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Driver assigned</label>
                                    <select wire.ignore.self wire:model="driver_id" class="form-select" id="driver_id">
                                        <option value="">Select a Driver</option>
                                        @foreach($drivers as $drive)
                                            <option value="{{ $drive->id }}">{{ $drive->name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('driver_id'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('driver_id') }}
                                    </div>
                                    @endif
                                    <input type="hidden" wire:model="address_hospital" id="address_hospital">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="input-group input-group-static my-3">
                                        <label>Date</label>
                                        <input type="date" class="form-control" id="date" wire:model="date">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="input-group input-group-static my-3">
                                        <label>Facility Check In</label>
                                        <input type="time" wire.ignore.self wire:model="check_in" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="check_in">
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Pick Up Address</label>
                                    <select wire.ignore.self wire:model="pick_up" class="form-select" id="pick_up">
                                        @for($i = 0; $i < count($addresses); $i++) <option value="{{ $addresses[$i]['value'] }}">{{ $addresses[$i]['text'] }}</option>
                                            @endfor
                                    </select>
                                    @if ($errors->has('pick_up'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('pick_up') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-6">
                                    <div class="input-group input-group-static my-3">
                                        <label>Suggested pick up time</label>
                                        <input type="time" wire.ignore.self wire:model="pick_up_time" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)" id="pick_up_time" readonly="readonly">
                                    </div>
                                </div>
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
                                        <label class="custom-control-label" for="customOutOfHours">Out of hour</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <hr class="dark horizontal">
                                    <div class="form-check mb-3 col-md-12">
                                        <input wire.ignore.self wire:model="auto_agend" class="form-check-input" type="checkbox" id="customAutoAgend">
                                        <label class="custom-control-label" for="customAutoAgend">Auto Agend <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="Automatically schedule your appointments">help</i></label>
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
        initialView: "timeGridWeek",
        headerToolbar: {
            start: 'title', // will normally be on the left. if RTL, will be on the right
            center: '',
            end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
        },
        events: @json($events),
        slotMinTime: '09:00:00',
        slotMaxTime: '20:00:00',
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

    document.addEventListener('livewire:load', function () {
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
        $("#patientId").on("change", function() {
            let patientId = $(this).val();
            Livewire.emit('updatePatientId', patientId);
        });

        $("#hospital_id").on("change", function() {
            let hospitalId = $(this).val();
            Livewire.emit('updateHospitalAddress', hospitalId);
        });

        $("#date").on("change", function() {
            let date = $(this).val();

            Livewire.emit('checkDate', date);
        });

        $("#pick_up").on("change", function() {
            let origin = $(this).find('option:selected').text();
            let destination = $("#address_hospital").val();

            let arrivalTime = $("#date").val() + " " + $("#check_in").val();

            Livewire.emit('getDistance', origin, destination, arrivalTime);
        });

        document.querySelectorAll('.drivers').forEach(function(driverCheckbox) {
            driverCheckbox.addEventListener('change', function() {
                const driverIds = Array.from(document.querySelectorAll('.drivers:checked')).map(checkbox => checkbox.value);
                Livewire.emit('updateEventsCalendar', driverIds);
            });
        });
    });
</script>