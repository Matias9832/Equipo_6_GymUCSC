<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Bienvenido')</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('argon/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('argon/css/nucleo-svg.css') }}" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link id="pagestyle" href="{{ asset('argon/css/argon-dashboard.css') }}" rel="stylesheet" />
    <style>
    .argon-bg-header {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        min-height: 300px;
        z-index: 0;
    }
    .main-content {
        position: relative;
        z-index: 1;
    }
</style>
</head>
<body class="bg-gray-100">
    @include('layouts.navbars.guest.navbar')
    <!-- Esto hace que pueda ser manipulable el fondo según la página -->
    @yield('argon-bg-header')
    @if (!View::hasSection('argon-bg-header'))
        <div class="argon-bg-header bg-primary"></div>
    @endif
    <main class="main-content">
        <div class="container py-4">
            @yield('content')
        </div>
    </main>
    <script src="{{ asset('argon/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/bootstrap.min.js') }}"></script>
    @stack('js')
</body>
</html>
