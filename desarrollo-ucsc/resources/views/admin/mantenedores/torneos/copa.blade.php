@extends('layouts.app')

@section('title', 'Llaves de Copa')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Llaves de Copa'])

<div class="container py-4">
    <h4 class="text-center mb-4 text-primary fw-bold">Llaves de Copa - {{ $torneo->nombre_torneo }}</h4>

    <div class="bracket-container">
        <div class="bracket-wrapper" id="bracket-wrapper">
            <div id="bracket"></div>
        </div>
    </div>

    <div class="d-flex justify-content-end mt-4">
        <a href="{{ route('torneos.index') }}" class="btn btn-secondary shadow-sm">Volver</a>
    </div>
</div>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/jquery-bracket@0.11.1/dist/jquery.bracket.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery-bracket@0.11.1/dist/jquery.bracket.min.js"></script>

<style>
    .bracket-container {
        width: 100%;
        max-width: 100%;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 6px 32px rgba(0, 0, 0, 0.1);
        overflow: auto;
        position: relative;
        padding: 0;
        height: 100%;
        min-height: 70vh;
    }

    .bracket-wrapper {
        padding: 32px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        transform-origin: top center;
        min-width: 600px;
    }

    .jQBracket .team {
        font-weight: 600;
        font-size: 1rem;
        color: #343a40;
        background: #f8f9fa;
        border-radius: 10px;
        border: 2px solid #dee2e6;
        padding: 10px 18px;
        min-width: 160px;
        text-align: center;
        transition: all 0.2s;
    }

    .jQBracket .team.win {
        background: #d1e7dd !important;
        color: #198754 !important;
        border-color: #198754 !important;
    }

    .jQBracket .team.lose {
        background: #f8d7da !important;
        color: #dc3545 !important;
        border-color: #dc3545 !important;
    }

    .jQBracket .connector {
        border-color: #0d6efd !important;
    }

    .jQBracket .label {
        font-size: 0.95rem;
        color: #6c757d;
    }

    .bracket-container::before {
        content: "🏆";
        position: absolute;
        top: 16px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 2.5rem;
        z-index: 10;
        opacity: 0.9;
        pointer-events: none;
    }
</style>

<script>
    $(function () {
        const equipos = @json($equipos);
        const resultados = @json($resultados);

        if (!equipos.length || !resultados.length) {
            $('#bracket').html('<p class="text-muted text-center">No hay datos disponibles para este torneo.</p>');
            return;
        }

        // Renderiza el bracket
        $('#bracket').bracket({
            init: {
                teams: equipos,
                results: resultados
            },
            dir: 'lr',
            skipConsolationRound: false,
            teamWidth: 160,
            scoreWidth: 30,
            matchMargin: 40,
            roundMargin: 80
        });

        // ResizeObserver para escalar dinámicamente en ancho
        const wrapper = document.getElementById('bracket-wrapper');
        const bracket = document.getElementById('bracket');

        const resize = () => {
            const parentWidth = wrapper.offsetWidth;
            const contentWidth = bracket.scrollWidth;

            let scale = 1;
            if (contentWidth > parentWidth) {
                scale = parentWidth / contentWidth;
            }

            wrapper.style.transform = `scale(${scale})`;
        };

        resize(); // inicial

        const observer = new ResizeObserver(() => resize());
        observer.observe(wrapper);
        window.addEventListener('resize', resize);
    });
</script>
@endpush
