@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center">
            <!-- Logo -->
            <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
            <h3 class="mt-3 text-danger">Editar Perfil</h3>
        </div>
        
        <form method="POST" action="{{ route('mi-perfil.update') }}">
            @csrf
            @method('POST')

            <!-- Mostrar campos según el tipo de usuario -->
            @if (Auth::user()->is_admin)
                <!-- Campos solo para administradores -->
                <div class="mb-3">
                    <label for="nombre_admin" class="form-label">Nombre Administrador</label>
                    <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" value="{{ $profile->nombre_admin }}" required disabled>
                </div>
                <div class="mb-3">
                    <label for="correo_usuario" class="form-label">Correo Administrador</label>
                    <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ $usuario->correo_usuario }}" required>
                </div>
            @else
                <!-- Campos solo para alumnos -->
                <div class="mb-3">
                    <label for="nombre_alumno" class="form-label">Nombre Alumno</label>
                    <input type="text" name="nombre_alumno" id="nombre_alumno" class="form-control" value="{{ $profile->nombre_alumno }}" required disabled>
                </div>
                <div class="mb-3">
                    <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                    <input type="text" name="apellido_paterno" id="apellido_paterno" class="form-control" value="{{ $profile->apellido_paterno }}" required disabled>
                </div>
                <div class="mb-3">
                    <label for="apellido_materno" class="form-label">Apellido Materno</label>
                    <input type="text" name="apellido_materno" id="apellido_materno" class="form-control" value="{{ $profile->apellido_materno }}" required disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Carrera</label>
                    <input type="text" class="form-control" value="{{ $profile->carrera }}" required disabled>
                </div>
                <div class="mb-3">
                    <label for="correo_usuario" class="form-label">Correo Alumno</label>
                    <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ $usuario->correo_usuario }}" required>
                </div>
            @endif

            <!-- Campos comunes -->
            <div class="mb-3">
                <label for="contrasenia_usuario" class="form-label">Nueva Contraseña</label>
                <div class="input-group">
                    <input type="password" name="contrasenia_usuario" id="contrasenia_usuario" class="form-control" placeholder="Dejar en blanco si no deseas cambiarla">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1"><i class="bi bi-eye"></i></button>
                    
                </div>
                @error('contrasenia_usuario')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="contrasenia_usuario_confirmation" class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <input type="password" name="contrasenia_usuario_confirmation" id="contrasenia_usuario_confirmation" class="form-control" placeholder="Confirme su nueva contraseña">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" tabindex="-1"><i class="bi bi-eye"></i></button>

                </div>
            </div>

            <!-- Botones para editar y cancelar -->
            <div class="d-flex justify-content-between gap-2 mt-3">
                <button type="submit" class="btn btn-danger w-100">Guardar Cambios</button>
                <a href="{{ route('news.index') }}" class="btn btn-secondary w-100">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const input = document.getElementById('contrasenia_usuario');
        input.type = input.type === 'password' ? 'text' : 'password';
    });
    
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const input = document.getElementById('contrasenia_usuario_confirmation');
        input.type = input.type === 'password' ? 'text' : 'password';
    });
</script>

@endsection

