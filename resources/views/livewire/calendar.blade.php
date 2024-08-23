<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    
                </div>
            </div>
            <div class="col-5 col-lg-5 d-flex justify-content-end mt-3 me-4">
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons notranslate">add</i> Add Event
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
    <div class="card card-calendar">
        <div class="card-body p-0">
            <div class="calendar" data-bs-toggle="calendar" id="calendar"></div>
        </div>
    </div>
</div>

<!-- Modal Add-->
<div wire:ignore.self class="modal fade" id="createEvent" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Name <span class="text-danger">*</span></label>
                                    <input wire:model="name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                    @if ($errors->has('name'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('name') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label"> Start date <span class="text-danger">*</span></label>
                                    <input wire:model="start_date" type="date" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                    @if ($errors->has('start_date'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('start_date') }}
                                    </div>
                                    @endif
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label"> End date <span class="text-danger">*</span></label>
                                    <input wire:model="end_date" type="date" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                    @if ($errors->has('end_date'))
                                    <div class="text-danger inputerror">
                                        {{ $errors->first('end_date') }}
                                    </div>
                                    @endif
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

<script>
    var calendar = new FullCalendar.Calendar(document.getElementById("calendar"), {
        initialView: "timeGridWeek",
        headerToolbar: {
            start: 'title', // will normally be on the left. if RTL, will be on the right
            center: '',
            end: 'today prev,next' // will normally be on the right. if RTL, will be on the left
        },
        selectable: true,
        editable: true,
        events: @json($events),
        slotMinTime: '09:00:00',
        slotMaxTime: '20:00:00',
        eventClick: function(info) {
            Livewire.emit('editEvent', info.event.id);
        },
    });

    calendar.render();
</script>