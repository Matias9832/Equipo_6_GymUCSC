@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Tabla de Posiciones'])
    <div class="container-fluid py-4">
        <div class="card">
            <div class="card-body">
                <h4>Tabla de posiciones - {{ $torneo->nombre_torneo }}</h4>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Equipo</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PJ</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PG</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PE</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PP</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">GF</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">GC</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tabla as $fila)
                                <tr>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['equipo']->nombre_equipo }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['pj'] }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['pg'] }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['pe'] }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['pp'] }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['gf'] }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['gc'] }}</p>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $fila['pts'] }}</p>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay datos para mostrar la tabla de posiciones.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('torneos.index') }}" class="btn btn-outline-secondary mb-0">Volver</a>
                </div>    
            </div>
        </div>
    </div>
@include('layouts.footers.auth.footer')
@endsection