@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-12 col-lg-3 d-md-flex">
                <div class="input-group mt-2">
                    <span class="input-group-text">
                        <i class="material-icons notranslate">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search patient...">
                </div>
            </div>
            <div class="col-12 col-lg-5 d-flex mt-3 me-4 justify-content-end">
                <!-- <div class="dropdown px-4">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons notranslate">expand_more</i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button wire:click="selectItem('','masiveExport')" class="dropdown-item btn-outline-gray-500"><i class="material-icons notranslate">download</i> Export</button>
                        </li>
                        @can('patient.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons notranslate">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div> -->
                @can('patient.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons notranslate">add</i> Add Patient
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
        @if ($patients->count())
        <div>
            <table class="table Patient-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="userCheck55">
                                <label class="form-check-label" for="userCheck55">
                                </label>
                            </div>
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Service Contract</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="userCheck1">
                                <label class="form-check-label" for="userCheck1">
                                </label>
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $patient->first_name }} {{ $patient->last_name }}</span>
                            </div>
                        </th>
                        @if($patient->service_contract)
                        <th>{{ $patient->service_contract->company }}</th>
                        @else
                        <th></th>
                        @endif
                        <th>
                            <span class="my-2 text-xs">
                                @can('patient.update')
                                <a wire:click="selectItem({{ $patient->id }}, 'update')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>Edit
                                </a>
                                @endcan
                                @can('patient.delete')
                                <a wire:click="selectItem({{ $patient->id }}, 'delete')" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Delete"><i class="material-icons notranslate text-sm me-2">delete</i>Delete</a>
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
            <span class="text-gray-500"><i class="fas fa-archive"></i> There are no patient to show</span>
        </div>
        @endif
        <div class="d-flex justify-content-end py-1 mx-5">
            {{ $patients->links() }}
        </div>
    </div>
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createPatient" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label class="form-label">Contract <span class="text-danger">*</span></label>
                                        <select wire:model="service_contract_id" class="form-select" id="service_contract_id">
                                            <option>Elegir</option>
                                            @foreach ($service_contracts as $service_contract_id)
                                            <option value="{{ $service_contract_id->id }}">{{ $service_contract_id->company }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('service_contract_id'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('service_contract_id') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">First Name</label>
                                        <input wire:model="first_name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('first_name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('first_name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Last Name</label>
                                        <input wire:model="last_name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('last_name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('last_name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Birth Date</label>
                                        <input wire:model="birth_date" class="form-control date-input border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="YYYY/MM/DD">
                                        @if ($errors->has('birth_date'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('birth_date') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Phone 1</label>
                                        <input wire:model="phone1" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('phone1'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('phone1') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Phone 2</label>
                                        <input wire:model="phone2" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('phone2'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('phone2') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Medicateid ID</label>
                                        <input wire:model="medicalid" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('medicalid'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('medicalid') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Billing code</label>
                                        <select wire:model="billing_code" class="form-select" id="billing_code">
                                            <option value="">Select a billing code</option>
                                            <option value="A0100">A0100</option>
                                            <option value="A0120-Ambulatory">A0120 - Ambulatory</option>
                                            <option value="A0130-Wheelchair">A0130 - Wheelchair </option>
                                        </select>
                                        @if ($errors->has('billing_code'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('billing_code') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Emergency Contact</label>
                                        <input wire:model="emergency_contact" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('emergency_contact'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('emergency_contact') }}
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
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Date start</label>
                                        <input wire:model="date_start" class="form-control date-input border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="YYYY/MM/DD">
                                        @if ($errors->has('date_start'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('date_start') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Date end</label>
                                        <input wire:model="date_end" class="form-control date-input border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)" placeholder="YYYY/MM/DD">
                                        @if ($errors->has('date_end'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('date_end') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Description of the patient</label>
                                        <textarea wire:model="observations" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)"></textarea>
                                        @if ($errors->has('observations'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('observations') }}
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
    <div wire:ignore.self class="modal fade" id="deletePatient" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deletePatientMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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

<!-- <script src="{{asset('public/assets/js/users.js') }}"></script> -->