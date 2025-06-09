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
                <div class="mb-3">
                    <label for="max_equipos" class="form-label">Máximo de Equipos</label>
                    <input type="number" name="max_equipos" id="max_equipos" class="form-control" required>
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
                            <input type="number" name="numero_grupos" id="numero_grupos" class="form-control" min="1">
                        </div>

                        <div class="mb-3">
                            <label for="equipos_por_grupo" class="form-label">Equipos que clasifican por grupo</label>
                            <input type="number" name="equipos_por_grupo" id="equipos_por_grupo" class="form-control" min="1">
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

        function toggleOpcionesCopa() {
            if (tipoCompetenciaSelect.value === 'copa') {
                opcionesCopaDiv.style.display = 'block';
            } else {
                opcionesCopaDiv.style.display = 'none';
                opcionesGruposDiv.style.display = 'none';
            }
        }

        function toggleOpcionesGrupos() {
            if (faseGruposSelect.value === '1') {
                opcionesGruposDiv.style.display = 'block';
            } else {
                opcionesGruposDiv.style.display = 'none';
            }
        }

        tipoCompetenciaSelect.addEventListener('change', toggleOpcionesCopa);
        faseGruposSelect.addEventListener('change', toggleOpcionesGrupos);

        toggleOpcionesCopa(); // Para mostrar/ocultar al cargar la página
    });
</script>
@endpush