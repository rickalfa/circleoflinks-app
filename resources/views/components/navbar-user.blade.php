{{-- ─────────────────────────────────────────────────────────
     Componente: navbar-user
     Descripción: Navbar principal del sitio público.
     Estilos: resources/css/stylesapp/components/_navbars.scss
     ───────────────────────────────────────────────────────── --}}

{{-- Contenedor sticky con scroll-state query (Progressive Enhancement) --}}
<div class="navbar-user-sticky">
  <nav id="navebar" class="navbar navbar-expand-lg p-0 navbar-transparent">
    <div class="container py-2">

      {{-- Brand --}}
      <a class="navbar-brand text-white fw-bold" href="{{ route('/') }}">
        <i class="bi bi-link-45deg text-purple me-1" style="color:#c084fc;"></i>Wsp service
      </a>

      {{-- Toggler mobile --}}
      <button id="buttonnav"
              class="navbar-toggler border-0"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarMain"
              aria-controls="navbarMain"
              aria-expanded="false"
              aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      {{-- Contenido colapsable --}}
      <div class="collapse navbar-collapse" id="navbarMain">

        {{-- Links principales --}}
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#api-features">Features</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('l5-swagger.default.api') }}" target="_blank" rel="noopener">
              <i class="bi bi-code-slash me-1"></i>API V1 Doc
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('privacy') }}">Privacidad</a>
          </li>
        </ul>

        {{-- Sección de usuario --}}
        @php $user = Auth::user(); @endphp

        <div class="d-flex align-items-center gap-2" id="dropmenunav">

          @auth
            {{-- Dropdown usuario autenticado --}}
            <div class="dropdown dropstart">
              <a class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                 href="#"
                 role="button"
                 data-bs-toggle="dropdown"
                 aria-expanded="false">
                <i class="bi bi-person-circle"></i>
                <span class="d-none d-sm-inline">{{ $user->name }}</span>
              </a>

              <ul class="dropdown-menu dropdown-menu-dark">
                {{-- Nombre del usuario --}}
                <li>
                  <span class="dropdown-item dropdown-item-user text-white-50">
                    <i class="bi bi-person me-1"></i>{{ $user->name }}
                  </span>
                </li>
                <li><hr class="dropdown-divider border-secondary"></li>

                {{-- Perfil --}}
                <li>
                  <a class="dropdown-item" href="{{ route('profile.edit') }}">
                    <i class="bi bi-person-badge me-2"></i>Perfil
                  </a>
                </li>

                {{-- Admin Dashboard (visible siempre en menú) --}}
                <li>
                  <a class="dropdown-item" href="{{ route('admindashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                  </a>
                </li>

                <li><hr class="dropdown-divider border-secondary"></li>

                {{-- Logout --}}
                <li>
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                      <i class="bi bi-box-arrow-right me-2"></i>{{ __('Log Out') }}
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          @endauth

          @guest
            {{-- Botones para visitantes --}}
            <button class="btn btn-sm btn-nav-login btn-outline-secondary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalLogin">
              Iniciar sesión
            </button>
            <button class="btn btn-sm btn-nav-register btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#modalRegister">
              Registrarse
            </button>
          @endguest

        </div>{{-- /#dropmenunav --}}

      </div>{{-- /.collapse --}}

    </div>{{-- /.container --}}
  </nav>
</div>{{-- /.navbar-user-sticky --}}

{{-- ─────────────────────────────────────────────────────────
     JS: Fallback scroll-aware para navegadores sin scroll-state
     Agrega clase .navbar-scrolled al nav cuando la página hace scroll
     ───────────────────────────────────────────────────────── --}}
<script>
  (function () {
    const nav = document.getElementById('navebar');
    if (!nav) return;

    // Solo aplica si scroll-state no está soportado (fallback)
    if (!CSS.supports('container-type', 'scroll-state')) {
      const onScroll = () => {
        const scrolled = window.scrollY > 20;
        nav.classList.toggle('navbar-scrolled', scrolled);
        nav.classList.toggle('navbar-transparent', !scrolled);
      };
      window.addEventListener('scroll', onScroll, { passive: true });
      onScroll(); // estado inicial
    }
  })();
</script>