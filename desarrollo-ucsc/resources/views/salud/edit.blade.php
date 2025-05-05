@extends('layouts.app')

@section('content')

<div class="container d-flex justify-content-center mt-5">
    <div class="card shadow p-4" style="width: 100%; max-width: 500px;">
        <div class="text-center mb-3">
            <img src="{{ asset('images/logo_ucsc.png') }}" alt="Logo UCSC" style="width: 100px;">
            <h3 class="mt-3 text-danger">Editar Información de Salud</h3>
        </div>
        
        <form method="POST" action="{{ route('salud.update') }}">
            @csrf

            <div class="form-group mb-3">
                <label>¿Tiene alguna enfermedad o condición médica?</label>
                <span>(Ya sea enfermedad cornica, alegias u indicaciones medicas)</span>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_si" value="si" onchange="toggleFormularioSalud()" {{ $salud->enfermo_cronico || $salud->alergias || $salud->indicaciones_medicas ? 'checked' : '' }}>
                        <label class="form-check-label" for="enfermedad_si">Sí</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_no" value="no" onchange="toggleFormularioSalud()" {{ (!$salud->enfermo_cronico && !$salud->alergias && !$salud->indicaciones_medicas) ? 'checked' : '' }}>
                        <label class="form-check-label" for="enfermedad_no">No</label>
                    </div>
                </div>
            </div>

            <div id="formulario_salud" style="display: none;">
                <div class="form-check mb-2">
                    <input type="checkbox" name="enfermo_cronico" class="form-check-input" id="enfermo_cronico" {{ $salud->enfermo_cronico ? 'checked' : '' }}>
                    <label class="form-check-label" for="enfermo_cronico">Enfermo Crónico</label>
                </div>

                <div class="form-check mb-2">
                    <input type="checkbox" name="alergias" class="form-check-input" id="alergias" {{ $salud->alergias ? 'checked' : '' }}>
                    <label class="form-check-label" for="alergias">Alergias</label>
                </div>

                <div class="form-check mb-2">
                    <input type="checkbox" name="indicaciones_medicas" class="form-check-input" id="indicaciones_medicas" {{ $salud->indicaciones_medicas ? 'checked' : '' }}>
                    <label class="form-check-label" for="indicaciones_medicas">Indicaciones Médicas</label>
                </div>

                <div class="form-group mb-3">
                    <label for="informacion_salud">Información Adicional</label>
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
    }

    // Ejecutar al cargar la página para mantener visibilidad si ya hay datos
    window.onload = toggleFormularioSalud;
</script>

@endsection

