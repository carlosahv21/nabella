<ul class="navbar-nav justify-content-end align-items-center">
    <li class="nav-item dropdown px-3 mb-0">
        <a href="javascript:;" class="nav-link p-0 position-relative text-body" id="dropdownMenuWhatsapp" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="{{ asset('assets') }}/img/whatsapp-color.svg" alt="Nabella Logo" width="30">
        </a>

        <ul class="dropdown-menu dropdown-menu-end w-100 border-radius-md shadow-xl" id="userDropdown" aria-labelledby="dropdownMenuWhatsapp">

        </ul>
    </li>
    <li class="nav-item dropdown pe-2">
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

<script>
    const user_auth = @json(auth()->user());
</script>

<script>
    document.getElementById('dropdownMenuWhatsapp').addEventListener('click', function(event) {
        event.preventDefault();

        fetch('{{ route("whatsapp-users") }}')
            .then(response => response.json())
            .then(users => {
                
                if(user_auth.roles[0].name == 'Driver'){
                    users = users.filter(user => user.role == 'Admin');
                }
                
                const dropdown = document.getElementById('userDropdown');
                dropdown.innerHTML = ''; // Limpiar contenido previo

                const header = document.createElement('li');
                header.classList.add('dropdown-header', 'text-center', 'text-white', 'bg-success', 'py-2');
                header.innerHTML = `<img class="whatsapp-logo" src="{{ asset('assets') }}/img/whatsapp.svg" alt="Nabella Logo" width="30"> Start conversation`;
                dropdown.appendChild(header);

                users.forEach(user => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('user-item');

                    if (user.phone) {
                        listItem.setAttribute('data-id', user.phone);
                    }

                    listItem.innerHTML = `
                    <img src="{{ asset('assets') }}/img/placeholder.jpg" alt="${user.name}">
                    <div class="user-info">
                        <h6>${user.name}</h6>
                        <p>${user.role}</p>
                    </div>
                    <button class="btn" data-bs-toggle="tooltip" data-bs-original-title="Iniciar conversación">
                        <img src="{{ asset('assets') }}/img/whatsapp-green.svg" alt="WhatsApp" class="whatsapp-chat">
                    </button>`;
                    dropdown.appendChild(listItem);
                });

                const dropdownButton = new bootstrap.Dropdown(document.getElementById('dropdownMenuWhatsapp'));
                dropdownButton.show();
            })
            .catch(error => console.error('Error:', error));
    });

    // Usar delegación de eventos en el contenedor principal del dropdown
    document.getElementById('userDropdown').addEventListener('click', function(event) {
        const listItem = event.target.closest('.user-item');
        
        if (listItem) {
            const phone = listItem.getAttribute('data-id'); // Obtener el teléfono del atributo data-id

            if(!phone){
                Swal.fire({
                    text: 'This user does not have a phone number.',
                    icon: 'error',
                });
                return;
            }

            window.open(`https://wa.me/${phone}`, '_blank');
        }

    });
</script>