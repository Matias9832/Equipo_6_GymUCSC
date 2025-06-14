@extends('layouts.tenants.tenants', ['class' => 'landing-page'])

@section('title', 'Inicio')

@section('content')
    <style>
        .navbar-nav .nav-link {
            color: #344767 !important;
            font-weight: 600;
            font-size: 1rem;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #5e72e4 !important;
        }

        .hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2rem;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero p {
            font-size: 1.25rem;
            max-width: 600px;
            margin: auto;
        }

        .section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 4rem 0;
        }

        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 2rem;
            color: #344767;
        }

        .benefit-card {
            background-color: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .benefit-card:hover {
            transform: translateY(-5px);
        }

        .gym-list {
            list-style: none;
            padding-left: 0;
        }

        .gym-list li {
            padding: 0.5rem 0;
        }
    </style>

    <div class="container position-sticky z-index-sticky top-0 pt-2 pb-2">
        <nav class="navbar navbar-expand-lg blur border-radius-lg top-0 z-index-3 shadow py-2">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center justify-content-center" href="#">
                    <img src="{{ url('img\tenants\logo_ugym-sinfondo.png') }}" height="40" alt="Logo"
                        style="margin-right: 0rem !important;">
                </a>

                <div class="collapse navbar-collapse justify-content-center">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="#nosotros">Nosotros</a></li>
                        <li class="nav-item"><a class="nav-link" href="#beneficios">Beneficios</a></li>
                        <li class="nav-item"><a class="nav-link" href="#gimnasios">Gimnasios</a></li>
                    </ul>
                </div>

                <div class="d-none d-sm-flex align-items-center">
                    @if(session()->has('tenant_id'))
                        <a href="{{ route('tenants.index') }}" class="btn btn-sm btn-outline-primary"
                            style="margin-bottom: 0rem !important;">
                            <i class="fas fa-tachometer-alt me-1"></i> Panel de control
                        </a>
                    @else
                        <a href="{{ route('tenant-login') }}" class="btn btn-sm btn-outline-primary"
                            style="margin-bottom: 0rem !important;">
                            <i class="fas fa-user me-1"></i> Iniciar sesión
                        </a>
                    @endif
                </div>
                <div class="d-flex d-sm-none align-items-center">
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTenant" aria-controls="navbarTenant" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>
                </div>
                <div class="collapse d-lg-none d-sm-none w-100" id="navbarTenant">
                    <ul class="navbar-nav align-items-center">
                        @if(session()->has('tenant_id'))
                            <li class="nav-item me-2 mb-1" style="width: 176px;">
                                <a href="{{ route('tenants.index') }}"
                                    class="btn btn-sm btn-primary mb-0 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-tachometer-alt me-1 text-white"></i>
                                    Panel de control
                                </a>
                            </li>
                        @else
                            <li class="nav-item me-2 mb-1" style="width: 176px;">
                                <a href="{{ route('tenant-login') }}"
                                    class="btn btn-sm btn-outline-primary mb-0 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user me-1"></i> Iniciar Sesión
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>


    <div class="hero bg-gradient-primary text-white">
        <div>
            <h1 style="color: white !important;">Bienvenido a UGYM</h1>
            <p>Gestiona todo tu gimnasio desde una sola plataforma, diseñada para empresas modernas y activas.</p>
        </div>
    </div>

    <section id="nosotros" class="section bg-gray-100">
        <div class="container">
            <h2 class="section-title text-center">Nosotros</h2>
            <p class="text-center mx-auto" style="max-width: 700px;">
                En UGYM creemos que la tecnología debe potenciar el deporte. Por eso desarrollamos una plataforma
                centralizada y adaptable para gestionar múltiples centros deportivos bajo distintas sucursales, con acceso
                personalizado.
            </p>
            <p class="text-center">
                <strong>Correo:</strong>
                <a href="mailto:contacto@ugym.cl" class="text-primary">contacto@ugym.cl</a>
            </p>
        </div>
    </section>

    <section id="beneficios" class="section">
        <div class="container">
            <h2 class="section-title text-center">Beneficios</h2>
            <div class="row d-flex justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="benefit-card text-center">
                        <i class="fas fa-building fa-2x text-primary mb-3"></i>
                        <h5 class="fw-bold">Múltiples Sucursales</h5>
                        <p>Administra fácilmente todas las sucursales de tu empresa deportiva desde una única plataforma
                            centralizada.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="benefit-card text-center">
                        <i class="fas fa-chart-line fa-2x text-success mb-3"></i>
                        <h5 class="fw-bold">Reportes Avanzados</h5>
                        <p>Obtén información detallada del uso, ingresos y rendimiento por gimnasio o sala, en tiempo real.
                        </p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="benefit-card text-center">
                        <i class="fas fa-users-cog fa-2x text-warning mb-3"></i>
                        <h5 class="fw-bold">Gestión de Usuarios</h5>
                        <p>Control total sobre administradores, entrenadores y usuarios. Todo con roles bien definidos.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="benefit-card text-center">
                        <i class="fas fa-dumbbell fa-2x text-danger mb-3"></i>
                        <h5 class="fw-bold">Gestión de Talleres</h5>
                        <p>Crea, organiza y controla talleres con cupos, horarios, indicaciones y asistentes de forma
                            sencilla.</p>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="benefit-card text-center">
                        <i class="fas fa-trophy fa-2x text-info mb-3"></i>
                        <h5 class="fw-bold">Gestión de Torneos</h5>
                        <p>Organiza torneos deportivos, registra participantes, gestiona calendarios y genera resultados
                            fácilmente.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="gimnasios" class="section bg-gray-100 py-5">
        <div class="container">
            <h2 class="section-title text-center">Gimnasios</h2>
            <p class="text-center mx-auto mb-4" style="max-width: 700px;">
                Estas son algunas de las marcas y centros deportivos que ya confían en nosotros.
            </p>

            <div class="row justify-content-center">
                @foreach ($empresas as $empresa)
                    <div class="col-6 col-md-3 mb-4">
                        <div class="card border-0 shadow-sm h-100 text-center p-3">
                            <a href="http://{{ $empresa->subdominio }}:8000" target="_blank" class="text-decoration-none">
                                <img src="{{ url($empresa->logo) }}" alt="{{ $empresa->nombre }}" class="img-fluid mb-2"
                                    style="max-height: 60px;">
                                <h6 class="fw-bold text-dark mt-2">{{ $empresa->nombre }}</h6>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection

<script>
    document.querySelectorAll('a.nav-link').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>