@extends('layouts.app')

@section('title', 'Gestor de Qr')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Gestor de QR'])

    <div class="container py-4">
        <h1 class="mb-4 text-center">Gestión de QR: {{ $sala->nombre_sala }}</h1>

        @if (isset($qrCode))
            <div class="row justify-content-center align-items-center mb-5">
                {{-- QR Code --}}
                <div class="col-md-6 mb-3">
                    <div class="card p-4 shadow-sm h-100 text-center">
                        <div style="overflow-x: auto;">
                            {!! $qrCode !!}
                        </div>
                    </div>
                </div>

                {{-- Datos de aforo --}}
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm p-4 mb-3 text-center">
                        <h5 class="text-muted mb-2">Aforo permitido</h5>
                        <h2 class="text-primary">{{ $aforoPermitido }}</h2>
                        <hr>
                        <h6 class="text-muted">Usuarios registrados</h6>
                        <h1 class="text-danger">{{ $usuariosActivos }}</h1>
                    </div>

                    <div class="card shadow-sm p-4">
                        <div class="d-flex justify-content-around align-items-center gap-4 flex-wrap">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-user fs-4 {{ ($personasConEnfermedad ?? 0 ) > 0 ? 'text-info' : 'text-primary' }}"></i>
                                <div>
                                    <h4 class="fw-bold text-danger">{{ $estudiantes ?? 0 }}</h4>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-solid fa-medal fs-4 text-success"></i>
                                <div>
                                    <h4 class="fw-bold text-danger">{{ $seleccionados ?? 0 }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
