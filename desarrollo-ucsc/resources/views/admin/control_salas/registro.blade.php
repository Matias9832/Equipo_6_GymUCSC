@extends('layouts.app') {{-- Usa tu layout base, cambia si usas otro --}}

@section('content')
<div class="container text-center">
    <h1 class="mb-4">Registro en Sala</h1>

    {{-- Mostrar la fecha obtenida del QR --}}
    <p>Fecha del registro: {{ $fecha }}</p>

    {{-- Mostrar botón de registro si el usuario está logueado --}}
    @auth
        <form action="#" method="POST">
            @csrf
            <button class="btn btn-success">Registrarse en sala</button>
        </form>
    @else
        <div class="alert alert-warning">
            Debes iniciar sesión para registrarte en la sala.
        </div>
    @endauth
</div>
@endsection
