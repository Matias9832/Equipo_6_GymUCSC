@extends('layouts.guest')

@section('content')
     @include('layouts.navbars.guest.navbar')

    @if(session('mensaje'))
        <div class="alert alert-success mt-3">
            {{ session('mensaje') }}
        </div>
    @endif

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100 text-center">
        @if (isset($horaIngreso))
            <h2 class="mb-3">Estás en la {{ $nombreSala }}</h2>
            <p>Hora de ingreso: <strong>{{ $horaIngreso }}</strong></p>

            @php
                $ingreso = \Carbon\Carbon::parse($horaIngreso);
                $limite = $ingreso->copy()->addMinutes(90);
                $cierre = \Carbon\Carbon::parse($horarioCierre);
                $horaMax = $limite->greaterThan($cierre) ? $cierre->format('H:i') : $limite->format('H:i');
            @endphp


            <p>Tienes acceso hasta: <strong>{{ $horaMax }}</strong></p>

            <!-- Botón para abrir el modal de confirmación -->
            <button class="btn btn-outline-danger mt-4" data-bs-toggle="modal" data-bs-target="#confirmarSalidaModal">
                Marcar salida
            </button>

        @else
            <div class="alert alert-info">
                Escanea el QR para acceder a la Sala de Musculación
            </div>
        @endif
    </div>

    <!-- Modal de confirmación de salida -->
    <div class="modal fade" id="confirmarSalidaModal" tabindex="-1" aria-labelledby="confirmarSalidaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarSalidaModalLabel">Confirmar salida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que deseas registrar tu salida?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="{{ route('sala.registrarSalida') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_sala" value="{{ $idSala }}">
                        <button type="submit" class="btn btn-outline-danger">Marcar salida</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.guest.footer')

@endsection