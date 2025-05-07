@extends('layouts.app')

@section('content')
    <div class="container-fluid d-flex flex-column align-items-center justify-content-center"
        style="max-width: 500px; margin: 0 auto; height: 50vh;">

        @if (isset($nombreSala))
            <h2 class="text-center mb-4">Acceder a {{ $nombreSala }}</h2>   
        @endif

        @if (isset($mensaje))
            <div class="alert alert-info text-center w-100">
            {!! nl2br(e($mensaje)) !!}
            </div>

            @if ($mensaje == 'Ya ingresaste a la sala previamente.')
                <a href="{{ route('ingreso.mostrar') }}" class="btn btn-primary btn-block mt-3 w-100">Ver tu acceso</a>
            @endif
        @else
            @if ($usuariosActivos >= $aforo)
                <div class="alert alert-danger text-center w-100">
                    La sala está llena. Intenta acceder más tarde.
                </div>
            @else
                <form action="{{ route('sala.registro') }}" method="POST" class="w-100">
                    @csrf
                    <button class="btn btn-success btn-block mt-3 w-100">Acceder a sala</button>
                </form>
            @endif
        @endif
    </div>
@endsection