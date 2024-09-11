@section('title','Roles')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <i class="material-icons notranslate">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search role...">
                </div>
            </div>
            <div class="col-5 col-lg-5 d-flex justify-content-end mt-3 me-4 justify-content-end">
                <!-- <div class="dropdown px-2">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons notranslate">expand_more</i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li>
                            <button wire:click="selectItem('','masiveExport')" class="dropdown-item btn-outline-gray-500"><i class="material-icons notranslate">download</i> Export</button>
                        </li>
                        @can('role.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons notranslate">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div> -->
                @can('role.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons notranslate">add</i> Add Role
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
        @if ($roles->count())
        <div>
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
                                @can('role.update', $role)
                                <a wire:click="selectItem({{ $role->id }}, 'update')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>Edit
                                </a>
                                @endcan
                                @can('role.delete', $role)
                                <a wire:click="selectItem({{ $role->id }}, 'delete')" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Delete"><i class="material-icons notranslate text-sm me-2">delete</i>Delete</a>
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
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Name</label>
                                        <input wire:model="name" type="text" class="form-control border border-2 p-2" onfocus="focused(this)" onfocusout="defocused(this)">
                                        @if ($errors->has('name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Permissions</label>
                                    </div>
                                    <div class="mb-3 col-md-12">
                                        <div class="table-responsive">
                                            <table class="table align-items-center mb-0">
                                                <thead>
                                                    <tr>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Module</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">View</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Create</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Update</th>
                                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Delete</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php
                                                    $permissionMap = [];

                                                    // Clasificar los permisos por módulo y acción
                                                    foreach ($permissions as $permission) {
                                                    [$module, $action] = explode('.', $permission->name);
                                                    $permissionMap[$module][$action] = $permission;
                                                    }

                                                    $modules = array_keys($permissionMap);
                                                    @endphp

                                                    @foreach ($modules as $module)
                                                    @php
                                                    $view = $permissionMap[$module]['view'] ?? null;
                                                    $create = $permissionMap[$module]['create'] ?? null;
                                                    $update = $permissionMap[$module]['update'] ?? null;
                                                    $delete = $permissionMap[$module]['delete'] ?? null;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex px-2 py-1">
                                                                <div class="d-flex flex-column justify-content-center">
                                                                    <h6 class="mb-0 text-xs">{{ ucfirst($module) }}</h6>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if ($view)
                                                            <div class="form-check">
                                                                <input type="checkbox" wire:model="checkPermitions" value="{{ $view ? $view->id : ''}}" id="fcustomCheck{{ $view ? $view->id : '' }}" data-name="{{ $view ? $view->name : '' }}">
                                                            </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($create)
                                                            <div class="form-check">
                                                                <input type="checkbox" wire:model="checkPermitions" value="{{ $create ? $create->id : ''}}" id="fcustomCheck{{ $create ? $create->id : '' }}" data-name="{{ $create ? $create->name : '' }}">
                                                            </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($update)
                                                            <div class="form-check">
                                                                <input type="checkbox" wire:model="checkPermitions" value="{{ $update ? $update->id : ''}}" id="fcustomCheck{{ $update ? $update->id : '' }}" data-name="{{ $update ? $update->name : '' }}">
                                                            </div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if ($delete)
                                                            <div class="form-check">
                                                                <input type="checkbox" wire:model="checkPermitions" value="{{  $delete ? $delete->id : ''}}" id="fcustomCheck{{  $delete ? $delete->id : '' }}" data-name="{{  $delete ? $delete->name : '' }}">
                                                            </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
    <div wire:ignore.self class="modal fade" id="deleteRole" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
    <div wire:ignore.self class="modal fade" id="deleteRoleMasive" tabindex="-1" aria-labelledby="modal-default" style="display: none;" aria-hidden="true">
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
</div>