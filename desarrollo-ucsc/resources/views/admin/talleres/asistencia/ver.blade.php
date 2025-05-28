@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Hoja de Asistencia'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">Asistencia del taller: {{ $taller->nombre_taller }}</h6>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('asistencia.registrar', $taller->id_taller) }}" class="btn btn-sm btn-primary me-2">
                                <i class="fas fa-edit me-1"></i> Registrar
                            </a>
                            <a href="{{ route('talleres.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Volver a talleres
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table id="tablaAsistencias" class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>RUT</th>
                                    <th>Nombre</th>
                                    <th>Carrera</th>
                                    <th>Sexo</th>
                                    <th>Fecha de Asistencia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Los datos se cargarán mediante DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    <script>
        $(document).ready(function () {
            $('#tablaAsistencias').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("asistencias.data", $taller->id_taller) }}',
                columns: [
                    { data: 'rut', name: 'usuario.rut' },
                    { data: 'nombre', name: 'nombre' },
                    { data: 'carrera', name: 'alumno.carrera' },
                    { data: 'sexo_alumno', name: 'alumno.sexo_alumno' },
                    { data: 'fecha_asistencia', name: 'taller_usuario.fecha_asistencia' }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
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
                    `<"row px-4 mt-3 mb-4"<"col-12 d-flex justify-content-center"p>>`
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

    @include('layouts.footers.auth.footer')
</div>
@endsection