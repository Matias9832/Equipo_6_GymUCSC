
@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Ejercicios'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Ejercicios</h6>
                        <a href="{{ route('ejercicios.create') }}" class="btn btn-primary btn-sm">Crear Ejercicio</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Grupo Muscular</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Imagen</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ejercicios as $ejercicio)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $ejercicio->nombre }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ ucfirst($ejercicio->grupo_muscular) }}</span>
                                            </td>
                                            <td>
                                                    @if($ejercicio->imagen)
                                                        <img src="{{ url('img/' . $ejercicio->imagen) }}" alt="Imagen del ejercicio" class="img-fluid" style="max-height: 50px; max-width: 80px;">
                                                    @else
                                                        <span class="text-muted">Sin imagen</span>
                                                    @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('ejercicios.edit', $ejercicio->id) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip"
                                                    title="Editar">
                                                    <i class="fas fa-pen-to-square text-info"></i></a>
                                                <form action="{{ route('ejercicios.destroy', $ejercicio->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro?')" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($ejercicios->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay ejercicios registrados.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection