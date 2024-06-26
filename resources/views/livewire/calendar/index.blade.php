<div>
    <label for="driverId">Select Drivers:</label>
    @foreach($drivers as $driver)
        <div>
            <input type="checkbox" wire:model="driverIds" value="{{ $driver->id }}">
            <label>{{ $driver->name }}</label>
        </div>
    @endforeach

    <div id="calendar"></div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.13/index.global.min.js'></script>

<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('updateEvents', events => {
            // Aquí puedes inicializar o actualizar tu calendario con los nuevos eventos
            // Por ejemplo, si usas FullCalendar, podrías hacer algo así:
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                events: events
            });
            calendar.render();
        });
    });
</script>
