@extends('layouts.app')

@section('title', 'Usuario Sala')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-start mb-3">
            <a href="{{ route('control-salas.seleccionar') }}" class="btn btn-secondary">
                ← Volver a Selección de Sala
            </a>
        </div>

        <h3 class="mb-4 text-center text-md-start">Usuarios Activos - {{ $sala->nombre_sala }}</h3>

        @if ($sala->ingresos->isEmpty())
            <p class="text-muted text-center">No hay usuarios activos en esta sala.</p>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>Rut</th>
                            <th>Nombre</th>
                            <th>Hora Ingreso</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sala->ingresos as $ingreso)
                            <tr>
                                <td>{{ $ingreso->usuario->rut }}</td>
                                <td>
                                    @if ($ingreso->usuario->alumno)
                                        {{ $ingreso->usuario->alumno->nombre_alumno }}
                                        {{ $ingreso->usuario->alumno->apellido_paterno }}
                                        {{ $ingreso->usuario->alumno->apellido_materno }}
                                    @else
                                        {{ $ingreso->usuario->administrador->nombre_admin }}
                                    @endif
                                </td>
                                <td>{{ $ingreso->hora_ingreso }}</td>
                                <td class="text-center">
                                    <form action="{{ route('admin.control-salas.sacar_usuario') }}" method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas sacar a este usuario?')">
                                        @csrf
                                        <input type="hidden" name="id_ingreso" value="{{ $ingreso->id_ingreso }}">
                                        <button type="submit" class="btn btn-danger btn-sm">Sacar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
