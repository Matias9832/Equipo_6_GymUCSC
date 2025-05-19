@extends('layouts.auth')

@section('content')
    <div class="card shadow p-4" style="width: 100%; max-width: 400px; margin: 2rem;">
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
@endsection