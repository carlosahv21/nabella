@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <i class="material-icons">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search client...">
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
                        @can('client.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div>
                @can('client.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons">add</i> Add Client
                </button>
                @endcan
            </div>
        </div>
    </div>
    <!-- notifications -->
    <div class="position-fixed top-2 end-2 z-index-2">
        <div class="toast fade hide p-2 bg-white bg-gradient-{{ session('alert.type', 'info') }}" role="alert" aria-live="assertive" id="toast" data-bs-delay="2000">
            <div class="toast-header bg-transparent text-white border-0">
                <i class="material-icons me-2">
                    {{ session('alert.icon') }}
                </i>
                <span class="me-auto font-weight-bold">Notification!</span>
                <i class="material-icons cursor-pointer" data-bs-dismiss="toast" aria-label="Close">close</i>
            </div>
            <hr class="horizontal light m-0">
            <div class="toast-body text-white ">
                {{ session('alert.message') }}
            </div>
        </div>
    </div>
    <!-- end notifications -->
    <div class="card shadow border-0 table-wrapper table-responsive">
        @if ($clients->count())
        <div>
            <table class="table Client-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="userCheck55">
                                <label class="form-check-label" for="userCheck55">
                                </label>
                            </div>
                        </th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Company</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Contact Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Rate Per Mile</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
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
                                <span class="fw-bold">{{ $client->company }}</span>
                            </div>
                        </th>
                        <th>{{ $client->contact_name }}</th>
                        <th>$ {{ $client->rate_per_mile }}</th>
                        <th>
                            <span class="my-2 text-xs">
                                @can('client.update')
                                <a wire:click="selectItem({{ $client->id }}, 'update')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>Edit
                                </a>
                                @endcan
                                @can('client.delete')
                                <a wire:click="selectItem({{ $client->id }}, 'delete')" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Delete"><i class="material-icons text-sm me-2">delete</i>Delete</a>
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
            <span class="text-gray-500"><i class="fas fa-archive"></i> There are no client to show</span>
        </div>
        @endif
    </div>
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createClient" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label class="form-label">Company</label>
                                        <input wire:model="company" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('company'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('company') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Contact Name</label>
                                        <input wire:model="contact_name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('contact_name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('contact_name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Rate Per Mile</label>
                                        <input wire:model="rate_per_mile" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('rate_per_mile'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('rate_per_mile') }}
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
    <div wire:ignore.self class="modal fade" id="deleteClient" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deleteClientMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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