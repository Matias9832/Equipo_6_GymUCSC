<!DOCTYPE html>
<html lang="es">
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
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        html, body {
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-light">

    <!-- Encabezado -->
    @include('layouts.partials.header')

    <!-- Contenido principal -->
    @if(View::hasSection('sidebar'))
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <aside class="bg-light border-end" style="width: 250px; min-height: 100vh;">
            @yield('sidebar')
        </aside>

        <!-- Main Content -->
        <main class="flex-grow-1 p-4">
            @yield('content')
        </main>
    </div>
    @else
    <main class="container my-4">
        @yield('content')
    </main>
    @endif

    <!-- Footer -->
    @include('layouts.partials.footer')

</body>
</html>