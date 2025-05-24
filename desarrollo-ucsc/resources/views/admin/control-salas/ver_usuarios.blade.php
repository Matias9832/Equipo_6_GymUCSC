@extends('layouts.app')

@section('title', 'Usuario Sala')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Usuario Sala'])

    <div class="container py-4 card shadow-sm p-4">
        
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
                                <th></th>
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Hora Ingreso</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sala->ingresos as $ingreso)
                                <tr>
                                    <td class="text-center">
                                        @php
                                            $tieneEnfermedad = $ingreso->usuario &&
                                                                $ingreso->usuario->salud &&
                                                                $ingreso->usuario->salud->enfermo_cronico == 1;
                                        @endphp
                                    
                                         @if ($ingreso->usuario->tipo_usuario === 'estudiante')
                                            <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#saludModal{{ $ingreso->id_ingreso }}">
                                                <i class="fas fa-user fs-4 {{ $tieneEnfermedad ? 'text-primary' : 'text-success' }}"></i>{{-- ícono de usuario --}}
                                            </button>
                                        @elseif ($ingreso->usuario->tipo_usuario === 'seleccionado')
                                            <button type="button" class="btn p-0 border-0 bg-transparent" data-bs-toggle="modal" data-bs-target="#saludModal{{ $ingreso->id_ingreso }}">
                                                <i class="fas fa-solid fa-medal fs-4 {{ $tieneEnfermedad ? 'text-primary' : 'text-success' }}"></i> {{-- ícono de premio --}}
                                            </button>
                                        @endif
                                    </td>
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
                                @foreach ($sala->ingresos as $ingreso)
                                @php
                                     $salud = $ingreso->usuario->salud;
                                @endphp

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
                            
                        </tbody>
                    </table>
                </div>
            @endif
        
    </div>
@endsection
