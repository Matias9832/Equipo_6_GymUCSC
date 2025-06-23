@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Llaves de Copa')

@section('content')
  @include('layouts.navbars.auth.topnav', ['title' => 'Llaves de Copa'])

  <div class="container-fluid py-4">
    <div class="row">
    <div class="col-12">
      <div class="card mb-4">
      <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6 class="text-dark mb-0">Llaves del Torneo</h6>
        <a href="{{ route('torneos.index') }}" class="btn btn-secondary btn-sm" style="margin-bottom: 0rem !important;">Volver</a>
      </div>

      <div class="card-body px-0 pt-0 pb-2">
        <div class="p-4" id="bracket-container">
        <div id="bracket"></div>
        </div>
      </div>
      </div>
    </div>
    </div>
  </div>

@endsection

@push('js')
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/jquery-bracket@0.11.1/dist/jquery.bracket.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/jquery-bracket@0.11.1/dist/jquery.bracket.min.js"></script>

  <style>
    #bracket-container {
    max-width: 800px;
    width: 100%;
    }

    #bracket {
    margin: 0 auto;
    }

    .jQBracket .team.win {
    background: #d4edda !important;
    border-color: #28a745 !important;
    }

    .jQBracket .team.lose {
    background: #f8d7da !important;
    border-color: #dc3545 !important;
    }

    .jQBracket .team.undefined {
    background: #e2e3e5 !important;
    border-color: #6c757d !important;
    }
  </style>

  <script>
    $(function () {
    const teams = @json($teams);
    const results = @json($results);
    const mostrarTercerLugar = {{ $torneo->tercer_lugar ? 'true' : 'false' }};

    $('#bracket').bracket({
      init: { teams, results },
      skipConsolationRound: !mostrarTercerLugar, // Oculta el partido por el 3er lugar si corresponde
      teamWidth: 120,
      scoreWidth: 30,
      matchMargin: 20,
      roundMargin: 50,
      decorate: function (container, data, score, state) {
      const t = container.find('.team');
      if (state === 'win') t.addClass('win');
      else if (state === 'lose') t.addClass('lose');
      else t.addClass('undefined');
      }
    });

    // Si el bracket ya fue generado y el partido de tercer lugar existe pero no debe mostrarse, lo ocultamos por CSS/JS
    if (!mostrarTercerLugar) {
      // El partido de tercer lugar suele ser el último .round > .match
      $('.jQBracket .final .match').last().hide();
      // O bien, si hay una clase específica para el partido de tercer lugar, puedes ocultarla así:
      // $('.jQBracket .consolation .match').hide();
    }
    });
  </script>
@endpush