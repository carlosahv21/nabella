@section('title','Roles')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <span class="fas fa-search"></span>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search role...">
                </div>
            </div>
            <div class="col-5 col-lg-5 d-flex justify-content-end mt-3 me-4">
                <div class="dropdown px-2">
                    <button class="btn btn-white dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><button wire:click="selectItem('','masiveExport')" class="dropdown-item btn-outline-gray-500"><i class="fas fa-download me-2"></i> Export</button></li>
                        <li><button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="fas fa-trash me-2"></i> Delete</button></li>
                    </ul>
                </div>

                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <span class="fas fa-plus"></span> Add Role
                </button>
            </div>
        </div>
    </div>
    <div class="card shadow border-0 table-wrapper table-responsive">
        @if ($roles->count())
        <div wire:loading.class.delay="opacity-5">
            <table class="table role-table align-items-center">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="roleCheck55">
                                <label class="form-check-label" for="roleCheck55">
                                </label>
                            </div>
                        </th>
                        <th>Name</th>
                        <th>permisions</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input class="form-check-input" type="checkbox" value="" id="roleCheck1">
                                <label class="form-check-label" for="roleCheck1">
                                </label>
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $role->name }}</span>
                            </div>
                        </th>
                        <th>{{ $role->permisions }}</th>
                        <th>
                            <span class="my-2 text-xs">
                                <a wire:click="selectItem({{ $role->id }}, 'update')" class="mx-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                    <i class="fas fa-role-edit" aria-hidden="true"></i>
                                </a>
                                <a wire:click="selectItem({{ $role->id }}, 'delete')" class="mx-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                    <i class="cursor-pointer fas fa-trash" aria-hidden="true"></i>
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
            <span class="text-gray-500"><i class="fas fa-archive"></i> There are no users to show </span>
        </div>
        @endif
    </div>
    @if($roles->links())
    <div class="d-flex justify-content-end py-4">
        {{ $roles->links()}}
    </div>
    @endif
    <!-- Modal Add-->
    <div wire:ignore.self class="modal fade" id="createRole" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
                                        <label class="form-label">Name</label>
                                        <input wire:model="name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">permisions</label>
                                        <input wire:model="permisions" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('permisions'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('permisions') }}
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
    <div wire:ignore.self class="modal fade" id="deleteRole" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deleteRoleMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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