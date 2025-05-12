<footer class="text-center text-muted py-2 border-top bg-white small">
    @php
        use App\Models\Marca;
        $marca = Marca::where('nombre_marca', 'GymUCSC')->first();
    @endphp

    @if($marca)
        <div class="d-inline-block">
            <div class="d-flex justify-content-center gap-4 flex-wrap text-start">
                <div style="max-width: 80%;">
                    <div class="fw-bold mb-0">Misión:</div>
                    <div>{{ $marca->mision_marca }}</div>
                </div>
                <div style="max-width: 80%;">
                    <div class="fw-bold mb-0">Visión:</div>
                    <div>{{ $marca->vision_marca }}</div>
                </div>
            </div>
        </div>
    @endif
</footer>
