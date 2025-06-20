@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Docentes'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12" id="columna-tabla">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5>Lista de Docentes</h5>
                        <a href="{{ route('docentes.create') }}" class="btn btn-primary btn-sm">Registrar Docente</a>
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

            <!-- Contenedor para la card del perfil -->
            <div class="col-lg-4 col-12" id="columna-perfil" style="display: none;">
                <div id="card-container" class="position-sticky" style="top: 20px;"></div>
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
                    { data: 'rut_admin', name: 'administrador.rut_admin', className: 'text-xs ps-3' },
                    { data: 'nombre_admin', name: 'administrador.nombre_admin', className: 'text-xs font-weight-bold' },
                    { data: 'correo_usuario', name: 'usuario.correo_usuario', defaultContent: '-', className: 'text-xs' },
                    { data: 'rol_name', name: 'roles.name', defaultContent: 'Sin rol', className: 'text-xs td-rol' },
                    { data: 'acciones', name: 'acciones', orderable: false, searchable: false, className: 'text-center text-xs' }
                ],
                // Añadimos un cursor-pointer a las filas para indicar que son clickeables
                createdRow: function(row, data, dataIndex) {
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

            function cerrarCard() {
                if (window.innerWidth < 768) {
                    // Mostrar la tabla y ocultar la card en móvil
                    $('#columna-tabla').show();
                    $('#columna-perfil').addClass('card-salir');
                    setTimeout(() => { $('#columna-perfil').hide().removeClass('col-12 card-salir');}, 300);
                } else {
                    // Restaurar layout en escritorio
                    $('#columna-tabla').removeClass('col-8').addClass('col-12');
                    $('#columna-perfil').hide().removeClass('col-4');
                }

                $('#card-container').html('');
                $('.fila-docente').removeClass('table-active');
                perfilVisible = false;
            }

            $('#card-container').on('click', '.btn-cerrar-card', function () {
                cerrarCard();
            });
            // Evento de clic en una fila de la tabla
            $('#tabla-docentes tbody').on('click', '.nombre-docente', function (e) {
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

                // Petición AJAX para obtener la card
                $.ajax({
                    url: `/docentes/perfil/${idDocente}`,
                    method: 'GET',
                    success: function(response) {
                        // 1. Oculta el contenedor antes de insertar el HTML
                        $('#card-container').hide();

                        // 2. Ajusta el layout ANTES de mostrar la card
                        if (!perfilVisible) {
                            if (window.innerWidth < 768) {
                                // Modo móvil
                                $('#columna-tabla').hide();
                                $('#columna-perfil').removeClass('col-4').addClass('col-12').show();
                            } else {
                                // Modo escritorio
                                $('#columna-tabla').removeClass('col-12').addClass('col-8');
                                $('#columna-perfil').removeClass('col-12').addClass('col-4').show();
                            }
                            perfilVisible = true;
                        }

                        // 3. Ahora sí, inserta el HTML y muestra la card con animación
                        $('#card-container').html(response.html).addClass('card-animar').show();
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
        /* Animación elegante para entrada lateral en móvil */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Para ocultar con efecto hacia la derecha */
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }

        .card-animar {
            animation: slideInRight 0.3s ease-out forwards;
        }

        .card-salir {
            animation: slideOutRight 0.3s ease-in forwards;
        }
        .nombre-docente {
            cursor: pointer;
            color: #344767;
            transition: color 0.2s;
        }
        .nombre-docente:hover {
            color: var(--bs-primary) !important;
        }
    </style>
@endsection