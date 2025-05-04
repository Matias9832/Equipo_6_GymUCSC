@extends('layouts.app')

@section('content')
<div class="container d-flex flex-column justify-content-center align-items-center vh-100 text-center">
    @if (isset($horaIngreso))
        <h2 class="mb-3">Estás en la {{ $nombreSala }}</h2>
        <p>Hora de ingreso: <strong>{{ $horaIngreso }}</strong></p>

        @php
            $ingreso = \Carbon\Carbon::parse($horaIngreso);
            $limite = $ingreso->copy()->addMinutes(90);
            $horaMax = $limite->greaterThan(\Carbon\Carbon::parse('18:00')) ? '18:00' : $limite->format('H:i');
        @endphp

        <p>Tienes acceso hasta: <strong>{{ $horaMax }}</strong></p>
    @else
        <div class="alert alert-info">
            Escanea el QR para acceder a la Sala de Musculación
        </div>
    @endif
</div>

<style>
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }
        h2 {
            font-size: 1.5rem;
        }
        p {
            font-size: 1rem;
        }
    }
</style>
@endsection
