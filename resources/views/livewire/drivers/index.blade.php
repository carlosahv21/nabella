@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-12 col-lg-3 d-md-flex">
                <div class="input-group mt-2">
                    <span class="input-group-text">
                        <i class="material-icons notranslate">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search driver...">
                </div>
            </div>
            <div class="col-12 col-lg-5 d-flex mt-3 me-4 justify-content-end">
                <div class="dropdown px-4">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons notranslate">expand_more</i>
                    </button>
                    <ul class="dropdown-menu">
                        @can('driver.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons notranslate">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div>
                @can('driver.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons notranslate">add</i> Add Driver
                </button>
                @endcan
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
    <div class="card shadow border-0 table-wrapper table-responsive">
        @if ($drivers->count())
        <div>
            <table class="table driver-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input wire:model="selectedAll" class="form-check-input" type="checkbox" value="true" id="userCheck55">
                                </label>
                            </div>
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($drivers as $driver)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input wire:model="selected" class="form-check-input" type="checkbox" value="{{ $driver->id }}" id="driverCheck{{ $driver->id }}">
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $driver->name }}</span>
                                <div class="small text-gray">{{ $driver->email }}</div>
                            </div>
                        </th>
                        <th>
                            <span class="my-2 text-xs">
                                @can('driver.view')
                                <a wire:click="selectItem({{ $driver->id }}, 'see')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="See details">visibility</i>View
                                </a>
                                @endcan
                                @can('driver.update')
                                <a wire:click="selectItem({{ $driver->id }}, 'update')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>Edit
                                </a>
                                @endcan
                                @can('driver.delete')
                                <a wire:click="selectItem({{ $driver->id }}, 'delete')" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Delete"><i class="material-icons notranslate text-sm me-2">delete</i>Delete</a>
                                @endcan
                            </span>
                        </th>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="d-flex justify-content-center py-6">
            <span class="text-gray-500"><i class="fas fa-archive"></i> There are no users to show</span>
        </div>
        @endif
        <div class="d-flex justify-content-end py-1 mx-5">
            {{ $drivers->links() }}
        </div>
    </div>
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createDriver" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label class="form-label">Email address <span class="text-danger"> *</span></label>
                                        <input wire:model="email" type="email" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('email'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('email') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Name<span class="text-danger"> *</span></label>
                                        <input wire:model="name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Phone</label>

                                        <div class="input-group">
                                            <!-- Campo para el prefijo -->
                                            <select wire:model="phone_prefix" class="form-select" style="max-width: 90px;">
                                                @foreach ($prefixs as $prefix => $name)
                                                <option value="{{ $prefix }}">{{ $name }}</option>
                                                @endforeach
                                                <!-- Agrega más opciones según sea necesario -->
                                            </select>

                                            <!-- Campo para el número de teléfono -->
                                            <input wire:model="phone" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                        @if ($errors->has('phone'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('phone') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">DOB</label>
                                        <input wire:model="dob" class="form-control border border-2 p-2 date-input" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('dob'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('dob') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">DL State</label>
                                        <input wire:model="dl_state" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('dl_state'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('dl_state') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">DL Number</label>
                                        <input wire:model="dl_number" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('dl_number'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('dl_number') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Date of Hire</label>
                                        <input wire:model="date_of_hire" class="form-control border border-2 p-2 date-input" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('date_of_hire'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('date_of_hire') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label>Color</label>
                                        <input type="color" class="form-control" wire:model="driver_color">
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
    <div wire:ignore.self class="modal fade" id="deleteDriver" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="material-icons notranslate">close</i>
                    </button>
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
    <div wire:ignore.self class="modal fade" id="deleteDriverMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="material-icons notranslate">close</i>
                    </button>
                </div>
                <div class="modal-body">
                    Deseas eliminar estos {{ $countDrivers }} registros?
                </div>
                <div class="modal-footer">
                    <button wire:click="massiveDelete" class="btn btn-secondary">Eliminar</button>
                    <button type="button" class="btn btn-link text-gray-600 " data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal SeeFileVehicle-->
    <div wire:ignore.self class="modal fade" id="seeDriver" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                        <div class="table-responsive ">
                            <table class="table align-items-center mb-0 table-striped">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">Name</span>
                                        </td>
                                        <td>
                                            {{ $this->name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">Email</span>
                                        </td>
                                        <td>
                                            {{ $this->email }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">Phone</span>
                                        </td>
                                        <td>
                                            {{ $this->phone_prefix}} {{ $this->phone }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">DOB</span>
                                        </td>
                                        <td>
                                            {{ $this->dob }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">Dl State</span>
                                        </td>
                                        <td>
                                            {{ $this->dl_state }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">Dl Number</span>
                                        </td>
                                        <td>
                                            {{ $this->dl_number }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">Date of Hire</span>
                                        </td>
                                        <td>
                                            {{ $this->date_of_hire }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="font-weight-bolder">Driver Color</span>
                                        </td>
                                        <td>
                                            <input type="color" class="form-control" wire:model="driver_color" disabled="disabled">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-gray-600 " data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="{{asset('public/assets/js/users.js') }}"></script> -->