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
                <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
                    <div class="card z-index-0">
                        <div class="card-body">
                            <form id="formularioSalud" method="POST" action="{{ route('salud.store') }}">
                                @csrf

                                <div class="form-group mb-3">
                                    <label>¿Tiene alguna enfermedad o condición médica?</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tiene_enfermedad"
                                                id="enfermedad_si" value="si" onchange="toggleFormularioSalud()">
                                            <label class="form-check-label" for="enfermedad_si">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="tiene_enfermedad"
                                                id="enfermedad_no" value="no" onchange="toggleFormularioSalud()">
                                            <label class="form-check-label" for="enfermedad_no">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div id="formulario_salud" style="display: none;">
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="enfermo_cronico" class="form-check-input"
                                            id="enfermo_cronico" onchange="toggleDetallesSalud()">
                                        <label class="form-check-label" for="enfermo_cronico">Enfermo Crónico</label>
                                    </div>
                                    <div id="detalles_enfermo_cronico" style="display: none;" class="mb-3">
                                        <label for="cronicas">Seleccione sus enfermedades crónicas:</label>
                                        <select name="cronicas[]" id="cronicas" class="form-select" multiple>
                                            @php
                                                $opciones = ['Diabetes', 'Hipertensión', 'Asma', 'Epilepsia', 'Otra'];
                                            @endphp
                                            @foreach($opciones as $opcion)
                                                <option value="{{ $opcion }}" {{ in_array($opcion, $salud->cronicas ?? []) ? 'selected' : '' }}>
                                                    {{ $opcion }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div id="error_cronicas" class="text-danger small mt-1"></div>

                                    </div>


                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="alergias" class="form-check-input" id="alergias"
                                            onchange="toggleDetallesSalud()">
                                        <label class="form-check-label" for="alergias">Alergias</label>
                                        
                                    </div>
                                    <div id="detalle_alergias" style="display: none;" class="mb-3">
                                        <label for="detalle_alergias">Especifique sus alergias    
                                            <span>(ya sea estacional, alimentaria o a medicamentos)</span>
                                        </label>
                                        <input class="w-100" type="text" name="detalle_alergias"
                                        value="{{ old('detalle_alergias', $salud?->detalle_alergias) }}">
                                        <div id="error_alergias" class="text-danger small mt-1"></div>
                                        
                                    </div>
                                    
                                    <div class="form-check mb-2">
                                        <input type="checkbox" name="indicaciones_medicas" class="form-check-input"
                                        id="indicaciones_medicas" onchange="toggleDetallesSalud()">
                                        <label class="form-check-label" for="indicaciones_medicas">Indicaciones
                                            Médicas</label>
                                        </div>
                                        
                                        <div id="detalle_indicaciones" style="display: none;" class="form-group mb-3">
                                        <label for="detalle_indicaciones">Indicaciones Médicas:</label>
                                        <input class="w-100" type="text" name="detalle_indicaciones"
                                        value="{{ old('detalle_indicaciones', $salud?->detalle_indicaciones) }}">
                                        <div id="error_indicaciones" class="text-danger small mt-1"></div>
                                    </div>
                                    
                                    
                                </div>
                                
                                

                                <div id="declaracion_veracidad" class="mb-3" style="display: none;">
                                    <div class="form-check">
                                        <input type="checkbox" name="acepta_veracidad" id="acepta_veracidad"
                                            class="form-check-input" required>
                                        <label for="acepta_veracidad" class="form-check-label">
                                            Declaro que la información proporcionada es verídica.
                                            <h6>(Está información puede ser modificada desde Mi Perfil)</h6>
                                        </label>
                                    </div>
                                </div>

                                    
                                <button type="submit" class="btn btn-primary">Guardar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="container d-flex justify-content-center mt-5">

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

        <script>
            document.getElementById('formularioSalud').addEventListener('submit', function (e) {
                const tieneEnfermedad = document.getElementById('enfermedad_si').checked;

                // Elementos
                const esCronico = document.getElementById('enfermo_cronico').checked;
                const selectCronicas = document.getElementById('cronicas');
                const seleccionadasCronicas = Array.from(selectCronicas.selectedOptions);

                const tieneAlergias = document.getElementById('alergias').checked;
                const detalleAlergias = document.querySelector('input[name="detalle_alergias"]').value.trim();

                const tieneIndicaciones = document.getElementById('indicaciones_medicas').checked;
                const detalleIndicaciones = document.querySelector('input[name="detalle_indicaciones"]').value.trim();

                // Limpia errores anteriores
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

    </div>

@endsection