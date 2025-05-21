<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Bienvenido')</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ asset('argon/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('argon/css/nucleo-svg.css') }}" rel="stylesheet" />
    <link id="pagestyle" href="{{ asset('argon/css/argon-dashboard.css') }}" rel="stylesheet" />
    <style>
        html, body {
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
        }
        body {
            background: url('https://sitios.ucsc.cl/sube/wp-content/uploads/sites/46/2021/11/CENTRAL-UCSC.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .auth-content-wrapper {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('layouts.navbars.auth.navbar')
    <div class="auth-content-wrapper">
        @yield('content')
    <script src="{{ asset('argon/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('argon/js/core/bootstrap.min.js') }}"></script>
    @stack('js')
</body>
</html>