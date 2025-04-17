<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Noticias | UCSC Gym</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/bg.jpg'); /* Fondo borroso como en tu imagen */
            background-size: cover;
            background-position: center;
            backdrop-filter: blur(5px);
        }
        .card-custom {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            
            <img src="/images/gym_logo.png" alt="Logo GYM" style="height: 30px; margin-right: 10px;">
            <img src="/images/ucsc_logo.png" alt="Logo UCSC" style="height: 40px; margin-right: 10px;">
            <a class="navbar-brand fw-bold" href="#"></a>
            <div class="ms-auto">
                <a href="#" class="btn btn-secondary me-3">Ingresar</a>
               
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">

            <!-- Noticias -->
            <div class="col-md-8">
                <h2 class="mb-4">Noticias</h2>

                <a href="{{ route('noticias.create') }}" class="btn btn-success mb-4">+ Agregar Noticia</a>
                <br>

                @foreach($noticias as $noticia)
                    <div class="card mb-4">
                        <a href="{{ route('noticias.show', $noticia) }}" class="text-decoration-none text-dark">
                            <div class="card mb-3 shadow-sm hover-shadow">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $noticia->titulo }}</h5>
                                    <p class="card-text">{{ Str::limit($noticia->contenido, 100) }}</p>
                                    @if($noticia->imagen)
                                    <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="Imagen" class="img-fluid mt-2">
                                @endif
    
                                <small class="text-muted">Publicado el {{ $noticia->created_at->format('d M Y') }}</small>
                            </div>
                                
                            </div>
                        </a>
                    </div>
                @endforeach

                <div class="row align-items-center mt-4">
                    <div class="d-flex justify-content-center">
                        {{ $noticias->links() }}
                    </div>
                </div>
                
    
            </div>

            <!-- Actividades / Sidebar -->
            <div class="col-md-4">
                <div class="card card-custom p-3">
                    <h5 class="mb-3">Actividades de esta semana</h5>

                    

                    <a href="#" class="mt-2 d-block text-end text-primary">Próximos eventos →</a>
                </div>
            </div>

        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light mt-4">
        <small>Copyright
