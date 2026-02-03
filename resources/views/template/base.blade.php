<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Viajesa')</title>
    <link rel="icon" type="image/x-icon" href="{{ url('favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ url('assets/css/main-agency.css?r=' . rand(1, 10000)) }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  </head>

  <body>
    <nav class="navbar navbar-expand-lg sticky-top navbar-agency">
    <div class="container">
        <a class="navbar-brand" href="{{ route('main.index') }}">
            <i class="fa-solid fa-earth-americas me-2"></i>
            @yield('navbar', 'Viajesa')
        </a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        
        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('main.index') }}">Inicio</a>
                </li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropVacations" role="button" data-bs-toggle="dropdown">
                        Destinos
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow">
                        <li>
                            <a class="dropdown-item" href="{{ route('vacacion.index') }}">
                                <i class="fa-solid fa- map-location-dot me-2 text-primary"></i>Ver Catálogo
                            </a>
                        </li>
                        @auth
                            @if(Auth::user()->isAdvanced())
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('vacacion.create') }}">
                                        <i class="fa-solid fa-plus me-2 text-success"></i>Publicar Oferta
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </li>

                <div class="vr mx-3 d-none d-lg-block text-secondary opacity-25"></div>

                @auth
                    @if(Auth::user()->isAdvanced())
                        <li class="nav-item me-lg-2">
                            <a class="btn btn-publish-nav" href="{{ route('vacacion.create') }}">
                                <i class="fa-solid fa-circle-plus me-1"></i> Nuevo Viaje
                            </a>
                        </li>
                    @endif
                    
                    <li class="nav-item me-lg-2">
                        <a class="btn btn-info-nav" href="{{ route('home') }}">
                            <i class="fa-solid fa-user-gear"></i> Mi Panel
                        </a>
                    </li>

                    <li class="nav-item">
                        <form method="post" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-logout-nav" title="Cerrar sesión">
                                <i class="fa-solid fa-power-off"></i>
                            </button>
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-login-nav" href="{{ route('login') }}">
                            Acceso Clientes
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
    <main class="container my-5">

        @if($errors->has('general'))
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-exclamation me-3 fs-4"></i>
                <div>{{ $errors->first('general') }}</div>
            </div>
        @endif

        @if(session('general'))
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="fa-solid fa-circle-check me-3 fs-4"></i>
                <div>{{ session('general') }}</div>
            </div>
        @endif

        @yield('content')

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>

</html>