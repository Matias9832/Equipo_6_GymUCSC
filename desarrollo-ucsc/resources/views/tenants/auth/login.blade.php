@extends('layouts.tenants.tenants', ['class' => 'bg-gradient-primary'])

@section('title', 'Iniciar Sesión')

@section('content')
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="card shadow-sm p-4" style="max-width: 400px; width: 100%;">

            <a class="navbar-brand d-flex align-items-center justify-content-center" href="{{ route('inicio') }}">
                <img src="{{ url('img/tenants/logo_ugym-sinfondo.png') }}" height="40" alt="Logo">
            </a>

            {{-- Mensajes de error generales --}}
            @if($errors->any())
                <div class="alert alert-danger mt-3">
                    @foreach($errors->all() as $error)
                        <div class="small">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('tenant-login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="gmail" class="form-control" required autofocus value="{{ old('gmail') }}">
                    @error('gmail')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">Entrar</button>

                @if ($errors->any())
                    <div class="alert alert-danger mt-3">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li class="small">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection