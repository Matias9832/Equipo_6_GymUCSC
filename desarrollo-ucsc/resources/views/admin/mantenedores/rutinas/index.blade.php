@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Rutinas'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Rutinas</h6>
                        <a href="{{ route('rutinas.create') }}" class="btn btn-primary btn-sm">Crear Rutina</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre Rutina</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT Usuario</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RUT Creador</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Ejercicios</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rutinas as $rutina)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">
                                                    {{ $rutina->nombre }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">
                                                    {{ $rutina->usuario->rut ?? 'Sin RUT' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">
                                                    {{ $rutina->creador_rut ?? 'Sin RUT' }}
                                                </span>
                                            </td>
                                            <td>
                                                <ul class="mb-0">
                                                    @foreach($rutina->ejercicios as $ejercicio)
                                                        <li>
                                                            {{ $ejercicio->nombre }}
                                                            ({{ $ejercicio->pivot->series }} series, {{ $ejercicio->pivot->repeticiones }} repeticiones)
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('rutinas.edit', $rutina->id) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="ni ni-ruler-pencil text-info"></i></a>
                                                <form action="{{ route('rutinas.destroy', $rutina->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro?')" title="Eliminar">
                                                        <i class="ni ni-fat-remove"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                No hay rutinas registradas.
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
    </div>
@endsection