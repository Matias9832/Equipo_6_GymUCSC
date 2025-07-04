<!DOCTYPE html>
<html lang="es">

<head>
    @php
        use App\Models\Marca;
        $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
    @endphp
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url($ultimaMarca->logo_marca) }}">
    <!-- <link rel="apple-touch-icon" sizes="76x76" href="{{ url('/img/apple-icon.png') }}"> -->
    <link rel="icon" type="image/png" href="{{ url($ultimaMarca->logo_marca) }}">
    <title>
        Inicio | Deportes {{ $ultimaMarca->nombre_marca ?? 'Marca por defecto' }}
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Nucleo Icons -->
    <link href="{{ url('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ url('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="{{ url('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ url('assets/css/argon-dashboard.css') }}" rel="stylesheet" />

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    @yield('custom-css')
    @php
        use App\Models\Tenants\TemaTenant;

        // Se obtiene el tenant actual usando Tenancy
        $tenant = tenancy()->tenant ?? null;

        $tema = $tenant
            ? TemaTenant::where('tenant_id', $tenant->id)->first()
            : null;
    @endphp

    @if($tema && $tema->url_fuente)
        <link href="{{ $tema->url_fuente }}" rel="stylesheet">
    @endif

    @include('layouts.colors.tema-css', ['tema' => $tema])
</head>

<body class="{{ $class ?? '' }}">

    <div class="min-height-300 bg-primary position-absolute w-100"></div>
    @yield('content')

    <!--   Core JS Files   -->
    <script src="{{ url('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <!-- jQuery necesario para rutinas personalizadas -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 bundle (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
    <script src="{{ url('assets/js/argon-dashboard.js') }}"></script>
    <!-- Headroom para esconder navbar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/headroom/0.12.0/headroom.min.js"></script>
    @stack('js')
    @stack('scripts')
    @stack('styles')
</body>

</html>