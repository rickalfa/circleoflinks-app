<style>
  /* Estilos interactivos y animaciones para el Sidebar Admin Dashboard */
  .admin-sidebar {
    width: 100%;
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(226, 232, 240, 0.8);
    transition: all 0.3s ease;
  }

  /* Encabezado */
  .admin-sidebar-header {
    padding: 1rem 0.85rem;
    margin-bottom: 0.5rem;
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.2s ease;
  }
  .admin-sidebar-header:hover {
    background-color: #f8fafc;
    border-radius: 12px 12px 0 0;
  }
  .admin-brand-icon {
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
    color: #ffffff;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(13, 110, 253, 0.25);
    transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
  }
  .admin-sidebar-header:hover .admin-brand-icon {
    transform: rotate(10deg) scale(1.1);
  }

  /* Botones principales de categoría */
  .admin-btn-toggle {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.65rem 0.85rem;
    font-weight: 600;
    font-size: 0.93rem;
    color: #334155;
    background: transparent;
    border: none;
    border-radius: 8px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
  }
  .admin-btn-toggle:hover {
    background-color: #f1f5f9;
    color: #0d6efd;
    transform: translateX(3px);
  }
  .admin-btn-toggle:active {
    transform: scale(0.97) translateX(3px);
  }
  .admin-btn-toggle[aria-expanded="true"] {
    background-color: rgba(13, 110, 253, 0.08);
    color: #0d6efd;
  }
  .admin-btn-toggle .chevron-icon {
    font-size: 0.75rem;
    color: #94a3b8;
    transition: transform 0.3s ease, color 0.3s ease;
  }
  .admin-btn-toggle:hover .chevron-icon {
    color: #0d6efd;
  }
  .admin-btn-toggle[aria-expanded="true"] .chevron-icon {
    transform: rotate(90deg);
    color: #0d6efd;
  }

  /* Submenús */
  .admin-subnav {
    padding-left: 0.5rem;
    margin-top: 0.25rem;
    margin-bottom: 0.35rem;
    border-left: 2px solid #e2e8f0;
    margin-left: 1.1rem;
  }

  /* Enlaces de submenú */
  .admin-nav-link {
    display: flex;
    align-items: center;
    padding: 0.45rem 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #64748b;
    text-decoration: none;
    border-radius: 6px;
    transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1);
    margin-bottom: 2px;
  }
  .admin-nav-link:hover {
    color: #0d6efd;
    background-color: #f8fafc;
    transform: translateX(5px);
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
  }
  .admin-nav-link:active {
    transform: translateX(3px) scale(0.98);
  }
  .admin-nav-link .menu-icon {
    font-size: 1rem;
    margin-right: 0.6rem;
    transition: transform 0.25s ease, color 0.25s ease;
  }
  .admin-nav-link:hover .menu-icon {
    transform: scale(1.2);
    color: #0d6efd;
  }

  /* Divisor */
  .admin-nav-divider {
    border-top: 1px solid #e2e8f0;
    margin: 0.75rem 0;
  }
</style>

<div class="flex-shrink-0 p-3 bg-white admin-sidebar" style="width: 100%;">
    <!-- Encabezado del Menú -->
    <a href="#" class="d-flex align-items-center text-decoration-none admin-sidebar-header">
      <div class="admin-brand-icon me-2">
        <i class="bi bi-grid-fill fs-5"></i>
      </div>
      <span class="fs-5 fw-bold text-dark">Menu Dashboard</span>
    </a>

    <!-- Lista de Menús -->
    <ul class="list-unstyled ps-0 mb-0">
      
      <!-- Categoría Service-WSP -->
      <li class="mb-1">
        <button class="btn admin-btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
          <span class="d-flex align-items-center">
            <i class="bi bi-whatsapp text-success me-2 fs-5"></i> 
            <span>Service-WSP</span>
          </span>
          <i class="bi bi-chevron-right chevron-icon"></i>
        </button>
        <div class="collapse show" id="home-collapse">
          <ul class="admin-subnav list-unstyled fw-normal pb-1">
            <li>
              <a href="{{ route('/admindashboard/user')}}" class="admin-nav-link">
                <i class="bi bi-people-fill menu-icon"></i>
                <span>user-app</span>
              </a>
            </li>
            <li>
              <a href="{{ route('/admindashboard/bots-r')}}" class="admin-nav-link">
                <i class="bi bi-robot menu-icon"></i>
                <span>Bots-R</span>
              </a>
            </li>
            <li>
              <a href="{{ route('/admindashboard/contacts')}}" class="admin-nav-link">
                <i class="bi bi-journal-bookmark-fill menu-icon"></i>
                <span>Contacts</span>
              </a>
            </li>
            <li>
              <a href="{{ route('leads.index')}}" class="admin-nav-link">
                <i class="bi bi-funnel-fill menu-icon"></i>
                <span>Leads</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

      <!-- Categoría Dashboard -->
      <li class="mb-1">
        <button class="btn admin-btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
          <span class="d-flex align-items-center">
            <i class="bi bi-speedometer2 text-primary me-2 fs-5"></i>
            <span>Dashboard</span>
          </span>
          <i class="bi bi-chevron-right chevron-icon"></i>
        </button>
        <div class="collapse" id="dashboard-collapse">
          <ul class="admin-subnav list-unstyled fw-normal pb-1">
            <li>
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

      <!-- Categoría Account -->
      <li class="mb-1">
        <button class="btn admin-btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
          <span class="d-flex align-items-center">
            <i class="bi bi-person-circle text-secondary me-2 fs-5"></i>
            <span>Account</span>
          </span>
          <i class="bi bi-chevron-right chevron-icon"></i>
        </button>
        <div class="collapse" id="account-collapse">
          <ul class="admin-subnav list-unstyled fw-normal pb-1">
            <li>
              <a href="#" class="admin-nav-link">
                <i class="bi bi-plus-circle-fill menu-icon"></i>
                <span>New...</span>
              </a>
            </li>
            <li>
              <a href="#" class="admin-nav-link">
                <i class="bi bi-person-badge-fill menu-icon"></i>
                <span>Profile</span>
              </a>
            </li>
            <li>
              <a href="#" class="admin-nav-link">
                <i class="bi bi-gear-fill menu-icon"></i>
                <span>Settings</span>
              </a>
            </li>
            <li>
              <a href="#" class="admin-nav-link text-danger">
                <i class="bi bi-box-arrow-right menu-icon text-danger"></i>
                <span>Sign out</span>
              </a>
            </li>
          </ul>
        </div>
      </li>

    </ul>
</div>