@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Administradores'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Administradores</h6>
                        <a href="{{ route('administradores.create') }}" class="btn btn-primary btn-sm">Crear Administrador</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Correo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Rol</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sucursal</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($administradores as $administrador)
                                        @php
                                            $usuario = $usuarios->firstWhere('rut', $administrador->rut_admin);
                                        @endphp
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $administrador->rut_admin }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $administrador->nombre_admin }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $usuario->correo_usuario ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm bg-gradient-info">
                                                    {{ $usuario ? $usuario->getRoleNames()->implode(', ') : 'Sin rol' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $administrador->sucursales->first()->nombre_suc ?? 'Sin sucursal' }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('administradores.edit', $administrador) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                    <i class="ni ni-ruler-pencil text-info"></i>
                                                </a>
                                                <form action="{{ route('administradores.destroy', $administrador) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar este administrador?')" title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- Paginación --}}
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $administradores->links('pagination::bootstrap-4') }}
                                </div>
                            @if($administradores->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay administradores registrados.
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