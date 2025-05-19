<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Cuenta</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
            <div class="text-center">
                <!-- Logo -->
                <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
                <h3 class="mt-3 text-danger">Verificar Cuenta</h3>
            </div>

            <!-- Mostrar mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Mostrar mensaje informativo de intentos o reenvío -->
            @if (session('info'))
                <div class="alert alert-warning">
                    {{ session('info') }}
                </div>
            @endif

            <!-- Mostrar errores generales SOLO si no es el código inválido -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            @if ($error !== 'El código es inválido.')
                                <li>{{ $error }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('verificar.codigo') }}">
                @csrf
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código de Verificación</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" placeholder="Ingrese el código enviado a su correo" required>
                    @error('codigo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-danger w-100">Verificar</button>
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