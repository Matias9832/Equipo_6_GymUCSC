@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Salas'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow rounded-4 p-4">
                <h5 class="mb-4">Registrar nueva sala</h5>

                <form action="{{ route('salas.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre_sala" class="form-label">Nombre</label>
                        <input type="text" name="nombre_sala" id="nombre_sala" class="form-control" placeholder="Nombre de la sala" required>
                    </div>

                    <div class="mb-3">
                        <label for="aforo_sala" class="form-label">Aforo</label>
                        <input type="number" name="aforo_sala" id="aforo_sala" class="form-control" placeholder="Cantidad de personas máximas permitidas" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Horario</label>
                        <div class="d-flex gap-2">
                            <input type="text" name="horario_apertura" id="horario_apertura" class="form-control" placeholder="Hora de apertura" required>
                            <span class="align-self-center">-</span>
                            <input type="text" name="horario_cierre" id="horario_cierre" class="form-control" placeholder="Hora de cierre" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Guardar</button>
                        <a href="{{ route('salas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.footers.auth.footer')
</div>
@push('js')
<script>
    flatpickr("#horario_apertura", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        altInput: true,
        altFormat: "H:i",
        locale: "es",
        minuteIncrement: 10
    });
    flatpickr("#horario_cierre", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        altInput: true,
        altFormat: "H:i",
        locale: "es",
        minuteIncrement: 10
    });
</script>
@endpush
@stack('js')
@endsection
