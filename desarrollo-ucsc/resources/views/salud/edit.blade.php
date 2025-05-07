@extends('layouts.app')


@section('content')

<div class="container d-flex justify-content-center mt-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show w-100" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    <div class="card shadow p-4" style="width: 100%; max-width: 600px;">
        <div class="text-center mb-3">
            <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
            <h3 class="mt-3 text-danger">Editar Información de Salud</h3>
        </div>
        
        <form method="POST" action="{{ route('salud.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label>¿Tiene alguna enfermedad o condición médica?</label>
                <span>(Ya sea enfermedad crónica, alergias o indicaciones médicas)</span>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_si" value="si" onchange="toggleFormularioSalud()" {{ $tieneEnfermedad ? 'checked' : '' }}>
                        <label class="form-check-label" for="enfermedad_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_no" value="no" onchange="toggleFormularioSalud()" {{ !$tieneEnfermedad ? 'checked' : '' }}>
                        <label class="form-check-label" for="enfermedad_no">No</label>
                    </div>
                </div>
            </div>

            <div id="formulario_salud" style="display: none;">
                {{-- Enfermo crónico --}}
                <input type="hidden" name="enfermo_cronico" value="0">
                <div class="form-check mb-2">
                    <input type="checkbox" name="enfermo_cronico" class="form-check-input" id="enfermo_cronico" value="1" {{ $salud->enfermo_cronico ? 'checked' : '' }} onchange="toggleDetallesSalud()">
                    <label for="enfermo_cronico" class="form-check-label">¿Tiene enfermedades crónicas?</label>
                </div>
                <div class="mb-3" id="detalles_enfermo_cronico" style="display: none;">
                    <label for="cronicas">Seleccione sus enfermedades crónicas:</label>
                    <select name="cronicas[]" id="cronicas" class="form-select" multiple>
                        @php
                            $opciones = ['Diabetes', 'Hipertensión', 'Asma', 'Epilepsia', 'Otra'];
                        @endphp
                        @foreach($opciones as $opcion)
                            <option value="{{ $opcion }}" {{ in_array($opcion, $salud->cronicas ?? []) ? 'selected' : '' }}>{{ $opcion }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Alergias --}}
                <input type="hidden" name="alergias" value="0">
                <div class="form-check mb-2">
                    <input type="checkbox" name="alergias" class="form-check-input" id="alergias" value="1" {{ $salud->alergias ? 'checked' : '' }} onchange="toggleDetallesSalud()">
                    <label for="alergias" class="form-check-label">¿Tiene alergias?</label>
                </div>
                <div class="form-group mb-3" id="detalle_alergias" style="display: none;">
                    <label for="detalle_alergias_input">Alergias (si corresponde):</label>
                    <input type="text" name="detalle_alergias" id="detalle_alergias_input" class="form-control" value="{{ $salud->detalle_alergias }}">
                </div>

                {{-- Indicaciones médicas --}}
                <input type="hidden" name="indicaciones_medicas" value="0">
                <div class="form-check mb-2">
                    <input type="checkbox" name="indicaciones_medicas" class="form-check-input" id="indicaciones_medicas" value="1" {{ $salud->indicaciones_medicas ? 'checked' : '' }} onchange="toggleDetallesSalud()">
                    <label for="indicaciones_medicas" class="form-check-label">¿Tiene indicaciones médicas?</label>
                </div>
                <div class="form-group mb-3" id="detalle_indicaciones" style="display: none;">
                    <label for="detalle_indicaciones_input">Indicaciones Médicas (si corresponde):</label>
                    <input type="text" name="detalle_indicaciones" id="detalle_indicaciones_input" class="form-control" value="{{ $salud->detalle_indicaciones }}">
                </div>

                {{-- Información adicional --}}
                <div class="form-group mb-3">
                    <label for="informacion_salud">Información Adicional (Que creas relevante)</label>
                    <textarea name="informacion_salud" class="form-control" id="informacion_salud" rows="3">{{ $salud->informacion_salud }}</textarea>
                </div>
            </div>

            <div id="declaracion_veracidad" class="mb-3" style="display: none;">
                <div class="form-check">
                    <input type="checkbox" name="acepta_veracidad" id="acepta_veracidad" class="form-check-input" required>
                    <label for="acepta_veracidad" class="form-check-label">
                        Declaro que la información proporcionada es verídica.
                        <h6>(Esta información puede ser modificada desde Mi Perfil)</h6>
                    </label>
                </div>
            </div>

            <div class="d-flex justify-content-between gap-2 mt-3">
                <button type="submit" class="btn btn-primary">Actualizar</button>
                <a href="{{ route('mi-perfil.edit') }}" class="btn btn-secondary">Volver</a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleFormularioSalud() {
        const si = document.getElementById('enfermedad_si').checked;
        const formulario = document.getElementById('formulario_salud');
        const declaracion = document.getElementById('declaracion_veracidad');

        if (si) {
            formulario.style.display = 'block';
            declaracion.style.display = 'block';
        } else {
            formulario.style.display = 'none';
            declaracion.style.display = 'block';
        }

        toggleDetallesSalud();
    }

    function toggleDetallesSalud() {
        document.getElementById('detalles_enfermo_cronico').style.display = document.getElementById('enfermo_cronico').checked ? 'block' : 'none';
        document.getElementById('detalle_alergias').style.display = document.getElementById('alergias').checked ? 'block' : 'none';
        document.getElementById('detalle_indicaciones').style.display = document.getElementById('indicaciones_medicas').checked ? 'block' : 'none';
    }

    window.onload = function () {
        toggleFormularioSalud();
    }
</script>

@endsection



