@extends('layouts.app')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <!-- Fondo superior estilo Argon -->
        <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
            style="background-image: url('https://ucsc.cl/content/uploads/2023/08/hero-facultad.jpg'); background-position: top;">
            <span class="mask bg-gradient-dark opacity-6"></span>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 text-center mx-auto">
                        <h1 class="text-white mb-2 mt-5">Editar Perfil</h1>
                        <p class="text-lead text-white">Actualiza tus datos personales y de acceso.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Formulario centrado -->
        <div class="container">
            <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-body">
                            <form method="POST" action="{{ route('edit-perfil.update') }}">
                                @csrf
                                @method('POST')

                                <!-- Mostrar campos según el tipo de usuario -->
                                @if (Auth::user()->tipo_usuario === 'admin')
                                    <!-- Campos solo para administradores -->
                                    <div class="mb-3">
                                        <label for="nombre_admin" class="form-label">Nombre Administrador</label>
                                        <input type="text" name="nombre_admin" id="nombre_admin" class="form-control" value="{{ $profile->nombre_admin }}" required disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="correo_usuario" class="form-label">Correo Administrador</label>
                                        <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ $usuario->correo_usuario }}" required disabled>
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
                                        <input type="email" name="correo_usuario" id="correo_usuario" class="form-control" value="{{ $usuario->correo_usuario }}" required disabled>
                                    </div>
                                @endif

                                <!-- Campos comunes -->
                                <div class="mb-3">
                                    <label for="contrasenia_usuario" class="form-label">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="contrasenia_usuario" id="contrasenia_usuario" class="form-control" placeholder="Dejar en blanco si no deseas cambiarla">
                                    </div>
                                    @error('contrasenia_usuario')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="contrasenia_usuario_confirmation" class="form-label">Confirmar Contraseña</label>
                                    <div class="input-group">
                                        <input type="password" name="contrasenia_usuario_confirmation" id="contrasenia_usuario_confirmation" class="form-control" placeholder="Confirme su nueva contraseña">
                                    </div>
                                </div>

                                <!-- Botones para editar y cancelar -->
                                <div class="d-flex justify-content-between gap-2 mt-3">
                                    <button type="submit" class="btn btn-primary w-100">Guardar Cambios</button>
                                    @if(auth()->user()->tipo_usuario === 'admin')
                                        <a href="{{ route('docentes.perfil') }}" class="btn btn-outline-secondary w-100">Cancelar</a>
                                    @else
                                        <a href="{{ route('news.index') }}" class="btn btn-outline-secondary w-100">Cancelar</a>
                                    @endif    
                                </div>
                            </form>
                            @if (auth()->user()->tipo_usuario !== 'admin')
                                <div class="mt-3 text-center">
                                    <a href="{{ route('salud.edit') }}" class="btn btn-outline-danger w-100">
                                        Editar Información de Salud
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection

@push('js')
<script>
    function togglePassword(inputId, btn) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            btn.querySelector('i').classList.remove('bi-eye');
            btn.querySelector('i').classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            btn.querySelector('i').classList.remove('bi-eye-slash');
            btn.querySelector('i').classList.add('bi-eye');
        }
    }
</script>
@endpush