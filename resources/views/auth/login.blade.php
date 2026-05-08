@extends('layouts.app')

@section('content')
    <!-- Formulario de inicio de sesión -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ __('Iniciar Sesión') }}</h4>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>{{ __('¡Error!') }}</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login.submit') }}" method="POST" novalidate>
                        @csrf
                        <input type="hidden" name="redirect_to" value="{{ old('redirect_to', request()->query('redirect_to')) }}">

                        <!-- Email o Usuario -->
                        <div class="mb-3">
                            <label for="email" class="form-label">{{ __('Nombre de Usuario o Correo Electrónico') }}</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required
                                placeholder="{{ __('Ej: tu_usuario o tu@email.com') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Recordarme -->
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Recuérdame en este dispositivo') }}
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">{{ __('Iniciar Sesión') }}</button>
                    </form>

                    <hr class="my-4">

                    <!-- Enlace para registrarse -->
                    <p class="text-center mb-0">
                        {{ __('¿No tienes una cuenta?') }}
                        <a href="{{ route('register.form', ['redirect_to' => request()->query('redirect_to')]) }}">{{ __('Regístrate aquí') }}</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection