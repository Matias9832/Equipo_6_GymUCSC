@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Academias Deportivas'])

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Registrar nueva academia</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('academias.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre_academia" class="form-label">Nombre de la academia</label>
                            <input type="text" name="nombre_academia" id="nombre_academia" class="form-control" placeholder="Ej: Academia de Fútbol" required maxlength="255" value="{{ old('nombre_academia') }}">
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_academia" class="form-label">Descripción</label>
                            <textarea name="descripcion_academia" id="descripcion_academia" class="form-control" rows="3" placeholder="Puedes explicar en qué consiste esta academia o sus objetivos" required>{{ old('descripcion_academia') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Espacio</label>
                            <select name="id_espacio" class="form-select" required>
                                <option value="">Seleccione un espacio</option>
                                @foreach($espacios as $espacio)
                                    <option value="{{ $espacio->id_espacio }}" {{ old('id_espacio') == $espacio->id_espacio ? 'selected' : '' }}>
                                        {{ $espacio->nombre_espacio }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Implementos (opcional)</label>
                            <input type="text" name="implementos" class="form-control" placeholder="Ej: Camiseta, buzo, zapatillas, etc." value="{{ old('implementos') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Matrícula</label>
                            <input type="text" name="matricula" class="form-control" placeholder="Precio de la matrícula" required value="{{ old('matricula') }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mensualidad</label>
                            <input type="text" name="mensualidad" class="form-control" placeholder="Valor de la mensualidad" required value="{{ old('mensualidad') }}">
                        </div>

                        <hr>
                        <h6>Horarios</h6>
                        @php
                            $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            $horarios_old = old('horarios', []);
                        @endphp

                        <div id="horarios-container" data-dias-semana="{{ json_encode($diasSemana) }}" data-index-inicial="{{ count($horarios_old) }}">
                            @if (count($horarios_old) > 0)
                                @foreach($horarios_old as $i => $horario)
                                    <div class="row my-2 horario-item">
                                        <div class="col-md-3">
                                            <select name="horarios[{{ $i }}][dia]" class="form-select @error('horarios.'.$i.'.dia') is-invalid @enderror" required>
                                                <option value="">-- Día --</option>
                                                @foreach($diasSemana as $dia)
                                                    <option value="{{ $dia }}" @selected(isset($horario['dia']) && $horario['dia'] === $dia)>{{ $dia }}</option>
                                                @endforeach
                                            </select>
                                            @error('horarios.'.$i.'.dia')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="horarios[{{ $i }}][hora_inicio]" class="form-control time-picker @error('horarios.'.$i.'.hora_inicio') is-invalid @enderror" placeholder="Hora inicio" value="{{ $horario['hora_inicio'] ?? '' }}" required>
                                            @error('horarios.'.$i.'.hora_inicio')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" name="horarios[{{ $i }}][hora_fin]" class="form-control time-picker @error('horarios.'.$i.'.hora_fin') is-invalid @enderror" placeholder="Hora término" value="{{ $horario['hora_fin'] ?? '' }}" required>
                                            @error('horarios.'.$i.'.hora_fin')
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
                            <button type="submit" class="btn btn-primary">Guardar academia</button>
                            <a href="{{ route('academias.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection

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
                <div class="col-md-3">
                    <select name="horarios[${index}][dia]" class="form-select" required>${selectDiaOptions}</select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="horarios[${index}][hora_inicio]" class="form-control time-picker" placeholder="Hora inicio" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="horarios[${index}][hora_fin]" class="form-control time-picker" placeholder="Hora término" required>
                </div>
                <div class="col-md-3 d-flex align-items-center">
                    <button type="button" class="btn btn-danger btn-sm remove-horario">Eliminar</button>
                </div>
            `;
            container.appendChild(newRow);
            initTimePickers(newRow);
            index++;
        });

        container.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-horario')) {
                e.target.closest('.horario-item').remove();
            }
        });

        // Validación en tiempo real (hora_fin > hora_inicio)
        container.addEventListener('input', function (e) {
            if (e.target && e.target.matches('input[name$="[hora_fin]"]')) {
                const terminoInput = e.target;
                const row = terminoInput.closest('.horario-item');
                const inicioInput = row.querySelector('input[name$="[hora_inicio]"]');
                
                terminoInput.setCustomValidity('');
                if (terminoInput.value && inicioInput.value) {
                    const inicioTime = new Date(`2000/01/01 ${inicioInput.value}`);
                    const terminoTime = new Date(`2000/01/01 ${terminoInput.value}`);

                    if (terminoTime <= inicioTime) {
                        terminoInput.setCustomValidity('La hora de término debe ser posterior a la hora de inicio.');
                        terminoInput.reportValidity();
                    }
                }
            }
        });
    });
</script>
@endpush