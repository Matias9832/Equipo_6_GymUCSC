@extends('layouts.guest')

@php
    use App\Models\Marca;
    $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
@endphp

@section('content')
<div class="container py-5 d-flex flex-column align-items-center justify-content-center" style="min-height: 70vh;">
    <div class="card shadow-lg border-0" style="max-width: 400px;">
        <div class="card-body text-center">
            <img src="{{ url($ultimaMarca->logo_marca) }}" alt="Logo Marca" style="height: 70px;" class="mb-4">
            <h2 class="mb-3 text-primary fw-bold">Error</h2>
            <p class="mb-4 text-secondary">
                Ha ocurrido un error inesperado.<br>
                Serás redirigido al inicio en unos segundos.
            </p>
            <a href="{{ url('/') }}" class="btn btn-primary">
                Ir al inicio ahora
            </a>
        </div>
    </div>
</div>
<script>
    setTimeout(function() {
        window.location.href = "{{ url('/') }}";
    }, 4000);
</script>
@endsection
