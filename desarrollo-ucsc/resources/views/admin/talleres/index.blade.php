@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Talleres'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5>Lista de Talleres</h5>
                        <a href="{{ route('talleres.create') }}" class="btn btn-primary btn-sm">Registrar Taller</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
                                        @can(['Acceso a Gestión de Asistencia Talleres'])  
                                        <th 
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Asistencia</th>
                                        @endcan    
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Cupos</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Estado</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Horarios</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Espacio</th>    
                                        <th 
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Restricciones</th>    
                                        <th 
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Profesor encargado</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($talleres as $taller)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $taller->nombre_taller }}</span>
                                            </td>
                                            @can(['Acceso a Gestión de Asistencia Talleres'])               
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('asistencia.registrar', $taller->id_taller) }}" class="btn btn-sm btn-outline-primary px-3" style="margin-bottom: 0rem !important;">
                                                        <i class="fas fa-edit"></i> Registrar asistencia
                                                    </a>
                                                    <a href="{{ route('asistencia.ver', $taller->id_taller) }}" class="btn btn-sm btn-outline-secondary px-3" style="margin-bottom: 0rem !important;">
                                                        <i class="fas fa-eye"></i> Ver asistencia
                                                    </a>
                                                </div>
                                            </td>
                                            @endcan
                                            <td>
                                                <span class="text-xs">{{ $taller->cupos_taller }}</span></td>
                                            <td>
                                                <span class="badge bg-gradient-{{ $taller->activo_taller ? 'success' : 'secondary' }}">
                                                    {{ $taller->activo_taller ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($taller->horarios->isEmpty())
                                                    <span class="text-xs text-muted">Sin horarios</span>
                                                @else
                                                    <ul class="mb-0 ps-3 text-xs">
                                                        <!-- Orden de horarios -->
                                                        @php 
                                                            $diasSemanaOrdenados = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                                            $horariosOrdenados = $taller->horarios->sortBy(function($h) use ($diasSemanaOrdenados) {
                                                                return array_search($h->dia_taller, $diasSemanaOrdenados);
                                                            });
                                                        @endphp

                                                        @foreach ($horariosOrdenados as $horario)
                                                            <div>
                                                                {{ $horario->dia_taller }}: {{ $horario->hora_inicio }} - {{ $horario->hora_termino }}
                                                            </div>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $taller->espacio->nombre_espacio ?? 'Sin asignar' }}</span>
                                            </td>
                                            <td>
                                                @if($taller->restricciones_taller)
                                                    <span class="text-xs">{{ $taller->restricciones_taller}}</span>
                                                @else
                                                    <span class="text-xs text-muted">Sin restricciones</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($taller->administrador)
                                                    <span class="text-xs">{{ $taller->administrador->nombre_admin }}</span>
                                                @else
                                                    <span class="text-muted text-xs">Sin asignar</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('talleres.edit', $taller->id_taller) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="fas fa-pen-to-square text-info"></i>
                                                </a>
                                                <form action="{{ route('talleres.destroy', $taller->id_taller) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este taller?')"
                                                        title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if(method_exists($talleres, 'links'))
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $talleres->links('pagination::bootstrap-4') }}
                                </div>
                            @endif

                            @if($talleres->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay talleres registrados.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection