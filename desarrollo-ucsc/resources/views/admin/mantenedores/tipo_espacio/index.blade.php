@extends('layouts.admin')

@section('title', 'Tipos de Espacios')

@section('content')
    <h1>Listado Tipos de Espacios</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('tipos_espacio.create') }}" class="btn btn-primary mb-3">Crear Nuevo Espacio</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tipo as $tipos)
                <tr>
                    <td>{{ $tipos->id }}</td>
                    <td>{{ $tipos->nombre}}</td>
                    <td>
                        <a href="{{ route('espacio.edit', $tipos-> id) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('tipos_espacio.destroy', $tipos-> id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo de espacio?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay tipod de espacios disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection