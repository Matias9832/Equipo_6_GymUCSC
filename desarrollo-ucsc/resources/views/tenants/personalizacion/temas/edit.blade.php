@extends('layouts.tenants.tenants', ['class' => 'g-sidenav-show bg-gray-100'])

@section('title', 'Editar Tema')

@section('content')
    @include('layouts.tenants.navbars.ttopnav', ['title' => 'Editar Tema'])

    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Editar Tema</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('personalizacion.temas.update', $tema) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="nombre_tema" class="form-label">Nombre del tema</label>
                                <input type="text" name="nombre_tema" id="nombre_tema" class="form-control" value="{{ old('nombre_tema', $tema->nombre_tema) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="fuente" class="form-label">Fuente</label>
                                <select name="id_fuente" id="fuente" class="form-select" required>
                                    <option value="" disabled>Seleccione una fuente</option>
                                    <option value="Sin Fuente" {{ $tema->id_fuente === 'Sin Fuente' ? 'selected' : '' }}>Sin Fuente</option>
                                    @foreach ($fuentes as $fuente)
                                        <option value="{{ $fuente->id }}" {{ $tema->id_fuente == $fuente->id ? 'selected' : '' }}>
                                            {{ $fuente->nombre_fuente }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <hr>
                            <h6>Colores principales</h6>
                            @foreach ([
                                'bs_primary' => 'Primario',
                                'bs_success' => 'Éxito',
                                'bs_danger' => 'Peligro'
                            ] as $campoBase => $label)
                                @php
                                    $focus = str_replace('bs_', '', $campoBase) . '_focus';
                                    $border = 'border_' . str_replace('bs_', '', $campoBase) . '_focus';
                                    $gradient = str_replace('bs_', '', $campoBase) . '_gradient';
                                @endphp

                                <div class="card mb-4 border">
                                    <div class="card-header bg-light">
                                        <strong>Color {{ $label }}</strong>
                                    </div>
                                    <div class="card-body">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Colores Guardados</label>
                                                <select class="form-select color-selector" data-target="{{ $campoBase }}_hex">
                                                    <option value="">Seleccionar</option>
                                                    @foreach ($colores as $color)
                                                        <option value="{{ $color->codigo_hex }}">
                                                            {{ $color->nombre_color }} ({{ $color->codigo_hex }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">{{ $label }} (HEX)</label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                       name="{{ $campoBase }}" id="{{ $campoBase }}_hex"
                                                       value="{{ old($campoBase, $tema->$campoBase) }}" style="height: 45px;">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="{{ $focus }}" class="form-label">Focus</label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                       name="{{ $focus }}" id="{{ $focus }}"
                                                       value="{{ old($focus, $tema->$focus) }}" style="height: 45px;">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="{{ $border }}" class="form-label">Border</label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                       name="{{ $border }}" id="{{ $border }}"
                                                       value="{{ old($border, $tema->$border) }}" style="height: 45px;">
                                            </div>

                                            <div class="col-md-2">
                                                <label for="{{ $gradient }}" class="form-label">Gradient</label>
                                                <input type="color" class="form-control form-control-color w-100"
                                                       name="{{ $gradient }}" id="{{ $gradient }}"
                                                       value="{{ old($gradient, $tema->$gradient) }}" style="height: 45px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr>
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary">Actualizar Tema</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    const grupos = [
        { base: 'bs_primary', focus: 'primary_focus', border: 'border_primary_focus', gradient: 'primary_gradient' },
        { base: 'bs_success', focus: 'success_focus', border: 'border_success_focus', gradient: 'success_gradient' },
        { base: 'bs_danger', focus: 'danger_focus', border: 'border_danger_focus', gradient: 'danger_gradient' },
    ];

    function shadeColor(hex, percent) {
        let r = parseInt(hex.substring(1, 3), 16);
        let g = parseInt(hex.substring(3, 5), 16);
        let b = parseInt(hex.substring(5, 7), 16);

        r = Math.min(255, Math.max(0, r + (r * percent / 100)));
        g = Math.min(255, Math.max(0, g + (g * percent / 100)));
        b = Math.min(255, Math.max(0, b + (b * percent / 100)));

        return "#" + [r, g, b].map(x => Math.round(x).toString(16).padStart(2, '0')).join('');
    }

    grupos.forEach(grupo => {
        const baseInput = document.getElementById(`${grupo.base}_hex`);
        const selector = document.querySelector(`select[data-target="${grupo.base}_hex"]`);

        const focusInput = document.getElementById(grupo.focus);
        const borderInput = document.getElementById(grupo.border);
        const gradientInput = document.getElementById(grupo.gradient);

        function actualizarSubcolores(color) {
            focusInput.value = shadeColor(color, -10);
            borderInput.value = shadeColor(color, -20);
            gradientInput.value = shadeColor(color, 20);
        }

        // Input manual
        baseInput.addEventListener('input', function () {
            actualizarSubcolores(this.value);
        });

        // Selector de colores guardados
        selector.addEventListener('change', function () {
            baseInput.value = this.value;
            actualizarSubcolores(this.value);
        });
    });
</script>
@endsection
