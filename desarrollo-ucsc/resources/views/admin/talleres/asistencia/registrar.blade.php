@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Registrar Asistencia'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Registrar Asistencia para: {{ $taller->nombre_taller }}</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('asistencia.guardar', $taller->id_taller) }}">
                @csrf

                <!-- Fecha actual y módulos en la misma fila -->
                <div class="row mb-4">
                    <!-- Fecha actual -->
                    <div class="col-md-4 d-flex align-items-stretch">
                        <div class="alert alert-info text-white mb-0 w-100 h-100 d-flex flex-column justify-content-center" style="min-height: 100%;">
                            <strong>Fecha actual:</strong><br>
                            {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}
                        </div>
                    </div>

                    <!-- Módulos del taller -->
                    <div class="col-md-8">
                        <h6 class="text-uppercase text-secondary font-weight-bolder mb-2">Módulos del Taller</h6>

                        @if($taller->horarios->count())
                            <ul class="list-group">
                                @foreach($taller->horarios as $horario)
                                    <li class="list-group-item py-2 px-3">
                                        <strong>{{ ucfirst($horario->dia_taller) }}</strong>:
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }} a
                                            {{ \Carbon\Carbon::parse($horario->hora_termino)->format('H:i') }}
                                        </small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted">Este taller aún no tiene módulos definidos.</p>
                        @endif
                    </div>
                </div>

                <!-- Usuario y Fecha de Asistencia -->
                <div class="row">
                    <!-- Usuario -->
                    <div class="col-md-6 mb-3">
                        <label for="id_usuario" class="form-label">Usuario</label>
                        <select name="id_usuario" id="id_usuario" class="form-select">
                            <option value="">Selecciona un usuario</option>
                            @foreach($usuarios as $usuario)
                                <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                    {{ $usuario->rut }} - {{ $usuario->nombre_usuario ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_usuario')
                            <small class="text-danger">
                                {{ $message === 'The id usuario field is required.' ? 'Debes seleccionar un usuario.' : $message }}
                            </small>
                        @enderror
                    </div>

                    <!-- Fecha de asistencia -->
                    <div class="col-md-6 mb-3">
                        <label for="fecha_asistencia" class="form-label">Fecha de Asistencia</label>
                        <input type="date" name="fecha_asistencia" id="fecha_asistencia" class="form-control" value="{{ old('fecha_asistencia') }}">
                        @error('fecha_asistencia')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Registrar Asistencia</button>
                    <a href="{{ route('talleres.index') }}" class="btn btn-secondary">Volver</a>
                </div>
            </form>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
