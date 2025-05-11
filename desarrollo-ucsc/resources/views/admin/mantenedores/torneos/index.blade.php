@extends('layouts.admin')

@section('title', 'Lista de Torneos')

@section('content')
    <h1 class="h3">Lista de Torneos</h1>
    <a href="{{ route('torneos.create') }}" class="btn btn-primary mb-3">Crear Torneo</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Sucursal</th>
                <th>Deporte</th>
                <th>Máx. Equipos</th>
                <th>Equipos Inscritos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($torneos as $torneo)
                <tr>
                    <td>{{ $torneo->nombre_torneo }}</td>
                    <td>{{ $torneo->sucursal->nombre_suc }}</td>
                    <td>{{ $torneo->deporte->nombre_deporte }}</td>
                    <td>{{ $torneo->max_equipos }}</td>
                    <td>
                        <ul class="list-unstyled mb-0">
                            @foreach($torneo->equipos as $equipo)
                                <li>{{ $equipo->nombre_equipo }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        <a href="{{ route('torneos.edit', $torneo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('torneos.destroy', $torneo->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection