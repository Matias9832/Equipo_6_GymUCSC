@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Carreras'])

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6 class="mb-0">Lista de Carreras</h6>
                    </div>

                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-3">
                            <table id="tabla-carreras" class="table align-items-center mb-0 w-100">
                                <thead>
                                    <tr>
                                        <th>UA</th>
                                        <th>Nombre Carrera</th>
                                        <th class="text-center">Cantidad de Estudiantes</th>
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
            var table = $('#tabla-carreras').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 10,
                lengthChange: false,
                ajax: '{{ route('carreras.data') }}',
                columns: [
                    { data: 'UA', name: 'UA', className: 'td-ua' },
                    { data: 'nombre_carrera', name: 'nombre_carrera', className: 'td-nombre' },
                    {
                        data: 'cantidad_estudiantes',
                        name: 'cantidad_estudiantes',
                        className: 'text-center td-cantidad',
                        render: function (data) {
                            return `<span class="badge badge-sm bg-gradient-info shadow text-white px-3 py-2" style="font-size: 0.75rem; width: 55px;">${data}</span>`;
                        }
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
                        next: '&raquo;',     // HTML para »
                        previous: '&laquo;'  // HTML para «
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
        .td-ua {
            padding-left: 1rem !important;
            font-weight: bold;
            color: #5e72e4;
        }

        .td-nombre {
            padding-left: 1rem !important;
        }

        .td-cantidad {
            padding-left: 1rem !important;
            text-align: center;
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