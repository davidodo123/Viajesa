<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas Vacacionales - Viajes</title>
    <link rel="stylesheet" href="{{ asset('css/viajes.css') }}">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="{{ route('vacaciones.index') }}" class="navbar-brand">
                <span class="icon-plane"></span>
                ViajesApp
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('vacaciones.index') }}" class="nav-link active">Ofertas</a></li>
                @auth
                    <li><a href="{{ route('reservas.mis-reservas') }}" class="nav-link icon-ticket">Mis Reservas</a></li>
                    @if(Auth::user()->isAdmin())
                        <li><a href="{{ route('vacaciones.create') }}" class="nav-link">+ Nueva Vacación</a></li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-secondary">Cerrar Sesión</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}" class="btn btn-outline">Iniciar Sesión</a></li>
                    <li><a href="{{ route('register') }}" class="btn btn-primary">Registrarse</a></li>
                @endauth
            </ul>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-content">
            <h1>🌍 Descubre tu Próxima Aventura</h1>
            <p>Las mejores ofertas de viajes al mejor precio. ¡Reserva ahora!</p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container" style="max-width: 1200px; margin: 0 auto; padding: 3rem 1.5rem;">
        
        <!-- Mensajes Flash -->
        @if (session('success'))
            <div class="alert alert-success">
                <span class="icon-check"></span>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                ⚠️ {{ session('warning') }}
            </div>
        @endif

        <!-- Panel de Filtros -->
        <div class="filters-panel fade-in">
            <h3>🔍 Buscar tu Viaje Ideal</h3>
            
            <form method="GET" action="{{ route('vacaciones.index') }}">
                <div class="filter-grid">
                    <!-- Filtro 1: Búsqueda -->
                    <div class="filter-item">
                        <label for="buscar">Buscar destino</label>
                        <input type="text" 
                               name="buscar" 
                               id="buscar" 
                               value="{{ request('buscar') }}"
                               placeholder="Ej: Cancún, París...">
                    </div>

                    <!-- Filtro 2: Tipo -->
                    <div class="filter-item">
                        <label for="tipo">Tipo de viaje</label>
                        <select name="tipo" id="tipo">
                            <option value="">Todos los tipos</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}" {{ request('tipo') == $tipo->id ? 'selected' : '' }}>
                                    {{ $tipo->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro 3: País -->
                    <div class="filter-item">
                        <label for="pais">País</label>
                        <select name="pais" id="pais">
                            <option value="">Todos los países</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais }}" {{ request('pais') == $pais ? 'selected' : '' }}>
                                    {{ $pais }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro 4: Precio -->
                    <div class="filter-item">
                        <label>Rango de precio (€)</label>
                        <div style="display: flex; gap: 0.5rem;">
                            <input type="number" 
                                   name="precio_min" 
                                   placeholder="Mín"
                                   value="{{ request('precio_min') }}"
                                   style="width: 50%;">
                            <input type="number" 
                                   name="precio_max" 
                                   placeholder="Máx"
                                   value="{{ request('precio_max') }}"
                                   style="width: 50%;">
                        </div>
                    </div>
                </div>

                <!-- Ordenación -->
                <div style="margin-bottom: 1.5rem;">
                    <div class="filter-item">
                        <label for="orden">Ordenar por</label>
                        <select name="orden" id="orden" style="max-width: 300px;">
                            <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                            <option value="alfabetico" {{ request('orden') == 'alfabetico' ? 'selected' : '' }}>A-Z</option>
                        </select>
                    </div>
                </div>

                <div class="filter-actions">
                    <a href="{{ route('vacaciones.index') }}" class="btn btn-outline">
                        🔄 Limpiar Filtros
                    </a>
                    <button type="submit" class="btn btn-primary">
                        🔍 Buscar Viajes
                    </button>
                </div>
            </form>
        </div>

        <!-- Grid de Vacaciones -->
        <div class="vacaciones-grid">
            @forelse ($vacaciones as $vacacion)
                <div class="vacacion-card fade-in">
                    <div class="card-image-container">
                        @if ($vacacion->fotos->count() > 0)
                            <img src="{{ $vacacion->fotos->first()->ruta }}" 
                                 alt="{{ $vacacion->titulo }}"
                                 class="card-image">
                        @else
                            <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=400" 
                                 alt="Destino"
                                 class="card-image">
                        @endif
                        <span class="card-badge">{{ $vacacion->tipo->nombre }}</span>
                    </div>

                    <div class="card-content">
                        <h3 class="card-title">{{ $vacacion->titulo }}</h3>
                        
                        <div class="card-location">
                            <span class="icon-location"></span>
                            <span>{{ $vacacion->pais }}</span>
                        </div>

                        <p class="card-description">
                            {{ Str::limit($vacacion->descripcion, 100) }}
                        </p>

                        <div class="card-footer">
                            <div class="card-price">
                                {{ number_format($vacacion->precio, 0) }}
                                <span class="card-price-label">€</span>
                            </div>
                            <a href="{{ route('vacaciones.show', $vacacion->id) }}" class="btn btn-primary">
                                Ver Detalles →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem;">
                    <h2 style="color: var(--text-gray); font-size: 1.5rem;">
                        😔 No se encontraron vacaciones
                    </h2>
                    <p style="color: var(--text-gray); margin-top: 1rem;">
                        Intenta ajustar los filtros de búsqueda
                    </p>
                </div>
            @endforelse
        </div>

        <!-- Paginación -->
        <div class="pagination">
            {{ $vacaciones->links() }}
        </div>

        <!-- Botón Admin -->
        @if (Auth::check() && Auth::user()->isAdmin())
            <div style="text-align: center; margin-top: 3rem;">
                <a href="{{ route('vacaciones.create') }}" class="btn btn-success">
                    ➕ Crear Nueva Vacación
                </a>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Sobre Nosotros</h3>
                <p>Tu agencia de viajes de confianza desde 2024. Ofrecemos las mejores experiencias al mejor precio.</p>
            </div>
            <div class="footer-section">
                <h3>Enlaces Rápidos</h3>
                <ul>
                    <li><a href="#">Quiénes Somos</a></li>
                    <li><a href="#">Términos y Condiciones</a></li>
                    <li><a href="#">Política de Privacidad</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contacto</h3>
                <ul>
                    <li>📧 info@viajesapp.com</li>
                    <li>📞 +34 900 123 456</li>
                    <li>📍 Granada, España</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 ViajesApp. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>