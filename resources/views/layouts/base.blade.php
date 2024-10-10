<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang='en' dir="{{ Route::currentRouteName() == 'rtl' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/favicon.png">
    <title>
        Nabella Transportation LLC
    </title>

    <!-- Metas -->
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" charset="UTF-8"></script>
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    @livewireStyles
</head>

<body class="g-sidenav-show {{ Route::currentRouteName() == 'rtl' ? 'rtl' : '' }} {{ Route::currentRouteName() == 'register' || Route::currentRouteName() == 'static-sign-up'  ? '' : 'bg-gray-200' }}">

    {{ $slot }}

    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
    @stack('js')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }

        window.addEventListener('closeModal', event => {
            $('#' + event.detail.name).modal('hide');
        })

        window.addEventListener('openModal', event => {
            $('#' + event.detail.name).modal('show');
        })

        window.addEventListener('showToast', event => {
            $('#' + event.detail.name).toast('show');
        })

        window.addEventListener('showConfirm', event => {
            Swal.fire({
                title: event.detail.text,
                icon: event.detail.icon,
                showCloseButton: true,
                showDenyButton: true,
                confirmButtonText: event.detail.confirmButtonText,
                denyButtonText: event.detail.denyButtonText,
            }).then((result) => {
                if (result.isConfirmed) {
                    if (event.detail.livewire) {
                        Livewire.emit(event.detail.livewire, result.isConfirmed);
                    } else {
                        Swal.fire({
                            title: "Success!",
                            icon: "success"
                        });
                    }
                } else if (result.isDenied) {
                    if (event.detail.livewire == 'continueScheduling' || event.detail.livewire == 'confirmCollect') {
                        Livewire.emit(event.detail.livewire, result.isConfirmed);
                    } else {
                        Swal.fire({
                            title: "Canceled!",
                            icon: "error"
                        });
                    }
                } else {
                    Swal.fire({
                        title: "Canceled!",
                        icon: "error"
                    });
                }
            });
        })

        window.addEventListener('showAlert', event => {
            Swal.fire({
                title: event.detail.text,
                icon: event.detail.icon,
            });
        })


        $(document).ready(function() {
            var modals = ['createUser', 'createDriver', 'createRole', 'createVehicle', 'createClient', 'createServiceContract', 'createPatient', 'SeeFileVehicle', 'createScheduling', 'seeEventDetails'];

            modals.forEach(element => {
                $("#" + element).on('hidden.bs.modal', function() {
                    livewire.emit('forcedCloseModal');
                });
            });

            flatpickr(".date-input", {
                enableTime: false, // Si quieres habilitar la selección de hora, cámbialo a true
                dateFormat: "m-d-Y", // Formato de la fecha
            });

            flatpickr(".date-input-range", {
                mode: "range", // Habilita el modo de rango
                dateFormat: "Y-m-d", // Formato de la fecha
            });

            flatpickr(".date-input-time", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
            });
        });
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- Sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0"></script>
    @livewireScripts
</body>

</html>