<nav class="navbar navbar-main navbar-expand-lg shadow-none border-radius-xl bg-white mt-3 mx-2" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active text-capitalize" aria-current="page">{{ str_replace('-', ' ', Route::currentRouteName()) }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0 text-capitalize">{{ str_replace('-', ' ', Route::currentRouteName()) }}</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                @can ('user.view')
                <ul class="navbar-nav justify-content-end align-items-center">
                    <li class="nav-item dropdown pe-2">
                        <a href="javascript:;" class="nav-link p-0 position-relative text-body" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="material-icons notranslate cursor-pointer">
                                manage_accounts
                            </i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4 w-100" aria-labelledby="dropdownMenuButton">
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
                        </ul>
                    </li>
                </ul>
                @endcan
            </div>
            <div class="d-flex align-items-center">
                <ul class="navbar-nav justify-content-end align-items-center">
                    <li class="nav-item dropdown pe-2">
                        <a href="{{ route('profile', ['id' => Auth::user()->id]) }}" class="nav-link p-0 position-relative text-body">
                            <i class="material-icons notranslate cursor-pointer">
                                person
                            </i>
                        </a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav  justify-content-end">
                <li class="nav-item d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body font-weight-bold px-0">
                        <i class="fa fa-user me-sm-1"></i>
                        <livewire:auth.logout />
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>