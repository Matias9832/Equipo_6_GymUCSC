@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Talleres'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Talleres</h6>
                        <a href="{{ route('talleres.create') }}" class="btn btn-primary btn-sm">Crear Taller</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Nombre</th>
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
                                            Profesor </th>
                                        <th 
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Asistencia</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($talleres as $taller)
                                        <tr>
                                            <td><span class="text-xs font-weight-bold ps-3">{{ $taller->nombre_taller }}</span>
                                            </td>
                                            <td><span class="text-xs">{{ $taller->cupos_taller }}</span></td>
                                            <td>
                                                <span class="badge bg-{{ $taller->activo_taller ? 'success' : 'secondary' }}">
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
                                                @if($taller->administrador)
                                                    <span class="text-xs">{{ $taller->administrador->nombre_admin }}</span>
                                                @else
                                                    <span class="text-muted text-xs">Sin asignar</span>
                                                @endif
                                            </td>

                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('asistencia.ver', $taller->id_taller) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="fas fa-eye me-1"></i> Ver
                                                    </a>
                                                    <a href="{{ route('asistencia.registrar', $taller->id_taller) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-edit me-1"></i> Registrar
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('talleres.edit', $taller->id_taller) }}"
                                                    class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="ni ni-ruler-pencil text-info"></i>
                                                </a>
                                                <form action="{{ route('talleres.destroy', $taller->id_taller) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-link text-danger p-0 m-0 align-baseline"
                                                        onclick="return confirm('¿Estás seguro de que quieres eliminar este taller?')"
                                                        title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
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