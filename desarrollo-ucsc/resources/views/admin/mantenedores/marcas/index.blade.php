@extends('layouts.admin')

@section('title', 'Lista de Marcas')

@section('content')
    <h1 class="h3">Lista de Marcas</h1>
    <a href="{{ route('marcas.create') }}" class="btn btn-primary mb-3">Crear Marca</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Logo</th>
                <th>Misión</th>
                <th>Visión</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marcas as $marca)
                <tr>
                    <td>{{ $marca->nombre_marca }}</td>
                    <td>
                        <img src="{{ asset('storage/' . $marca->logo_marca) }}" alt="Logo" width="60">
                    </td>
                    <td>{{ $marca->mision_marca }}</td>
                    <td>{{ $marca->vision_marca }}</td>
                    <td>
                        <a href="{{ route('marcas.edit', $marca->id_marca) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('marcas.destroy', $marca->id_marca) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar esta marca?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
