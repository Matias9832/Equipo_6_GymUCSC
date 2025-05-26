@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Usuario Sala'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">

            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">Usuarios Activos - {{ $sala->nombre_sala }}</h6>
                    <a href="{{ route('control-salas.seleccionar') }}" class="btn btn-secondary btn-sm">
                        ← Volver a Selección de Sala
                    </a>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @if ($sala->ingresos->isEmpty())
                        <div class="text-center py-4 text-muted">
                            No hay usuarios activos en esta sala.
                        </div>
                    @else
                        <div class="table-responsive p-3">
                            <table class="table align-items-center mb-0 table-bordered">
                                <thead class="bg-light">
                                    <tr class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <th></th>
                                        <th>Rut</th>
                                        <th>Nombre</th>
                                        <th>Hora Ingreso</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sala->ingresos as $ingreso)
                                        @php
                                            $usuario = $ingreso->usuario;
                                            $tieneEnfermedad = $usuario && $usuario->salud && $usuario->salud->enfermo_cronico == 1;
                                            $icono = $usuario->tipo_usuario === 'seleccionado' ? 'fa-medal' : 'fa-user';
                                        @endphp
                                        <tr>
                                            <td class="text-center">
                                                <button type="button" class="btn p-0 border-0 bg-transparent"
                                                    data-bs-toggle="modal" data-bs-target="#saludModal{{ $ingreso->id_ingreso }}">
                                                    <i class="fas {{ $icono }} fs-5 {{ $tieneEnfermedad ? 'text-primary' : 'text-success' }}"></i>
                                                </button>
                                            </td>
                                            <td class="text-sm text-center">{{ $usuario->rut }}</td>
                                            <td class="text-sm">
                                                @if ($usuario->alumno)
                                                    {{ $usuario->alumno->nombre_alumno }} {{ $usuario->alumno->apellido_paterno }} {{ $usuario->alumno->apellido_materno }}
                                                @else
                                                    {{ $usuario->administrador->nombre_admin }}
                                                @endif
                                            </td>
                                            <td class="text-sm text-center">{{ $ingreso->hora_ingreso }}</td>
                                            <td class="text-center">
                                                <form action="{{ route('admin.control-salas.sacar_usuario') }}" method="POST"
                                                    onsubmit="return confirm('¿Seguro que deseas sacar a este usuario?')">
                                                    @csrf
                                                    <input type="hidden" name="id_ingreso" value="{{ $ingreso->id_ingreso }}">
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        Sacar
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </div>

    @include('layouts.footers.auth.footer')
</div>

{{-- Modales de Salud --}}
@foreach ($sala->ingresos as $ingreso)
    @php $salud = $ingreso->usuario->salud; @endphp
    @if ($salud)
        <div class="modal fade" id="saludModal{{ $ingreso->id_ingreso }}" tabindex="-1" aria-labelledby="saludModalLabel{{ $ingreso->id_ingreso }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="saludModalLabel{{ $ingreso->id_ingreso }}">Información de Salud</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>¿Enfermo Crónico?:</strong> {{ $salud->enfermo_cronico ? 'Sí' : 'No' }}</p>
                        @if ($salud->enfermo_cronico)
                            <p><strong>Detalles:</strong>
                                {{ is_array($salud->cronicas) ? implode(', ', $salud->cronicas) : ($salud->cronicas ?? 'Sin detalles') }}
                            </p>
                        @endif

                        <p><strong>¿Alergias?:</strong> {{ $salud->alergias ? 'Sí' : 'No' }}</p>
                        @if ($salud->alergias)
                            <p><strong>Detalles de Alergias:</strong> {{ $salud->detalle_alergias ?? 'Sin detalles' }}</p>
                        @endif

                        <p><strong>¿Indicaciones Médicas?:</strong> {{ $salud->indicaciones_medicas ? 'Sí' : 'No' }}</p>
                        @if ($salud->indicaciones_medicas)
                            <p><strong>Detalles de Indicaciones:</strong> {{ $salud->detalle_indicaciones ?? 'Sin detalles' }}</p>
                        @endif

                        <p><strong>Otra Información:</strong> {{ $salud->informacion_salud ?? 'Ninguna' }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection
