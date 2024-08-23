<div class="container-fluid my-3 py-3">
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

    <div class="row mb-5">
        <div class="col-lg-12 mt-lg-0 mt-4">
            <div class="card card-body" id="profile">
                <div class="row justify-content-center align-items-center">
                    <div class="col-sm-auto col-8 my-auto">
                        <div class="h-100">
                            <h5 class="mb-1 font-weight-bolder">
                                {{ $user->name }}
                            </h5>
                            <p class="mb-0 font-weight-normal text-sm">
                                {{ $role->name }} / {{ $user->email }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                        <label class="form-check-label mb-0">
                            <small id="profileVisibility">
                                Switch to inactive
                            </small>
                        </label>
                        <div class="form-check form-switch ms-2 my-auto is-filled">
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault23" checked="" onchange="visible()">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4" id="basic-info">
                <div class="card-header">
                    <h5>Basic Info</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-6 mt-md-0 mt-4 position-relative">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <div class="row">
                                        <div class="col-md-8 d-flex align-items-center">
                                            <h6 class="mb-0">Profile Information</h6>
                                        </div>
                                        <div class="col-md-4 text-end">
                                            <a href="javascript:;">
                                                <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <hr class="horizontal gray-light mt-1">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Full Name:</strong> &nbsp; {{ $user->name }}</li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Mobile:</strong> &nbsp; {{ $user->phone }}</li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Email:</strong> &nbsp; {{ $user->email }}</li>
                                        <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Location:</strong> &nbsp; {{ $user->location }}</li>
                                    </ul>
                                </div>
                            </div>
                            <hr class="vertical dark">
                        </div>
                        <div class="col-12 col-xl-6 mt-xl-0 mt-4">
                            <div class="card card-plain h-100">
                                <div class="card-header pb-0 p-3">
                                    <h6 class="mb-0">Data Completed</h6>
                                </div>
                                <div class="card-body p-3">
                                    <ul class="list-group">
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                    <i class="material-icons notranslate opacity-10 ">launch</i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">Devices</h6>
                                                    <span class="text-xs">250 in stock, <span class="font-weight-bold">346+
                                                            sold</span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                    <i class="material-icons notranslate opacity-10 ">book_online</i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">Tickets</h6>
                                                    <span class="text-xs">123 closed, <span class="font-weight-bold">15
                                                            open</span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                    <i class="material-icons notranslate opacity-10 ">priority_high</i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">Error logs</h6>
                                                    <span class="text-xs">1 is active, <span class="font-weight-bold">40
                                                            closed</span></span>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                            </div>
                                        </li>
                                        <li class="list-group-item border-0 d-flex justify-content-between ps-0 border-radius-lg">
                                            <div class="d-flex align-items-center">
                                                <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                                    <i class="material-icons notranslate opacity-10 ">insert_emoticon</i>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <h6 class="mb-1 text-dark text-sm">Happy users</h6>
                                                    <span class="text-xs font-weight-bold">+ 430</span>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <button class="btn btn-link btn-icon-only btn-rounded btn-sm text-dark icon-move-right my-auto"><i class="ni ni-bold-right" aria-hidden="true"></i></button>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="input-group input-group-outline mt-4">
                        <input wire:model="new_password" type="password" class="form-control" placeholder="New Password">
                    </div>
                    <div class="input-group input-group-outline mt-4">
                        <input wire:model="confirmationPassword" type="password" class="form-control" placeholder="Confirm New Password">
                    </div>
                    <button class="btn bg-gradient-dark btn-sm mt-6 mb-0" wire:click="passwordUpdate">Update password</button>
                </div>
            </div>
        </div>
    </div>
</div>