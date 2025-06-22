@extends('layouts.guest')

@section('content')
    @include('layouts.navbars.guest.navbar')

    <!-- La hora actual del navegador ya NO se muestra -->

    <div style="min-height: 100vh; background: #f8f9fa;">
        <div class="min-height-300 bg-primary position-absolute w-100" style="top:0;left:0;z-index:0;"></div>
        <div style="
            position: relative;
            z-index: 1;
            max-width: 700px;
            margin: 0 auto;
            margin-top: 120px;
            padding: 40px 24px;
            border-radius: 20px;
            box-shadow: 0 2px 16px rgba(0,0,0,0.07);
            background: #fff;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        ">
            <div id="contenido-ingreso">
                @if (isset($horaIngreso))
                    <h2 class="mb-4" style="font-weight: bold; font-size:2.7rem;">Estás en la {{ $nombreSala }}</h2>
                    <p style="font-size:1.2rem;">Hora de ingreso: <strong>{{ \Carbon\Carbon::parse($horaIngreso)->format('H:i') }}</strong></p>
                    <p style="font-size:1.2rem;">Hora estimada de salida: <strong id="hora-salida-estimada">{{ $horaSalidaEsperada }}</strong></p>
                    <button class="btn btn-outline-danger mt-4" data-bs-toggle="modal" data-bs-target="#confirmarSalidaModal">
                        Marcar salida
                    </button>
                @else
                    <div class="alert alert-info">
                        Escanea el QR para acceder a la Sala de Musculación
                    </div>
                @endif
            </div>
            <!-- Ya no se muestra la hora actual aquí -->
        </div>
    </div>

    <!-- Modal de confirmación de salida -->
    <div class="modal fade" id="confirmarSalidaModal" tabindex="-1" aria-labelledby="confirmarSalidaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmarSalidaModalLabel">Confirmar salida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
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

    <!-- Modal urgente: Tiempo finalizado -->
    <div class="modal fade" id="modalTiempoFinalizado" tabindex="-1" aria-labelledby="modalTiempoFinalizadoLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="modalTiempoFinalizadoLabel">¡Tiempo finalizado!</h5>
                </div>
                <div class="modal-body">
                    <p class="fw-bold text-danger fs-5">
                        Tu tiempo en la sala de musculación ha terminado.<br>
                        Debes abandonar la sala y marcar tu salida.
                    </p>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('sala.registrarSalida') }}" method="POST" class="w-100">
                        @csrf
                        <input type="hidden" name="id_sala" value="{{ $idSala }}">
                        <button type="submit" class="btn btn-danger w-100">Marcar salida</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para mostrar el modal automáticamente al llegar a la hora límite -->
    <script>
        // La hora actual NO se muestra, pero el script sigue funcionando
        let modalMostrado = false;
        function checkHoraSalida() {
            const horaSalida = document.getElementById('hora-salida-estimada');
            if (!horaSalida) return;
            const horaLimite = horaSalida.textContent.trim();
            if (!horaLimite) return;

            const ahora = new Date();
            const [h, m, s] = horaLimite.split(':');
            const salida = new Date();
            salida.setHours(parseInt(h), parseInt(m), s ? parseInt(s) : 0, 0);

            if (ahora >= salida && !modalMostrado) {
                const modal = new bootstrap.Modal(document.getElementById('modalTiempoFinalizado'), {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                modalMostrado = true;
            }
        }
        setInterval(checkHoraSalida, 1000);
    </script>

    @include('layouts.footers.guest.footer')
@endsection