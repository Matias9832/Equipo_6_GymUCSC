
@extends('layouts.app')

@section('title', 'Lista de Países')

@section('content')
    <h1 class="h3">Lista de Países</h1>
    <a href="{{ route('paises.create') }}" class="btn btn-primary mb-3">Crear País</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Bandera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($paises as $pais)
                <tr>
                    <td>{{ $pais->nombre_pais }}</td>
                    <td>
                        <img src="{{ $pais->bandera_pais }}" alt="Bandera de {{ $pais->nombre_pais }}" style="width: 50px; height: auto;">
                    </td>
                    <td>
                        <a href="{{ route('paises.edit', $pais->id_pais) }}" class="btn btn-sm btn-warning">Editar</a>
                        <form action="{{ route('paises.destroy', $pais->id_pais) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm p-1" onclick="return confirm('¿Estás seguro de que quieres eliminar este país?')">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection