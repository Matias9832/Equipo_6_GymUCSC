<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="/img/apple-icon.png">
    <link rel="icon" type="image/png" href="/img/favicon.png">
    <title>
        Panel de Control | Sistema de Gestión Deportes UCSC
    </title>
    @stack('styles')
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" crossorigin="anonymous">

    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets/css/argon-dashboard.css') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show g-sidenav-pinned {{ $class ?? '' }}">


    @guest
        @yield('content')
    @endguest

    @auth
    @if (in_array(request()->route()->getName(), ['login', 'register', 'mi-perfil.edit', 'recover-password']))
        @yield('content')
        <button class="navbar-toggler ms-3 d-xl-none position-fixed z-index-3 top-1 start-1"
                type="button" id="iconSidenavToggle"
                style="background-color: white; border: none; border-radius: 5px;">
            <span class="navbar-toggler-icon"></span>
        </button>
    @else
        @if (!in_array(request()->route()->getName(), ['profile', 'profile-static']))
            <div class="min-height-300 bg-primary position-absolute w-100"></div>
        @elseif (in_array(request()->route()->getName(), ['profile-static', 'profile']))
            <div class="position-absolute w-100 min-height-300 top-0"
                style="background-image: url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg'); background-position-y: 50%;">
                <span class="mask bg-primary opacity-6"></span>
            </div>
        @endif

        <div class="g-sidenav-show g-sidenav-pinned">
            @include('layouts.navbars.auth.sidenav')

            <main class="main-content border-radius-lg">
                @yield('content')
            </main>
        </div>
    @endif
@endauth

@push('js')
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
    

    @endpush
    @stack('js')
</body>

</html>
