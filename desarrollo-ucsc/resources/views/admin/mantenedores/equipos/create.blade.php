@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Equipo'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div> 
                    @endif
                <form action="{{ route('equipos.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre_equipo" class="form-label">Nombre del Equipo</label>
                        <input type="text" name="nombre_equipo" id="nombre_equipo" class="form-control" required>
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
                        <label for="torneos" class="form-label">Torneos</label>
                        <select name="torneos[]" id="torneos" class="form-select" multiple>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="capitan_id" class="form-label">Capitán del Equipo</label>
                        <select name="capitan_id" id="capitan_id" class="form-select" required>
                            <option value="">Selecciona un capitán</option>
                        </select>
                        <div id="usuario-error" class="text-danger mt-2" style="display:none;"></div>
                    </div>
                    <button type="submit" class="btn btn-primary">Crear Equipo</button>
                    <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#capitan_id').select2({
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
        $('#capitan_id').on('select2:open', function () {
            setTimeout(function() {
                document.querySelector('.select2-search__field').focus();
            }, 100);
        });

        $('#id_deporte').on('change', function() {
            var idDeporte = $(this).val();
            if (idDeporte) {
                $.ajax({
                    url: '{{ route('torneos.porDeporte') }}',
                    type: 'GET',
                    data: { id_deporte: idDeporte },
                    dataType: 'json',
                    success: function(data) {
                        $('#torneos').empty();
                        $.each(data, function(key, value) {
                            $('#torneos').append('<option value="' + value.id + '">' + value.nombre_torneo + '</option>');
                        });
                    }
                });
            } else {
                $('#torneos').empty();
            }
        });
    });
</script>
@endpush