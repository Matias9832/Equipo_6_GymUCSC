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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tipos as $tipos)
                <tr>
                    <td>{{ $tipos->id_tipo_sancion }}</td>
                    <td>{{ $tipos->nombre_tipo_sancion}}</td>
                    <td>
                        <a href="{{ route('tipos_sancion.edit', $tipos-> id_tipo_sancion) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('tipos_sancion.destroy', $tipos-> id_tipo_sancion) }}" method="POST" style="display:inline-block;">
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