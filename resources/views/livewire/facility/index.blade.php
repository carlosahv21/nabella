@php
use App\Models\Address;
@endphp

@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-12 col-lg-3 d-md-flex">
                <div class="input-group mt-2">
                    <span class="input-group-text">
                        <i class="material-icons notranslate">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search facilities...">
                </div>
            </div>
            <div class="col-12 col-lg-5 d-flex mt-3 me-4 justify-content-end">
                <div class="dropdown px-4">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons notranslate">expand_more</i>
                    </button>
                    <ul class="dropdown-menu">
                        @can('facility.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons notranslate">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div>
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons notranslate">add</i> Add Facility
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
    <div class="card shadow border-0 table-wrapper table-responsive">
        @if ($facilities->count())
        <div>
            <table class="table facilities-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input wire:model="selectedAll" class="form-check-input" type="checkbox" value="true" id="userCheck55">
                            </div>
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($facilities as $_facility)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input wire:model="selected" class="form-check-input" type="checkbox" value="{{ $_facility->id }}" id="facilityCheck{{ $_facility->id }}">
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $_facility->name }}</span>
                            </div>
                        </th>
                        <th>
                            <span class="my-2 text-xs">
                                @can('facility.update')
                                <a wire:click="selectItem({{ $_facility->id }}, 'update')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>Edit
                                </a>
                                @endcan
                                @can('facility.delete')
                                <a wire:click="selectItem({{ $_facility->id }}, 'delete')" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Delete"><i class="material-icons notranslate text-sm me-2">delete</i>Delete</a>
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
            <span class="text-gray-500"><i class="fas fa-archive"></i> There are no facilities to show</span>
        </div>
        @endif
        <div class="d-flex justify-content-end py-1 mx-5">
            {{ $facilities->links() }}
        </div>
    </div>
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createFacility" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label class="form-label">Name of the Facility <span class="text-danger">*</span></label>
                                        <input wire:model="name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6 col-lg-6">
                                        <label class="form-label">Service Contract</label>
                                        <select wire:model="service_contract_id" class="form-control border border-2 p-2">
                                            <option value="">Select a service contract</option>
                                            @foreach ($service_contracts as $service_contract)
                                            <option value="{{ $service_contract->id }}">{{ $service_contract->company }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('service_contract_id'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('service_contract_id') }}
                                        </div>
                                        @endif
                                    </div>
                                    @if(count($inputs_view) > 0)
                                    <div class="row">
                                        <hr class="dark horizontal">
                                        <label class="form-label">Created addresses</label>
                                        @foreach($inputs_view as $index => $input)
                                        <div class="col-md-12">
                                            <label class="form-label">
                                                <i class="material-icons notranslate">location_on</i>
                                                {{ $input->address }} </label>
                                            <button type="button" class="btn btn-link text-danger text-gradient px-3 mb-0" wire:click="removeAddress({{ $index}}, {{ $input->id }})">
                                                <i class="material-icons notranslate">delete</i>
                                            </button>
                                        </div>
                                        @endforeach
                                        <hr class="dark horizontal">
                                    </div>
                                    @endif
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Address</label>
                                        <button type="button" wire:click="addInput" class="btn btn-link text-dark text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Add address">
                                            <i class="material-icons notranslate">add</i>
                                        </button>
                                        <!-- Add new address -->
                                        @foreach($inputs as $index => $input)
                                        <div class="row mb-3 me-3">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control border border-2 p-2" wire:model="inputs.{{ $index }}" placeholder="Address and city">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" class="form-control border border-2 p-2" wire:model="state.{{ $index }}" placeholder="State">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="form-control border border-2 p-2" wire:model="zipcode.{{ $index }}" placeholder="Zipcode">
                                            </div>
                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-link text-danger text-gradient px-3 mb-0" wire:click="removeInput({{ $index }})">
                                                    <i class="material-icons notranslate">delete</i>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
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
    <div wire:ignore.self class="modal fade" id="deleteFacility" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deleteFacilityMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h5>
                    <button type="button" class="btn" data-bs-dismiss="modal">
                        <i class="material-icons notranslate">close</i>
                    </button>
                </div>
                <div class="modal-body">
                    Deseas eliminar estos {{ $countFacilities }} registros?
                </div>
                <div class="modal-footer">
                    <button wire:click="masiveDelete" class="btn btn-secondary">Eliminar</button>
                    <button type="button" class="btn btn-link text-gray-600 " data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="{{asset('public/assets/js/users.js') }}"></script> -->