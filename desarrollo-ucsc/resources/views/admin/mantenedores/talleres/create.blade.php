@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Crear Taller'])
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card">
                    <div class="card-header pb-0">
                        <h6>Crear Taller</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('talleres.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nombre_taller" class="form-label">Nombre Taller</label>
                                <input type="text" name="nombre_taller" id="nombre_taller" class="form-control"
                                    value="{{ old('nombre_taller') }}" required maxlength="100">
                                @error('nombre_taller') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion_taller" class="form-label">Descripción</label>
                                <textarea name="descripcion_taller" id="descripcion_taller" class="form-control" rows="3"
                                    required>{{ old('descripcion_taller') }}</textarea>
                                @error('descripcion_taller') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="cupos_taller" class="form-label">Cupos</label>
                                <input type="number" name="cupos_taller" id="cupos_taller" class="form-control"
                                    value="{{ old('cupos_taller') }}" required min="1">
                                @error('cupos_taller') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duracion_taller" class="form-label">Duración</label>
                                <input type="text" name="duracion_taller" id="duracion_taller" class="form-control"
                                    value="{{ old('duracion_taller') }}" required maxlength="50">
                                @error('duracion_taller') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3">
                                <label for="id_admin" class="form-label">Profesor asignado</label>
                                <select name="id_admin" id="id_admin" class="form-select">
                                    <option value="">-- Sin asignar --</option>
                                    @foreach($admins as $admin)
                                        <option value="{{ $admin->id_admin }}" {{ old('id_admin') == $admin->id_admin ? 'selected' : '' }}>
                                            {{ $admin->nombre_admin }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_admin') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="mb-3 form-check">
                                <input type="hidden" name="activo_taller" value="0">
                                <input type="checkbox" name="activo_taller" id="activo_taller" class="form-check-input"
                                    value="1" {{ old('activo_taller', true) ? 'checked' : '' }}>
                                <label for="activo_taller" class="form-check-label">Activo</label>
                            </div>

                            <hr>
                            <h6>Horarios</h6>

                            {{-- Fijo 3 horarios para que el usuario complete --}}
                            @php
                                $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            @endphp

                            @for($i = 0; $i < 3; $i++)
                                <div class="row mb-2">
                                    <div class="col-md-5">
                                        <select name="horarios[{{ $i }}][dia]" class="form-select">
                                            <option value="">-- Seleccionar Día --</option>
                                            @foreach($diasSemana as $dia)
                                                <option value="{{ $dia }}" {{ old("horarios.$i.dia") == $dia ? 'selected' : '' }}>
                                                    {{ $dia }}</option>
                                            @endforeach
                                        </select>
                                        @error("horarios.$i.dia") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-5">
                                        <input type="time" name="horarios[{{ $i }}][hora]" class="form-control"
                                            value="{{ old("horarios.$i.hora") }}">
                                        @error("horarios.$i.hora") <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>
                            @endfor

                            <small class="text-muted">Puedes dejar horarios vacíos si no quieres agregar más.</small>

                            <button type="submit" class="btn btn-primary mt-3">Crear</button>
                            <a href="{{ route('talleres.index') }}" class="btn btn-link mt-3">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth.footer')
    </div>
@endsection