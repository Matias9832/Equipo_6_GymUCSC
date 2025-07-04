@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Torneos'])
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-header pb-0">
            <h4>Fase de Grupos - {{ $torneo->nombre_torneo }}</h4>
        </div>
        <div class="card-body">
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
            <div class="d-flex justify-content-end gap-2 mt-4">
                <a href="{{ route('torneos.index') }}" class="btn btn-outline-secondary px-4">Volver</a>
            </div>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
@endsection