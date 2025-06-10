@extends('layouts.app')

@section('title', 'Fase de Grupos')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Fase de Grupos'])
<div class="container-fluid py-4">
    <div class="card">
        <div class="card-body">
            <h4>Fase de Grupos - {{ $torneo->nombre_torneo }}</h4>
            @foreach($tablas as $idx => $tabla)
                <h5>Grupo {{ chr(65 + $idx) }}</h5>
                <div class="table-responsive mb-4">
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
                                    <td colspan="8" class="text-center">No hay datos para mostrar.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endforeach
            <a href="{{ route('torneos.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
</div>
@include('layouts.footers.auth.footer')
@endsection