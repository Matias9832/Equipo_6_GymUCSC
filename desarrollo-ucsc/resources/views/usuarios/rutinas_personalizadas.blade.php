@extends('layouts.guest')

@section('content')
    @include('layouts.navbars.guest.navbar')
    <main class="main-content mt-0">
        <div class="container py-4">
            <h2 class="mb-4">Mis Rutinas Personalizadas</h2>
            <div class="card shadow rounded-4 p-4">
                @if($rutinas->isEmpty())
                    <div class="alert alert-info">No tienes rutinas asignadas.</div>
                @else
                    @foreach($rutinas as $rutina)
                        <div class="mb-4">
                            <h5>Rutina #{{ $rutina->id }}</h5>
                            <ul>
                                @foreach($rutina->ejercicios as $ejercicio)
                                    <li>
                                        <strong>{{ $ejercicio->nombre }}</strong>
                                        - Series: {{ $ejercicio->pivot->series }}
                                        - Repeticiones: {{ $ejercicio->pivot->repeticiones }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </main>
    @include('layouts.footers.guest.footer')
@endsection