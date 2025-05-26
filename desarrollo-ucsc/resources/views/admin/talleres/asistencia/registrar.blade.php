@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Registrar Asistencia'])
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0 d-flex justify-content-between align-items-center">
            <h4 >Registrar Asistencia para: {{ $taller->nombre_taller }}</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('asistencia.guardar', $taller->id_taller) }}">
                @csrf

                <div class="mb-3">
                    <label for="id_usuario" class="form-label">Usuario</label>
                    <select name="id_usuario" id="id_usuario" class="form-select">
                        <option value="">Selecciona un usuario</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                {{ $usuario->rut }} - {{ $usuario->correo_usuario }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_usuario')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="fecha_asistencia" class="form-label">Fecha de Asistencia</label>
                    <input type="date" name="fecha_asistencia" id="fecha_asistencia" class="form-control" value="{{ old('fecha_asistencia') }}">
                    @error('fecha_asistencia')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success">Registrar Asistencia</button>
                <a href="{{ route('talleres.index', $taller->id_taller) }}" class="btn btn-secondary">Volver</a>
            </form>
        </div>
    </div>
</div>
@endsection
