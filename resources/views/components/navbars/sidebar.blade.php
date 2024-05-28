<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
                <img src="{{ asset('assets') }}/img/logo_nabella_black.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-2 font-weight-bold text-white">Nabella Transportation LLC</span>
            </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Modules</h6>
            </li>
            @can ('user.view')
                <li class="nav-item">
                    <a class="nav-link text-white {{ Route::currentRouteName() == 'user-profile' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('user-profile') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons">group</i>
                        </div>
                        <span class="nav-link-text ms-1">Users</span>
                    </a>
                </li>
            @endcan
            @can ('role.view')
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'role' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('role') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">manage_accounts</i>
                        
                    </div>
                    <span class="nav-link-text ms-1">Roles</span>
                </a>
            </li>
            @endcan
            @can ('driver.view')
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'driver' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('driver') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">person</i>
                    </div>
                    <span class="nav-link-text ms-1">Drivers</span>
                </a>
            </li>
            @endcan
            @can ('vehicle.view')
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'vehicle' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('vehicle') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">directions_car</i>
                    </div>
                    <span class="nav-link-text ms-1">Vehicles</span>
                </a>
            </li>
            @endcan
            @can ('client.view')
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'client' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('client') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">support_agent</i>
                    </div>
                    <span class="nav-link-text ms-1">Clients</span>
                </a>
            </li>
            @endcan
            @can ('servicecontract.view')
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'servicecontract' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('servicecontract') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">receipt_long</i>
                    </div>
                    <span class="nav-link-text ms-1">Service Contracts</span>
                </a>
            </li>
            @endcan
            @can ('patient.view')
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'patient' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('patient') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">personal_injury</i>
                    </div>
                    <span class="nav-link-text ms-1">Patient</span>
                </a>
            </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'hospital' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('hospital') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons">local_hospital</i>
                    </div>
                    <span class="nav-link-text ms-1">Hospital</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ Route::currentRouteName() == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
