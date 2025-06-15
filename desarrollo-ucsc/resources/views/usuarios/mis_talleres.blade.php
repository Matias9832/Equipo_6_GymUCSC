@extends('layouts.guest')

@section('content')
@include('layouts.navbars.guest.navbar')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-transparent">
            <h2 class="mb-0">Mis Talleres</h2>
        </div>
        <div class="card-body">
            @if($talleres->isEmpty())
                <p class="text-muted">No tienes talleres registrados con asistencia.</p>
            @else
                <div class="row">
                    @foreach($talleres as $taller)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card border shadow-sm h-100">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title text-primary">{{ $taller->nombre_taller }}</h5>
                                    <p class="card-text flex-grow-1">{{ Str::limit($taller->descripcion_taller, 100) }}</p>
                                    <a href="{{ route('asistencia.ver', $taller->id_taller) }}" class="btn btn-sm btn-primary mt-2 align-self-start">
                                        Ver asistencias
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
