@section('title','Dashboard')
@if(auth()->user()->roles->first()->name == 'Admin')
<h1>Admin</h1>
@elseif(auth()->user()->roles->first()->name == 'Driver')
<div>
    <div class="table-settings mx-3 my-4">
        <div class="row">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-3 pt-2">
                        <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                            <i class="material-icons opacity-10">directions_car</i>
                        </div>
                        <div class="text-end pt-1">
                            <p class="text-sm mb-4 text-capitalize">Car assigned today</p>
                            <h4 class="mb-0">{{ $cars->first()->make }} {{ $cars->first()->model }}</h4>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-3 text-end">
                        <a wire:click="selectItem({{ $cars->first()->id }}, 'see')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                            <i class="material-icons text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">visibility</i>View
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Schedule of the day</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                                    <span class="font-weight-bold ms-1">{{ count($events) }}</span> this day
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Routes</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Patient name</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Status</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Map</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($events as $event)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="timeline timeline-one-side">
                                                    <div class="timeline-block">
                                                        <span class="timeline-step">
                                                            <i class="material-icons text-success text-gradient">location_on</i>
                                                        </span>
                                                        <div class="timeline-content">
                                                            <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $event['pick_up'] }}</h6>
                                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"> {{ $event['date'] }} {{ \Carbon\Carbon::parse($event['pick_up_time'])->format('H:i A') }} </p>
                                                        </div>
                                                        <div class="timeline-content pt-3">
                                                            <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $event['hospital'] }}</h6>
                                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $event['date'] }} {{ \Carbon\Carbon::parse($event['check_in'])->format('H:i A') }} </p>
                                                        </div>
                                                        <span class="timeline-step" style="margin-top: -25px;">
                                                            <i class="material-icons text-success text-gradient">location_on</i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $event['patient_name'] }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="badge badge-sm bg-gradient-success">Waiting</span>
                                        </td>
                                        <td class="align-middle">
                                            <a href="javascript:;" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                                <i class="material-icons text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="See map">location_on</i> See map
                                            </a>
                                        </td>
                                        <td class="align-middle">
                                            <div class="row">
                                                <div class="form-check mb-3 col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="customWheelchair" @if($event['wheelchair']) checked @endif>
                                                    <label class="custom-control-label" for="customWheelchair">Wheelchair</label>
                                                </div>
                                                <div class="form-check mb-3 col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="customAmbulatory" @if($event['ambulatory']) checked @endif>
                                                    <label class="custom-control-label" for="customAmbulatory">Ambulatory</label>
                                                </div>
                                                <div class="form-check mb-3 col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="customSaturdays" @if($event['saturdays']) checked @endif>
                                                    <label class="custom-control-label" for="customSaturdays">Saturdays</label>
                                                </div>
                                                <div class="form-check mb-3 col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="customCompanion" @if($event['companion']) checked @endif>
                                                    <label class="custom-control-label" for="customCompanion">Companion</label>
                                                </div>
                                                <div class="form-check mb-3 col-md-3">
                                                    <input class="form-check-input" type="checkbox" id="customFastTrack" @if($event['fast_track']) checked @endif>
                                                    <label class="custom-control-label" for="customFastTrack">Fast Track</label>
                                                </div>
                                                <div class="form-check mb-3 col-md-4">
                                                    <input class="form-check-input" type="checkbox" id="customSundaysHolidays" @if($event['sundays_holidays']) checked @endif>
                                                    <label class="custom-control-label" for="customSundaysHolidays">Sundays/Holidays</label>
                                                </div>
                                                <div class="form-check mb-3 col-md-4">
                                                    <input class="form-check-input" type="checkbox" id="customOutOfHours" @if($event['out_of_hours']) checked @endif>
                                                    <label class="custom-control-label" for="customOutOfHours">Out of hour</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endifa