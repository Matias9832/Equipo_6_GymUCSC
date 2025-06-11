@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Lista de Torneos')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Torneos'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center pb-0">
                        <h6>Lista de Torneos</h6>
                        <a href="{{ route('torneos.create') }}" class="btn btn-primary btn-sm">Crear Torneo</a>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Sucursal</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Deporte</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Tipo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Máx. Equipos</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Acciones</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Gestión</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($torneos as $torneo)
                                        <tr>
                                            <td>{{ $torneo->nombre_torneo }}</td>
                                            <td>{{ $torneo->sucursal->nombre_suc }}</td>
                                            <td>{{ $torneo->deporte->nombre_deporte }}</td>
                                            <td>{{ $torneo->tipo_competencia }}</td>
                                            <td>{{ $torneo->max_equipos }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('torneos.edit', $torneo->id) }}" class="btn btn-sm btn-primary">Editar</a>
                                                <form action="{{ route('torneos.destroy', $torneo->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                                </form>
                                            </td>
                                            <td class="text-center">
                                                @if(!\App\Models\Partido::where('torneo_id', $torneo->id)->exists())
                                                    <a href="{{ route('torneos.iniciar', $torneo->id) }}" class="btn btn-sm btn-success ms-1">
                                                        <i class="fas fa-play"></i> Iniciar Torneo
                                                    </a>
                                                @endif
                                                <a href="{{ route('torneos.partidos', $torneo->id) }}" class="btn btn-sm btn-info ms-1">
                                                    <i class="fas fa-futbol"></i> Partidos
                                                </a>
                                                @if($torneo->fase_grupos)
                                                    <a href="{{ route('torneos.fase-grupos', $torneo->id) }}" class="btn btn-sm btn-warning ms-1">
                                                        <i class="fas fa-list-ol"></i> Fase de Grupos
                                                    </a>
                                                    {{-- Aquí deberías agregar una condición para verificar si la fase de grupos ha finalizado --}}
                                                    {{-- Por ejemplo, podrías agregar un campo "fase_grupos_finalizada" en la tabla "torneos" --}}
                                                    {{-- y verificar si ese campo es true --}}
                                                    @if($torneo->fase_grupos_finalizada)
                                                        <a href="{{ route('torneos.copa', $torneo->id) }}" class="btn btn-sm btn-dark ms-1">
                                                            <i class="fas fa-sitemap"></i> Llaves
                                                        </a>
                                                    @endif
                                                @else
                                                    @if($torneo->tipo_competencia === 'copa')
                                                        <a href="{{ route('torneos.copa', $torneo->id) }}" class="btn btn-sm btn-dark ms-1">
                                                            <i class="fas fa-sitemap"></i> Llaves
                                                        </a>
                                                    @else
                                                        <a href="{{ route('torneos.tabla', $torneo->id) }}" class="btn btn-sm btn-warning ms-1">
                                                            <i class="fas fa-list-ol"></i> Tabla
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection