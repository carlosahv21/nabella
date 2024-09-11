@section('title','Usuario')
@if(auth()->user()->roles->first()->name == 'Admin')
<div class="container-fluid py-4 px-3">
    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-7 text-start">
                            <p class="text-sm mb-1 text-capitalize font-weight-bold">Sales</p>
                            <h5 class="font-weight-bolder mb-0">
                                $230,220
                            </h5>
                        </div>
                        <div class="col-5">
                            <div class="dropdown text-end">
                                <a href="javascript:;" class="cursor-pointer text-secondary" id="dropdownUsers1" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="text-xs text-secondary">6 May - 7 May</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="dropdownUsers1">
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last 7
                                            days</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last
                                            week</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last 30
                                            days</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-sm-0 mt-4">
            <div class="card">
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-7 text-start">
                            <p class="text-sm mb-1 text-capitalize font-weight-bold">Customers</p>
                            <h5 class="font-weight-bolder mb-0">
                                3.200
                            </h5>
                        </div>
                        <div class="col-5">
                            <div class="dropdown text-end">
                                <a href="javascript:;" class="cursor-pointer text-secondary" id="dropdownUsers2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="text-xs text-secondary">6 May - 7 May</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="dropdownUsers2">
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last 7
                                            days</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last
                                            week</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last 30
                                            days</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 mt-sm-0 mt-4">
            <div class="card">
                <div class="card-body p-3 position-relative">
                    <div class="row">
                        <div class="col-7 text-start">
                            <p class="text-sm mb-1 text-capitalize font-weight-bold">Avg. Revenue</p>
                            <h5 class="font-weight-bolder mb-0">
                                $1.200
                            </h5>
                        </div>
                        <div class="col-5">
                            <div class="dropdown text-end">
                                <a href="javascript:;" class="cursor-pointer text-secondary" id="dropdownUsers3" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="text-xs text-secondary">6 May - 7 May</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end px-2 py-3" aria-labelledby="dropdownUsers3">
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last 7
                                            days</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last
                                            week</a></li>
                                    <li><a class="dropdown-item border-radius-md" href="javascript:;">Last 30
                                            days</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Status of the drivers</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Product</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Value</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Ads Spent</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        Refunds</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/blue-shoe.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Nike v22 Running</h6>
                                                <p class="text-sm font-weight-normal text-secondary mb-0"><span class="text-success">8.232</span> orders</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">$130.992</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">$9.500</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">13</p>
                                            <i class="ni ni-bold-down text-sm ms-1 text-success"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/black-mug.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Business Kit (Mug + Notebook)</h6>
                                                <p class="text-sm font-weight-normal text-secondary mb-0"><span class="text-success">12.821</span> orders</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">$80.250</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">$4.200</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">40</p>
                                            <i class="ni ni-bold-down text-sm ms-1 text-success"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/black-chair.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Black Chair</h6>
                                                <p class="text-sm font-weight-normal text-secondary mb-0"><span class="text-success">2.421</span> orders</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">$40.600</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">$9.430</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">54</p>
                                            <i class="ni ni-bold-up text-sm ms-1 text-danger"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/bang-sound.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Wireless Charger</h6>
                                                <p class="text-sm font-weight-normal text-secondary mb-0"><span class="text-success">5.921</span> orders</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">$91.300</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">$7.364</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">5</p>
                                            <i class="ni ni-bold-down text-sm ms-1 text-success"></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div>
                                                <img src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/ecommerce/photo-tools.jpg" class="avatar me-3" alt="image">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">Mountain Trip Kit (Camera + Backpack)
                                                </h6>
                                                <p class="text-sm font-weight-normal text-secondary mb-0"><span class="text-success">921</span> orders</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">$140.925</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">$20.531</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">121</p>
                                            <i class="ni ni-bold-up text-sm ms-1 text-danger"></i>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(auth()->user()->roles->first()->name == 'Driver')
