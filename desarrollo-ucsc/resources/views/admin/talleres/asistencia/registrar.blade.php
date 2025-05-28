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
                                @php
                                    $alumno = $usuario->alumno;
                                    $nombreCompleto = $alumno ? "{$alumno->nombre_alumno} {$alumno->apellido_paterno} {$alumno->apellido_materno}" : 'Nombre no disponible';
                                @endphp
                                <option value="{{ $usuario->id_usuario }}" {{ old('id_usuario') == $usuario->id_usuario ? 'selected' : '' }}>
                                    {{ $usuario->rut }} - {{ $nombreCompleto }}
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
                        <input type="text" name="fecha_asistencia" id="fecha_asistencia" class="form-control" placeholder="Selecciona una fecha" value="{{ $fechaSeleccionada }}">
                        @error('fecha_asistencia')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success">Registrar Asistencia</button>
                    <a href="{{ route('asistencia.ver', $taller->id_taller) }}" class="btn btn-primary">
                        <i class="fas fa-eye me-1"></i> Ver asistencias
                    </a>
                    <a href="{{ route('talleres.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i> Volver a talleres
                    </a>
                </div>
            </form>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
    @push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const diasPermitidos = @json($diasValidos); // ej: ['lunes', 'martes']
            const diasNumericos = {
                'domingo': 0,
                'lunes': 1,
                'martes': 2,
                'miércoles': 3,
                'jueves': 4,
                'viernes': 5,
                'sábado': 6,
            };
            const diasDeshabilitados = Object.entries(diasNumericos)
                .filter(([dia, num]) => !diasPermitidos.includes(dia))
                .map(([_, num]) => num);

            flatpickr("#fecha_asistencia", {
                dateFormat: "Y-m-d", //Formato de fecha para backend
                altInput: true, // Mostrar un campo visible con formato distinto
                altFormat: "d-m-Y", // Mostrar la fecha como día-mes-año
                locale: "es",
                disable: [
                    function(date) {
                        // Deshabilitar si el día no está en la lista de permitidos
                        return diasDeshabilitados.includes(date.getDay());
                    }
                ],
                minDate: new Date(new Date().getFullYear(), 0, 1),
                maxDate: new Date(new Date().getFullYear(), 11, 31),
                defaultDate: "{{ old('fecha_asistencia') }}"
            });
            $('#id_usuario').select2({
                theme: 'bootstrap-5',
                placeholder: "Buscar por RUT o nombre...",
                width: '100%',
                ajax: {
                    url: '{{ route('usuarios.buscar') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return { q: params.term };
                    },
                    processResults: function (data) {
                        return { results: data };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                language: {
                    inputTooShort: function () {
                        return "Escribe para buscar...";
                    },
                    noResults: function () {
                        return "No se encontraron resultados";
                    },
                    searching: function () {
                        return "Buscando...";
                    }
                }
            });
            $('#id_usuario').on('select2:open', function () {
                setTimeout(function() {
                    document.querySelector('.select2-search__field').focus();
                }, 100);
            });
        });
    </script>
    @endpush
    @stack('js')
</div>
@endsection
