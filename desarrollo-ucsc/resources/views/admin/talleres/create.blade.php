@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Talleres'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header pb-0">
                        <h5>Registrar nuevo taller</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('talleres.store') }}" method="POST">
                            @csrf
                            <div class="mb-3 form-check">
                                <input type="hidden" name="activo_taller" value="0">
                                <input type="checkbox" name="activo_taller" id="activo_taller" class="form-check-input"
                                    value="1" {{ old('activo_taller', true) ? 'checked' : '' }}>
                                <label for="activo_taller" class="form-check-label">Taller activo</label>
                            </div>
                            <div class="mb-3">
                                <label for="nombre_taller" class="form-label">Nombre</label>
                                <input type="text" name="nombre_taller" id="nombre_taller" placeholder="Nombre del taller" class="form-control {{ $errors->has('nombre_taller') ? 'is-invalid' : '' }}"
                                    value="{{ old('nombre_taller') }}" required maxlength="100">
                                @error('nombre_taller') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion_taller" class="form-label">Descripción</label>
                                <textarea name="descripcion_taller" id="descripcion_taller" placeholder="Descripción sobre qué trata el taller" class="form-control {{ $errors->has('descripcion_taller') ? 'is-invalid' : '' }}" rows="3"
                                    required>{{ old('descripcion_taller') }}</textarea>
                                @error('descripcion_taller') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cupos_taller" class="form-label">Cupos</label>
                                <input type="number" name="cupos_taller" id="cupos_taller" placeholder="Cantidad de cupos disponibles para el taller" class="form-control {{ $errors->has('cupos_taller') ? 'is-invalid' : '' }}"
                                    value="{{ old('cupos_taller') }}" required min="1">
                                @error('cupos_taller') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="restricciones_taller" class="form-label">Restricciones</label>
                                <textarea name="restricciones_taller" id="restricciones_taller" placeholder="Restricciones para participar en el taller (opcional)" class="form-control {{ $errors->has('restricciones_taller') ? 'is-invalid' : '' }}" rows="3">{{ old('restricciones_taller') }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="id_admin" class="form-label">Profesor asignado</label>
                                <select name="id_admin" id="id_admin" class="form-select {{ $errors->has('id_admin') ? 'is-invalid' : '' }}">
                                    <option value="">-- Sin asignar --</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id_admin }}" {{ old('id_admin') == $admin->id_admin ? 'selected' : '' }}>
                                            {{ $admin->nombre_admin }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_admin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="id_espacio" class="form-label">Espacio</label>
                                <select name="id_espacio" id="id_espacio" class="form-select {{ $errors->has('id_espacio') ? 'is-invalid' : '' }}">
                                    <option value="">-- Sin asignar --</option>
                                    @foreach($espacios as $espacio)
                                        <option value="{{ $espacio->id_espacio }}" {{ old('id_espacio') == $espacio->id_espacio ? 'selected' : '' }}>
                                            {{ $espacio->nombre_espacio }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_espacio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>             
                            <hr>
                            <h6>Horarios</h6>

                            @php
                                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                $horarios_old = old('horarios', []); // Obtiene los horarios previos o un array vacío
                            @endphp

                            <div id="horarios-container" data-dias-semana="{{ json_encode($diasSemana) }}" data-index-inicial="{{ count($horarios_old) }}">
                                @if (count($horarios_old) > 0)
                                    {{-- Si hay horarios antiguos (ej. después de un error de validación), mostrarlos --}}
                                    @foreach($horarios_old as $i => $horario)
                                        <div class="row my-2 horario-item">
                                            <input type="hidden" name="horarios[{{ $i }}][id]" value="{{ $horario['id'] ?? '' }}">
                                            <div class="col-md-3">
                                                <select name="horarios[{{ $i }}][dia]" class="form-select {{ $errors->has('horarios.' . $i . '.dia') ? 'is-invalid' : '' }}">
                                                    <option value="">-- Día --</option>
                                                    @foreach($diasSemana as $dia)
                                                        <option value="{{ $dia }}" @selected(isset($horario['dia']) && $horario['dia'] === $dia)>{{ $dia }}</option>
                                                    @endforeach
                                                </select>
                                                @error('horarios.' . $i . '.dia')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="horarios[{{ $i }}][hora_inicio]" class="form-control time-picker {{ $errors->has('horarios.' . $i . '.hora_inicio') ? 'is-invalid' : '' }}" placeholder="Hora inicio" value="{{ $horario['hora_inicio'] ?? '' }}">
                                                @error('horarios.' . $i . '.hora_inicio')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" name="horarios[{{ $i }}][hora_termino]" class="form-control time-picker {{ $errors->has('horarios.' . $i . '.hora_termino') ? 'is-invalid' : '' }}" placeholder="Hora término" value="{{ $horario['hora_termino'] ?? '' }}">
                                                @error('horarios.' . $i . '.hora_termino')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 d-flex align-items-center">
                                                <button type="button" class="btn btn-danger btn-sm remove-horario">Eliminar</button>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif    
                            </div>
                            <button type="button" class="btn btn-secondary btn-sm mt-2" id="agregar-horario">+ Añadir Horario</button>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <button type="submit" class="btn btn-primary ">Guardar</button>
                                <a href="{{ route('talleres.index') }}" class="btn btn-outline-secondary ">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('horarios-container');
            const diasSemana = JSON.parse(container.dataset.diasSemana);
            let index = parseInt(container.dataset.indexInicial, 10);

            function initTimePickers(element = document) {
                flatpickr(element.querySelectorAll('.time-picker'), {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: "H:i",
                    time_24hr: true,
                    minuteIncrement: 5
                });
            }

            // Inicializa los time-pickers existentes (si hay errores y se recargó la página)
            initTimePickers();

            document.getElementById('agregar-horario').addEventListener('click', function () {
                const newRow = document.createElement('div');
                newRow.classList.add('row', 'my-2', 'horario-item');

                let selectDiaOptions = `<option value="">-- Día --</option>`;
                diasSemana.forEach(dia => {
                    selectDiaOptions += `<option value="${dia}">${dia}</option>`;
                });

                newRow.innerHTML = `
                    <input type="hidden" name="horarios[${index}][id]" value="">
                    <div class="col-md-3">
                        <select name="horarios[${index}][dia]" class="form-select" required>${selectDiaOptions}</select>
                    </div>
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
                
                container.appendChild(newRow);
                initTimePickers(newRow); // Inicializa flatpickr solo para la nueva fila
                index++;
            });

            // Delegación de eventos para el botón eliminar
            container.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-horario')) {
                    e.target.closest('.horario-item').remove();
                }
            });

            // Delegación de eventos para la validación en tiempo real (hora_termino > hora_inicio)
            container.addEventListener('input', function (e) {
                if (e.target && e.target.matches('input[name$="[hora_termino]"]')) {
                    const terminoInput = e.target;
                    const row = terminoInput.closest('.horario-item');
                    const inicioInput = row.querySelector('input[name$="[hora_inicio]"]');
                    
                    terminoInput.setCustomValidity(''); // Limpia cualquier mensaje anterior
                    if (terminoInput.value && inicioInput.value) {
                        const inicioTime = new Date(`2000/01/01 ${inicioInput.value}`);
                        const terminoTime = new Date(`2000/01/01 ${terminoInput.value}`);

                        if (terminoTime <= inicioTime) {
                            terminoInput.setCustomValidity('La hora de término debe ser posterior a la hora de inicio.');
                            terminoInput.reportValidity(); // Muestra el globo de error
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endsection