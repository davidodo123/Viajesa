<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Skyline Travel - Explora el Mundo')</title>
    
    <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('main.index') }}">
                <i class="fa-solid fa-plane-departure me-2 text-primary"></i>
                <span>@yield('navbar', 'Skyline Travel')</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('main.index') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('vacacion.index') }}">Destinos</a>
                    </li>

                    @auth
                        @if(Auth::user()->isAdvanced())
                            <li class="nav-item mx-lg-2">
                                <a class="btn btn-outline-primary btn-sm rounded-pill px-3" href="{{ route('vacacion.create') }}">
                                    <i class="fa-solid fa-plus me-1"></i> Publicar Viaje
                                </a>
                            </li>
                        @endif
                        
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDrop" role="button" data-bs-toggle="dropdown">
                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                Mi Cuenta
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                                <li><a class="dropdown-item" href="{{ route('home') }}"><i class="fa-solid fa-user me-2"></i>Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="post" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-primary rounded-pill px-4" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5 main-content">
        @if($errors->has('general'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-3 fs-4"></i>
                <div>{{ $errors->first('general') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('general'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-check me-3 fs-4"></i>
                <div>{{ session('general') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Skyline Travel</h5>
                    <p class="text-muted">Tu próxima aventura comienza aquí. Especialistas en deportes extremos y viajes de lujo.</p>
                </div>
                <div class="col-md-4 mb-4 text-center">
                    <h5>Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('vacacion.index') }}" class="text-muted text-decoration-none">Ver Destinos</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Sobre Nosotros</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4 text-end">
                    <h5>Síguenos</h5>
                    <div class="fs-4">
                        <a href="#" class="text-white me-3"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="text-white me-3"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#" class="text-white"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-4 border-secondary">
            <div class="text-center text-muted small">
                &copy; {{ date('Y') }} Skyline Travel. Todos los derechos reservados.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>