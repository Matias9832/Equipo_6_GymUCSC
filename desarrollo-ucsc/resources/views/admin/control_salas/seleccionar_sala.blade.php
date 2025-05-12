@extends('layouts.admin')

@section('title', 'Seleccionar Sala')

@section('content')
    <div class="container">
        <h1 class="mb-1 text-center">Seleccionar Sala y Aforo</h1>
        <h2 class="mb-4 text-center text-secondary">{{ session('nombre_sucursal') }}</h2>

        <form action="{{ route('control-salas.generarQR') }}" method="POST" class="d-flex flex-wrap gap-2 align-items-end">
            @csrf

            {{-- Sala --}}
            <div class="flex-grow-1">
                <label for="id_sala" class="form-label">Sala:</label>
                <select name="id_sala" id="id_sala" class="form-select" required>
                    @foreach ($salas as $sala)
                        <option value="{{ $sala->id_sala }}">
                            {{ $sala->nombre_sala }} (Máx: {{ $sala->aforo_sala }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Aforo --}}
            <div>
                <label for="aforo" class="form-label">Aforo:</label>
                <input type="number" name="aforo" id="aforo" class="form-control" min="1" required>
            </div>

            {{-- Botón --}}
            <div>
                <button type="submit" class="btn btn-primary">Generar QR</button>
            </div>
        </form>

        @if ($salasActivas->count())
            <div class="mt-5">
                <h3 class="text-center mb-3">Salas Activas</h3>
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Nombre de la Sala</th>
                                <th>Aforo QR</th>
                                <th>Personas Activas</th>
                                <th style="width: 40%;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salasActivas as $sala)
                                        <tr>
                                            <td>{{ $sala->nombre_sala }}</td>
                                            <td>{{ $sala->aforo_qr }}</td>
                                            <td>
                                                {{
                                \App\Models\Ingreso::where('id_sala', $sala->id_sala)
                                    ->whereNull('hora_salida')
                                    ->count()
                                                                                                                                                                                                                                                                                }}
                                            </td>
                                            <td>
                                                <a href="{{ route('control-salas.verQR', ['id_sala' => $sala->id_sala, 'aforo_qr' => $sala->aforo_qr]) }}"
                                                    class="btn btn-primary btn-sm">
                                                    Ver QR
                                                </a>

                                                <!-- Botón Cambiar Aforo -->
                                                <button class="btn btn-sm btn-warning ms-2" data-bs-toggle="modal"
                                                    data-bs-target="#cambiarAforoModal{{ $sala->id_sala }}">
                                                    Cambiar Aforo
                                                </button>

                                                <a href="{{ route('admin.control_salas.ver_usuarios', $sala->id_sala) }}"
                                                    class="btn btn-info btn-sm ms-1">
                                                    Ver Ingresos
                                                </a>


                                                <form action="{{ route('admin.control_salas.cerrar_sala') }}" method="POST"
                                                    class="d-inline ms-1">
                                                    @csrf
                                                    <input type="hidden" name="id_sala" value="{{ $sala->id_sala }}">
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('¿Estás seguro de cerrar la sala {{ $sala->nombre_sala }}?')">
                                                        Cerrar Sala
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    {{-- Modal para cambiar el aforo --}}
    @foreach ($salasActivas as $sala)
        <div class="modal fade" id="cambiarAforoModal{{ $sala->id_sala }}" tabindex="-1"
            aria-labelledby="cambiarAforoModalLabel{{ $sala->id_sala }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cambiarAforoModalLabel{{ $sala->id_sala }}">Cambiar Aforo -
                            {{ $sala->nombre_sala }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('control_salas.cambiar_aforo') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_sala" value="{{ $sala->id_sala }}">
                            <div class="mb-3">
                                <label for="aforo" class="form-label">Nuevo Aforo (Máx: {{ $sala->aforo_sala }}):</label>
                                <input type="number" name="aforo_qr" id="aforo_qr" class="form-control" min="1"
                                    value="{{ $sala->aforo_qr }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Aforo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection