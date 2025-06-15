@extends('layouts.guest')

@section('content')
     @include('layouts.navbars.guest.navbar')

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100 text-center">
        <div id="contenido-ingreso">
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

@section('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const contenedor = document.querySelector('.container');

        setInterval(() => {
            fetch('/estado-usuario')
                .then(res => res.json())
                .then(data => {
                    if (data.enSala) {
                        const ingreso = new Date(`1970-01-01T${data.horaIngreso}:00`);
                        const cierre = new Date(`1970-01-01T${data.horarioCierre}:00`);
                        const limite = new Date(ingreso.getTime() + 90 * 60000);
                        const horaMax = (limite > cierre ? cierre : limite).toTimeString().slice(0,5);

                        contenedor.innerHTML = `
                            <h2 class="mb-3">Estás en la ${data.nombreSala}</h2>
                            <p>Hora de ingreso: <strong>${data.horaIngreso}</strong></p>
                            <p>Tienes acceso hasta: <strong>${horaMax}</strong></p>
                            <button class="btn btn-outline-danger mt-4" data-bs-toggle="modal" data-bs-target="#confirmarSalidaModal">
                                Marcar salida
                            </button>
                        `;
                    } else {
                        contenedor.innerHTML = `
                            <div class="alert alert-info">
                                Escanea el QR para acceder a la Sala de Musculación
                            </div>
                        `;
                    }
                });
        }, 10000); // cada 10 segundos
    });
</script>

@endsection