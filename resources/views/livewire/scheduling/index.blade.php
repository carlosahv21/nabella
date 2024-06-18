<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <i class="material-icons">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search scheduling...">
                </div>
            </div>
            <div class="col-5 col-lg-5 d-flex justify-content-end mt-3 me-4">
                <div class="dropdown px-2">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons">expand_more</i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button wire:click="selectItem('','masiveExport')" class="dropdown-item btn-outline-gray-500"><i class="material-icons">download</i> Export</button>
                        </li>
                        @can('scheduling.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div>
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
                                        <select wire.ignore.self wire:model="patient_id" class="form-select" id="patient_id">
                                            <option value="">Select a patient</option>
                                            @foreach($patients as $patient)
                                            <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('patient_id'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('patient_id') }}
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
                                    <div class="mb-3 col-md-6">
                                        <div class="input-group input-group-static my-3">
                                            <label>Date</label>
                                            <input type="date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="input-group input-group-static my-3">
                                            <label>Check In</label>
                                            <input type="time" wire.ignore.self wire:model="check_in" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Pick Up</label>
                                        <select wire.ignore.self wire:model="pick_up" class="form-select" id="pick_up">
                                            <option value="">Select a pick up</option>
                                            @foreach($hospitals as $hospital)
                                            <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('pick_up'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('pick_up') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <div class="input-group input-group-static my-3">
                                            <label>Pick up time</label>
                                            <input type="time" wire.ignore.self wire:model="check_in" class="form-control" aria-label="Time (to the nearest minute)" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-check mb-3 col-md-3">
                                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                                            <label class="custom-control-label" for="customCheck1">Wheelchair</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-3">
                                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                                            <label class="custom-control-label" for="customCheck1">Ambulatory</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-3">
                                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                                            <label class="custom-control-label" for="customCheck1">Saturdays</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-3">
                                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                                            <label class="custom-control-label" for="customCheck1">Companion</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-3">
                                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                                            <label class="custom-control-label" for="customCheck1">Fast track</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                                            <label class="custom-control-label" for="customCheck1">Sundays/Holidays</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input class="form-check-input" type="checkbox" value="" id="fcustomCheck1">
                                            <label class="custom-control-label" for="customCheck1">Out of hour</label>
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
    <!-- Modal Delete-->
    <div wire:ignore.self class="modal fade" id="deleteScheduling" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h2>
                </div>
                <div class="modal-body">
                    Deseas eliminar este registro?
                </div>
                <div class="modal-footer">
                    <button wire:click="delete" class="btn btn-secondary">Eliminar</button>
                    <button type="button" class="btn btn-link text-gray-600 " data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Delete Masive-->
    <div wire:ignore.self class="modal fade" id="deleteSchedulingMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h2>
                </div>
                <div class="modal-body">
                    Deseas eliminar este registro?
                </div>
                <div class="modal-footer">
                    <button wire:click="delete" class="btn btn-secondary">Eliminar</button>
                    <button type="button" class="btn btn-link text-gray-600 " data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>

<script>
    var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
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
        hiddenDays: [ 6, 7 ],
        eventClick: function(info) {
            Livewire.emit('editEvent', info.event.id);
        },
        eventDrop: function(info) {
            Livewire.emit('updateEventDate', info.event.id, formatDateToYmdHis(info.event.start), formatDateToYmdHis(info.event.end));
        }
    });

    calendar.render();

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
        var eventObj = calendar.getEventById(eventId);
        eventObj.remove();
    });

    function formatDateToYmdHis(date) {
        var d = new Date(date);
        var yyyy = d.getFullYear();
        var mm = ('0' + (d.getMonth() + 1)).slice(-2);
        var dd = ('0' + d.getDate()).slice(-2);
        var hh = ('0' + d.getHours()).slice(-2);
        var ii = ('0' + d.getMinutes()).slice(-2);
        var ss = ('0' + d.getSeconds()).slice(-2);

        return `${yyyy}-${mm}-${dd} ${hh}:${ii}:${ss}`;
    }
</script>