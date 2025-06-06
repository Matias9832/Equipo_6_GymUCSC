@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Taller'])
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Editar Taller</h6>
                </div>
                @if($errors->any())
                    <div class="alert alert-danger mx-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-body bg-white">
                    <form action="{{ route('talleres.update', $taller) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Datos del taller --}}
                        <div class="mb-3">
                            <label for="nombre_taller" class="form-label">Nombre Taller</label>
                            <input type="text" name="nombre_taller" class="form-control" value="{{ old('nombre_taller', $taller->nombre_taller) }}" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="hidden" name="activo_taller" value="0">
                            {{-- MEJORA: Se usa la directiva @checked para manejar el estado 'checked' y los datos 'old' de forma limpia --}}
                            <input type="checkbox" name="activo_taller" class="form-check-input" value="1" @checked(old('activo_taller', $taller->activo_taller))>
                            <label class="form-check-label">Activo</label>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_taller" class="form-label">Descripción</label>
                            <textarea name="descripcion_taller" class="form-control" required>{{ old('descripcion_taller', $taller->descripcion_taller) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="cupos_taller" class="form-label">Cupos</label>
                            <input type="number" name="cupos_taller" class="form-control" value="{{ old('cupos_taller', $taller->cupos_taller) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_admin" class="form-label">Profesor asignado</label>
                            <select name="id_admin" class="form-select">
                                <option value="">-- Sin asignar --</option>
                                @foreach($admins as $admin)
                                    {{-- MEJORA: Se usa @selected para manejar la selección y los datos 'old' --}}
                                    <option value="{{ $admin->id_admin }}" @selected(old('id_admin', $taller->id_admin) == $admin->id_admin)>
                                        {{ $admin->nombre_admin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_espacio" class="form-label">Espacio</label>
                            <select name="id_espacio" class="form-select">
                                <option value="">-- Sin Asignar --</option>
                                @foreach($espacios as $espacio)
                                    {{-- MEJORA: Se usa @selected para manejar la selección y los datos 'old' --}}
                                    <option value="{{ $espacio->id_espacio }}" @selected(old('id_espacio', $taller->id_espacio) == $espacio->id_espacio)>
                                        {{ $espacio->nombre_espacio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <hr>
                        <h6>Horarios</h6>

                        @php
                            // MEJORA: Se combinan los horarios guardados con los enviados en 'old' si falla la validación
                            $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            $horarios_mostrados = old('horarios', $taller->horarios->map(function ($h) {
                                return [
                                    'id' => $h->id,
                                    'dia' => $h->dia_taller,
                                    'hora_inicio' => \Carbon\Carbon::parse($h->hora_inicio)->format('H:i'),
                                    'hora_termino' => \Carbon\Carbon::parse($h->hora_termino)->format('H:i')
                                ];
                            })->all());
                        @endphp

                        {{-- MEJORA: Se añaden atributos data-* para pasar datos a JavaScript de forma segura --}}
                        <div id="horarios-container" 
                             data-dias-semana="{{ json_encode($diasSemana) }}"
                             data-index-inicial="{{ count($horarios_mostrados) }}">
                            
                            @foreach($horarios_mostrados as $i => $horario)
                                <div class="row mb-2 horario-item">
                                    {{-- El ID solo existe si el horario ya estaba guardado --}}
                                    <input type="hidden" name="horarios[{{ $i }}][id]" value="{{ $horario['id'] ?? '' }}">
                                    <div class="col-md-3">
                                        <select name="horarios[{{ $i }}][dia]" class="form-select" required>
                                            <option value="">-- Día --</option>
                                            @foreach($diasSemana as $dia)
                                                <option value="{{ $dia }}" @selected(isset($horario['dia']) && $horario['dia'] === $dia)>{{ $dia }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="horarios[{{ $i }}][hora_inicio]" class="form-control time-picker" value="{{ $horario['hora_inicio'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="horarios[{{ $i }}][hora_termino]" class="form-control time-picker" value="{{ $horario['hora_termino'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-horario">Eliminar</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="agregar-horario">+ Añadir Horario</button>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <a href="{{ route('talleres.index') }}" class="btn btn-link">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>

@push('scripts')
{{-- MEJORA: JavaScript más limpio y robusto --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const container = document.getElementById('horarios-container');
        
        // Se leen los datos desde los atributos data-*
        const dias = JSON.parse(container.dataset.diasSemana);
        let index = parseInt(container.dataset.indexInicial, 10);

        function initTimePickers(element = document) {
            flatpickr(element.querySelectorAll('.time-picker'), {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true,
                minuteIncrement: 10
            });
        }
        
        // Inicializa los time-pickers que ya existen en la página
        initTimePickers();

        document.getElementById('agregar-horario').addEventListener('click', function () {
            const row = document.createElement('div');
            row.classList.add('row', 'mb-2', 'horario-item');

            let selectDia = `<select name="horarios[${index}][dia]" class="form-select" required>
                                <option value="">-- Día --</option>`;
            dias.forEach(dia => {
                selectDia += `<option value="${dia}">${dia}</option>`;
            });
            selectDia += `</select>`;
            
            // El ID para los nuevos horarios es vacío
            row.innerHTML = `
                <input type="hidden" name="horarios[${index}][id]" value="">
                <div class="col-md-3">${selectDia}</div>
                <div class="col-md-3">
                    <input type="text" name="horarios[${index}][hora_inicio]" class="form-control time-picker" placeholder="Hora inicio" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="horarios[${index}][hora_termino]" class="form-control time-picker" placeholder="Hora término" required>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-horario">Eliminar</button>
                </div>
            `;
            
            container.appendChild(row);
            // Inicializa el time-picker solo para la nueva fila
            initTimePickers(row); 
            index++;
        });
        
        // Usamos delegación de eventos para manejar validación y eliminación
        container.addEventListener('input', function (e) {
            if (e.target && e.target.matches('input[name$="[hora_termino]"]')) {
                const terminoInput = e.target;
                const row = terminoInput.closest('.horario-item');
                const inicioInput = row.querySelector('input[name$="[hora_inicio]"]');
                
                terminoInput.setCustomValidity('');
                if (terminoInput.value && inicioInput.value && terminoInput.value <= inicioInput.value) {
                    terminoInput.setCustomValidity('La hora de término debe ser posterior a la hora de inicio.');
                    terminoInput.reportValidity(); // Muestra el mensaje de error inmediatamente
                }
            }
        });

        container.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-horario')) {
                e.target.closest('.horario-item').remove();
            }
        });
    });
</script>
@endpush
@endsection