
@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Rutinas Personalizadas'])
    <main class="main-content mt-0">
        <div class="container py-4">
            <h2 class="mb-4">Rutinas Personalizadas</h2>
            <div class="card shadow rounded-4 p-4">
                <div class="col">
                    <h4 class="mb-4">Crear rutina</h4>
                </div>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('rutinas.store') }}" method="POST" id="rutina-form">
                    @csrf
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de la Rutina</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required value="{{ old('nombre') }}">
                    </div>
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">Alumno</label>
                        <select name="user_id" id="id_usuario" class="form-select" required>
                            <option value="">Selecciona un usuario</option>
                        </select>
                        <div id="usuario-error" class="text-danger mt-2" style="display:none;"></div>
                    </div>
                    <hr>
                    <label class="form-label">Ejercicios</label>
                    <div id="ejercicios-container"></div>
                    <button type="button" class="btn btn-secondary mb-3" id="agregar-ejercicio">+ Añadir Ejercicio</button>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('rutinas.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary" id="crear-rutina-btn" disabled>Crear Rutina</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')

    <!-- Plantilla oculta para ejercicios -->
    <div id="ejercicio-template" style="display:none;">
        <div class="row g-2 align-items-end ejercicio-item mb-3">
            <div class="col-md-3">
                <label class="form-label">Grupo Muscular</label>
                <select class="form-control grupo-muscular" required>
                    <option value="">Selecciona un grupo muscular</option>
                    <option value="todos">Mostrar todos</option>
                    <option value="pecho">Pecho</option>
                    <option value="espalda">Espalda</option>
                    <option value="hombros">Hombros</option>
                    <option value="bíceps">Bíceps</option>
                    <option value="tríceps">Tríceps</option>
                    <option value="abdominales">Abdominales</option>
                    <option value="cuádriceps">Cuádriceps</option>
                    <option value="isquiotibiales">Isquiotibiales</option>
                    <option value="glúteos">Glúteos</option>
                    <option value="pantorrillas">Pantorrillas</option>
                    <option value="antebrazos">Antebrazos</option>
                    <option value="trapecio">Trapecio</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ejercicio</label>
                <select class="form-control ejercicio-select" required>
                    <option value="">Selecciona un ejercicio</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Series</label>
                <input type="number" min="1" class="form-control series-input" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Repeticiones</label>
                <input type="number" min="1" class="form-control repeticiones-input" required>
            </div>
            <div class="col-md-2">
                <label class="form-label">Descanso (seg)</label>
                <input type="number" min="0" class="form-control descanso-input" required placeholder="Ej: 60">
            </div>
            <div class="col-md-2 mt-4">
                <button type="button" class="btn btn-danger btn-sm remove-ejercicio">Eliminar</button>
            </div>
        </div>
    </div>
@endsection

@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('#id_usuario').select2({
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
    $('#id_usuario').on('select2:open', function () {
        setTimeout(function() {
            document.querySelector('.select2-search__field').focus();
        }, 100);
    });

    function checkCrearRutinaBtn() {
        const userId = $('#id_usuario').val();
        const ejercicios = document.querySelectorAll('.ejercicio-item');
        document.getElementById('crear-rutina-btn').disabled = !(userId && ejercicios.length > 0);
    }
    $('#id_usuario').on('change', checkCrearRutinaBtn);

    let ejercicioIndex = 0;
    document.getElementById('agregar-ejercicio').addEventListener('click', function() {
        const container = document.getElementById('ejercicios-container');
        const template = document.getElementById('ejercicio-template').firstElementChild.cloneNode(true);

        template.querySelector('.grupo-muscular').setAttribute('name', `ejercicios[${ejercicioIndex}][grupo_muscular]`);
        template.querySelector('.ejercicio-select').setAttribute('name', `ejercicios[${ejercicioIndex}][id]`);
        template.querySelector('.series-input').setAttribute('name', `ejercicios[${ejercicioIndex}][series]`);
        template.querySelector('.repeticiones-input').setAttribute('name', `ejercicios[${ejercicioIndex}][repeticiones]`);
        template.querySelector('.descanso-input').setAttribute('name', `ejercicios[${ejercicioIndex}][descanso]`);

        template.querySelector('.grupo-muscular').addEventListener('change', function() {
            const grupo = this.value;
            const ejercicioSelect = template.querySelector('.ejercicio-select');
            ejercicioSelect.innerHTML = '<option value="">Cargando...</option>';
            if (grupo) {
                fetch(`/ejercicios-por-grupo/${grupo}`)
                    .then(res => res.json())
                    .then(data => {
                        let options = '<option value="">Selecciona un ejercicio</option>';
                        data.forEach(ej => {
                            options += `<option value="${ej.id}">${ej.nombre}</option>`;
                        });
                        ejercicioSelect.innerHTML = options;
                    });
            } else {
                ejercicioSelect.innerHTML = '<option value="">Selecciona un ejercicio</option>';
            }
        });

        template.querySelector('.remove-ejercicio').addEventListener('click', function() {
            template.remove();
            checkCrearRutinaBtn();
        });

        container.appendChild(template);
        ejercicioIndex++;
        checkCrearRutinaBtn();
    });
});
</script>
@endpush