<div class="mx-3">
    <div class="row mt-4">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow-dark text-center border-radius-xl mt-n4 position-absolute">
                        <i class="material-icons notranslate opacity-10">directions_car</i>
                    </div>
                    <div class="text-end pt-1">
                        <p class="text-sm mb-4 text-capitalize">Car assigned today</p>
                        <h4 class="mb-0">@if(count($cars) > 0) {{ $cars->first()->make }} {{ $cars->first()->model }} @else No car assigned @endif</h4>
                    </div>
                </div>
                <hr class="dark horizontal my-0">
                @if(count($cars) > 0)
                <div class="card-footer p-3 text-end">
                    <a wire:click="selectItem({{ $cars->first()->id }}, 'see')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                        <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">visibility</i>View
                    </a>
                </div>
                @endif
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
    <div class="card shadow border-0 table-wrapper table-responsive mt-4">
        <div>
            <div class="card-header pb-0">
                <div class="row">
                    <div class="col-lg-6 col-7">
                        <h6>Schedule of the day</h6>
                        <p class="text-sm mb-0">
                            <i class="fa fa-check text-info" aria-hidden="true"></i>
                            <span class="font-weight-bold ms-1">{{ count($events) }} route</span> this day
                        </p>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
                <div class="table-responsive">
                    <table class="table driver-table align-items-center">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Routes</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Patient name</th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Details</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)
                            <tr>
                                <td>
                                    <div class="d-flex px-2 py-1">
                                        <div class="timeline timeline-one-side">
                                            <div class="timeline-block">
                                                <span class="timeline-step">
                                                    <i class="material-icons notranslate text-success text-gradient">location_on</i>
                                                </span>
                                                <div class="timeline-content">
                                                    <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $event['pick_up_address'] }}</h6>
                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0"> {{ $event['date'] }} {{ \Carbon\Carbon::parse($event['pick_up_hour'])->format('H:i A') }} </p>
                                                </div>
                                                <div class="timeline-content pt-3">
                                                    <h6 class="text-dark text-sm font-weight-bold mb-0">{{ $event['drop_off_address'] }}</h6>
                                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{ $event['date'] }} {{ \Carbon\Carbon::parse($event['drop_off_hour'])->format('H:i A') }} </p>
                                                </div>
                                                <span class="timeline-step" style="margin-top: -25px;">
                                                    <i class="material-icons notranslate text-success text-gradient">location_on</i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{ $event['patient_name'] }}
                                </td>
                                <td class="align-middle text-center">
                                    <span class="badge {{ $event['status_color'] }}">
                                        {{ $event['status'] }}
                                    </span>
                                </td>
                                <td class="align-middle">
                                    <a wire:click="selectItem({{ $event['id'] }}, 'seeDetails')" class="btn btn-link text-dark text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="See details">
                                        <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="See details">visibility</i> See details
                                    </a>
                                </td>
                                <td class="align-middle">
                                    @if($event['status'] == 'Waiting')
                                    <a wire:click="startDriving({{ $event['id'] }})" class="btn btn-link text-dark text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Start driving">
                                        <i class="material-icons notranslate text-sm me-2">directions_car</i> Start driving
                                    </a>
                                    @elseif($event['status'] == 'In Progress')
                                    <a wire:click="completeDriving({{ $event['id'] }})" class="btn btn-link text-dark text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Finish driving">
                                        <i class="material-icons notranslate text-sm me-2">directions_car</i> Finish driving
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Details-->
    <div wire:ignore.self class="modal fade" id="seeEventDetails" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="material-icons notranslate">close</i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-plain h-100">
                        <div class="card-body p-0">
                            <form>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Patient </label><br>
                                        <span class="text-dark text-sm font-weight-bolder ms-sm-2">
                                            <i class="material-icons notranslate text-sm me-1">person</i>
                                            {{ $patient_id }}
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Facility</label><br>
                                        <span class="text-dark text-sm font-weight-bolder ms-sm-2">
                                            <i class="material-icons notranslate text-sm me-1">local_hospital</i>
                                            {{ $hospital_name }}
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Driver assigned</label><br>
                                        <span class="text-dark text-sm font-weight-bolder ms-sm-2">
                                            <i class="material-icons notranslate text-sm me-1">person</i>
                                            {{ $driver_name }}
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label>Date</label><br>
                                        <span class="text-dark text-sm font-weight-bolder ms-sm-2">
                                            <i class="material-icons notranslate text-sm me-1">calendar_today</i>
                                            {{ $date }}
                                        </span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Pick Up Address</label><br>
                                        <span class="text-dark text-sm font-weight-bolder ms-sm-2">
                                            <i class="material-icons notranslate text-sm me-1">location_on</i>
                                            {{ $pick_up }}
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Drop Off Address</label><br>
                                        <span class="text-dark text-sm font-weight-bolder ms-sm-2">
                                            <i class="material-icons notranslate text-sm me-1">location_on</i>
                                            {{ $drop_off }}
                                        </span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label>Facility Check In</label><br>
                                        <span class="text-dark text-sm font-weight-bolder ms-sm-2">
                                            <i class="material-icons notranslate text-sm me-1">schedule</i>
                                            {{ \Carbon\Carbon::parse($check_in)->format('H:i A') }}
                                        </span>
                                    </div>
                                    <div class="row">
                                        <hr class="dark horizontal">
                                        <h6>Charges</h6>
                                        <hr class="dark horizontal">
                                        <div class="form-check mb-3 col-md-4">
                                            @if($wheelchair)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customWheelchair">Wheelchair</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($ambulatory)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customAmbulatory">Ambulatory</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($out_of_hours)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customOutOfHours">After Hour</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($saturdays)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customSaturdays">Saturdays</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($sundays_holidays)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customSundaysHolidays">Sundays/Holidays</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($companion)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customCompanion">Accompanist</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($aditional_waiting)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customAditionalWaiting">Aditional Waiting</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($fast_track)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customFastTrack">Quick Pass</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            @if($if_not_cancel)
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">check</i>
                                            </span>
                                            @else
                                            <span>
                                                <i class="material-icons notranslate text-sm me-1">close</i>
                                            </span>
                                            @endif
                                            <label class="custom-control-label" for="customIfNotCancel">If not cancel</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Complete Driving-->
    <div wire:ignore.self class="modal fade" id="CompleteDriving" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="material-icons notranslate">close</i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-plain h-100">
                        <div class="card-body p-0">
                            <form>
                                <div class="row">
                                    <div class="mb-3 col-md-6 col-6">
                                        <label class="form-label">Comments</label>
                                        <textarea wire:model="observations" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="Any additional comments"></textarea>
                                        @if ($errors->has('observations'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('observations') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6 col-6">
                                        <label class="form-label">Additional Milles </label>
                                        <input wire:model="additional_milles" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('additional_milles'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('additional_milles') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <hr class="dark horizontal">
                                        <h6>Additional Charges</h6>
                                        <hr class="dark horizontal">
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="wheelchair" class="form-check-input" type="checkbox" @if($ambulatory) disabled @endif id="customWheelchair">
                                            <label class="custom-control-label" for="customWheelchair">Wheelchair</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="ambulatory" class="form-check-input" type="checkbox" @if($wheelchair) disabled @endif id="customAmbulatory">
                                            <label class="custom-control-label" for="customAmbulatory">Ambulatory</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="out_of_hours" class="form-check-input" type="checkbox" id="customOutOfHours">
                                            <label class="custom-control-label" for="customOutOfHours">After Hour</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="saturdays" class="form-check-input" type="checkbox" id="customSaturdays">
                                            <label class="custom-control-label" for="customSaturdays">Saturdays</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="sundays_holidays" class="form-check-input" type="checkbox" id="customSundaysHolidays">
                                            <label class="custom-control-label" for="customSundaysHolidays">Sundays/Holidays</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="companion" class="form-check-input" type="checkbox" id="customCompanion">
                                            <label class="custom-control-label" for="customCompanion">Accompanist</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="aditional_waiting" class="form-check-input" type="checkbox" id="customAditionalWaiting">
                                            <label class="custom-control-label" for="customAditionalWaiting">Aditional Waiting</label>
                                        </div>
                                        <div class="form-check mb-3 col-md-4">
                                            <input wire.ignore.self wire:model="fast_track" class="form-check-input" type="checkbox" id="customFastTrack">
                                            <label class="custom-control-label" for="customFastTrack">Quick Pass</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                    <button wire:click="finishDriving" type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Map-->
    <div wire:ignore.self class="modal fade" id="seeMap" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="material-icons notranslate">close</i>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div id="map" style="height: 500px; width: 100%;"></div>

                        <script>
                            document.addEventListener('livewire:load', function() {
                                let map;
                                let directionsService;
                                let directionsRenderer;

                                function initMap(routes) {
                                    directionsService = new google.maps.DirectionsService();
                                    directionsRenderer = new google.maps.DirectionsRenderer();

                                    let allCoordinates = [];
                                    routes.forEach(route => {
                                        let path = JSON.parse(route.path);
                                        path.forEach(point => {
                                            allCoordinates.push({
                                                lat: point.lat,
                                                lng: point.lng
                                            });
                                        });
                                    });

                                    let bounds = new google.maps.LatLngBounds();
                                    allCoordinates.forEach(coord => {
                                        bounds.extend(coord);
                                    });

                                    map = new google.maps.Map(document.getElementById('map'), {
                                        center: bounds.getCenter(),
                                        zoom: 8,
                                    });

                                    map.fitBounds(bounds);
                                    directionsRenderer.setMap(map);

                                    // Obtener y mostrar la ruta recomendada
                                    routes.forEach(route => {
                                        let path = JSON.parse(route.path);
                                        if (path.length >= 2) {
                                            let origin = new google.maps.LatLng(parseFloat(path[0].lat), parseFloat(path[0].lng));
                                            let destination = new google.maps.LatLng(parseFloat(path[path.length - 1].lat), parseFloat(path[path.length - 1].lng));
                                            calculateAndDisplayRoute(origin, destination);
                                        }
                                    });
                                }

                                function calculateAndDisplayRoute(origin, destination) {
                                    directionsService.route({
                                            origin: origin,
                                            destination: destination,
                                            travelMode: google.maps.TravelMode.DRIVING,
                                        },
                                        (response, status) => {
                                            if (status === google.maps.DirectionsStatus.OK) {
                                                directionsRenderer.setDirections(response);
                                            } else {
                                                window.livewire.emit('showError', {
                                                    message: 'Error in directions request!'
                                                });
                                            }
                                        }
                                    );
                                }

                                // Evento cuando se muestra el modal
                                $('#seeMap').on('shown.bs.modal', function(e) {
                                    window.addEventListener('showMap', event => {
                                        initMap(event.detail.routes);
                                    });
                                });

                                // Evento cuando se oculta el modal
                                $('#seeMap').on('hidden.bs.modal', function(e) {
                                    // Destruimos el mapa
                                    $('#map').html('');
                                    map = null;
                                });

                                window.livewire.on('showError', event => {
                                    alert(event.message);
                                });
                            });
                        </script>

                        <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBOx8agvT4F1RjSW4IS_zgkINQzdFZevik&callback=initMap">
                        </script>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif