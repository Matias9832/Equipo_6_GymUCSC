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
@endsection

@push('js')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#tabla-administradores').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('administradores.data') }}',
                columns: [
                    { data: 'rut_admin', name: 'rut_admin' },
                    { data: 'nombre_admin', name: 'nombre_admin' },
                    { data: 'correo', name: 'correo', defaultContent: 'N/A' },
                    { data: 'rol', name: 'rol', defaultContent: 'Sin rol' },
                    { data: 'sucursal', name: 'sucursal', defaultContent: 'Sin sucursal' },
                    {
                        data: 'id_admin',
                        name: 'acciones',
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function (data, type, row) {
                            let editUrl = `{{ url('administradores') }}/${data}/edit`;
                            let deleteUrl = `{{ url('administradores') }}/${data}`;
                            return `
                                    <a href="${editUrl}" class="text-secondary font-weight-bold text-xs me-2" title="Editar">
                                        <i class="ni ni-ruler-pencil text-info"></i>
                                    </a>
                                    <form action="${deleteUrl}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar este administrador?')" title="Eliminar">
                                            <i class="ni ni-fat-remove"></i>
                                        </button>
                                    </form>
                                `;
                        }
                    }
                ],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
                }
            });
        });
    </script>
@endpush