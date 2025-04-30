@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">Gestión de QR</h1>

    {{-- Mostrar código QR --}}
    @if (isset($qrCode))
        <div class="mb-4">
            {!! $qrCode !!}
        </div>
    @endif

    {{-- Mostrar botón si vino desde el QR y el usuario está autenticado --}}
    @if ($desdeQR ?? false)
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
    @endif
</div>
@endsection
