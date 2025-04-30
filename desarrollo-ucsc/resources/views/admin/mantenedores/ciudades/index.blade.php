@extends('layouts.admin')

@section('title', 'Lista de Ciudades')

@section('content')
    <h1 class="h3">Lista de Ciudades</h1>
    <a href="{{ route('ciudades.create') }}" class="btn btn-primary mb-3">Crear Ciudad</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Región</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ciudades as $ciudad)
                <tr>
                    <td>{{ $ciudad->id_ciudad }}</td>
                    <td>{{ $ciudad->nombre_ciudad }}</td>
                    <td>{{ $ciudad->region->nombre_region }}</td>
                    <td>
                        <a href="{{ route('ciudades.edit', $ciudad->id_ciudad) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('ciudades.destroy', $ciudad->id_ciudad) }}" method="POST" class="d-inline">
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