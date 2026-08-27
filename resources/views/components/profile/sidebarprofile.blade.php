<nav class="profile-sidebar mb-4">

    <!-- Header Brand -->
    <div class="profile-sidebar-brand d-flex align-items-center">
        <i class="bi bi-shield-lock-fill text-white fs-4 me-2"></i>
        <a class="text-white text-decoration-none fw-bold fs-5" href="{{ url('/')}}">Demo Service</a>
    </div>

    <!-- Menú de Navegación -->
    <ul class="nav flex-column mb-0">
        <!-- Inicio -->
        <li class="nav-item">
            <a class="profile-nav-link" href="#">
                <span class="d-flex align-items-center">
                    <i class="bi bi-house-door-fill profile-nav-icon text-secondary"></i>
                    <span>Inicio</span>
                </span>
            </a>
        </li>
        
        <!-- Separador -->
        <hr class="text-muted opacity-25 my-2">

        <!-- Servicios -->
        <li class="nav-item">
            <a href="#submenu-servicios" class="profile-nav-toggle w-100 collapsed text-decoration-none" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenu-servicios">
                <span class="d-flex align-items-center">
                    <i class="bi bi-layers-fill profile-nav-icon text-primary"></i>
                    <span>Servicios</span>
                </span>
                <i class="bi bi-chevron-right profile-chevron"></i>
            </a>
            <div class="collapse" id="submenu-servicios">
                <ul class="profile-subnav list-unstyled">
                    <li>
                        <a class="profile-subnav-link" href="{{ url('/admindashboard')}}">
                            <i class="bi bi-speedometer2 me-2"></i> Dashboard Admin
                        </a>
                    </li>
                    <li>
                        <a class="profile-subnav-link" href="#">
                            <i class="bi bi-box-seam me-2"></i> Servicio 2
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Seguridad -->
        <li class="nav-item">
            <a href="#submenu-seguridad" class="profile-nav-toggle w-100 collapsed text-decoration-none" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="submenu-seguridad">
                <span class="d-flex align-items-center">
                    <i class="bi bi-lock-fill profile-nav-icon text-success"></i>
                    <span>Security</span>
                </span>
                <i class="bi bi-chevron-right profile-chevron"></i>
            </a>
            <div class="collapse" id="submenu-seguridad">
                <ul class="profile-subnav list-unstyled">
                    <li>
                        <a class="profile-subnav-link" href="{{ url('/profile/accesstoken')}}">
                            <i class="bi bi-key-fill me-2"></i> API Token
                        </a>
                    </li>
                    <li>
                        <a class="profile-subnav-link" href="#">
                            <i class="bi bi-shield-check me-2"></i> Servicios 2
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Separador -->
        <hr class="text-muted opacity-25 my-2">

        <!-- Contacto -->
        <li class="nav-item">
            <a class="profile-nav-link" href="#">
                <span class="d-flex align-items-center">
                    <i class="bi bi-envelope-fill profile-nav-icon text-info"></i>
                    <span>Contacto</span>
                </span>
            </a>
        </li>
    </ul>
</nav>