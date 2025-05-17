@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mi Actividad</h2>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Hora Ingreso</th>
                <th>Hora Salida</th>
                <th>Tiempo de Uso</th>
                <th>Sala</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($actividades as $actividad)
                <tr>
                    <td>{{ $actividad->fecha_ingreso }}</td>
                    <td>{{ $actividad->hora_ingreso }}</td>
                    <td>{{ $actividad->hora_salida }}</td>
                    <td>{{ $actividad->tiempo_uso }}</td>
                    <td>{{ $actividad->nombre_sala }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay registros de actividad.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
