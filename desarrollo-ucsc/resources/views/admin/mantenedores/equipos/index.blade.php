@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Equipos'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Equipos</h6>
                        <a href="{{ route('equipos.create') }}" class="btn btn-primary btn-sm">Crear Equipo</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre del Equipo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Deporte</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Integrantes</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($equipos as $equipo)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $equipo->nombre_equipo }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $equipo->deporte->nombre_deporte }}</span>
                                            </td>
                                            <td>
                                                @if($equipo->usuarios->isNotEmpty())
                                                    <ul class="mb-0 ps-3">
                                                        @foreach($equipo->usuarios as $usuario)
                                                            <li class="text-xs">{{ $usuario->nombre }} ({{ $usuario->rut }})</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted text-xs ps-3">Sin integrantes</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('equipos.edit', $equipo->id) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                    <i class="ni ni-ruler-pencil text-warning"></i>
                                                </a>
                                                <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar este equipo?')" title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if(method_exists($equipos, 'links'))
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $equipos->links('pagination::bootstrap-4') }}
                                </div>
                            @endif

                            @if($equipos->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay equipos registrados.
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
