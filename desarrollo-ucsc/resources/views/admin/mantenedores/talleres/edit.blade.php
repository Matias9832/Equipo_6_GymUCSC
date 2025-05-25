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
                <div class="card-body">
                    <form action="{{ route('talleres.update', $taller) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Datos del taller --}}
                        <div class="mb-3">
                            <label for="nombre_taller" class="form-label">Nombre Taller</label>
                            <input type="text" name="nombre_taller" class="form-control" value="{{ old('nombre_taller', $taller->nombre_taller) }}" required>
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
                                    <option value="{{ $admin->id_admin }}" {{ $taller->id_admin == $admin->id_admin ? 'selected' : '' }}>
                                        {{ $admin->nombre_admin }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="hidden" name="activo_taller" value="0">
                            <input type="checkbox" name="activo_taller" class="form-check-input" value="1" {{ $taller->activo_taller ? 'checked' : '' }}>
                            <label class="form-check-label">Activo</label>
                        </div>

                        <hr>
                        <h6>Horarios</h6>

                        @php $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo']; @endphp

                        <div id="horarios-container">
                            @foreach($taller->horarios as $i => $horario)
                                <div class="row mb-2 horario-item">
                                    <input type="hidden" name="horarios[{{ $i }}][id]" value="{{ $horario->id }}">
                                    <div class="col-md-3">
                                        <select name="horarios[{{ $i }}][dia]" class="form-select" required>
                                            <option value="">-- Día --</option>
                                            @foreach($diasSemana as $dia)
                                                <option value="{{ $dia }}" {{ $horario->dia_taller === $dia ? 'selected' : '' }}>{{ $dia }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="horarios[{{ $i }}][hora_inicio]" class="form-control" value="{{ $horario->hora_inicio }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="time" name="horarios[{{ $i }}][hora_termino]" class="form-control" value="{{ $horario->hora_termino }}" required>
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    let index = {{ $taller->horarios->count() }};

    document.getElementById('agregar-horario').addEventListener('click', function () {
        const container = document.getElementById('horarios-container');
        const original = container.querySelector('.horario-item');
        const clone = original.cloneNode(true);

        // Limpiar valores
        clone.querySelectorAll('input, select').forEach(input => {
            if (input.type === 'hidden' || input.name.includes('[id]')) {
                input.remove(); // eliminar input oculto de ID si lo tiene
            } else {
                input.value = '';
            }
        });

        // Reasignar nombres con el nuevo índice
        clone.querySelectorAll('select, input').forEach(input => {
            input.name = input.name.replace(/\[\d+\]/, `[${index}]`);
        });

        // Mostrar botón eliminar si estaba oculto
        clone.querySelector('.remove-horario')?.classList.remove('d-none');

        // Agregar evento eliminar
        clone.querySelector('.remove-horario')?.addEventListener('click', function () {
            clone.remove();
        });

        container.appendChild(clone);
        index++;
    });

    // Delegación para botones ya existentes
    document.querySelectorAll('.remove-horario').forEach(btn => {
        btn.addEventListener('click', function () {
            btn.closest('.horario-item').remove();
        });
    });
});
</script>
@endpush

@endsection
