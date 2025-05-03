@extends('layouts.app')

@section('title', 'Registro Ingreso')

@section('content')
    <div class="container text-center mt-5">
        @if($mensaje)
            <h4 class="text-warning">{{ $mensaje }}</h4>
        @else
            <h2 class="text-success">¡Registro exitoso!</h2>
            <p class="mt-3">Ingreso registrado el día <strong>{{ $fecha }}</strong> a las <strong>{{ $horaIngreso }}</strong>.</p>

            <h4 class="mt-4">Tiempo restante:</h4>
            <div id="tiempoRestante" class="display-4 text-primary mb-4">Cargando...</div>

            <form action="{{ route('sala.registrarSalida') }}" method="POST">
                @csrf
                <input type="hidden" name="id_sala" value="{{ $idSala }}">
                <button type="submit" class="btn btn-danger">Registrar Salida</button>
            </form>
        @endif
    </div>
@endsection

@if(!$mensaje)
    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const horaIngreso = new Date("{{ now()->format('Y-m-d') }}T{{ $horaIngreso }}");
                const tiempoUsoMax = 1.5 * 60 * 60 * 1000;
                const horaLimite = new Date(horaIngreso.getTime() + tiempoUsoMax);

                function actualizarCuentaRegresiva() {
                    const ahora = new Date();
                    const diff = horaLimite - ahora;

                    if (diff <= 0) {
                        document.getElementById('tiempoRestante').textContent = "00:00:00";
                        return;
                    }

                    const horas = String(Math.floor(diff / (1000 * 60 * 60))).padStart(2, '0');
                    const minutos = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    const segundos = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');

                    document.getElementById('tiempoRestante').textContent = `${horas}:${minutos}:${segundos}`;
                }

                actualizarCuentaRegresiva();
                setInterval(actualizarCuentaRegresiva, 1000);
            });
        </script>
    @endsection
@endif
