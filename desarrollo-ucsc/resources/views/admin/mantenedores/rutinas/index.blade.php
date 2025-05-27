@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Rutinas'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Rutinas</h6>
                        @can('Crear Rutinas')
                            <a href="{{ route('rutinas.create') }}" class="btn btn-primary btn-sm">Crear Rutina</a>
                        @endcan
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ejercicios</th>
                                        @can('Editar Rutinas|Eliminar Rutinas')
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rutinas as $rutina)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $rutina->usuario->correo_usuario }}</span>
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach($rutina->ejercicios as $ejercicio)
                                                        <li>{{ $ejercicio->nombre }} ({{ $ejercicio->pivot->series }} series, {{ $ejercicio->pivot->repeticiones }} repeticiones)</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            @can('Editar Rutinas|Eliminar Rutinas')
                                                <td class="align-middle text-center">
                                                    @can('Editar Rutinas')
                                                        <a href="{{ route('rutinas.edit', $rutina->id) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                            <i class="ni ni-ruler-pencil text-info"></i>
                                                        </a>
                                                    @endcan
                                                    @can('Eliminar Rutinas')
                                                        <form action="{{ route('rutinas.destroy', $rutina->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar esta rutina?')" title="Eliminar">
                                                                <i class="ni ni-fat-remove"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($rutinas->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay rutinas registradas.
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