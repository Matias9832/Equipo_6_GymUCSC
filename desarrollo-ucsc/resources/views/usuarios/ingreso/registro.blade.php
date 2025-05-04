@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h2 class="mb-4">Acceder a {{ $nombreSala }}</h2>

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
