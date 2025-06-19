@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Máquinas'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h5>Lista de Máquinas</h5>
                        <a href="{{ route('maquinas.create') }}" class="btn btn-primary btn-sm">Registrar máquina</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Estado</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($maquinas as $maquina)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $maquina->nombre_maq }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-sm {{ $maquina->estado_maq ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                    {{ $maquina->estado_maq ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('maquinas.edit', $maquina->id_maq) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-pen-to-square  text-warning"></i>
                                                </a>
                                                <form action="{{ route('maquinas.destroy', $maquina->id_maq) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar esta máquina?')" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @if(method_exists($maquinas, 'links'))
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $maquinas->links('pagination::bootstrap-4') }}
                                </div>
                            @endif

                            @if($maquinas->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay máquinas registradas.
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
