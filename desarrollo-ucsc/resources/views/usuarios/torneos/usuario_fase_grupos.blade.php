@extends('layouts.guest')

@section('title', 'Fase de Grupos')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container py-4">
            <h2 class="mb-4">Fase de Grupos - {{ $torneo->nombre_torneo }}</h2>
            <div class="card shadow rounded-4 p-4" style="background: #fff;">
                @foreach($tablas as $idx => $tabla)
                    <h5>Grupo {{ chr(65 + $idx) }}</h5>
                    <div class="table-responsive mb-4">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-3">Equipo</th>
                                    <th class="ps-3">PJ</th>
                                    <th class="ps-3">PG</th>
                                    <th class="ps-3">PE</th>
                                    <th class="ps-3">PP</th>
                                    <th class="ps-3">GF</th>
                                    <th class="ps-3">GC</th>
                                    <th class="ps-3">PTS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tabla as $fila)
                                    <tr>
                                        <td class="ps-3">{{ $fila['equipo']->nombre_equipo }}</td>
                                        <td class="ps-3">{{ $fila['pj'] }}</td>
                                        <td class="ps-3">{{ $fila['pg'] }}</td>
                                        <td class="ps-3">{{ $fila['pe'] }}</td>
                                        <td class="ps-3">{{ $fila['pp'] }}</td>
                                        <td class="ps-3">{{ $fila['gf'] }}</td>
                                        <td class="ps-3">{{ $fila['gc'] }}</td>
                                        <td class="ps-3">{{ $fila['pts'] }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No hay datos para mostrar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                @endforeach
                <a href="{{ route('torneos.usuario.index') }}" class="btn btn-secondary mt-3 float-end">Volver</a>
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection