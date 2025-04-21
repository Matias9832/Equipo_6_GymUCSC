<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <div class="text-center">
                <!-- Logo -->
                <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
                <h3 class="mt-3 text-danger">Registro de Usuario</h3>
            </div>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="rut" class="form-label">RUT</label>
                    <input type="text" name="rut" id="rut" class="form-control" placeholder="Sin puntos, ni dígito verificador" required>
                </div>
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo" required>
                </div>
                <div class="mb-3">
                    <label for="contraseña" class="form-label">Contraseña</label>
                    <input type="password" name="contraseña" id="contraseña" class="form-control" placeholder="Ingrese su contraseña" required>
                </div>
                <div class="mb-3">
                    <label for="contraseña_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="contraseña_confirmation" id="contraseña_confirmation" class="form-control" placeholder="Confirme su contraseña" required>
                </div>
                <button type="submit" class="btn btn-danger w-100">Registrarse</button>
            </form>
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-decoration-none text-danger">¿Ya tienes una cuenta? Inicia sesión</a>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>