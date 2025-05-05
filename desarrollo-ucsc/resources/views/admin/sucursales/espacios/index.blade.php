@extends('layouts.admin')

@section('title', 'Lista de Alumnos')

@section('content')
    <h1>
        Listado de Espacios:
        <span class="text-muted">{{ session('nombre_sucursal') }}</span>
    </h1>

   

    <a href="{{ route('espacios.create') }}" class="btn btn-primary mb-3">Crear Nuevo Espacio</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($espacios as $espacio)
                <tr>
                    <td>{{ $espacio->id_espacio }}</td>
                    <td>{{ $espacio->nombre_espacio }}</td>
                    <td>{{ ucfirst($espacio->tipo->nombre_tipo) }}</td>
                    <td>
                        <a href="{{ route('espacios.edit', $espacio) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('espacios.destroy', $espacio) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar este espacio?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay espacios disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection