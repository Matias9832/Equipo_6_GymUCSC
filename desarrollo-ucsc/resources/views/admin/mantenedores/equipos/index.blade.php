@extends('layouts.app')

@section('title', 'Lista de Equipos')

@section('content')
    <h1 class="h3">Lista de Equipos</h1>
    <a href="{{ route('equipos.create') }}" class="btn btn-primary mb-3">Crear Equipo</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre del Equipo</th>
                <th>Deporte</th>
                <th>Integrantes</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipos as $equipo)
                <tr>
                    <td>{{ $equipo->nombre_equipo }}</td>
                    <td>{{ $equipo->deporte->nombre_deporte }}</td>
                    <td>
                        @if($equipo->usuarios->isNotEmpty())
                            <ul class="list-unstyled mb-0">
                                @foreach($equipo->usuarios as $usuario)
                                    <li>{{ $usuario->nombre }} ({{ $usuario->rut }})</li>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-muted">Sin integrantes</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" class="d-inline">
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