@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Mi Actividad</h2>
    <div id="calendarioActividad"></div>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let calendarEl = document.getElementById('calendarioActividad');

            let calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: '/actividades',
                eventDisplay: 'background', // fondo de día
                eventClick: function(info) {
                    alert('Actividad: ' + info.event.title);
                }
            });

            calendar.render();
        });
    </script>
@endpush


