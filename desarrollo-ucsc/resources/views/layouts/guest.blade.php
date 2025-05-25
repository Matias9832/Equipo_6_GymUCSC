<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>
        Inicio | Deportes UCSC
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
    <style>
             /* Encabezados de días con colores */
        .fc-col-header-cell:nth-child(1) { background-color: #f59e0b; color: white; } /* Lunes */
        .fc-col-header-cell:nth-child(2) { background-color: #fb923c; color: white; } /* Martes */
        .fc-col-header-cell:nth-child(3) { background-color: #ef4444; color: white; } /* Miércoles */
        .fc-col-header-cell:nth-child(4) { background-color: #ec4899; color: white; } /* Jueves */
        .fc-col-header-cell:nth-child(5) { background-color: #8b5cf6; color: white; } /* Viernes */
        .fc-col-header-cell:nth-child(6) { background-color: #60a5fa; color: white; } /* Sábado */
        .fc-col-header-cell:nth-child(7) { background-color: #22c55e; color: white; } /* Domingo */

        .fc-daygrid-day {
            border: 1px solid #eee;
            height: 100px;
            position: relative;
        }

        .fc-day-today {
            background-color: #fef3c7 !important;
            border: 2px solid #facc15;
        }

        
        

        .fc-toolbar-title {
            font-size: 1.8rem;
            font-weight: bold;
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
            color: #000 !important;       /* Negro */
            text-decoration: none !important; /* Sin subrayado */
            font-weight: 500;
        }

        /* Nombre de los días */
        .fc-col-header-cell-cushion {
            color: #fff !important;       /* Ya están con color blanco por fondo */
            text-decoration: none !important;
            font-weight: bold;
        }
          /* Estilo para el texto de los eventos */
        .fc-event-title {
            color: #000 !important;      /* Negro */
            font-weight: 500;
        }

        .fc-event {
            background-color: #fef08a !important; /* fondo suave amarillo */
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
    
</head>

<body class="{{ $class ?? '' }}">
    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @yield('content')

    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/argon-dashboard.js') }}"></script>
    @stack('js')
    @stack('scripts')
    @stack('styles')
</body>

</html>