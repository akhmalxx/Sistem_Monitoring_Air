<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ url('/dashboard') }}">Sistem Monitoring Air</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('/dashboard') }}">=</a>
        </div>

        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="{{ Request::is('dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/dashboard') }}">
                    <i class="fas fa-home"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('water-usage*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/water-usage') }}">
                    <i class="fas fa-water"></i> <span>Pemakaian & Tagihan</span>
                </a>
            </li>

            {{-- Admin Dashboard --}}
            <li class="{{ Request::is('admin-dashboard*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/admin-dashboard') }}">
                    <i class="fas fa-users-cog"></i> <span>Admin Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('water-usage*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/water-usage') }}">
                    <i class="fas fa-chart-line"></i> <span>Monitoring Device</span>
                </a>
            </li>

            {{-- SU --}}
            <li class="{{ Request::is('user-management*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ url('/user-management') }}">
                    <i class="fas fa-users-cog"></i> <span>User Management</span>
                </a>
            </li>
        </ul>
    </aside>
</div>
