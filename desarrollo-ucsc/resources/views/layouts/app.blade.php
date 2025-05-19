<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>
        @yield('title', 'Panel de Control')
    </title>
    <!-- Fonts and icons -->
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

<body class="g-sidenav-show bg-gray-100 {{ $class ?? '' }}">

    @auth
        <!-- Esto hace que pueda ser manipulable el fondo según la página -->
        @yield('argon-bg-header')
        @if (!View::hasSection('argon-bg-header'))
            <div class="argon-bg-header bg-primary"></div>
        @endif

        {{-- Mostrar sidebar solo en rutas admin --}}
        @if(Request::is('admin*'))
            @include('layouts.navbars.admin.sidenav')
        @endif

        <main class="main-content border-radius-lg">
            <div class="container-fluid py-4">
                <div class="card card-body">
                    @yield('content')
                </div>
            </div>
        </main>
    @endauth

    @guest
        @yield('content')
    @endguest

    <!--   Core JS Files   -->
    <script src="{{ asset('argon/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('argon/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = { damping: '0.5' }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('argon/js/argon-dashboard.js') }}"></script>
    @stack('js')
</body>
</html>