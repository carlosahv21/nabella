@section('title','Roles')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <i class="material-icons">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search role...">
                </div>
            </div>
            <div class="col-5 col-lg-5 d-flex justify-content-end mt-3 me-4">
                <div class="dropdown px-2">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons">expand_more</i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <button wire:click="selectItem('','masiveExport')" class="dropdown-item btn-outline-gray-500"><i class="material-icons">download</i> Export</button>
                        </li>
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons">delete</i> Delete</button>
                        </li>
                    </ul>
                </div>

                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons">add</i> Add Role
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
                                <input type="checkbox" value="" id="roleCheck55">
                                <label class="form-check-label" for="roleCheck55">
                                </label>
                            </div>
                        </th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <th>
                            <div class="form-check dashboard-check">
                                <input type="checkbox" value="" id="roleCheck1">
                                <label class="form-check-label" for="roleCheck1">
                                </label>
                            </div>
                        </th>
                        <th>
                            <div class="d-block">
                                <span class="fw-bold">{{ $role->name }}</span>
                            </div>
                        </th>
                        <th>
                            <span class="my-2 text-xs">
                                <a wire:click="selectItem({{ $role->id }}, 'permitions')" class="mx-2 pointer">
                                    <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="Edit">visibility</i>
                                </a>
                                <a wire:click="selectItem({{ $role->id }}, 'update')" class="mx-2 pointer">
                                    <i class="material-icons" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>
                                </a>
                                <a wire:click="selectItem({{ $role->id }}, 'delete')" class="mx-2 pointer">
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

    <!-- Modal Delete Masive-->
    <div wire:ignore.self class="modal fade" id="rolePermitions" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{$title_modal}}</h2>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Module</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">See</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Create/Edit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs">Drivers</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" value="" id="fcustomCheck" checked="">
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <input type="checkbox" value="" id="fcustomCheck1" checked="">
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="checkbox" value="" id="fcustomCheck2">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-xs">Vehicle</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check">
                                                <input type="checkbox" value="" id="fcustomCheck1" checked="">
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm">
                                            <input type="checkbox" value="" id="fcustomCheck1">
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="checkbox" value="" id="fcustomCheck1" >
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
</div>