@extends('layouts.auth')

@section('content')
    <div class="card shadow p-4" style="width: 100%; max-width: 400px; margin: 2rem;">
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
@endsection