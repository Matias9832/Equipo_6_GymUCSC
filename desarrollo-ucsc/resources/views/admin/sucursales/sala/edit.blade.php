@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Salas'])

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow rounded-4 p-4">
                <h6 class="mb-4">Editar información de la sala</h6>

                <form action="{{ route('salas.update', $sala) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nombre_sala" class="form-label">Nombre de la Sala</label>
                        <input type="text" name="nombre_sala" id="nombre_sala" class="form-control" value="{{ $sala->nombre_sala }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="aforo_sala" class="form-label">Aforo</label>
                        <input type="number" name="aforo_sala" id="aforo_sala" class="form-control" value="{{ $sala->aforo_sala }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Horario (Apertura - Cierre)</label>
                        <div class="d-flex gap-2">
                            <input type="time" name="horario_apertura" id="horario_apertura" class="form-control" value="{{ $sala->horario_apertura }}" required>
                            <span class="align-self-center">-</span>
                            <input type="time" name="horario_cierre" id="horario_cierre" class="form-control" value="{{ $sala->horario_cierre }}" required>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-2">Guardar cambios</button>
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
        minuteIncrement: 10 // Los minutos avanzan de 10 en 10
    });
    flatpickr("#horario_cierre", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true,
        altInput: true,
        altFormat: "H:i",
        locale: "es",
        minuteIncrement: 10 // Los minutos avanzan de 10 en 10
    });
</script>
@endpush
@stack('js')
@endsection
