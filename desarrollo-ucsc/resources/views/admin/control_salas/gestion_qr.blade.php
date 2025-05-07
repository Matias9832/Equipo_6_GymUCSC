@extends('layouts.app')

@section('content')
    <div class="container text-center">
        <h1 class="mb-4">Gestión de QR: {{ $sala->nombre_sala }}</h1> <!-- Aquí se agrega el nombre de la sala -->

        @if (isset($qrCode))
            <div class="row justify-content-center align-items-center mb-4">
                <div class="col-md-6 mb-3">
                    <div>{!! $qrCode !!}</div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm p-3">
                        <h5 class="text-muted mb-2">Aforo permitido</h5>
                        <h2 class="text-primary">{{ $aforoPermitido }}</h2>
                        <hr>
                        <h6 class="text-muted">Usuarios registrados</h6>
                        <h1 class="text-danger">{{ $usuariosActivos }}</h1>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
