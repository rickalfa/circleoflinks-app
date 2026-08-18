<style>
    .sidebar-profile {
        background: #111827;
        border-radius: 14px;
        color: #e5e7eb;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.15);
        overflow: hidden;
    }

    .sidebar-profile .sidebar-header {
        padding: 16px 18px 8px;
        border-bottom: 1px solid rgba(148, 163, 184, 0.25);
    }

    .sidebar-profile .sidebar-title {
        font-size: 14px;
        letter-spacing: 0.4px;
        text-transform: uppercase;
        color: rgba(226, 232, 240, 0.7);
    }

    .sidebar-profile .sidebar-list {
        padding: 12px;
        gap: 8px;
    }

    .sidebar-profile .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 10px;
        color: #e2e8f0;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .sidebar-profile .nav-link:hover,
    .sidebar-profile .nav-link.active {
        background: rgba(59, 130, 246, 0.18);
        color: #ffffff;
    }

    .sidebar-profile .nav-link.disabled {
        opacity: 0.55;
    }

    @media (max-width: 991.98px) {
        .sidebar-profile {
            margin-bottom: 16px;
        }

        .sidebar-profile .sidebar-list {
            flex-direction: row;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: 6px;
        }

        .sidebar-profile .nav-link {
            white-space: nowrap;
        }
    }

    @media (min-width: 992px) {
        .sidebar-profile {
            position: sticky;
            top: 16px;
        }

        .sidebar-profile .sidebar-list {
            flex-direction: column;
        }
    }
</style>

<aside class="sidebar-profile bg-dark-custom">
    <div class="sidebar-header">
        <div class="sidebar-title">
            <i class="fas fa-quote-left me-2"></i>
            Perfil
        </div>
    </div>

    <ul class="nav sidebar-list d-flex flex-lg-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('/profile') }}">
                <i class="fas fa-user-circle"></i> <span>Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('profile/api-tokens') ? 'active' : '' }}" href="{{ url('/profile/api-tokens') }}">
                <i class="fas fa-key"></i> <span>Access-API</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="#">
                <i class="fas fa-ban"></i> <span>Disabled</span>
            </a>
        </li>
    </ul>
</aside>
