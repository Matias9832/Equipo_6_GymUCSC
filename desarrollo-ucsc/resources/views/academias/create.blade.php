@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Academias Deportivas'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Registrar nueva academia</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('academias.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre_academia" class="form-label">Nombre de la academia</label>
                            <input type="text" name="nombre_academia" class="form-control" placeholder="Ej: Academia de Fútbol" required>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_academia" class="form-label">Descripción</label>
                            <textarea name="descripcion_academia" class="form-control" rows="3" placeholder="Puedes explicar en qué consiste esta academia o sus objetivos" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Espacio</label>
                            <select name="id_espacio" class="form-select" required>
                                @foreach($espacios as $espacio)
                                    <option value="{{ $espacio->id_espacio }}">{{ $espacio->nombre_espacio }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Implementos (opcional)</label>
                            <input type="text" name="implementos" class="form-control" placeholder="Ej: Camiseta, buzo, zapatillasm etc." value="{{ old('implementos') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Matrícula</label>
                            <input type="text" name="matricula" class="form-control" placeholder="Precio de la matrícula" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mensualidad</label>
                            <input type="text" name="mensualidad" class="form-control" placeholder="Valor de la mensualidad" required>
                        </div>

                        <hr>
                        
                        <h5>Horarios</h5>

                        @php
                            $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            $oldHorarios = old('horarios', [null]);
                        @endphp

                        <div id="horarios-container">
                            @foreach ($oldHorarios as $index => $horario)
                                <div class="row horario-item mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <label>Día</label>
                                        <select name="horarios[{{ $index }}][dia]" class="form-control" required>
                                            @foreach ($diasSemana as $dia)
                                                <option value="{{ $dia }}" {{ (old("horarios.$index.dia") ?? ($horario['dia'] ?? '')) == $dia ? 'selected' : '' }}>
                                                    {{ $dia }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Hora de inicio</label>
                                        <input type="time" name="horarios[{{ $index }}][hora_inicio]" class="form-control"
                                            value="{{ old("horarios.$index.hora_inicio", $horario['hora_inicio'] ?? '') }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Hora de fin</label>
                                        <input type="time" name="horarios[{{ $index }}][hora_fin]" class="form-control"
                                            value="{{ old("horarios.$index.hora_fin", $horario['hora_fin'] ?? '') }}" required>
                                    </div>
                                    
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-horario">+ Añadir Horario</button>


                        <div class="d-flex justify-content-end">
                            <a href="{{ route('academias.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar academia</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>        
    </div>
    @include('layouts.footers.auth.footer')
</div>

@endsection
{{-- Script para añadir horarios dinámicamente --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    let index = {{ count(old('horarios', [null])) }};

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
            <div class="col-md-3 mt-4 pt-4">
                <button type="button" class="btn btn-danger remove-horario"><i class="fas fa-trash-alt"></i></button>
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


