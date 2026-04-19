<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin TopSneakers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/layouts.css">
    <link rel="stylesheet" href="{{ asset('css/admin/layout.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
    <meta name="theme-color" content="#000000">
</head>

<body>
    <!-- Barra de navegación principal (IGUAL A USUARIOS NORMALES) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo y Nombre -->
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('catalogo') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo TopSneakers" class="rounded"
                    style="height: 40px; width: 40px; object-fit: contain;">
                <span>TopSneakers</span>
            </a>

            <!-- Sección de usuario para móvil -->
            <div class="user-section-mobile mobile-user">
                @auth
                    <div class="btn-group">
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-light" title="Mi Perfil">
                            <i class="fas fa-user-circle"></i>
                            <span>Perfil</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-light" title="Cerrar Sesión">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Salir</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="btn-group">
                        <a href="{{ route('login') }}" class="btn btn-outline-light" title="Iniciar Sesión">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login</span>
                        </a>
                        <a href="{{ route('register.form') }}" class="btn btn-primary" title="Registrarse">
                            <i class="fas fa-user-plus"></i>
                            <span>Registro</span>
                        </a>
                    </div>
                @endauth
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación (solo usuario para desktop) -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- Menú vacío en admin -->
                </ul>

                <!-- Sección de usuario para desktop -->
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

    <!-- CONTENIDO ADMIN CON SIDEBAR -->
    <div class="d-flex" style="gap: 0;">
        <!-- Toggle Sidebar Button (Mobile) -->
        <button class="btn btn-dark d-lg-none" id="sidebarToggle" style="position: fixed; bottom: 20px; right: 20px; z-index: 1050; border-radius: 50%; width: 50px; height: 50px; padding: 0; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar -->
        <nav class="bg-light p-3" id="sidebar" style="width: 250px; min-height: calc(100vh - 56px); border-right: 1px solid #dee2e6; position: sticky; top: 56px;">
            <h6 class="text-uppercase text-muted mb-3">Administración</h6>
            <ul class="nav flex-column mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}" 
                       href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line me-2"></i>Dashboard
                    </a>
                </li>
            </ul>

            <h6 class="text-uppercase text-muted mb-3">Gestión</h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.sneakers') !== false ? 'active' : '' }}" 
                       href="{{ route('admin.sneakers.index') }}">
                        <i class="fas fa-shoe-prints me-2"></i>Zapatillas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ strpos(Route::currentRouteName(), 'admin.brands') !== false ? 'active' : '' }}" 
                       href="{{ route('admin.brands.index') }}">
                        <i class="fas fa-tag me-2"></i>Marcas
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main content -->
        <main class="flex-grow-1 p-4" style="width: 100%; overflow-x: hidden;">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>¡Error!</strong> Por favor revisa los siguientes errores:
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('admin-content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite('resources/js/admin/layout.js')
</body>

</html>
