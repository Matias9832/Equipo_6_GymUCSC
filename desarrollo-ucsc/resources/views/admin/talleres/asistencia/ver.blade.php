@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Hoja de Asistencia'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0">Asistencia del taller: {{ $taller->nombre_taller }}</h6>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('talleres.index') }}" class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Volver
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-3">
                        <table class="table align-items-center mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nombre</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Carrera</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Sexo</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Fecha de Asistencia</th>
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
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $asistencia->rut }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $asistencia->nombre ?? 'No disponible' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $asistencia->carrera ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm border {{ $asistencia->sexo_alumno === 'M' ? 'bg-gradient-blue' : 'bg-gradient-pink' }}" style="width: 35px;">
                                                {{ $asistencia->sexo_alumno ?? '-' }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($asistencia->fecha_asistencia)->format('d-m-Y') }}</p>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No hay registros de asistencia.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.auth.footer')
</div>
@endsection