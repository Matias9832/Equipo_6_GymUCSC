@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Academia')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Academia'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('academias.update', $academia->id_academia) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre de la academia</label>
                    <input type="text" name="nombre_academia" class="form-control" value="{{ old('nombre_academia', $academia->nombre_academia) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion_academia" class="form-control" rows="3" required>{{ old('descripcion_academia', $academia->descripcion_academia) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Espacio</label>
                    <select name="id_espacio" class="form-select" required>
                        @foreach($espacios as $espacio)
                            <option value="{{ $espacio->id_espacio }}" {{ $academia->id_espacio == $espacio->id_espacio ? 'selected' : '' }}>
                                {{ $espacio->nombre_espacio }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Implementos</label>
                    <input type="text" name="implementos" class="form-control" value="{{ old('implementos', $academia->implementos) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Matrícula</label>
                    <input type="text" name="matricula" class="form-control" value="{{ old('matricula', $academia->matricula) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mensualidad</label>
                    <input type="text" name="mensualidad" class="form-control" value="{{ old('mensualidad', $academia->mensualidad) }}" required>
                </div>

                <hr>
                <h5>Horarios</h5>

                @php
                    $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                    $oldHorarios = old('horarios', $academia->horarios->toArray());
                @endphp

                <div id="horarios-container">
                    @foreach ($oldHorarios as $index => $horario)
                        <div class="row horario-item mb-3 align-items-center">
                            <div class="col-md-3">
                                <label>Día</label>
                                <select name="horarios[{{ $index }}][dia]" class="form-control" required>
                                    @foreach ($diasSemana as $dia)
                                        <option value="{{ $dia }}" {{ ($horario['dia'] ?? '') == $dia ? 'selected' : '' }}>
                                            {{ $dia }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Hora de inicio</label>
                                <input type="time" name="horarios[{{ $index }}][hora_inicio]" class="form-control" value="{{ $horario['hora_inicio'] ?? '' }}" required>
                            </div>
                            <div class="col-md-3">
                                <label>Hora de fin</label>
                                <input type="time" name="horarios[{{ $index }}][hora_fin]" class="form-control" value="{{ $horario['hora_fin'] ?? '' }}" required>
                            </div>
                            <div class="col-md-3 mt-4">
                                <button type="button" class="btn btn-danger remove-horario">Eliminar</button>
                            </div>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-secondary my-2" id="add-horario">+ Agregar otro horario</button>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Actualizar academia</button>
                </div>
            </form>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    let index = {{ count($oldHorarios) }};

    document.getElementById('add-horario').addEventListener('click', function () {
        const container = document.getElementById('horarios-container');
        const item = document.createElement('div');
        item.classList.add('row', 'horario-item', 'mb-3', 'align-items-center');
        item.innerHTML = `
            <div class="col-md-3">
                <label>Día</label>
                <select name="horarios[${index}][dia]" class="form-control" required>
                    <option value="">Seleccione día</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                    <option value="Sábado">Sábado</option>
                    <option value="Domingo">Domingo</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Hora de inicio</label>
                <input type="time" name="horarios[${index}][hora_inicio]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <label>Hora de fin</label>
                <input type="time" name="horarios[${index}][hora_fin]" class="form-control" required>
            </div>
            <div class="col-md-3 mt-4">
                <button type="button" class="btn btn-danger remove-horario">Eliminar</button>
            </div>
        `;
        container.appendChild(item);
        index++;
    });

    document.getElementById('horarios-container').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-horario')) {
            e.target.closest('.horario-item').remove();
        }
    });
});
</script>

