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
                buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
            },
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
    <style>
             /* Encabezados de días con colores */
        .fc-col-header-cell{
             background-color: var(--bs-primary); 
             color: white; 
        }

        .fc-daygrid-day {
            border: 1px solid #eee;
            height: 100px;
            position: relative;
        }

        .fc-day-today {
            background-color: #fff7d2 !important;        
            border: 2px solid #f5e7b1;
        }      

        .fc-toolbar-title {
            color: #1f2937;
            font-size: 1.8rem;
            font-weight: bold;
            text-transform: capitalize;
        }

        .fc-button {
            background-color: #6b7280;
            border: none;
            color: white;
        }

        .fc-button:hover {
            background-color: #4b5563;
        }

        /* Números de los días */
        .fc-daygrid-day-number {
            color: #000 !important;       
            text-decoration: none !important; 
            font-weight: 500;
        }

        /* Nombre de los días */
        .fc-col-header-cell-cushion {
            color: #fff !important;       
            text-decoration: none !important;
            font-weight: bold;
        }
          /* Estilo para el texto de los eventos */
        .fc-event-title {
            color: #000 !important;      
            font-weight: 500;
        }

        .fc-event {
            background-color: #daf8c8da !important; 
            border: none;
            padding: 2px 4px;
            border-radius: 6px;
            font-size: 0.9rem;
        }

      
        /* Evita subrayado en enlaces del calendario */
        .fc a {
            text-decoration: none !important;
            color: inherit; /* hereda el color correcto */
        }

        /* Botones y título */
        .fc-toolbar-title {
            color: #1f2937;
            font-weight: bold;
        }
       

        .fc-button {
            color: white;
            background-color: #6b7280;
            border: none;
        }

    </style>
@endpush
