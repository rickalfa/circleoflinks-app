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
          <li>
            <a href="{{ route('/admindashboard/user') }}" class="admin-nav-link">
              <i class="bi bi-people-fill menu-icon"></i>
              <span>User-App</span>
            </a>
          </li>
          <li>
            <a href="{{ route('/admindashboard/bots-r') }}" class="admin-nav-link">
              <i class="bi bi-robot menu-icon"></i>
              <span>Bots-R</span>
            </a>
          </li>
          <li>
            <a href="{{ route('/admindashboard/contacts') }}" class="admin-nav-link">
              <i class="bi bi-journal-bookmark-fill menu-icon"></i>
              <span>Contacts</span>
            </a>
          </li>
          <li>
            <a href="{{ route('leads.index') }}" class="admin-nav-link">
              <i class="bi bi-funnel-fill menu-icon"></i>
              <span>Leads</span>
            </a>
          </li>
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
                <h6 class="card-title text-uppercase text-muted fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">Plan Actual</h6>
                <div class="d-flex align-items-center justify-content-center mb-3">
                    <i class="bi bi-star-fill text-warning me-2 fs-5"></i>
                    <span class="fw-bold text-primary fs-6">{{ auth()->user()->plan ?? 'Gratuito' }}</span>
                </div>
                <a href="#" class="btn btn-sm btn-primary w-100 rounded-pill fw-semibold shadow-sm" style="font-size: 0.8rem;">Mejorar Plan</a>
            </div>
        </div>
    </li>

  </ul>
</div>