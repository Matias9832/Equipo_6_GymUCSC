@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Crear Torneo')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Crear Torneo'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('torneos.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nombre_torneo" class="form-label">Nombre del Torneo</label>
                    <input type="text" name="nombre_torneo" id="nombre_torneo" class="form-control" required>
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
                    <label for="tipo_competencia" class="form-label">Tipo de Competencia</label>
                    <select name="tipo_competencia" id="tipo_competencia" class="form-select" required>
                        <option value="">Seleccione un tipo de competencia</option>
                        <option value="liga">Liga</option>
                        <option value="copa">Copa</option>
                        <option value="encuentro">Encuentro</option>
                    </select>
                </div>
                <div class="mb-3" id="max-equipos-div">
                    <label for="max_equipos" class="form-label">Máximo de Equipos</label>
                    <select name="max_equipos" id="max_equipos" class="form-select" required>
                        <option value="">Seleccione...</option>
                        <!-- Opciones generadas por JS si es copa -->
                    </select>
                </div>

                <div id="opciones-copa" style="display: none;">
                    <div class="mb-3">
                        <label for="fase_grupos" class="form-label">Fase de grupos</label>
                        <select name="fase_grupos" id="fase_grupos" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
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

                    <div class="mb-3">
                        <label for="partidos_ida_vuelta" class="form-label">Partidos ida y vuelta</label>
                        <select name="partidos_ida_vuelta" id="partidos_ida_vuelta" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tercer_lugar" class="form-label">Se juega partido por el tercer lugar</label>
                        <select name="tercer_lugar" id="tercer_lugar" class="form-select">
                            <option value="0">No</option>
                            <option value="1">Sí</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Crear Torneo</button>
                <a href="{{ route('torneos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
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
        const numeroGruposSelect = document.getElementById('numero_grupos');
        const clasificanPorGrupoSelect = document.getElementById('clasifican_por_grupo');
        const maxEquiposDiv = document.getElementById('max-equipos-div');

        // Valores permitidos para copa
        const valoresCopa = [];
        for(let i=4; i<=30; i+=2) valoresCopa.push(i);

        function toggleOpcionesCopa() {
            if (tipoCompetenciaSelect.value === 'copa') {
                opcionesCopaDiv.style.display = 'block';
                // Rellenar opciones de max_equipos solo para copa
                maxEquiposSelect.innerHTML = '<option value="">Seleccione...</option>';
                valoresCopa.forEach(function(val) {
                    maxEquiposSelect.innerHTML += `<option value="${val}">${val}</option>`;
                });
            } else {
                opcionesCopaDiv.style.display = 'none';
                opcionesGruposDiv.style.display = 'none';
                maxEquiposSelect.innerHTML = '<option value="">Seleccione...</option>';
            }
        }

        function toggleOpcionesGrupos() {
            if (faseGruposSelect.value === '1') {
                opcionesGruposDiv.style.display = 'block';
                actualizarNumeroGrupos();
            } else {
                opcionesGruposDiv.style.display = 'none';
            }
        }

        function actualizarNumeroGrupos() {
            const maxEquipos = parseInt(maxEquiposSelect.value);
            numeroGruposSelect.innerHTML = '<option value="">Seleccione...</option>';
            if (!isNaN(maxEquipos)) {
                // Calcular divisores de maxEquipos (sin el 1)
                for(let i=2; i<maxEquipos; i++) { // i < maxEquipos para excluir el mismo número
                    if(maxEquipos % i === 0) {
                        numeroGruposSelect.innerHTML += `<option value="${i}">${i}</option>`;
                    }
                }
            }
            actualizarClasificanPorGrupo();
        }

        function actualizarClasificanPorGrupo() {
            const maxEquipos = parseInt(maxEquiposSelect.value);
            const numGrupos = parseInt(numeroGruposSelect.value);
            clasificanPorGrupoSelect.innerHTML = '<option value="">Seleccione...</option>';
            if (!isNaN(maxEquipos) && !isNaN(numGrupos) && numGrupos > 0) {
                const equiposPorGrupo = maxEquipos / numGrupos;
                // Solo permitir valores entre 1 y equiposPorGrupo-1
                for(let i=1; i<equiposPorGrupo; i++) {
                    clasificanPorGrupoSelect.innerHTML += `<option value="${i}">${i}</option>`;
                }
            }
        }

        tipoCompetenciaSelect.addEventListener('change', function() {
            toggleOpcionesCopa();
            toggleOpcionesGrupos();
        });
        faseGruposSelect.addEventListener('change', toggleOpcionesGrupos);
        maxEquiposSelect.addEventListener('change', function() {
            if (faseGruposSelect.value === '1') {
                actualizarNumeroGrupos();
            }
        });
        numeroGruposSelect.addEventListener('change', actualizarClasificanPorGrupo);

        // Inicialización al cargar
        toggleOpcionesCopa();
        toggleOpcionesGrupos();
    });
</script>
@endpush