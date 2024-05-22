@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <i class="material-icons">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search vehicle...">
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
                        @can('vehicle.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div>
                @can('vehicle.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons">add</i> Add vehicle
                </button>
                @endcan
            </div>
        </div>
    </div>
    <div class="card shadow border-0 table-wrapper table-responsive">
        @if ($vehicles->count())
        <div wire:loading.class.delay="opacity-5">
            <table class="table vehicle-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="userCheck55">
                                <label class="form-check-label" for="userCheck55">
                                </label>
                            </div>
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Model</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="userCheck1">
                                <label class="form-check-label" for="userCheck1">
                                </label>
                            </div>
                        </th>
                        <th>{{ $vehicle->brand }}</th>
                        <th>{{ $vehicle->model }}</th>
                        <th>
                            <span class="my-2 text-xs">
                                <a wire:click="selectItem({{ $vehicle->id }}, 'see')" class="mx-2 pointer">
                                    <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="See file">visibility</i>
                                </a>
                                @can('vehicle.update', $vehicle)
                                <a wire:click="selectItem({{ $vehicle->id }}, 'update')" class="mx-2 pointer">
                                    <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>
                                </a>
                                @endcan
                                <a wire:click="selectItem({{ $vehicle->id }}, 'delete')" class="mx-2 pointer">
                                    <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="Delete">delete</i>
                                </a>
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
    </div>
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createVehicle" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h2>
                </div>
                <div class="modal-body">
                    <div class="card card-plain h-100">
                        <div class="card-body p-3">
                            <form>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Year</label>
                                        <input wire:model="year" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('year'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('year') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Make</label>
                                        <input wire:model="brand" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('brand'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('brand') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Model</label>
                                        <input wire:model="model" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('model'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('model') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Vin #</label>
                                        <input wire:model="color" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('color'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('color') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Value</label>
                                        <input wire:model="car_plate" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('car_plate'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('car_plate') }}
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
    <!-- Modal Delete-->
    <div wire:ignore.self class="modal fade" id="deleteVehicle" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deleteVehicleMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <!-- Modal SeeFileVehicle-->
    <div wire:ignore.self class="modal fade" id="SeeFileVehicle" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h2>
                </div>
                <div class="modal-body">
                    <img src="https://i.pinimg.com/736x/bc/c8/ee/bcc8ee6f1b51e5d9900a91141105e50c.jpg" alt="cherry" class="mb-3 w-50 border-radius-lg shadow-sm">
                    <div class="table-responsive ">
                        <table class="table align-items-center mb-0 table-striped">
                            <tbody>
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder">Make</span>
                                    </td>
                                    <td>
                                        {{ $this->brand }}
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
                                        {{ $this->color }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="font-weight-bolder">Value</span>
                                    </td>
                                    <td>
                                        ${{ $this->car_plate }}
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