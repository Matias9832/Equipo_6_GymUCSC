@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Panel de Control'])
    @php
        use App\Models\Marca;
        $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
    @endphp
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-5 text-center">
                        <img src="{{ url($ultimaMarca->logo_marca) }}" alt="Logo Marca" style="height: 70px;" class="mb-4">
                        <h1 class="mb-3">¡Bienvenido al Sistema de Gestión Deportiva {{ $ultimaMarca->nombre_marca ?? 'Marca por defecto' }}!</h1>
                        <p class="mb-4 text-muted">
                            Accede a talleres, torneos y al gimnasio desde un solo lugar.<br>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footers.guest.footer')
@endsection