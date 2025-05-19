@extends('layouts.auth')

@section('content')
    <div class="card shadow p-4" style="width: 100%; max-width: 400px; margin: 2rem;">
        <div class="text-center">
            <!-- Logo -->
            <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
            <h3 class="mt-3 text-danger">Registro de Usuario</h3>
        </div>

        <!-- Mostrar mensaje de éxito -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

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

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="rut" class="form-label">RUT</label>
                <input type="text" name="rut" id="rut" class="form-control" placeholder="Sin puntos, ni dígito verificador" value="{{ old('rut') }}" required>
                @error('rut')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" placeholder="Ingrese su correo" value="{{ old('correo') }}" required>
                @error('correo')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="contraseña" class="form-label">Contraseña</label>
                <input type="password" name="contraseña" id="contraseña" class="form-control" placeholder="Ingrese su contraseña" required>
                @error('contraseña')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
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
@endsection