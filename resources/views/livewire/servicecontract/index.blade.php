@section('title','Usuario')

<div>
    <div class="table-settings mx-3 my-4">
        <div class="row justify-content-between align-items-center bg-white rounded-3">
            <div class="col-12 col-lg-3 d-md-flex">
                <div class="input-group mt-2">
                    <span class="input-group-text">
                        <i class="material-icons notranslate">search</i>
                    </span>
                    <input wire:model="search" type="text" class="form-control" placeholder="Search service contract...">
                </div>
            </div>
            <div class="col-12 col-lg-5 d-flex mt-3 me-4 justify-content-end">
                <!-- <div class="dropdown">
                    <button class="btn btn-white" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        Mass action <i class="material-icons notranslate">expand_more</i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <button wire:click="selectItem('','masiveExport')" class="dropdown-item btn-outline-gray-500"><i class="material-icons notranslate">download</i> Export</button>
                        </li>
                        @can('servicecontract.delete')
                        <li>
                            <button wire:click="selectItem('','masiveDelete')" class="dropdown-item btn-outline-gray-500 text-danger"><i class="material-icons notranslate">delete</i> Delete</button>
                        </li>
                        @endcan
                    </ul>
                </div> -->
                @can('servicecontract.create')
                <button class="btn bg-gradient-dark " wire:click="selectItem('', 'create')">
                    <i class="material-icons notranslate">add</i> Add Service Contract
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
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Start date - End date</th>
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
                        <th>{{ \Carbon\Carbon::parse($servicecontract->date_start)->format('d/m/Y')}} - {{ \Carbon\Carbon::parse($servicecontract->date_end)->format('d/m/Y')}}</th>
                        <th> {{ $servicecontract->company }}</th>
                        <th>
                            <span class="my-2 text-xs">
                                @can('servicecontract.update')
                                <a wire:click="selectItem({{ $servicecontract->id }}, 'update')" class="btn btn-link text-dark text-gradient px-3 mb-0">
                                    <i class="material-icons notranslate text-sm me-2" data-bs-toggle="tooltip" data-bs-original-title="Edit">edit</i>Edit
                                </a>
                                @endcan
                                @can('servicecontract.delete')
                                <a wire:click="selectItem({{ $servicecontract->id }}, 'delete')" class="btn btn-link text-danger text-gradient px-3 mb-0" data-bs-toggle="tooltip" data-bs-original-title="Delete"><i class="material-icons notranslate text-sm me-2">delete</i>Delete</a>
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
            <span class="text-gray-500"><i class="fas fa-archive"></i> There are no service contracts to show</span>
        </div>
        @endif
        <div class="d-flex justify-content-end py-1 mx-5">
            {{ $servicecontracts->links() }}
        </div>
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
                        <div class="card-body p-0">
                            <form>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label wire.ignore.self class="form-label">Company</label>
                                        <input  wire:model="company" type="text" class="form-control border border-2 p-2">
                                        @if ($errors->has('company'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('company') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Contact Name</label>
                                        <input wire:model="contact_name" type="text" class="form-control border border-2 p-2">
                                        @if ($errors->has('contact_name'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('contact_name') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Customer address</label>
                                        <input wire:model="address" type="text" class="form-control border border-2 p-2">
                                        @if ($errors->has('address'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('address') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Customer phone</label>
                                        <input wire:model="phone" type="text" class="form-control border border-2 p-2">
                                        @if ($errors->has('phone'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('phone') }}
                                        </div>
                                        @endif
                                    </div>
                                    <hr class="dark horizontal">
                                    <label class="form-label mb-3">Rate config</label>
                                    <hr class="dark horizontal">
                                    <div class="my-3 col-md-3 col-3">
                                        <div  class="input-group input-group-dynamic mb-4 is-filled">
                                            <label class="form-label">Wheelchair</label>
                                            <input wire:model="wheelchair" type="text" class="form-control" min="0" placeholder="0" >
                                        </div>
                                        @if ($errors->has('wheelchair'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('wheelchair') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="my-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled">
                                            <label class="form-label">Ambulatory</label>
                                            <input wire:model="ambulatory" type="text" class="form-control" min="0" placeholder="0">
                                        </div>
                                        @if ($errors->has('ambulatory'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('ambulatory') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="my-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled">
                                            <label class="form-label">After Hours</label>
                                            <input wire:model="out_of_hours" type="text" min="0" placeholder="0" class="form-control" >
                                        </div>
                                        @if ($errors->has('out_of_hours'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('out_of_hours') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="my-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled"> 
                                            <label class="form-label">Saturdays</label>
                                            <input wire:model="saturdays" type="text" min="0" placeholder="0" class="form-control" >
                                        </div>
                                        @if ($errors->has('saturdays'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('saturdays') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled">
                                            <label class="form-label">Sundays/Holidays</label>
                                            <input wire:model="sundays_holidays" type="text" min="0" placeholder="0" class="form-control" >
                                        </div>
                                        @if ($errors->has('sundays_holidays'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('sundays_holidays') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled">
                                            <label class="form-label">Accompanist</label>
                                            <input wire:model="companion" type="text" min="0" placeholder="0" class="form-control" >
                                        </div>
                                        @if ($errors->has('companion'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('companion') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled">
                                            <label class="form-label">Additional waiting</label>
                                            <input wire:model="additional_waiting" type="text" min="0" placeholder="0" class="form-control" >
                                        </div>
                                        @if ($errors->has('additional_waiting'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('additional_waiting') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled">
                                            <label class="form-label">After</label>
                                            <span class="input-group-text">Min</span>
                                            <input wire:model="after" type="text" class="form-control" >
                                        </div>
                                        @if ($errors->has('after'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('after') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled"> 
                                            <label class="form-label">Quick Pass</label>
                                            <input wire:model="fast_track" type="text" class="form-control" min="0" placeholder="0" >
                                        </div>
                                        @if ($errors->has('fast_track'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('fast_track') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled"> 
                                            <label class="form-label">If not cancel</label>
                                            <input wire:model="if_not_cancel" type="text"  class="form-control" min="0" placeholder="0" >
                                        </div>
                                        @if ($errors->has('if_not_cancel'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('if_not_cancel') }}
                                        </div>
                                        @endif
                                    </div>

                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled"> 
                                            <label class="form-label">Rate Per Mile</label>
                                            <input wire:model="rate_per_mile" type="text" class="form-control" min="0" placeholder="0" >
                                        </div>
                                        @if ($errors->has('rate_per_mile'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('rate_per_mile') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-3 col-3">
                                        <div class="input-group input-group-dynamic mb-4 is-filled"> 
                                            <label class="form-label">Overcharge</label>
                                            <input wire:model="overcharge" type="text" class="form-control" min="0" placeholder="0" >
                                        </div>
                                        @if ($errors->has('overcharge'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('overcharge') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">State</label>
                                        <select wire:ignore.self wire:model="state" class="form-select" id="state">
                                            <option>Elegir</option>
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Start Date</label>
                                        <input wire:model="date_start" class="form-control border border-2 p-2 date-input" placeholder="YYYY/MM/DD">
                                        @if ($errors->has('date_start'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('date_start') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">End Date</label>
                                        <input wire:model="date_end" class="form-control border border-2 p-2 date-input" placeholder="YYYY/MM/DD">
                                        @if ($errors->has('date_end'))
                                        <div class="text-danger inputerror">
                                            {{ $errors->first('date_end') }}
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