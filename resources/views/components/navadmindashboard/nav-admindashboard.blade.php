{{-- ─────────────────────────────────────────────────────────
     Componente: nav-admindashboard
     Descripción: Sidebar de navegación del panel de administración.
     Estilos: resources/css/stylesapp/components/_navbars.scss
     ───────────────────────────────────────────────────────── --}}

<div class="flex-shrink-0 p-3 bg-white admin-sidebar" style="width: 100%;">

  {{-- ── Encabezado del Menú → ruta home ── --}}
  <a href="{{ route('/') }}" class="d-flex align-items-center text-decoration-none admin-sidebar-header">
    <div class="admin-brand-icon me-2">
      <i class="bi bi-grid-fill fs-5"></i>
    </div>
    <span class="fs-5 fw-bold text-dark">Menu Dashboard</span>
  </a>

  {{-- ── Lista de Menús ── --}}
  <ul class="list-unstyled ps-0 mb-0">

    {{-- ── Categoría: Service-WSP ── --}}
    <li class="mb-1">
      <button class="btn admin-btn-toggle align-items-center rounded"
              data-bs-toggle="collapse"
              data-bs-target="#home-collapse"
              aria-expanded="true">
        <span class="d-flex align-items-center">
          <i class="bi bi-whatsapp text-success me-2 fs-5"></i>
          <span>Service-WSP</span>
        </span>
        <i class="bi bi-chevron-right chevron-icon"></i>
      </button>
      <div class="collapse show" id="home-collapse">
        <ul class="admin-subnav list-unstyled fw-normal pb-1">
          @if(auth()->check() && auth()->user()->isTypeB())
            <li class="px-2 py-2 mb-2 bg-light rounded-3 text-center border">
              <span class="badge bg-warning text-dark mb-1">
                <i class="bi bi-exclamation-triangle-fill me-1"></i> Sin Proyecto Activo
              </span>
              <p class="small text-muted mb-2" style="font-size: 0.75rem;">
                Activa tu servicio de WhatsApp para habilitar las conversaciones.
              </p>
              <a href="{{ route('onboarding.setup') }}" class="btn btn-sm btn-success w-100 rounded-pill fw-semibold" style="font-size: 0.78rem;">
                <i class="bi bi-whatsapp me-1"></i> Activar Conversaciones
              </a>
            </li>
          @endif

          <li>
            <a href="{{ auth()->user()->isTypeB() ? route('onboarding.setup') : route('/admindashboard/user') }}" 
               class="admin-nav-link {{ auth()->user()->isTypeB() ? 'opacity-50' : '' }}"
               title="{{ auth()->user()->isTypeB() ? 'Requiere activar servicio' : '' }}">
              <i class="bi bi-people-fill menu-icon"></i>
              <span>User-App</span>
              @if(auth()->user()->isTypeB()) <i class="bi bi-lock-fill ms-auto small text-muted"></i> @endif
            </a>
          </li>
          <li>
            <a href="{{ auth()->user()->isTypeB() ? route('onboarding.setup') : route('/admindashboard/bots-r') }}" 
               class="admin-nav-link {{ auth()->user()->isTypeB() ? 'opacity-50' : '' }}"
               title="{{ auth()->user()->isTypeB() ? 'Requiere activar servicio' : '' }}">
              <i class="bi bi-robot menu-icon"></i>
              <span>Bots-R</span>
              @if(auth()->user()->isTypeB()) <i class="bi bi-lock-fill ms-auto small text-muted"></i> @endif
            </a>
          </li>
          <li>
            <a href="{{ auth()->user()->isTypeB() ? route('onboarding.setup') : route('/admindashboard/contacts') }}" 
               class="admin-nav-link {{ auth()->user()->isTypeB() ? 'opacity-50' : '' }}"
               title="{{ auth()->user()->isTypeB() ? 'Requiere activar servicio' : '' }}">
              <i class="bi bi-journal-bookmark-fill menu-icon"></i>
              <span>Contacts</span>
              @if(auth()->user()->isTypeB()) <i class="bi bi-lock-fill ms-auto small text-muted"></i> @endif
            </a>
          </li>
          <li>
            <a href="{{ auth()->user()->isTypeB() ? route('onboarding.setup') : route('leads.index') }}" 
               class="admin-nav-link {{ auth()->user()->isTypeB() ? 'opacity-50' : '' }}"
               title="{{ auth()->user()->isTypeB() ? 'Requiere activar servicio' : '' }}">
              <i class="bi bi-funnel-fill menu-icon"></i>
              <span>Leads</span>
              @if(auth()->user()->isTypeB()) <i class="bi bi-lock-fill ms-auto small text-muted"></i> @endif
            </a>
          </li>

          {{-- Enlace a la Configuración del Proyecto y Número de WhatsApp --}}
          @if(auth()->check() && auth()->user()->isTypeA())
            <li class="mt-2 pt-2 border-top">
              <a href="{{ route('project.settings') }}" class="admin-nav-link text-primary fw-semibold">
                <i class="bi bi-sliders menu-icon text-primary"></i>
                <span>Configurar Proyecto</span>
              </a>
            </li>
          @endif
        </ul>
      </div>
    </li>

    {{-- ── Categoría: Dashboard ── --}}
    <li class="mb-1">
      <button class="btn admin-btn-toggle align-items-center rounded collapsed"
              data-bs-toggle="collapse"
              data-bs-target="#dashboard-collapse"
              aria-expanded="false">
        <span class="d-flex align-items-center">
          <i class="bi bi-speedometer2 text-primary me-2 fs-5"></i>
          <span>Dashboard</span>
        </span>
        <i class="bi bi-chevron-right chevron-icon"></i>
      </button>
      <div class="collapse" id="dashboard-collapse">
        <ul class="admin-subnav list-unstyled fw-normal pb-1">
          <li>
            {{-- Sin ruta definida aún --}}
            <a href="#" class="admin-nav-link">
              <i class="bi bi-bar-chart-line-fill menu-icon"></i>
              <span>Overview</span>
            </a>
          </li>
          <li>
            <a href="#" class="admin-nav-link">
              <i class="bi bi-calendar-week-fill menu-icon"></i>
              <span>Weekly</span>
            </a>
          </li>
          <li>
            <a href="#" class="admin-nav-link">
              <i class="bi bi-calendar-month-fill menu-icon"></i>
              <span>Monthly</span>
            </a>
          </li>
          <li>
            <a href="#" class="admin-nav-link">
              <i class="bi bi-calendar-check-fill menu-icon"></i>
              <span>Annually</span>
            </a>
          </li>
        </ul>
      </div>
    </li>

    <li class="admin-nav-divider"></li>

    {{-- ── Categoría: Account ── --}}
    <li class="mb-1">
      <button class="btn admin-btn-toggle align-items-center rounded collapsed"
              data-bs-toggle="collapse"
              data-bs-target="#account-collapse"
              aria-expanded="false">
        <span class="d-flex align-items-center">
          <i class="bi bi-person-circle text-secondary me-2 fs-5"></i>
          <span>Account</span>
        </span>
        <i class="bi bi-chevron-right chevron-icon"></i>
      </button>
      <div class="collapse" id="account-collapse">
        <ul class="admin-subnav list-unstyled fw-normal pb-1">
          <li>
            {{-- Sin ruta definida aún --}}
            <a href="#" class="admin-nav-link">
              <i class="bi bi-plus-circle-fill menu-icon"></i>
              <span>New...</span>
            </a>
          </li>
          <li>
            <a href="{{ route('profile.edit') }}" class="admin-nav-link">
              <i class="bi bi-person-badge-fill menu-icon"></i>
              <span>Profile</span>
            </a>
          </li>
          <li>
            {{-- Sin ruta definida aún --}}
            <a href="#" class="admin-nav-link">
              <i class="bi bi-gear-fill menu-icon"></i>
              <span>Settings</span>
            </a>
          </li>
          <li>
            {{-- Sign out mediante form POST --}}
            <form method="POST" action="{{ route('logout') }}" class="m-0">
              @csrf
              <button type="submit" class="admin-nav-link admin-nav-link--danger border-0 bg-transparent w-100 text-start">
                <i class="bi bi-box-arrow-right menu-icon"></i>
                <span>Sign out</span>
              </button>
            </form>
          </li>
        </ul>
      </div>
    </li>
    
    <li class="admin-nav-divider"></li>

    {{-- ── Plan ── --}}
    <li class="mb-1 px-3 mt-4">
        <div class="card border-0 shadow-sm" style="background-color: rgba(13, 110, 253, 0.05);">
            <div class="card-body p-3 text-center">
                <h6 class="card-title text-uppercase text-muted fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Servicio Actual</h6>
                @if(auth()->check() && auth()->user()->isTypeA())
                    <div class="d-flex align-items-center justify-content-center mb-1">
                        <i class="bi bi-whatsapp text-success me-2 fs-5"></i>
                        <span class="fw-bold text-success fs-6">Conversaciones</span>
                    </div>
                    @if(auth()->user()->currentProject()?->phone_number)
                        <div class="text-muted small mb-2 font-monospace" style="font-size: 0.78rem;">
                            {{ auth()->user()->currentProject()->phone_number }}
                        </div>
                    @endif
                    <a href="{{ route('project.settings') }}" class="btn btn-sm btn-outline-primary w-100 rounded-pill fw-semibold shadow-sm mt-1" style="font-size: 0.78rem;">
                        <i class="bi bi-gear-fill me-1"></i>Gestionar Proyecto
                    </a>
                @else
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="bi bi-dash-circle text-muted me-2 fs-5"></i>
                        <span class="fw-bold text-secondary fs-6">Sin Suscripción</span>
                    </div>
                    <a href="{{ route('onboarding.setup') }}" class="btn btn-sm btn-success w-100 rounded-pill fw-semibold shadow-sm" style="font-size: 0.8rem;">
                        <i class="bi bi-gift-fill me-1"></i>Activar Gratis
                    </a>
                @endif
            </div>
        </div>
    </li>

  </ul>
</div>