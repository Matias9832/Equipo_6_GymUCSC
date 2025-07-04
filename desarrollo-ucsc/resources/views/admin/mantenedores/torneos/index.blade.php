@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Torneos'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0">
                        <h5>Lista de Torneos</h5>
                        <a href="{{ route('torneos.create') }}" class="btn btn-primary btn-sm">Crear Torneo</a>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-0">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">Sucursal</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">Deporte</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">Tipo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">Máx. Equipos</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">Gestión</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center ps-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($torneos as $torneo)
                                        <tr>
                                            <td>{{ $torneo->nombre_torneo }}</td>
                                            <td>{{ $torneo->sucursal->nombre_suc }}</td>
                                            <td class="align-middle text-center ps-3">{{ $torneo->deporte->nombre_deporte }}</td>
                                            <td class="align-middle text-center ps-2 text-capitalize">{{ $torneo->tipo_competencia }}</td>
                                            <td class="align-middle text-center ps-2">{{ $torneo->max_equipos }}</td>
                                            <td class="align-middle text-center ps-2">
                                                @if(!\App\Models\Partido::where('torneo_id', $torneo->id)->exists())
                                                    <a href="{{ route('torneos.iniciar', $torneo->id) }}" class="btn btn-sm btn-outline-primary ms-1 my-2">
                                                        <i class="fas fa-play"></i> Iniciar Torneo
                                                    </a>
                                                @endif
                                                <a href="{{ route('torneos.partidos', $torneo->id) }}" class="btn btn-sm btn-outline-dark ms-1 my-2">
                                                    <i class="fas fa-futbol"></i> Partidos
                                                </a>
                                                @if($torneo->fase_grupos)
                                                    <a href="{{ route('torneos.fase-grupos', $torneo->id) }}" class="btn btn-sm btn-outline-dark ms-1 my-2">
                                                        <i class="fas fa-list-ol"></i> Fase de Grupos
                                                    </a>
                                                    @if($torneo->fase_grupos_finalizada)
                                                        <a href="{{ route('torneos.copa', $torneo->id) }}" class="btn btn-sm btn-outline-dark ms-1 my-2">
                                                            <i class="fas fa-sitemap"></i> Llaves
                                                        </a>
                                                    @endif
                                                @else
                                                    @if($torneo->tipo_competencia === 'copa')
                                                        <a href="{{ route('torneos.copa', $torneo->id) }}" class="btn btn-sm btn-outline-dark ms-1 my-2">
                                                            <i class="fas fa-sitemap"></i> Llaves
                                                        </a>
                                                    @else
                                                        <a href="{{ route('torneos.tabla', $torneo->id) }}" class="btn btn-sm btn-outline-dark ms-1 my-2">
                                                            <i class="fas fa-list-ol"></i> Tabla
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('torneos.edit', $torneo->id) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-pen-to-square text-primary"></i>
                                                </a>
                                                <form action="{{ route('torneos.destroy', $torneo->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar este deporte?')" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted py-3 align-middle">No hay torneos disponibles.</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection