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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Máx. Equipos</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Equipos Inscritos</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($torneos as $torneo)
                                    <tr>
                                        <td class="text-sm">{{ $torneo->nombre_torneo }}</td>
                                        <td class="text-sm">{{ $torneo->sucursal->nombre_suc }}</td>
                                        <td class="text-sm">{{ $torneo->deporte->nombre_deporte }}</td>
                                        <td class="text-sm">{{ $torneo->max_equipos }}</td>
                                        <td class="text-sm">
                                            <ul class="mb-0 ps-3">
                                                @foreach($torneo->equipos as $equipo)
                                                    <li>{{ $equipo->nombre_equipo }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('torneos.edit', $torneo->id) }}" class="text-warning me-2" title="Editar">
                                                <i class="fas fa-pen-to-square text-info"></i>
                                            </a>
                                            <form action="{{ route('torneos.destroy', $torneo->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-link text-danger p-0" onclick="return confirm('¿Estás seguro de que quieres eliminar este torneo?')" title="Eliminar">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
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
