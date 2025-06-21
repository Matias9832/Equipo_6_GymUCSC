@extends('layouts.guest')

@section('content')
    @include('layouts.navbars.guest.navbar')

    <div class="container d-flex flex-column justify-content-center align-items-center vh-100 text-center">
        <div id="contenido-ingreso">
            @if (isset($horaIngreso))
                <h2 class="mb-3">Estás en la {{ $nombreSala }}</h2>
                <p>Hora de ingreso: <strong>{{ $horaIngreso }}</strong></p>
                <p>Tienes acceso hasta: <strong>{{ $horaSalidaEsperada }}</strong></p>
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

    @include('layouts.footers.guest.footer')
@endsection

@section('scripts')
<script>
    let horaSalidaEsperada = "{{ $horaSalidaEsperada ?? '' }}";
    window.notif5min = false;
    window.notifSalida = false;
    let modalMostrado = false;
    let modalInterval = null;

    document.addEventListener('DOMContentLoaded', function () {
        const contenedor = document.querySelector('.container');

        setInterval(() => {
            fetch('/estado-usuario')
                .then(res => res.json())
                .then(data => {
                    if (data.enSala) {
                        contenedor.innerHTML = `
                            <h2 class="mb-3">Estás en la ${data.nombreSala}</h2>
                            <p>Hora de ingreso: <strong>${data.horaIngreso}</strong></p>
                            <p>Tienes acceso hasta: <strong>${data.horaSalidaEsperada}</strong></p>
                            <button class="btn btn-outline-danger mt-4" data-bs-toggle="modal" data-bs-target="#confirmarSalidaModal">
                                Marcar salida
                            </button>
                        `;
                        if (data.horaSalidaEsperada) {
                            horaSalidaEsperada = data.horaSalidaEsperada;
                        }
                    } else {
                        contenedor.innerHTML = `
                            <div class="alert alert-info">
                                Escanea el QR para acceder a la Sala de Musculación
                            </div>
                        `;
                        horaSalidaEsperada = '';
                        window.notif5min = false;
                        window.notifSalida = false;
                        modalMostrado = false;
                        if (modalInterval) {
                            clearInterval(modalInterval);
                            modalInterval = null;
                        }
                    }
                });
        }, 10000); // cada 10 segundos

        // Notificaciones navegador
        if (window.Notification && Notification.permission !== "granted") {
            Notification.requestPermission();
        }

        function mostrarModalUrgente() {
            let modal = new bootstrap.Modal(document.getElementById('modalTiempoFinalizado'), {
                backdrop: 'static',
                keyboard: false
            });
            modal.show();

            // Si el usuario intenta cerrar el modal, lo volvemos a mostrar cada minuto
            document.getElementById('modalTiempoFinalizado').addEventListener('hidden.bs.modal', function () {
                if (modalInterval) clearInterval(modalInterval);
                modalInterval = setInterval(() => {
                    // Verificamos si sigue pasado el tiempo de salida
                    const ahora = new Date();
                    const [h, m] = horaSalidaEsperada.split(':');
                    const salida = new Date();
                    salida.setHours(parseInt(h), parseInt(m), 0, 0);
                    if (ahora >= salida) {
                        let modal2 = new bootstrap.Modal(document.getElementById('modalTiempoFinalizado'), {
                            backdrop: 'static',
                            keyboard: false
                        });
                        modal2.show();
                    } else {
                        clearInterval(modalInterval);
                        modalInterval = null;
                    }
                }, 60000); // cada 1 minuto
            }, { once: true });
        }

        function checkNotificaciones() {
            if (!horaSalidaEsperada) return;
            const ahora = new Date();
            const [h, m] = horaSalidaEsperada.split(':');
            const salida = new Date();
            salida.setHours(parseInt(h), parseInt(m), 0, 0);

            const diffMs = salida - ahora;
            const diffMin = Math.floor(diffMs / 60000);

            // Notificar 5 minutos antes
            if (diffMin === 5 && !window.notif5min) {
                window.notif5min = true;
                if (Notification.permission === "granted") {
                    new Notification("¡Atención!", {
                        body: "Te quedan 5 minutos en la sala de musculación.",
                        icon: "/favicon.ico"
                    });
                }
            }

            // Notificar y mostrar modal cuando se alcanza o pasa la hora de salida
            if (diffMin <= 0 && !window.notifSalida) {
                window.notifSalida = true;
                if (Notification.permission === "granted") {
                    new Notification("¡Tiempo finalizado!", {
                        body: "Tu tiempo en la sala de musculación ha finalizado. Por favor, marca tu salida.",
                        icon: "/favicon.ico"
                    });
                }
                if (!modalMostrado) {
                    modalMostrado = true;
                    mostrarModalUrgente();
                }
            }
        }

        setInterval(checkNotificaciones, 30000);
        checkNotificaciones();
    });
</script>