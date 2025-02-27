<div>
    <!-- Selector de Tabla -->
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group ms-5">
                    <span class="input-group-text">
                        <i class="material-icons notranslate">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search {{$table}}...">
                </div>
            </div>
            <div class="col-3 col-lg-3 d-md-flex">
                <div class="input-group me-3 my-2">
                    <select wire:model="table" class="form-select" id="service_contract_id">
                        <option value="">Select a table</option>
                        <option value="users">Users</option>
                        <option value="drivers">Drivers</option>
                        <option value="vehicles">Vehicles</option>
                        <option value="service_contracts">Service Contracts</option>
                        <option value="patients">Patients</option>
                        <option value="facilities">Facilities</option>
                        <option value="schedulings">Schedulings</option>
                    </select>
                </div>
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

    <!-- Tabla Dinámica -->
    <div class="card shadow border-0 table-wrapper table-responsive">
        @if ($records->count())
        <table class="table user-table align-items-center">
            <thead class="thead-dark">
                <tr>
                    <th>
                        <div class="form-check dashboard-check">
                            <input wire:model="selectedAll" class="form-check-input" type="checkbox" value="true" id="userCheck55">
                        </div>
                    </th>
                    @foreach ($columns as $column)
                        <th>
                            {{ $column['label'] }}
                        </th>
                    @endforeach
                    <th>
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($records as $record)
                <tr>
                    <td>
                        <div class="d-block">
                            <div class="form-check dashboard-check">
                                <input wire:model="selected" class="form-check-input" type="checkbox" value="{{ $record->id }}">
                            </div>
                        </div>
                    </td>
                    @foreach ($columns as $column)
                        <td>
                            <div class="d-block">
                                <span class="fw-bold">{{ $record->{$column['key']} }}</span>
                            </div>
                        </td>
                    @endforeach
                    <td>
                        <a wire:click="confirmDelete({{ $record->id }})" class="btn btn-link text-dark text-gradient px-3 mb-0">
                            <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Delete">delete</i>Delete
                        </a>
                        <a wire:click="confirmRestore({{ $record->id }})" class="btn btn-link text-dark text-gradient px-3 mb-0">
                            <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Restore">restore_from_trash</i>Restore
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $records->links() }}
        @else
        <div class="d-flex justify-content-center py-6">
            <span class="text-muted">No hay registros eliminados</span>
        </div>
        @endif
    </div>

    <!-- Modales -->
    <!-- Modal Restaurar -->
    <div wire:ignore.self class="modal fade" id="revertModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Restaurar Registro</h5>
                </div>
                <div class="modal-body">
                    ¿Deseas restaurar este registro?
                </div>
                <div class="modal-footer">
                    <button wire:click="restore" class="btn btn-secondary">Confirmar</button>
                    <button class="btn btn-link text-gray-600" data-bs-dismiss="modal">Cancelar</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal Eliminar -->
    <div wire:ignore.self class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Eliminar Permanentemente</h5>
                </div>
                <div class="modal-body">
                    <p>
                    ¿Deseas eliminar este registro definitivamente? 
                    <br/>
                    <b>Nota: Esta acción no se puede deshacer.</b>
                    </p>
                </div>
                <div class="modal-footer">
                    <button wire:click="delete" class="btn btn-secondary">Confirmar</button>
                    <button class="btn btn-link text-gray-600 " data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>