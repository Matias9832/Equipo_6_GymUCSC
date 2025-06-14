@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Docentes'])

    <div class="container-fluid py-4">
        <div class="row">
            {{-- Columna para la tabla de docentes --}}
            <div class="col-12" id="columna-tabla">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5>Lista de Docentes</h5>
                        <a href="{{ route('docentes.create') }}" class="btn btn-primary btn-sm">Crear Docente</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" id="tabla-docentes">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Correo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rol</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna para la CardDocente (inicialmente oculta) --}}
            <div class="col-4" id="columna-perfil" style="display: none;">
                <div id="card-container" class="position-sticky" style="top: 20px;">
                    {{-- El CardDocente se cargará aquí vía AJAX --}}
                </div>
            </div>

        </div>
        @include('layouts.footers.auth.footer')
    </div>

    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            const tablaDocentes = $('#tabla-docentes').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                lengthChange: false,
                ajax: '{{ route('docentes.data') }}',
                columns: [
                    { data: 'rut_admin', name: 'administrador.rut_admin', className: 'text-xs font-weight-bold ps-3' },
                    { data: 'nombre_admin', name: 'administrador.nombre_admin', className: 'text-xs' },
                    { data: 'correo_usuario', name: 'usuario.correo_usuario', defaultContent: '-', className: 'text-xs' },
                    { data: 'rol_name', name: 'roles.name', defaultContent: 'Sin rol', className: 'text-xs td-rol' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'text-center text-xs' }
                ],
                // Añadimos un cursor-pointer a las filas para indicar que son clickeables
                createdRow: function(row, data, dataIndex) {
                    $(row).css('cursor', 'pointer');
                    $(row).addClass('fila-docente');
                    $(row).data('id', data.id_admin); // Guardamos el ID en el data attribute de la fila
                },
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
                    zeroRecords: 'No se encontraron resultados',
                    search: 'Buscar:',
                    paginate: { next: '&raquo;', previous: '&laquo;' }
                },
                dom: `<"row px-4 mt-3"<"col-md-6"f>>` +
                     `<"table-responsive"tr>` +
                     `<"row px-4 mt-3 mb-4"<"col-12 d-flex justify-content-center"p>>`,
            });

            // Ocultar el buscador por defecto de DataTables
            $('.dataTables_filter').hide();

            // Conectar tu buscador general si lo tienes
            $('#buscador-general').on('keyup', function () {
                tablaDocentes.search(this.value).draw();
            });

            // --- LÓGICA PARA MOSTRAR LA CARD ---
            let perfilVisible = false;

            // Evento de clic en una fila de la tabla
            $('#tabla-docentes tbody').on('click', '.fila-docente', function () {
                const idDocente = $(this).data('id');
                const url = `{{ url('/docentes/perfil') }}/${idDocente}`;
                
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

                // Hacer la transición de columnas si es la primera vez que se abre
                if (!perfilVisible) {
                    $('#columna-tabla').removeClass('col-12').addClass('col-8');
                    $('#columna-perfil').show();
                    perfilVisible = true;
                }

                // Petición AJAX para obtener la card
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Si todo va bien, inyectamos el HTML de la tarjeta
                            $('#card-container').html(response.html);
                        } else {
                            // Si el controlador dice que hubo un error (success: false)
                            $('#card-container').html(response.html || '<p class="text-danger">No se pudo cargar el perfil.</p>');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Si hay un error de servidor (404, 500, etc.)
                        console.error("Error AJAX:", textStatus, errorThrown, jqXHR.responseText);
                        $('#card-container').html('<div class="alert alert-danger text-white" role="alert"><strong>¡Error!</strong> No se pudo contactar al servidor para cargar el perfil.</div>');
                    }
                });
            });
        });
    </script>

    <style>
        /* Estilos para DataTables y la nueva funcionalidad */
        table.dataTable { width: 100% !important; }
        table.dataTable td, table.dataTable th { white-space: nowrap; }
        .td-rol { width: 150px !important; }
        .dataTables_info, .dataTables_filter { display: none !important; }
        .dataTables_filter input { border-radius: 0.5rem; border: 1px solid #d2d6da; padding: 0.375rem 0.75rem; font-size: 0.875rem; color: #344767; }
        
        /* Estilos para la transición de las columnas */
        #columna-tabla, #columna-perfil {
            transition: all 0.3s ease-in-out;
        }
    </style>
@endsection