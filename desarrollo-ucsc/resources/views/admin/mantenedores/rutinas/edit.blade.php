@extends('layouts.app')

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Editar Rutina'])
    <div class="container-fluid py-4">
        <div class="card shadow rounded-4 p-4">
            <form action="{{ route('rutinas.update', $rutina->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="user_id" class="form-label">Usuario</label>
                    <select name="user_id" id="user_id" class="form-control" required>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id_usuario }}" {{ $rutina->user_id == $usuario->id_usuario ? 'selected' : '' }}>
                                {{ $usuario->correo_usuario }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="ejercicios" class="form-label">Ejercicios</label>
                    <div id="ejercicios">
                        @foreach($ejercicios as $ejercicio)
                            <div class="form-check">
                                <input type="checkbox" name="ejercicios[{{ $ejercicio->id }}][id]" value="{{ $ejercicio->id }}" class="form-check-input" id="ejercicio-{{ $ejercicio->id }}"
                                    {{ $rutina->ejercicios->contains($ejercicio->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ejercicio-{{ $ejercicio->id }}">{{ $ejercicio->nombre }}</label>
                                <div class="row mt-2">
                                    <div class="col">
                                        <input type="number" name="ejercicios[{{ $ejercicio->id }}][series]" class="form-control" placeholder="Series" min="1"
                                            value="{{ $rutina->ejercicios->find($ejercicio->id)?->pivot->series }}">
                                    </div>
                                    <div class="col">
                                        <input type="number" name="ejercicios[{{ $ejercicio->id }}][repeticiones]" class="form-control" placeholder="Repeticiones" min="1"
                                            value="{{ $rutina->ejercicios->find($ejercicio->id)?->pivot->repeticiones }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <a href="{{ route('rutinas.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
@endsection