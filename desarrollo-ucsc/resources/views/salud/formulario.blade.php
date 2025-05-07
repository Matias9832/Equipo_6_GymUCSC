@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
        <div class="text-center mb-3">
            <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
            <h3 class="mt-3 text-danger">Formulario de Salud</h3>
        </div>


    <form method="POST" action="{{ route('salud.store') }}">
        @csrf

        <div class="form-group mb-3">
            <label>¿Tiene alguna enfermedad o condición médica?</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_si" value="si" onchange="toggleFormularioSalud()" >
                        <label class="form-check-label" for="enfermedad_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_no" value="no" onchange="toggleFormularioSalud()">
                        <label class="form-check-label" for="enfermedad_no">No</label>
                    </div>
                </div>
        </div>

        <div id="formulario_salud" style="display: none;">
            <div class="form-check mb-2">
                <input type="checkbox" name="enfermo_cronico" class="form-check-input" id="enfermo_cronico" onchange="toggleDetallesSalud()">
                <label class="form-check-label" for="enfermo_cronico">Enfermo Crónico</label>
            </div>
            <div id="detalles_enfermo_cronico" style="display: none;" class="mb-3">
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
            

            <div class="form-check mb-2">
                <input type="checkbox" name="alergias" class="form-check-input" id="alergias" onchange="toggleDetallesSalud()">
                <label class="form-check-label" for="alergias">Alergias</label>
            </div>
            <div id="detalle_alergias" style="display: none;" class="mb-3">
                <label for="detalle_alergias">Especifique sus alergias</label>
                <span>(ya sea estacional, alimentaria o a medicamentos)</span>
                <input type="text" name="detalle_alergias" value="{{ old('detalle_alergias', $salud?->detalle_alergias) }}">
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" name="indicaciones_medicas" class="form-check-input" id="indicaciones_medicas" onchange="toggleDetallesSalud()">
                <label class="form-check-label" for="indicaciones_medicas">Indicaciones Médicas</label>
            </div>

            <div id="detalle_indicaciones" style="display: none;" class="form-group mb-3">
                <label for="detalle_indicaciones">Indicaciones Médicas:</label>
                <input type="text" name="detalle_indicaciones" value="{{ old('detalle_indicaciones', $salud?->detalle_indicaciones) }}">
            </div>
            
        </div>

        <div id="declaracion_veracidad" class="mb-3" style="display: none;">
            <div class="form-check">
                <input type="checkbox" name="acepta_veracidad" id="acepta_veracidad" class="form-check-input" required>
                <label for="acepta_veracidad" class="form-check-label">
                    Declaro que la información proporcionada es verídica. 
                    <h6>(Está información puede ser modificada desde Mi Perfil)</h6>
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
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

        toggleDetallesSalud(); // actualizar visibilidad también al cargar
    }

    function toggleDetallesSalud() {
        document.getElementById('detalles_enfermo_cronico').style.display = document.getElementById('enfermo_cronico').checked ? 'block' : 'none';
        document.getElementById('detalle_alergias').style.display = document.getElementById('alergias').checked ? 'block' : 'none';
        document.getElementById('detalle_indicaciones').style.display = document.getElementById('indicaciones_medicas').checked ? 'block' : 'none';
    }

    window.onload = function () {
        toggleFormularioSalud();

        // Vincula eventos para actualizar visibilidad al marcar/desmarcar
        document.getElementById('enfermo_cronico').addEventListener('change', toggleDetallesSalud);
        document.getElementById('alergias').addEventListener('change', toggleDetallesSalud);
        document.getElementById('indicaciones_medicas').addEventListener('change', toggleDetallesSalud);
    }
</script>

@endsection
