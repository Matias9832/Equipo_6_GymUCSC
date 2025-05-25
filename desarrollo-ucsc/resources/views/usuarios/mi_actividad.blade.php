@extends('layouts.guest')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container py-4 ">
            <h2 class="mb-4">Mi Actividad</h2>
            <div id="calendarioActividad" style="min-height: 600px;" class="card shadow-sm p-4"></div>
        </div>
    </main>    
    @include('layouts.footers.guest.footer')

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
                eventDisplay: 'block',
                eventContent: function(arg) {
                    let horaIngreso = arg.event.extendedProps.hora_ingreso;
                    let tiempoUso = parseInt(arg.event.extendedProps.tiempo_uso);
                    let durationText = '-';
                    let horaTexto = '';
                    let now = new Date();

                    // Validar hora_ingreso
                    if (horaIngreso && horaIngreso.includes(':')) {
                        let [h, m] = horaIngreso.split(':');
                        horaTexto = `${h.padStart(2, '0')}:${m.padStart(2, '0')}`;

                        // Construir fecha completa para comparar
                        let startDate = new Date(arg.event.start);
                        startDate.setHours(parseInt(h));
                        startDate.setMinutes(parseInt(m));

                        if (startDate < now && !isNaN(tiempoUso)) {
                            if (tiempoUso >= 60) {
                                let horas = Math.floor(tiempoUso / 60);
                                let mins = tiempoUso % 60;
                                durationText = mins > 0 ? `${horas}h ${mins}min` : `${horas}h`;
                            } else {
                                durationText = `${tiempoUso}min`;
                            }
                        }
                    }

                    // Mostrar contenido incluso si no hay hora_ingreso
                    return {
                        html: `
                            <div style="
                                color: #000;
                                font-weight: 500;
                                font-size: 12px;
                                line-height: 1.2;
                                word-wrap: break-word;
                                white-space: normal;
                                overflow-wrap: break-word;
                                max-width: 100%;
                            ">
                                ${arg.event.title}<br>
                                ${horaTexto ? `<small>Ingreso: ${horaTexto}</small><br>` : ''}
                                <small>Duración: ${durationText}</small>
                            </div>`
                    };
                }
            });

            calendar.render();
        });
    </script>
@endpush
