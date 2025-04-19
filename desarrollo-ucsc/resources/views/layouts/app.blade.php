<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gym UCSC</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('images/dym_logo.png') }}" alt="Logo" height="40" class="me-2">
            <img src="{{ asset('images/dym_logo.png') }}" alt="Logo" height="40" class="me-2">
            <strong>Noticias</strong>
        </a>
        <div class="ms-auto">
            @auth
                <span class="me-3">Hola, {{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Iniciar sesión</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
