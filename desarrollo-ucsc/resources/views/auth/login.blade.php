<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <div class="text-center">
                <!-- Logo -->
                <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
                <h3 class="mt-3 text-danger">Iniciar Sesión</h3>
            </div>

            <!-- Mostrar errores generales -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label for="rut" class="form-label">RUT</label>
                    <input type="text" name="rut" id="rut" class="form-control" placeholder="Sin puntos, ni dígito verificador" value="{{ old('rut') }}" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Ingrese su contraseña" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Iniciar Sesión</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('register') }}" class="text-decoration-none text-danger">¿No tienes una cuenta? Regístrate</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>