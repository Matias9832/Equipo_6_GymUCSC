@extends('layouts.app')

@section('title', 'Llaves de Copa')

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Llaves de Copa'])
<div class="container py-4">
    <h4>Llaves de Copa - {{ $torneo->nombre_torneo }}</h4>
    <div id="bracket" class="my-4"></div>
    <a href="{{ route('torneos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection

@push('js')
<!-- jQuery y jquery-bracket desde CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/jquery-bracket@0.11.1/dist/jquery.bracket.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery-bracket@0.11.1/dist/jquery.bracket.min.js"></script>
<script>
    $(function() {
        var equipos = @json($equipos);
        var resultados = [@json($resultados)];
        $('#bracket').bracket({
            init: { teams: equipos, results: resultados }
        });
    });
</script>
@endpush