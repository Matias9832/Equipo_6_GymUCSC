@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Alumnos'])
    <div class="container-fluid py-4">

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="mb-0">Lista de Alumnos</h5>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <form action="{{ route('alumnos.import') }}" method="POST" enctype="multipart/form-data"
                                    class="d-flex align-items-center gap-2">
                                    @csrf
                                    <div>
                                        <input type="file" name="file" id="file"
                                            class="btn form-control form-control-sm @error('file') is-invalid @enderror">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-primary">Importar</button>
                                </form>
                            </div>
                        </div>
                        <form method="GET" action="{{ route('alumnos.index') }}" id="filtroForm" class="mb-4">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="ocultar_inactivos"
                                    id="ocultarInactivos" {{ request('ocultar_inactivos') ? 'checked' : '' }}
                                    onchange="document.getElementById('filtroForm').submit();">
                                <label class="form-check-label" for="ocultarInactivos">
                                    {{ request('ocultar_inactivos') ? 'Mostrar' : 'Ocultar Inactivos' }}
                                </label>
                            </div>
                        </form>
                        @if(session('warning'))
                            <div class="alert alert-warning">
                                <strong>{{ session('warning') }}</strong>
                                @if(session('import_errors_missing_rut'))
                                    <h5>Errores por RUT faltante:</h5>
                                    <ul>
                                        @foreach (session('import_errors_missing_rut') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                @if(session('import_errors_incomplete_data'))
                                    <h5>Errores por datos incompletos:</h5>
                                    <ul>
                                        @foreach (session('import_errors_incomplete_data') as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endif
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table id="tablaAlumnos" class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Apellidos</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nombre</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Carrera</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Sexo</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Estado</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script>
        $(document).ready(function () {
            const table = $('#tablaAlumnos').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('alumnos.index', ['ocultar_inactivos' => request('ocultar_inactivos')]) }}',
                columns: [
                    { data: 'rut_alumno', name: 'rut_alumno', className: 'mb-0 text-sm fw-bold ps-3' },
                    { data: 'apellidos', name: 'apellido_paterno', className: 'text-xs font-weight-bold mb-0' },
                    { data: 'nombre_alumno', name: 'nombre_alumno', className: 'text-xs font-weight-bold mb-0' },
                    { data: 'carrera_html', name: 'carrera', className: 'text-xs font-weight-bold mb-0' },
                    { data: 'sexo_html', name: 'sexo_alumno', className: '' },
                    { data: 'estado_html', name: 'estado_alumno', orderable: false, className: 'align-middle text-center text-sm' },
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    info: '',
                    infoEmpty: '',
                    infoFiltered: '',
                    zeroRecords: 'No se encontraron resultados',
                    search: 'Buscar:',
                    paginate: {
                        next: '&raquo;',
                        previous: '&laquo;'
                    }
                },
                dom:
                    `<"row px-4 mt-3"<"col-md-6"f>>` +
                    `<"table-responsive"tr>` +
                    `<"row px-4 mt-3 mb-4"<"col-12 d-flex justify-content-center"p>>`,
            });

            $('.dataTables_filter').hide();

            $('#buscador-general').on('keyup', function () {
                table.search(this.value).draw();
            });
        });
    </script>

    <style>
        /* Asegura que la tabla siempre se ajuste al contenedor */
        table.dataTable {
            width: 100% !important;
        }

        /* Opcional: Si quieres que las columnas no se encojan */
        table.dataTable td,
        table.dataTable th {
            white-space: nowrap;
        }

        /* Estilos de búsqueda */
        .dataTables_filter input {
            border-radius: 0.5rem;
            border: 1px solid #d2d6da;
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            color: #344767;
        }

        /* Ocultar info */
        .dataTables_info {
            display: none !important;
        }

        .dataTables_filter {
            display: none !important;
        }
    </style>
@endsection