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
                        <div class="table-responsive p-0">
                            <table id="tabla-carreras" class="table align-items-center mb-0">
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
            $('#tabla-carreras').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('carreras.data') }}',
                columns: [
                    { data: 'UA', name: 'UA' },
                    { data: 'nombre_carrera', name: 'nombre_carrera' },
                    { data: 'cantidad_estudiantes', name: 'cantidad_estudiantes', className: 'text-center' }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
                }
            });
        });
    </script>
@endsection