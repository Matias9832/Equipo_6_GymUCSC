@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Torneos'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header pb-0">
                    <h5>Crear nuevo torneo</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('torneos.store') }}" method="POST" id="form-torneo">
                        @csrf
                        <div class="mb-3">
                            <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
                            <input type="text" name="nombre_torneo" id="nombre_torneo" placeholder="Ej: Liga de basketball interfacultades" class="form-control" required>
                            <div id="nombre-torneo-error" class="text-danger mt-1" style="display:none;"></div>
                        </div>
                        <div class="mb-3">
                            <label for="id_deporte" class="form-label">Deporte</label>
                            <select name="id_deporte" id="id_deporte" class="form-select" required>
                                <option value="">Seleccione un deporte</option>
                                @foreach($deportes as $deporte)
                                    <option value="{{ $deporte->id_deporte }}">{{ $deporte->nombre_deporte }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_competencia" class="form-label">Tipo de Torneo</label>
                            <select name="tipo_competencia" id="tipo_competencia" class="form-select" required>
                                <option value="">Seleccione un tipo de torneo</option>
                                <option value="liga">Liga</option>
                                <option value="copa">Copa</option>
                                <option value="encuentro">Encuentro</option>
                            </select>
                        </div>

                        <div id="opciones-copa" style="display: none;">
                            <div class="mb-3">
                                <label for="fase_grupos" class="form-label">¿Tiene fase de grupos?</label>
                                <select name="fase_grupos" id="fase_grupos" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <option value="1">Sí</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="max-equipos-div" style="display:none;">
                            <label for="max_equipos" class="form-label">Cantidad de Equipos</label>
                            <select name="max_equipos" id="max_equipos" class="form-select" required>
                                <option value="">Seleccione...</option>
                                <!-- Opciones generadas por JS -->
                            </select>
                        </div>

                        <div id="opciones-grupos" style="display: none;">
                            <div class="mb-3">
                                <label for="numero_grupos" class="form-label">Número de grupos</label>
                                <select name="numero_grupos" id="numero_grupos" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <!-- Opciones generadas por JS -->
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="clasifican_por_grupo" class="form-label">Equipos que clasifican por grupo</label>
                                <select name="clasifican_por_grupo" id="clasifican_por_grupo" class="form-select">
                                    <option value="">Seleccione...</option>
                                    <!-- Opciones generadas por JS -->
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="tercer-lugar-div" style="display:none;">
                            <label for="tercer_lugar" class="form-label">¿Se juega partido por el tercer lugar?</label>
                            <select name="tercer_lugar" id="tercer_lugar" class="form-select">
                                <option value="0">No</option>
                                <option value="1">Sí</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Crear Torneo</button>
                            <a href="{{ route('torneos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>        
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipoCompetenciaSelect = document.getElementById('tipo_competencia');
        const opcionesCopaDiv = document.getElementById('opciones-copa');
        const faseGruposSelect = document.getElementById('fase_grupos');
        const opcionesGruposDiv = document.getElementById('opciones-grupos');
        const maxEquiposSelect = document.getElementById('max_equipos');
        const maxEquiposDiv = document.getElementById('max-equipos-div');
        const numeroGruposSelect = document.getElementById('numero_grupos');
        const clasificanPorGrupoSelect = document.getElementById('clasifican_por_grupo');
        const tercerLugarDiv = document.getElementById('tercer-lugar-div');
        const nombreTorneoInput = document.getElementById('nombre_torneo');
        const nombreTorneoError = document.getElementById('nombre-torneo-error');
        const formTorneo = document.getElementById('form-torneo');

        // Valores permitidos
        const valoresPares = [];
        for(let i=2; i<=30; i+=2) valoresPares.push(i);
        const potencias2 = [2,4,8,16,32];

        // Validar nombre de torneo único (AJAX)
        nombreTorneoInput.addEventListener('blur', function() {
            const nombre = nombreTorneoInput.value.trim();
            if (!nombre) return;
            fetch("{{ url('admin/torneos') }}?nombre=" + encodeURIComponent(nombre))
                .then(res => res.json())
                .then(data => {
                    if (data.exists) {
                        nombreTorneoError.textContent = 'Ya existe un torneo con ese nombre.';
                        nombreTorneoError.style.display = 'block';
                    } else {
                        nombreTorneoError.textContent = '';
                        nombreTorneoError.style.display = 'none';
                    }
                });
        });

        formTorneo.addEventListener('submit', function(e) {
            if (nombreTorneoError.textContent) {
                e.preventDefault();
                nombreTorneoInput.focus();
            }
        });

        function toggleCampos() {
            const tipo = tipoCompetenciaSelect.value;
            if (tipo === 'copa') {
                opcionesCopaDiv.style.display = 'block';
                maxEquiposDiv.style.display = 'none';
                opcionesGruposDiv.style.display = 'none';
                tercerLugarDiv.style.display = 'none';
            } else if (tipo === 'liga') {
                opcionesCopaDiv.style.display = 'none';
                opcionesGruposDiv.style.display = 'none';
                maxEquiposDiv.style.display = 'block';
                tercerLugarDiv.style.display = 'none';
                // Solo pares 2-30
                maxEquiposSelect.innerHTML = '<option value="">Seleccione...</option>';
                valoresPares.forEach(function(val) {
                    maxEquiposSelect.innerHTML += `<option value="${val}">${val}</option>`;
                });
            } else {
                opcionesCopaDiv.style.display = 'none';
                opcionesGruposDiv.style.display = 'none';
                maxEquiposDiv.style.display = 'none';
                tercerLugarDiv.style.display = 'none';
            }
        }

        function toggleFaseGrupos() {
            const fase = faseGruposSelect.value;
            if (fase === '1') {
                opcionesGruposDiv.style.display = 'block';
                maxEquiposDiv.style.display = 'block';
                tercerLugarDiv.style.display = 'block';
                // Solo pares 2-30
                maxEquiposSelect.innerHTML = '<option value="">Seleccione...</option>';
                valoresPares.forEach(function(val) {
                    maxEquiposSelect.innerHTML += `<option value="${val}">${val}</option>`;
                });
            } else if (fase === '0') {
                opcionesGruposDiv.style.display = 'none';
                maxEquiposDiv.style.display = 'block';
                tercerLugarDiv.style.display = 'block';
                // Solo potencias de 2
                maxEquiposSelect.innerHTML = '<option value="">Seleccione...</option>';
                potencias2.forEach(function(val) {
                    maxEquiposSelect.innerHTML += `<option value="${val}">${val}</option>`;
                });
            } else {
                opcionesGruposDiv.style.display = 'none';
                maxEquiposDiv.style.display = 'none';
                tercerLugarDiv.style.display = 'none';
            }
        }

        function actualizarNumeroGrupos() {
            const maxEquipos = parseInt(maxEquiposSelect.value);
            numeroGruposSelect.innerHTML = '<option value="">Seleccione...</option>';
            if (!isNaN(maxEquipos)) {
                for(let i=2; i<maxEquipos; i++) {
                    if(maxEquipos % i === 0) {
                        const equiposPorGrupo = maxEquipos / i;
                        let tieneOpcionValida = false;
                        for(let j=1; j<equiposPorGrupo; j++) {
                            if(esPotenciaDe2(j * i)) {
                                tieneOpcionValida = true;
                                break;
                            }
                        }
                        if (tieneOpcionValida) {
                            numeroGruposSelect.innerHTML += `<option value="${i}">${i}</option>`;
                        }
                    }
                }
            }
            actualizarClasificanPorGrupo();
        }

        function esPotenciaDe2(n) {
            return n > 0 && (n & (n - 1)) === 0;
        }

        function actualizarClasificanPorGrupo() {
            const maxEquipos = parseInt(maxEquiposSelect.value);
            const numGrupos = parseInt(numeroGruposSelect.value);
            clasificanPorGrupoSelect.innerHTML = '<option value="">Seleccione...</option>';
            if (!isNaN(maxEquipos) && !isNaN(numGrupos) && numGrupos > 0) {
                const equiposPorGrupo = maxEquipos / numGrupos;
                for(let i=1; i<equiposPorGrupo; i++) {
                    const totalClasificados = i * numGrupos;
                    if(esPotenciaDe2(totalClasificados)) {
                        clasificanPorGrupoSelect.innerHTML += `<option value="${i}">${i}</option>`;
                    }
                }
            }
        }

        tipoCompetenciaSelect.addEventListener('change', function() {
            toggleCampos();
        });
        if (faseGruposSelect) {
            faseGruposSelect.addEventListener('change', toggleFaseGrupos);
        }
        maxEquiposSelect.addEventListener('change', function() {
            if (tipoCompetenciaSelect.value === 'copa' && faseGruposSelect.value === '1') {
                actualizarNumeroGrupos();
            }
        });
        numeroGruposSelect.addEventListener('change', actualizarClasificanPorGrupo);

        // Inicialización
        toggleCampos();
        if (faseGruposSelect) toggleFaseGrupos();
    });
</script>
@endpush