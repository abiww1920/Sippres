<aside class="left-sidebar">
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}" 
                           href="{{ route('kepsek.dashboard') }}">
                            <i class="ti ti-layout-dashboard"></i>
                            <span class="hide-menu ms-2">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.monitoring*') ? 'active' : '' }}" 
                           href="{{ route('kepsek.monitoring') }}">
                            <i class="ti ti-eye"></i>
                            <span class="hide-menu ms-2">Monitoring</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kepsek.laporan*') ? 'active' : '' }}" 
                           href="{{ route('kepsek.laporan') }}">
                            <i class="ti ti-file-text"></i>
                            <span class="hide-menu ms-2">Laporan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</aside>
