@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Formulario de Salud</h2>

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
                <input type="checkbox" name="enfermo_cronico" class="form-check-input" id="enfermo_cronico">
                <label class="form-check-label" for="enfermo_cronico">Enfermo Crónico</label>
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" name="alergias" class="form-check-input" id="alergias">
                <label class="form-check-label" for="alergias">Alergias</label>
            </div>

            <div class="form-check mb-2">
                <input type="checkbox" name="indicaciones_medicas" class="form-check-input" id="indicaciones_medicas">
                <label class="form-check-label" for="indicaciones_medicas">Indicaciones Médicas</label>
            </div>

            <div class="form-group mb-3">
                <label for="informacion_salud">Información Adicional</label>
                <textarea name="informacion_salud" class="form-control" id="informacion_salud" rows="3"></textarea>
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
        const seleccion = document.getElementById('tiene_enfermedad').value;
        const formulario = document.getElementById('formulario_salud');
        const declaracion = document.getElementById('declaracion_veracidad');

        if (seleccion === 'si') {
            formulario.style.display = 'block';
            declaracion.style.display = 'block';
        } else if (seleccion === 'no') {
            formulario.style.display = 'none';
            declaracion.style.display = 'block';
        } else {
            formulario.style.display = 'none';
            declaracion.style.display = 'none';
        }
    }
</script>
@endsection
