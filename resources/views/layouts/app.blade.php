<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopSneakers: Sneakers populares</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
    <meta name="theme-color" content="#000000">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="{{ route('home') }}">
                <img src="{{ asset('logo.png') }}" alt="Logo TopSneakers" class="rounded" style="height: 40px; width: 40px; object-fit: contain;">
                TopSneakers
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    @auth
                        <li class="nav-item me-3">
                            <span class="text-light">
                                ¡Hola, <strong>{{ Auth::user()->name }}</strong>!
                            </span>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="btn btn-outline-light btn-sm">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.form') }}">
                                Registrarse
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>