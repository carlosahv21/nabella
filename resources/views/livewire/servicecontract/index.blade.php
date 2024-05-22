@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <i class="material-icons">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search service contract...">
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
                        @can('servicecontract.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div>

                @can('servicecontract.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons">add</i> Add Service Contract
                </button>
                @endcan
            </div>
        </div>
    </div>
    <div class="card shadow border-0 table-wrapper table-responsive">
        @if ($servicecontracts->count())
        <div>
            <table class="table servicecontract-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="userCheck55">
                                <label class="form-check-label" for="userCheck55">
                                </label>
                            </div>
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Subject</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date start - Date end</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Client</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($servicecontracts as $servicecontract)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="userCheck1">
                                <label class="form-check-label" for="userCheck1">
                                </label>
                            </div>
                        </th>
                        <th>{{ $servicecontract->subject }}</th>
                        <th>{{ \Carbon\Carbon::parse($servicecontract->date_start)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($servicecontract->date_end)->format('d/m/Y')}}</th>

                        <!-- <th>{{ $servicecontract->date_start }} / {{ $servicecontract->date_end }}</th> -->
                        <th><a href="{{ route('client') }}"> {{ $servicecontract->client->company }}</a></th>
                        <th>
                            <span class="my-2 text-xs">
                                @can('servicecontract.update')
                                <a wire:click="selectItem({{ $servicecontract->id }}, 'update')" class="mx-2 pointer">
                                    <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>
                                </a>
                                @endcan
                                @can('servicecontract.delete')
                                <a wire:click="selectItem({{ $servicecontract->id }}, 'delete')" class="mx-2 pointer">
                                    <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="Delete">delete</i>
                                </a>
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
    </div>
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createServiceContract" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label class="form-label">Subject</label>
                                        <input wire:model="subject" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('subject'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('subject') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">State</label>
                                        <select wire:ignore.self wire:model="state" class="form-select"  id="state">
                                            <option>Elegir</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Date Start</label>
                                        <input wire:model="date_start" type="date" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('date_start'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('date_start') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Date End</label>
                                        <input wire:model="date_end" type="date" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('date_end'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('date_end') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Client Owner</label>
                                        <select wire:ignore.self wire:model="client_id" class="form-select"  id="client_id">
                                            <option>Elegir</option>
                                            @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->company }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('client_id'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('client_id') }}
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
    <div wire:ignore.self class="modal fade" id="deleteServiceContract" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deleteServiceContractMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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

    <!-- <script src="{{asset('public/assets/js/users.js') }}"></script> -->