<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GYM-UCSC')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1; /* El contenido principal ocupa el espacio restante */
        }
        footer {
            flex-shrink: 0; /* El footer no se encoge ni se superpone */
        }
        #calendarioActividad {
        max-width: 900px;
        margin: 0 auto;
        padding: 10px;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        min-height: 600px; /* IMPORTANTE para que el calendario se vea */
        }
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
    @stack('styles')
</head>