@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Usuarios'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Usuarios</h6>
                        @can('Crear Usuarios')
                            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">Crear Usuario</a>
                        @endcan
                    </div>
                    <div class="row px-4 py-2">
                        <div class="col">
                            <form method="GET" action="{{ route('usuarios.index') }}" id="filtroAdminsForm" class="mb-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="solo_admins" id="soloAdmins" {{ request('solo_admins') ? 'checked' : '' }}
                                        onchange="document.getElementById('filtroAdminsForm').submit();">
                                    <label class="form-check-label" for="soloAdmins">
                                        {{ request('solo_admins') ? 'Ocultar administradores' : 'Ocultar administradores' }}
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="tablaUsuarios">
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
                                            Rol / Tipo de usuario</th>
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

    <script>
        $(document).ready(function () {
            const table = $('#tablaUsuarios').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('usuarios.index', ['solo_admins' => request('solo_admins')]) }}',
                columns: [
                    { data: 'rut', name: 'usuario.rut', className: 'text-xs font-weight-bold ps-3' },
                    { data: 'nombre_usuario', name: 'nombre_usuario', className: 'text-xs' },
                    { data: 'correo_usuario', name: 'usuario.correo_usuario', className: 'text-xs' },
                    { data: 'rol_visible', name: 'rol_visible', className: '' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'align-middle text-center' },
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