@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Administradores'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12" id="columna-tabla">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5>Lista de Administradores</h5>
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
            <!-- Contenedor para la card del perfil -->
            <div class="col-4" id="columna-perfil" style="display: none;">
                <div id="card-container" class="position-sticky" style="top: 20px;"></div>
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
            // --- LÓGICA PARA MOSTRAR LA CARD ---
            let perfilVisible = false;
            function cerrarCard() {
                $('#columna-tabla').removeClass('col-8').addClass('col-12');
                $('#columna-perfil').hide();
                $('#card-container').html('');
                $('.fila-docente').removeClass('table-active');
                perfilVisible = false;
            }

            $('#card-container').on('click', '.btn-cerrar-card', function () {
                cerrarCard();
            });
            $('#tabla-administradores tbody').on('click', '.nombre-administrador', function (e) {
                const idDocente = $(this).data('id');
                const url = `{{ url('/administradores/perfil') }}/${idDocente}`;

                // Resaltar fila seleccionada
                $('.fila-docente').removeClass('table-active');
                $(this).addClass('table-active');

                // Mostrar un spinner/loading mientras se carga la tarjeta
                $('#card-container').html(`
                    <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                    </div>
                `);

                // --- Transición siempre que sea necesario ---
                if (!perfilVisible) {
                    $('#columna-tabla').removeClass('col-12').addClass('col-8');
                    $('#columna-perfil').show();
                    perfilVisible = true;
                }

                // Petición AJAX para obtener la card
                $.ajax({
                    url: `/docentes/perfil/${idDocente}`,
                    method: 'GET',
                    success: function(response) {
                        $('#card-container').html(response.html);
                    },
                    error: function() {
                        $('#card-container').html(`<div class="alert alert-danger m-3">Error al cargar perfil del docente.</div>`);
                    }
                });
            });
        });
        $(document).on('click', '#cerrar-perfil-docente', function () {
            // Ocultar la columna del perfil
            $('#columna-perfil').hide();

            // Expandir la tabla nuevamente
            $('#columna-tabla').removeClass('col-8').addClass('col-12');

            // Quitar la selección de fila activa
            $('.fila-docente').removeClass('table-active');

            // Resetear bandera
            perfilVisible = false;
        });
        function cerrarCard() {
            $('#columna-tabla').removeClass('col-8').addClass('col-12'); // tabla vuelve a 12 cols
            $('#columna-perfil').hide();                                // oculta la columna perfil
            $('#card-container').html('');                              // limpia el contenido del perfil
            $('.fila-docente').removeClass('table-active');             // quita highlight en filas
            perfilVisible = false;                                       // resetea la variable para poder abrir de nuevo
        }
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