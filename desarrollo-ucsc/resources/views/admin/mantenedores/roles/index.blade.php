@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Roles'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5>Lista de Roles</h5>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">Registrar Rol</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">
                                            Permisos</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        @if($role->name !== 'superadmin')
                                            <tr>
                                                <td>
                                                    <span class="text-xs font-weight-bold ps-3">{{ $role->name }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-xs">
                                                        {{ $role->permissions->count() }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('roles.show', $role->id) }}"
                                                        class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                        title="Ver">
                                                        <i class="fas fa-eye text-success"></i>
                                                    </a>
                                                    <a href="{{ route('roles.edit', $role->id) }}"
                                                        class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                        title="Editar">
                                                        <i class="fas fa-pen-to-square text-info"></i>
                                                    </a>
                                                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                                        class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este rol?')"
                                                            title="Eliminar">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Si hay paginación --}}
                            @if(method_exists($roles, 'links'))
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $roles->links('pagination::bootstrap-4') }}
                                </div>
                            @endif

                            {{-- Si no hay roles (excepto superadmin) --}}
                            @if($roles->where('name', '!=', 'superadmin')->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay roles registrados.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection