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
                            <table class="table align-items-center mb-0">
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
                                        @role('Super Admin|Director|Coordinador')
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones</th>
                                        @endrole
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                        @php
                                            $nombre = 'Sin nombre';
                                            $rolOTipo = '';
                                            $badgeClass = '';

                                            if ($usuario->tipo_usuario === 'admin') {
                                                $admin = \App\Models\Administrador::where('rut_admin', $usuario->rut)->first();
                                                $nombre = $admin ? $admin->nombre_admin : 'Sin nombre';
                                                $rolOTipo = $usuario->getRoleNames()->implode(', ') ?: 'Sin rol';
                                                $badgeClass = 'bg-gradient-info';
                                            } else {
                                                $alumno = \App\Models\Alumno::where('rut_alumno', $usuario->rut)->first();
                                                $nombre = $alumno
                                                    ? $alumno->nombre_alumno . ' ' . $alumno->apellido_paterno . ' ' . $alumno->apellido_materno
                                                    : 'Sin nombre';
                                                $rolOTipo = $usuario->tipo_usuario === 'estudiante' ? 'Estudiante' : 'Seleccionado';
                                                $badgeClass = $usuario->tipo_usuario === 'estudiante' ? 'bg-gradient-success' : 'bg-gradient-warning';
                                            }
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $usuario->rut }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $nombre }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $usuario->correo_usuario }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm {{ $badgeClass }}" style="width:150px;">
                                                    {{ $rolOTipo }}
                                                </span>
                                            </td>
                                            @role('Super Admin|Director|Coordinador')
                                            <td class="align-middle text-center">
                                                @can('Editar Usuarios')
                                                    <a href="{{ route('usuarios.edit', $usuario->id_usuario) }}"
                                                        class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                        title="Editar">
                                                        <i class="ni ni-ruler-pencil text-info"></i>
                                                    </a>
                                                @endcan
                                                @can('Eliminar Usuarios')
                                                    <form action="{{ route('usuarios.destroy', $usuario->id_usuario) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este usuario?')"
                                                            title="Eliminar">
                                                            <i class="ni ni-fat-remove"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                            @endrole
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- Paginación --}}
                            <div class="d-flex justify-content-center mt-3">
                                {{ $usuarios->links('pagination::bootstrap-4') }}
                            </div>
                            @if($usuarios->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay usuarios registrados.
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