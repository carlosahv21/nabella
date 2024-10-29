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
                            <h6 class="text-sm font-weight-normal my-auto">Users</h6>
                        </div>
                    </div>
                </a>
            </li>
        @endcan
        <li class="mb-2">
            <a class="dropdown-item border-radius-md" href="{{ route('profile', ['id' => Auth::user()->id]) }}">
                <div class="d-flex align-items-center py-1">
                    <i class="material-icons notranslate">person</i>
                    <div class="ms-2">
                        <h6 class="text-sm font-weight-normal my-auto">Profile</h6>
                    </div>
                </div>
            </a>
        </li>

        <li class="dropdown-divider"></li>
        <li class="dropdown-header">Users List</li>
        @foreach($users as $user)
            <li>
                <a class="dropdown-item border-radius-md" href="{{ route('profile', ['id' => $user->id]) }}">
                    <div class="d-flex align-items-center py-1">
                        <i class="material-icons notranslate">person</i>
                        <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">{{ $user->name }}</h6>
                        </div>
                    </div>
                </a>
            </li>
        @endforeach
    </ul>
</li>
