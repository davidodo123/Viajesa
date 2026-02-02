<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $vacacion->titulo }} - Viajes</title>
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
                <li><a href="{{ route('vacaciones.index') }}" class="nav-link">← Volver a Ofertas</a></li>
                @auth
                    <li><a href="{{ route('reservas.mis-reservas') }}" class="nav-link icon-ticket">Mis Reservas</a></li>
                    @if(Auth::user()->isAdmin())
                        <li><a href="{{ route('vacaciones.edit', $vacacion->id) }}" class="nav-link">✏️ Editar</a></li>
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

    <!-- Detalle de la Vacación -->
    <div class="detail-container" style="padding: 3rem 1.5rem;">
        
        <!-- Mensajes Flash -->
        @if (session('success'))
            <div class="alert alert-success">
                <span class="icon-check"></span>{{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif

        <!-- Galería de Fotos -->
        @if ($vacacion->fotos->count() > 0)
            <div class="gallery-grid">
                @foreach ($vacacion->fotos as $foto)
                    <img src="{{ $foto->ruta }}" 
                         alt="{{ $vacacion->titulo }}"
                         class="gallery-image">
                @endforeach
            </div>
        @else
            <div class="gallery-grid">
                <img src="https://images.unsplash.com/photo-1488646953014-85cb44e25828?w=800" 
                     alt="Destino de viaje"
                     class="gallery-image">
                <img src="https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=800" 
                     alt="Destino de viaje"
                     class="gallery-image">
                <img src="https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?w=800" 
                     alt="Destino de viaje"
                     class="gallery-image">
            </div>
        @endif

        <!-- Info Principal -->
        <div class="detail-header" style="background: white; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-md); margin-bottom: 2rem; margin-top: 2rem;">
            <div class="detail-info">
                <h1>{{ $vacacion->titulo }}</h1>
                <div style="display: flex; gap: 1rem; margin-top: 1rem; flex-wrap: wrap;">
                    <span class="card-badge">{{ $vacacion->tipo->nombre }}</span>
                    <div class="card-location" style="margin: 0;">
                        <span>{{ $vacacion->pais }}</span>
                    </div>
                </div>
            </div>
            <div class="detail-price">
                <span class="price-amount">
                    {{ number_format($vacacion->precio, 0) }}<span class="price-currency">€</span>
                </span>
            </div>
        </div>

        <!-- Descripción -->
        <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-md); margin-bottom: 2rem;">
            <h2 style="color: var(--primary-blue); margin-bottom: 1rem;">Descripción</h2>
            <p style="line-height: 1.8; color: var(--text-dark); font-size: 1.05rem;">
                {{ $vacacion->descripcion }}
            </p>
        </div>

        <!-- Información Adicional -->
        <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-md); margin-bottom: 2rem;">
            <h2 style="color: var(--primary-blue); margin-bottom: 1rem;">Información del Viaje</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
                <div>
                    <div style="font-weight: 600; color: var(--text-gray); margin-bottom: 0.5rem;">Destino</div>
                    <div style="font-size: 1.1rem; color: var(--text-dark);">{{ $vacacion->pais }}</div>
                </div>
                <div>
                    <div style="font-weight: 600; color: var(--text-gray); margin-bottom: 0.5rem;">Tipo</div>
                    <div style="font-size: 1.1rem; color: var(--text-dark);">{{ $vacacion->tipo->nombre }}</div>
                </div>
                <div>
                    <div style="font-weight: 600; color: var(--text-gray); margin-bottom: 0.5rem;">Precio</div>
                    <div style="font-size: 1.1rem; color: var(--success-green); font-weight: 700;">{{ number_format($vacacion->precio, 2) }}€</div>
                </div>
                <div>
                    <div style="font-weight: 600; color: var(--text-gray); margin-bottom: 0.5rem;">Comentarios</div>
                    <div style="font-size: 1.1rem; color: var(--text-dark);">{{ $vacacion->comentarios->count() }} opiniones</div>
                </div>
            </div>
        </div>

        <!-- Botón de Reserva -->
        @auth
            @if (Auth::user()->hasVerifiedEmail())
                @if ($haReservado)
                    <div class="badge-reserved" style="margin-bottom: 2rem; width: 100%; justify-content: center; padding: 1.5rem;">
                        <span class="icon-check"></span>
                        Ya has reservado esta vacación
                    </div>
                @else
                    <form method="POST" action="{{ route('reservas.store') }}" style="margin-bottom: 2rem; text-align: center;">
                        @csrf
                        <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                        <button type="submit" class="btn btn-success" style="font-size: 1.2rem; padding: 1.25rem 3rem;">
                            Reservar Ahora - {{ number_format($vacacion->precio, 0) }}€
                        </button>
                        <p style="margin-top: 1rem; color: var(--text-gray); font-size: 0.9rem;">
                            ✓Confirmación inmediata  •  ✓ Mejor precio garantizado
                        </p>
                    </form>
                @endif
            @else
                <div class="alert alert-warning">
                    Debes <a href="{{ route('verification.notice') }}" style="font-weight: 700; text-decoration: underline; color: inherit;">verificar tu email</a> para poder reservar esta vacación.
                </div>
            @endif
        @else
            <div class="alert alert-info" style="text-align: center; font-size: 1.05rem;">
                <a href="{{ route('login') }}" style="font-weight: 700; text-decoration: underline; color: inherit;">Inicia sesión</a> o 
                <a href="{{ route('register') }}" style="font-weight: 700; text-decoration: underline; color: inherit;">regístrate</a> para reservar esta increíble vacación.
            </div>
        @endauth

        <!-- Sección de Comentarios -->
        <div class="comments-section">
            <div class="comments-header">
                <span class="icon-comment"></span>
                <span>Comentarios ({{ $vacacion->comentarios->count() }})</span>
            </div>

            <!-- Formulario de Comentario -->
            @auth
                @if ($haReservado)
                    <form method="POST" action="{{ route('comentarios.store') }}" class="comment-form">
                        @csrf
                        <input type="hidden" name="idvacacion" value="{{ $vacacion->id }}">
                        
                        <label style="font-weight: 600; margin-bottom: 0.5rem; display: block; font-size: 1rem;">
                         Escribe tu comentario sobre esta vacación
                        </label>
                        <textarea name="texto" 
                                  required
                                  minlength="10"
                                  maxlength="1000"
                                  placeholder="Comparte tu experiencia y ayuda a otros viajeros..."></textarea>
                        
                        @error('texto')
                            <p style="color: var(--danger-red); margin-top: 0.5rem; font-weight: 500;">{{ $message }}</p>
                        @enderror

                        <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                            Publicar Comentario
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                         Debes reservar esta vacación para poder dejar un comentario.
                    </div>
                @endif
            @else
                <div class="alert alert-info">
                     <a href="{{ route('login') }}" style="font-weight: 700; text-decoration: underline; color: inherit;">Inicia sesión</a> y reserva esta vacación para poder comentar.
                </div>
            @endauth

            <!-- Lista de Comentarios -->
            <div style="margin-top: 2rem;">
                @forelse ($vacacion->comentarios as $comentario)
                    <div class="comment-item">
                        <div class="comment-header">
                            <div>
                                <div class="comment-author"> {{ $comentario->usuario->name }}</div>
                                <div class="comment-date"> {{ $comentario->created_at->diffForHumans() }}</div>
                            </div>

                            @auth
                                @if (Auth::id() === $comentario->iduser || Auth::user()->isAdmin())
                                    <form method="POST" action="{{ route('comentarios.destroy', $comentario->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('¿Estás seguro de eliminar este comentario?')"
                                                style="color: var(--danger-red); background: none; border: none; cursor: pointer; font-weight: 600; padding: 0.5rem 1rem; border-radius: 6px; transition: var(--transition);"
                                                onmouseover="this.style.backgroundColor='#fee2e2'"
                                                onmouseout="this.style.backgroundColor='transparent'">
                                            🗑️ Eliminar
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                        
                        <p class="comment-text">{{ $comentario->texto }}</p>

                        @if ($comentario->created_at != $comentario->updated_at)
                            <p style="color: var(--text-gray); font-size: 0.8rem; font-style: italic; margin-top: 0.75rem;">
                                 Editado el {{ $comentario->updated_at->format('d/m/Y') }}
                            </p>
                        @endif
                    </div>
                @empty
                    <div style="text-align: center; padding: 3rem; background: var(--bg-light); border-radius: 12px;">
                        <p style="font-size: 3rem; margin-bottom: 1rem;"></p>
                        <p style="color: var(--text-gray); font-size: 1.1rem; font-weight: 500;">
                            No hay comentarios aún
                        </p>
                        <p style="color: var(--text-gray); margin-top: 0.5rem;">
                            ¡Sé el primero en compartir tu opinión!
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Botón Volver -->
        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('vacaciones.index') }}" class="btn btn-outline" style="padding: 1rem 2rem;">
                ← Volver a todas las ofertas
            </a>
        </div>
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
                    <li>info@viajesapp.com</li>
                    <li>+34 900 123 456</li>
                    <li> Granada, España</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 ViajesApp. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>