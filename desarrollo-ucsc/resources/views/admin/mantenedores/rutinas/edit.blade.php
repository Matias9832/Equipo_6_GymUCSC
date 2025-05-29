@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar Rutina'])
    <div class="container-fluid py-4">
        <div class="card shadow rounded-4 p-4">
            <div class="col">
                    <h4 class="mb-4">Editar rutina</h4>
                </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('rutinas.update', $rutina->id) }}" method="POST" id="rutina-form">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la Rutina</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required value="{{ old('nombre', $rutina->nombre) }}">
                </div>
                <hr>
                <label class="form-label">Ejercicios</label>
                <div id="ejercicios-container">
                    @foreach($rutina->ejercicios as $i => $ejercicio)
                        <div class="row g-2 align-items-end ejercicio-item mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Ejercicio</label>
                                <select class="form-control ejercicio-select" name="ejercicios[{{ $i }}][id]" required>
                                    <option value="">Selecciona un ejercicio</option>
                                    @foreach($ejercicios as $ej)
                                        <option value="{{ $ej->id }}" {{ $ejercicio->id == $ej->id ? 'selected' : '' }}>
                                            {{ $ej->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Series</label>
                                <input type="number" min="1" class="form-control series-input" name="ejercicios[{{ $i }}][series]" required value="{{ $ejercicio->pivot->series }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Repeticiones</label>
                                <input type="number" min="1" class="form-control repeticiones-input" name="ejercicios[{{ $i }}][repeticiones]" required value="{{ $ejercicio->pivot->repeticiones }}">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Descanso (seg)</label>
                                <input type="number" min="0" class="form-control descanso-input" name="ejercicios[{{ $i }}][descanso]" required value="{{ $ejercicio->pivot->descanso }}">
                            </div>
                            <div class="col-md-2 mt-4">
                                <button type="button" class="btn btn-danger btn-sm remove-ejercicio">Eliminar</button>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary mb-3" id="agregar-ejercicio">+ Añadir Ejercicio</button>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('rutinas.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Plantilla oculta para ejercicios -->
    <div id="ejercicio-template" style="display:none;">
        <div class="row g-2 align-items-end ejercicio-item mb-3">
            <div class="col-md-4">
                <label class="form-label">Ejercicio</label>
                <select class="form-control ejercicio-select" required>
                    <option value="">Selecciona un ejercicio</option>
                    @foreach($ejercicios as $ej)
                        <option value="{{ $ej->id }}">{{ $ej->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Series</label>
                <input type="number" min="1" class="form-control series-input" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Repeticiones</label>
                <input type="number" min="1" class="form-control repeticiones-input" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Descanso (seg)</label>
                <input type="number" min="0" class="form-control descanso-input" required placeholder="Ej: 60">
            </div>
            <div class="col-md-2 mt-4">
                <button type="button" class="btn btn-danger btn-sm remove-ejercicio">Eliminar</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    let ejercicioIndex = {{ $rutina->ejercicios->count() }};
    document.getElementById('agregar-ejercicio').addEventListener('click', function() {
        const container = document.getElementById('ejercicios-container');
        const template = document.getElementById('ejercicio-template').firstElementChild.cloneNode(true);

        template.querySelector('.ejercicio-select').setAttribute('name', `ejercicios[${ejercicioIndex}][id]`);
        template.querySelector('.series-input').setAttribute('name', `ejercicios[${ejercicioIndex}][series]`);
        template.querySelector('.repeticiones-input').setAttribute('name', `ejercicios[${ejercicioIndex}][repeticiones]`);
        template.querySelector('.descanso-input').setAttribute('name', `ejercicios[${ejercicioIndex}][descanso]`);

        template.querySelector('.remove-ejercicio').addEventListener('click', function() {
            template.remove();
        });

        container.appendChild(template);
        ejercicioIndex++;
    });

    document.querySelectorAll('.remove-ejercicio').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.ejercicio-item').remove();
        });
    });
});
</script>
@endpush