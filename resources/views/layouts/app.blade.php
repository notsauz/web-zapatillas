<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TopSneakers: Sneakers populares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @vite('resources/css/layouts.css')
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
    <meta name="theme-color" content="#000000">
    @yield('styles')
</head>

<body>
    <!-- Barra de navegación principal -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo y Nombre - siempre visible completo -->
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('catalogo') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo TopSneakers" class="rounded"
                    style="height: 40px; width: 40px; object-fit: contain;">
                <span>TopSneakers</span>
            </a>

            <!-- Sección de usuario para móvil (siempre visible a la derecha) - Botones más grandes -->
            <div class="user-section-mobile mobile-user">
                @auth
                    <div class="btn-group">
                        <a href="{{ route('profile.favorites') }}" class="btn btn-outline-light" title="Mis Favoritos">
                            <i class="fas fa-heart"></i>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light" title="Mi Perfil">
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-light" title="Cerrar Sesión">
                                <i class="fas fa-sign-out-alt"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="btn-group">
                        <a href="{{ route('login') }}" class="btn btn-outline-light" title="Iniciar Sesión">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register.form') }}" class="btn btn-primary btn-sm" title="Registrarse">
                            <i class="fas fa-user-plus"></i>
                            <span>Registro</span>
                        </a>
                    </div>
                @endauth
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route()->getName() === 'catalogo' ? 'active' : '' }}"
                            href="{{ route('catalogo') }}">
                            <i class="fas fa-home me-1"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->route()->getName() === 'marcas.index' ? 'active' : '' }}"
                            href="{{ route('marcas.index') }}">
                            <i class="fas fa-tag me-1"></i> Marcas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->input('category') === 'hombre' ? 'active' : '' }}"
                            href="{{ route('categoria', 'hombre') }}">
                            <i class="fas fa-male me-1"></i> Hombres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->input('category') === 'mujer' ? 'active' : '' }}"
                            href="{{ route('categoria', 'mujer') }}">
                            <i class="fas fa-female me-1"></i> Mujeres
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->input('category') === 'niño' ? 'active' : '' }}"
                            href="{{ route('categoria', 'niño') }}">
                            <i class="fas fa-child me-1"></i> Niños
                        </a>
                    </li>
                </ul>

                <!-- Sección de usuario para desktop (dentro del menú colapsable) -->
                <div class="desktop-user">
                    @auth
                        <span class="text-light me-3">
                            <i class="far fa-user-circle me-1"></i>{{ Auth::user()->name }}
                        </span>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-lock me-1"></i> Admin
                            </a>
                        @endif
                        <a href="{{ route('profile.favorites') }}" class="btn btn-outline-light btn-sm me-2">
                            <i class="fas fa-heart me-1"></i> Favoritos
                        </a>
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light btn-sm me-2">
                            <i class="fas fa-cog me-1"></i> Mi Perfil
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm me-2">
                            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                        </a>
                        <a href="{{ route('register.form') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-plus me-1"></i> Registrarse
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Barra de búsqueda con fondo igual al nav -->
    <div class="search-section-hidden">
        <div class="search-container-fluid">
            <div class="search-form-hidden">
                <div class="search-group-hidden">
                    <input type="search" id="searchInput" class="search-input-hidden" name="q"
                        placeholder="Buscar por marca, color, etc." value="" aria-label="Buscar" autocomplete="off">
                    <i class="fas fa-search search-icon-hidden"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>

</html>