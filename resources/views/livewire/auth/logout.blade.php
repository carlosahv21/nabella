<ul class="navbar-nav justify-content-end align-items-center">
    <li>
        <button class="btn btn-link px-3 mb-0">
            <img src="{{ asset('assets') }}/img/icons8-whatsapp.svg" alt="Nabella Logo" width="30">
        </button>
    </li>
    <li class="nav-item dropdown pe-2 ocultar-en-movil">
        <a href="javascript:;" class="nav-link p-0 position-relative text-body" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Hi, {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4 w-100" aria-labelledby="dropdownMenuButton">
            @can('user.view')
            <li class="mb-2">
                <a class="dropdown-item border-radius-md" href="{{ route('user-profile') }}">
                    <div class="d-flex align-items-center py-1">
                        <i class="material-icons notranslate">group</i>
                        <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">
                                Users
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="mb-2">
                <a class="dropdown-item border-radius-md" href="{{ route('role') }}">
                    <div class="d-flex align-items-center py-1">
                        <i class="material-icons notranslate">manage_accounts</i>
                        <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">
                                Roles
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
            @endcan
            <li>
                <a class="dropdown-item border-radius-md" href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                    <div class="d-flex align-items-center py-1">
                        <i class="material-icons notranslate">person</i>
                        <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">
                                Profile
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
            <li class="mb-2">
                <a class="dropdown-item border-radius-md" wire:click="destroy">
                    <div class="d-flex align-items-center py-1">
                        <i class="material-icons notranslate">logout</i>
                        <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">
                                Sign Out
                            </h6>
                        </div>
                    </div>
                </a>
            </li>
        </ul>
    </li>
</ul>