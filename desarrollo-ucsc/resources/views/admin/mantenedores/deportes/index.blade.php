@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Deportes'])
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                        <h6>Lista de Deportes</h6>
                        <a href="{{ route('deportes.create') }}" class="btn btn-primary btn-sm">Crear Deporte</a>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nombre</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Jugadores por Equipo</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Descripción</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php use Illuminate\Support\Str; @endphp
                                    @foreach($deportes as $deporte)
                                        <tr>
                                            <td>
                                                <span class="text-xs font-weight-bold ps-3">{{ $deporte->nombre_deporte }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ $deporte->jugadores_por_equipo }}</span>
                                            </td>
                                            <td>
                                                <span class="text-xs">{{ Str::limit($deporte->descripcion, 70, '...') }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('deportes.edit', $deporte->id_deporte) }}" class="text-secondary font-weight-bold text-xs me-2" data-toggle="tooltip" title="Editar">
                                                    <i class="fas fa-pen-to-square text-info"></i>
                                                </a>
                                                <form action="{{ route('deportes.destroy', $deporte->id_deporte) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger p-0 m-0 align-baseline" onclick="return confirm('¿Estás seguro de que quieres eliminar este deporte?')" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- Si hay paginación, se muestra --}}
                            @if(method_exists($deportes, 'links'))
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $deportes->links('pagination::bootstrap-4') }}
                                </div>
                            @endif

                            {{-- Si está vacío --}}
                            @if($deportes->isEmpty())
                                <div class="text-center text-muted py-4">
                                    No hay deportes registrados.
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
