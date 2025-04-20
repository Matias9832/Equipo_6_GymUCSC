<!-- filepath: c:\xampp\htdocs\Equipo_6_GymUCSC\desarrollo-ucsc\resources\views\welcome.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="text-center">
            <!-- Logo -->
            <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 150px;">
            <h1 class="mt-4 text-danger">Bienvenido a la Aplicación</h1>

            @if (Route::has('login'))
                <div class="mt-4">
                    @auth
                        <p class="mb-4">Ya has iniciado sesión como <strong>{{ Auth::user()->correo_usuario }}</strong></p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-danger me-2">Iniciar sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-outline-danger">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>