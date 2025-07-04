<footer class="footer pt-3  ">
    @php
        use App\Models\Marca;
        $ultimaMarca = Marca::orderBy('id_marca', 'desc')->first();
    @endphp

    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    ©
                    <script>
                        document.write(new Date().getFullYear())
                    </script>,
                    Hecho por U gym.
                </div>
            </div>
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                    <li class="nav-item">
                        <a href="{{ route('welcome') }}" class="nav-link text-primary" target="_blank" disabled>Deportes
                            {{ $ultimaMarca->nombre_marca ?? 'Marca por defecto' }}</a>
                        <!-- <a href="https://www.creative-tim.com" class="nav-link text-primary" target="_blank">Deportes UCSC</a> -->
                    </li>
                    <!-- <li class="nav-item">
                        <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">Sobre nosotros</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Contáctanos</a>
                    </li>
                    <li class="nav-item">
                        <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted"
                            target="_blank">Licencia</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </div>
</footer>