@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-12 col-lg-3 d-md-flex">
                <div class="input-group mt-2">
                    <span class="input-group-text">
                        <i class="material-icons notranslate">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search vehicle...">
                </div>
            </div>
            <div class="col-12 col-lg-5 d-flex mt-3 me-4 justify-content-end">
                <div class="dropdown px-4">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons notranslate">expand_more</i>
                    </button>
                    <ul class="dropdown-menu">
                        @can('vehicle.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons notranslate">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div>
                @can('vehicle.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons notranslate">add</i> Add vehicle
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
        @if ($vehicles->count())
        <div>
            <table class="table vehicle-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input wire:model="selectedAll" class="form-check-input" type="checkbox" value="true" id="userCheck55">
                            </div>
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Year</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Make</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Model</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vin</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Driver</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input wire:model="selected" class="form-check-input" type="checkbox" value="{{ $vehicle->id }}" id="vehicleCheck{{ $vehicle->id }}">
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $vehicle->year }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $vehicle->make }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $vehicle->model }}</span>
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $vehicle->vin }}</span>
                            </div>
                        </th>
                        @if($vehicle->driver)
                        <th>{{ $vehicle->driver->name }}</th>
                        @else
                        <th></th>
                        @endif
                        <th>
                            <span class="my-2 text-xs">
                                <a wire:click="selectItem({{ $vehicle->id }}, 'see')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">visibility</i>View
                                </a>
                                @can('vehicle.update')
                                <a wire:click="selectItem({{ $vehicle->id }}, 'update')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>Edit
                                </a>
                                @endcan
                                @can('vehicle.delete')
                                <a wire:click="selectItem({{ $vehicle->id }}, 'delete')" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Delete"><i class="material-icons notranslate text-sm me-2">delete</i>Delete</a>
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
            <span class="text-gray-500"><i class="fas fa-archive"></i> There are no vehicle to show</span>
        </div>
        @endif
        <div class="d-flex justify-content-end py-1 mx-5">
            {{ $vehicles->links() }}
        </div>
    </div>
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createVehicle" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label class="form-label">Year <span class="text-danger"> *</span></label>
                                        <input wire:model="year" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('year'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('year') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Make <span class="text-danger"> *</span></label>
                                        <input wire:model="make" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('make'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('make') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Model <span class="text-danger"> *</span></label>
                                        <input wire:model="model" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('model'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('model') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Vin #</label>
                                        <input wire:model="vin" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('vin'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('vin') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Vehicle #<span class="text-danger">*</span></label>
                                        <input wire:model="number_vehicle" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('number_vehicle'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('number_vehicle') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Driver</label>
                                        <select wire:model.ignore="user_id" class="form-select">
                                            <option value="">Elegir</option>
                                            @foreach ($drivers as $driver)
                                            <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('driver'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('driver') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12"> 
                                        <label class="form-label">Image</label>
                                        <input type="file" wire:model="fileVehicle" wire:key="{{ $image_key }}">
                                        @if ($errors->has('fileVehicle'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('fileVehicle') }}
                                        </div>
                                        @endif

                                        <div class="text-center">
                                            @if ( $fileVehicle )
                                                <img class="w-40 shadow-sm" src="{{ $fileVehicle->temporaryUrl() }}" alt="cambia tu foto">

                                                <div class="text-center">
                                                    <a wire:ignore.self wire:click="deleteImage" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                        <i class="material-icons notranslate text-sm me-2">delete</i>Delete
                                                    </a>
                                                </div>
                                            @elseif($this->seeFileVehicle)
                                                <img class="w-40 shadow-sm" src="{{ Storage::url($seeFileVehicle) }}" alt="cambia tu foto">

                                                <div class="text-center">
                                                    <a wire:ignore.self wire:click="deleteImage" class="btn btn-link text-danger text-gradient px-3 mb-0">
                                                        <i class="material-icons notranslate text-sm me-2">delete</i>Delete
                                                    </a>
                                                </div>
                                            @else
                                                <img class="w-20 rounded-circle shadow-sm" src="{{ asset('assets') }}/img/placeholder.jpg" alt="cambia tu foto">
                                            @endif
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
    <!-- Modal Delete-->
    <div wire:ignore.self class="modal fade" id="deleteVehicle" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deleteVehicleMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="material-icons notranslate">close</i>
                </button>
                </div>
                <div class="modal-body">
                    Deseas eliminar estos {{ $countVehicles }} registros?
                </div>
                <div class="modal-footer">
                    <button wire:click="massiveDelete" class="btn btn-secondary">Eliminar</button>
                    <button type="button" class="btn btn-link text-gray-600 " data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal SeeFileVehicle-->
    <div wire:ignore.self class="modal fade" id="SeeFileVehicle" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                <button type="button" class="btn" data-bs-dismiss="modal">
                    <i class="material-icons notranslate">close</i>
                </button>
                </div>
                <div class="modal-body">
                    @if($this->seeFileVehicle)
                        <img  src="{{ Storage::url($this->seeFileVehicle) }}" alt="vehicle" class="mb-3 w-50 border-radius-lg shadow-sm">
                    @else
                        <img src="{{ asset('assets') }}/img/placeholder.jpg" alt="vehicle" class="mb-3 w-50 border-radius-lg shadow-sm">
                    @endif
                    <div class="table-responsive ">
                        <table class="table align-items-center mb-0 table-striped">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder">Make</span>
                                    </td>
                                    <td>
                                        {{ $this->make }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder">Model</span>
                                    </td>
                                    <td>
                                        {{ $this->model }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder">Year</span>
                                    </td>
                                    <td>
                                        {{ $this->year }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder">Vin #</span>
                                    </td>
                                    <td>
                                        {{ $this->vin }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder">Driver</span>
                                    </td>
                                    <td>
                                        {{ $this->driver }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
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