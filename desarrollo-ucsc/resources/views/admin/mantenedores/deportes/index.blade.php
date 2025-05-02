@extends('layouts.admin')

@section('title', 'Lista de Deportes')

@section('content')
    <h1 class="h3">Lista de Deportes</h1>
    <a href="{{ route('deportes.create') }}" class="btn btn-primary mb-3">Crear Deporte</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Jugadores por Equipo</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deportes as $deporte)
                <tr>
                    <td>{{ $deporte->id_deporte }}</td>
                    <td>{{ $deporte->nombre_deporte }}</td>
                    <td>{{ $deporte->jugadores_por_equipo }}</td>
                    <td>{{ $deporte->descripcion }}</td>
                    <td>
                        <a href="{{ route('deportes.edit', $deporte->id_deporte) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('deportes.destroy', $deporte->id_deporte) }}" method="POST" class="d-inline">
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