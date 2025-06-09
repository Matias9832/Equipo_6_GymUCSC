@extends('layouts.app')

@section('content')
@include('layouts.navbars.guest.navbar')

<main class="main-content mt-0">
    <!-- Fondo superior estilo Argon -->
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 m-3 border-radius-lg"
        style="background-image: url('https://ucsc.cl/content/uploads/2023/08/hero-facultad.jpg'); background-position: top;">
        <span class="mask bg-gradient-dark opacity-6"></span>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 text-center mx-auto">
                    <h1 class="text-white mb-2 mt-5">Formulario de Salud</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row mt-lg-n10 mt-md-n11 mt-n10 justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 mx-auto">
                <div class="card z-index-0">
                    <div class="card-body">
                        <form id="formularioSalud" method="POST" action="{{ route('salud.store') }}">
                            @csrf

                            <div class="mb-3">
                                <h6 class="mb-2">¿Presenta alguna enfermedad o condición médica?</h6>
                                <small class="d-block mb-2">(Ej: enfermedad crónica, alergias o indicaciones médicas)</small>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_si" value="si" onchange="toggleFormularioSalud()">
                                    <label class="form-check-label" for="enfermedad_si">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tiene_enfermedad" id="enfermedad_no" value="no" onchange="toggleFormularioSalud()">
                                    <label class="form-check-label" for="enfermedad_no">No</label>
                                </div>
                            </div>

                            <div id="formulario_salud" style="display: none;">
                                {{-- Enfermedades crónicas --}}
                                <input type="hidden" name="enfermo_cronico" value="0">
                                <div class="form-check mb-1">
                                    <input type="checkbox" name="enfermo_cronico" class="form-check-input" id="enfermo_cronico" value="1" onchange="toggleDetallesSalud()">
                                    <label for="enfermo_cronico" class="form-check-label">¿Presenta enfermedades crónicas?</label>
                                </div>
                                <div class="mb-3 ms-4" id="detalles_enfermo_cronico" style="display: none;">
                                    <small class="d-block text-muted mb-1">Seleccione sus enfermedades crónicas:</small>
                                    @php
                                        $opciones = ['Diabetes', 'Hipertensión', 'Asma', 'Epilepsia', 'Otra'];
                                    @endphp
                                    @foreach($opciones as $opcion)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="cronicas[]" value="{{ $opcion }}">
                                            <label class="form-check-label">{{ $opcion }}</label>
                                        </div>
                                    @endforeach
                                    <div id="error_cronicas" class="text-danger small mt-1"></div>
                                </div>

                                {{-- Alergias --}}
                                <input type="hidden" name="alergias" value="0">
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="alergias" class="form-check-input" id="alergias" value="1" onchange="toggleDetallesSalud()">
                                    <label for="alergias" class="form-check-label">¿Presenta alergias?</label>
                                </div>
                                <div class="mb-3 ms-4" id="detalle_alergias" style="display: none;">
                                    <small class="d-block text-muted mb-1">Escriba aquí sus alergias que puedan afectar su salud o actividad física</small>
                                    <input type="text" name="detalle_alergias" id="detalle_alergias_input" placeholder="Ej: Estacional, alimentaria, medicamentos, etc." class="form-control" value="{{ old('detalle_alergias') }}">
                                    <div id="error_alergias" class="text-danger small mt-1"></div>
                                </div>

                                {{-- Indicaciones médicas --}}
                                <input type="hidden" name="indicaciones_medicas" value="0">
                                <div class="form-check mb-2">
                                    <input type="checkbox" name="indicaciones_medicas" class="form-check-input" id="indicaciones_medicas" value="1" onchange="toggleDetallesSalud()">
                                    <label for="indicaciones_medicas" class="form-check-label">¿Presenta indicaciones médicas?</label>
                                </div>
                                <div class="mb-3 ms-4" id="detalle_indicaciones" style="display: none;">
                                    <small class="d-block text-muted mb-1">Escriba aquí sus indicaciones que puedan afectar su salud o actividad física</small>
                                    <input type="text" name="detalle_indicaciones" id="detalle_indicaciones_input" placeholder="Ej: No realizar pesas por 3 meses o lesión en el tobillo" class="form-control" value="{{ old('detalle_indicaciones') }}">
                                    <div id="error_indicaciones" class="text-danger small mt-1"></div>
                                </div>
                            </div>
                            <hr>
                            <div id="declaracion_veracidad" class="mb-3" style="display: none;">
                                <div class="form-check">
                                    <input type="checkbox" name="acepta_veracidad" id="acepta_veracidad" class="form-check-input" required>
                                    <label for="acepta_veracidad" class="form-check-label">
                                        Declaro que la información proporcionada es verídica.
                                        <br><small class="text-muted">(Esta información puede ser modificada desde Mi Perfil)</small>
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

{{-- Scripts --}}
<script>
    function toggleFormularioSalud() {
        const si = document.getElementById('enfermedad_si').checked;
        const formulario = document.getElementById('formulario_salud');
        const declaracion = document.getElementById('declaracion_veracidad');
        formulario.style.display = si ? 'block' : 'none';
        declaracion.style.display = 'block';
        toggleDetallesSalud();
    }

    function toggleDetallesSalud() {
        document.getElementById('detalles_enfermo_cronico').style.display = document.getElementById('enfermo_cronico').checked ? 'block' : 'none';
        document.getElementById('detalle_alergias').style.display = document.getElementById('alergias').checked ? 'block' : 'none';
        document.getElementById('detalle_indicaciones').style.display = document.getElementById('indicaciones_medicas').checked ? 'block' : 'none';
    }

    window.onload = toggleFormularioSalud;

    document.getElementById('formularioSalud').addEventListener('submit', function (e) {
        const tieneEnfermedad = document.getElementById('enfermedad_si').checked;

        const esCronico = document.getElementById('enfermo_cronico').checked;
        const seleccionadasCronicas = document.querySelectorAll('input[name="cronicas[]"]:checked');

        const tieneAlergias = document.getElementById('alergias').checked;
        const detalleAlergias = document.getElementById('detalle_alergias_input').value.trim();

        const tieneIndicaciones = document.getElementById('indicaciones_medicas').checked;
        const detalleIndicaciones = document.getElementById('detalle_indicaciones_input').value.trim();

        document.getElementById('error_cronicas').innerText = '';
        document.getElementById('error_alergias').innerText = '';
        document.getElementById('error_indicaciones').innerText = '';

        let errores = false;

        if (tieneEnfermedad && esCronico && seleccionadasCronicas.length === 0) {
            document.getElementById('error_cronicas').innerText = 'Debe seleccionar al menos una enfermedad crónica.';
            errores = true;
        }

        if (tieneEnfermedad && tieneAlergias && detalleAlergias === '') {
            document.getElementById('error_alergias').innerText = 'Debe especificar sus alergias.';
            errores = true;
        }

        if (tieneEnfermedad && tieneIndicaciones && detalleIndicaciones === '') {
            document.getElementById('error_indicaciones').innerText = 'Debe especificar las indicaciones médicas.';
            errores = true;
        }

        if (errores) {
            e.preventDefault();
        }
    });
</script>
@endsection
