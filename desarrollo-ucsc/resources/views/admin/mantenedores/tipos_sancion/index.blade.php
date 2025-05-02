@extends('layouts.admin')

@section('title', 'Tipos de Sanción')

@section('content')
    <h1>Listado Tipos de Sanciones</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('tipos_sancion.create') }}" class="btn btn-primary mb-3">Crear Nuevo Tipo de Sanción</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tipos as $tipo)
                <tr>
                    <td>{{ $tipo->id_tipo_sancion }}</td>
                    <td>{{ $tipo->nombre_tipo_sancion}}</td>
                    <td>{{ $tipo->descripcion_tipo_sancion }}</td>
                    <td>
                        <a href="{{ route('tipos_sancion.edit', $tipo-> id_tipo_sancion) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('tipos_sancion.destroy', $tipo-> id_tipo_sancion) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este tipo de sasncion?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay Tipos de Sanciones disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection