@extends('layouts.admin')

@section('title', 'Lista de Salas')

@section('content')
    <h1>
        Listado de Salas:
        <span class="text-muted">{{ session('nombre_sucursal') }}</span>
    </h1>

    <a href="{{ route('salas.create') }}" class="btn btn-primary mb-3">Crear Nueva Sala</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Aforo</th>
                <th>Horario</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($salas as $sala)
                <tr>
                    <td>{{ $sala->nombre_sala }}</td>
                    <td>{{ $sala->aforo_sala }}</td>
                    <td>{{ \Carbon\Carbon::parse($sala->horario_apertura)->format('H:i') }} -
                        {{ \Carbon\Carbon::parse($sala->horario_cierre)->format('H:i') }}
                    </td>
                    <td>
                        <a href="{{ route('salas.edit', $sala) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('salas.destroy', $sala) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Estás seguro de eliminar esta sala?')">Eliminar</button>
                        </form>

                        <div class="dropdown d-inline-block">
                            <button class="btn btn-sm btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Exportar Excel
                            </button>
                            <div class="dropdown-menu p-3" style="min-width: 300px;">
                                <form action="{{ route('salas.exportar') }}" method="GET">
                                    <input type="hidden" name="sala_id" value="{{ $sala->id_sala }}">

                                    <div class="mb-2">
                                        <label for="fecha">Fecha:</label>
                                        <input type="date" name="fecha" class="form-control" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="tipo">Periodo:</label>
                                        <select name="tipo" class="form-select" required>
                                            <option value="diario">Diario</option>
                                            <option value="semanal">Semanal</option>
                                            <option value="mensual">Mensual</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-sm w-100">Descargar</button>
                                </form>
                            </div>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay salas disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection