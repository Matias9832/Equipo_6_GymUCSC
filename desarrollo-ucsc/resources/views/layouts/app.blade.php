<!-- resources/views/layouts/layout.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') GYM-UCSC </title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .object-fit-cover {
            object-fit: cover;
            height: 100%;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-light">

    <!-- Encabezado -->
    <nav class="navbar navbar-expand-lg bg-white border-bottom shadow-sm px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/gym_logo.png') }}" alt="Logo GYM" style="height: 30px;" class="me-3">
            <img src="{{ asset('images/ucsc_logo.png') }}" alt="Logo UCSC" style="height: 30px;" class="me-3">
            
        </a>
        <div class="ms-auto d-flex">
            @if (Route::has('login'))
                @auth
                    <div class="d-flex align-items-center me-3 text-secondary small">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ Auth::user()->name }}
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
                    </form>
            @else
            
                
                    <a href="{{ route('login') }}" class="btn btn-danger btn-sm me-2">Iniciar sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-outline-danger btn-sm">Registrarse</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container my-4">
        @yield('content')
    </div>

  

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
  <!-- Footer -->
<footer class="text-center text-muted py-3 border-top bg-white">
    Copyright © 2024 Website. All rights reserved.
</footer>
</html>
