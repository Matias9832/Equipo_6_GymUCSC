@extends('layouts.guest')

@section('title', 'Tabla de Posiciones')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container py-4">
            <h2 class="mb-4">Tabla de posiciones - {{ $torneo->nombre_torneo }}</h2>
            <div class="card shadow rounded-4 p-4" style="background: #fff;">
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>Equipo</th>
                                <th>PJ</th>
                                <th>PG</th>
                                <th>PE</th>
                                <th>PP</th>
                                <th>GF</th>
                                <th>GC</th>
                                <th>PTS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tabla as $fila)
                                <tr>
                                    <td>{{ $fila['equipo']->nombre_equipo }}</td>
                                    <td>{{ $fila['pj'] }}</td>
                                    <td>{{ $fila['pg'] }}</td>
                                    <td>{{ $fila['pe'] }}</td>
                                    <td>{{ $fila['pp'] }}</td>
                                    <td>{{ $fila['gf'] }}</td>
                                    <td>{{ $fila['gc'] }}</td>
                                    <td>{{ $fila['pts'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No hay datos para mostrar la tabla de posiciones.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <a href="{{ route('torneos.usuario.index') }}" class="btn btn-secondary mt-3 float-end">Volver</a>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection