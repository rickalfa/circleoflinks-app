<div class="sidebar-container bg-dark-custom">
    <div class="sidebar-header p-3 text-muted small">
        <i class="fas fa-quote-left me-2"></i>
    </div>

    <ul class="nav flex-column sidebar-nav">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('profile') ? 'active' : '' }}" href="{{ url('/profile') }}">
                <i class="fas fa-user-circle me-3"></i> <span>Profile</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('profile/api-tokens') ? 'active' : '' }}" href="{{ url('/profile/api-tokens') }}">
                <i class="fas fa-key me-3"></i> <span>Access-API</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" href="#">
                <i class="fas fa-ban me-3"></i> <span>Disabled</span>
            </a>
        </li>
    </ul>
</div>