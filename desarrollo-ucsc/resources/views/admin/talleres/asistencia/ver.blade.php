@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Hoja de Asistencia'])

<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Asistencia del taller: {{ $taller->nombre_taller }}</h4>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-3">
                <table class="table align-items-center mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Carrera</th>
                            <th>Sexo</th>
                            <th>Fecha de Asistencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $fechaAnterior = null;
                            $colorA = 'bg-gray-100';
                            $colorB = 'bg-white';
                            $toggle = false;
                        @endphp

                        @forelse ($asistencias->sortByDesc('fecha_asistencia') as $asistencia)
                            @php
                                $fechaActual = \Carbon\Carbon::parse($asistencia->fecha_asistencia)->format('d-m-Y');
                                if ($fechaActual !== $fechaAnterior) {
                                    $toggle = !$toggle;
                                    $fechaAnterior = $fechaActual;
                                }
                                $rowClass = $toggle ? $colorA : $colorB;
                            @endphp
                            <tr class="{{ $rowClass }}">
                                <td>{{ $asistencia->rut }}</td>
                                <td>{{ $asistencia->nombre ?? 'No disponible' }}</td>
                                <td>{{ $asistencia->carrera ?? '-' }}</td>
                                <td>{{ $asistencia->sexo_alumno ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($asistencia->fecha_asistencia)->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay registros de asistencia.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-3 pb-3">
                <a href="{{ route('talleres.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Volver
                </a>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection
