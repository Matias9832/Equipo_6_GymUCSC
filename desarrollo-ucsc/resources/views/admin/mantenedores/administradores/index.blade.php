@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Administradores'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Administradores</h6>
                        <a href="{{ route('administradores.create') }}" class="btn btn-primary btn-sm">Crear
                            Administrador</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="tabla-administradores">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT
                                        </th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Nombre</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Correo</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Rol</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Sucursal</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones</th>
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

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            const table = $('#tabla-administradores').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                lengthChange: false,
                ajax: '{{ route('administradores.data') }}',
                columns: [
                    { data: 'rut_admin', name: 'administrador.rut_admin', className: 'text-xs font-weight-bold ps-3' },
                    { data: 'nombre_admin', name: 'administrador.nombre_admin', className: 'text-xs' },
                    { data: 'correo_usuario', name: 'usuario.correo_usuario', defaultContent: 'N/A', className: 'text-xs' },
                    { data: 'rol_name', name: 'roles.name', defaultContent: 'Sin rol', className: '' },
                    { data: 'nombre_suc', name: 'sucursal.nombre_suc', defaultContent: 'Sin sucursal', className: 'text-xs' },
                    {
                        data: 'acciones',
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        className: 'text-center text-xs',
                    }
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

        /* Estilos para clases específicas de columnas */
        .td-rol {
            width: 150px !important;
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