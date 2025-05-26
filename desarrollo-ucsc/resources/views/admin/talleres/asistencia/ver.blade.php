@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <h4 class="text-white mb-4">Asistencia del Taller: {{ $taller->nombre_taller }}</h4>

    <form method="GET" action="{{ route('asistencia.ver', $taller->id_taller) }}" class="row mb-4">
        <div class="col-md-4">
            <label for="fecha" class="form-label text-white">Seleccionar Fecha</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $fecha }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <div class="card">
        <div class="card-header pb-0">
            <h6>Listado de Asistencias</h6>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-3">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <th>RUT</th>
                            <th>Correo</th>
                            <th>Fecha de Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asistencias as $asistencia)
                            <tr>
                                <td>{{ $asistencia->rut }}</td>
                                <td>{{ $asistencia->correo_usuario }}</td>
                                <td>{{ \Carbon\Carbon::parse($asistencia->fecha_asistencia)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">No hay registros de asistencia para esta fecha.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

