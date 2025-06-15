@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Equipo')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Editar Equipo'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h5 class="mb-4">Editar Equipo: <strong>{{ $equipo->nombre_equipo }}</strong></h5>

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('equipos.update', $equipo->id) }}" method="POST" id="equipo-form">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre_equipo" class="form-label">Nombre del Equipo</label>
                    <input type="text" name="nombre_equipo" id="nombre_equipo" class="form-control" required value="{{ old('nombre_equipo', $equipo->nombre_equipo) }}">
                </div>

                <div class="mb-4">
                    <h6>Integrantes <small class="text-muted">(Máx: {{ $deporte->jugadores_por_equipo }})</small></h6>
                    <div id="integrantes-container">
                        {{-- Capitán (no editable ni eliminable) --}}
                        @if($equipo->capitan)
                            <div class="row g-2 align-items-end integrante-item mb-2">
                                <div class="col-md-10">
                                    <select class="form-select" disabled style="width:100%">
                                        <option selected>{{ $equipo->capitan->rut }} - {{ $equipo->capitan->nombre }}</option>
                                    </select>
                                    <input type="hidden" name="usuarios[]" value="{{ $equipo->capitan->id_usuario }}">
                                </div>
                                <div class="col-md-2">
                                    <span class="badge bg-primary w-100">Capitán</span>
                                </div>
                            </div>
                        @endif
                        {{-- Integrantes editables --}}
                        @foreach($equipo->usuarios->where('id_usuario', '!=', optional($equipo->capitan)->id_usuario) as $usuario)
                            <div class="row g-2 align-items-end integrante-item mb-2">
                                <div class="col-md-10">
                                    <select name="usuarios[]" class="form-select integrante-select" required style="width:100%">
                                        <option value="{{ $usuario->id_usuario }}" selected>{{ $usuario->rut }} - {{ $usuario->nombre }}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-integrante">Eliminar</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mb-3" id="agregar-integrante">+ Añadir Integrante</button>
                </div>

                <button type="submit" class="btn btn-success">Guardar Cambios</button>
                <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

{{-- Plantilla oculta para integrantes --}}
<div id="integrante-template" style="display:none;">
    <div class="row g-2 align-items-end integrante-item mb-2">
        <div class="col-md-10">
            <select name="usuarios[]" class="form-select integrante-select" required style="width:100%"></select>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm remove-integrante">Eliminar</button>
        </div>
    </div>
</div>
@endsection

@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const maxIntegrantes = {{ $deporte->jugadores_por_equipo }};

    function initSelect2($select, selected = null) {
        $select.select2({
            theme: 'bootstrap-5',
            placeholder: "Buscar por RUT o nombre...",
            width: '100%',
            ajax: {
                url: '{{ route('usuarios.buscar') }}',
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return { results: data };
                },
                cache: true
            },
            minimumInputLength: 2,
            language: {
                inputTooShort: function () {
                    return "Escribe para buscar...";
                },
                noResults: function () {
                    return "No se encontraron resultados";
                },
                searching: function () {
                    return "Buscando...";
                }
            }
        });

        // Si hay un usuario seleccionado, agregarlo como opción inicial
        if (selected) {
            var option = new Option(selected.text, selected.id, true, true);
            $select.append(option).trigger('change');
        }
    }

    // Inicializar select2 en los selects existentes (excepto el capitán)
    $('#integrantes-container .integrante-select').each(function() {
        var $select = $(this);
        var selected = {
            id: $select.find('option:selected').val(),
            text: $select.find('option:selected').text()
        };
        initSelect2($select, selected);
    });

    function checkIntegrantesLimit() {
        const totalIntegrantes = document.querySelectorAll('#integrantes-container .integrante-item').length;
        document.getElementById('agregar-integrante').disabled = totalIntegrantes >= maxIntegrantes;
    }

    document.getElementById('agregar-integrante').addEventListener('click', function() {
        const container = document.getElementById('integrantes-container');
        const templateDiv = document.getElementById('integrante-template');
        const template = templateDiv.querySelector('.integrante-item').cloneNode(true);
        const $select = $(template).find('.integrante-select');
        initSelect2($select);

        template.querySelector('.remove-integrante').addEventListener('click', function() {
            template.remove();
            checkIntegrantesLimit();
        });

        container.appendChild(template);
        checkIntegrantesLimit();
    });

    // Eliminar integrante existente
    document.querySelectorAll('.remove-integrante').forEach(btn => {
        btn.addEventListener('click', function() {
            btn.closest('.integrante-item').remove();
            checkIntegrantesLimit();
        });
    });

    checkIntegrantesLimit();
});
</script>
@endpush