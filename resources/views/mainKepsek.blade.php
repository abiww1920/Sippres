<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Kepala Sekolah</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  @stack('styles')
  <style>
    /* Fix layout spacing */
    .body-wrapper {
      padding-top: 0 !important;
    }
    .container-fluid {
      padding-top: 1.5rem;
    }
    /* Ensure sidebar and header are properly positioned */
    .left-sidebar {
      top: 0 !important;
    }
    .app-header {
      top: 0 !important;
    }
  </style>
</head>
<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ route('kepsek.dashboard') }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo-saya.png') }}" alt="Logo" style="max-width: 180px; height: auto;" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Menu Utama</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('kepsek.dashboard') ? 'active' : '' }}" href="{{ route('kepsek.dashboard') }}" aria-expanded="false">
                <i class="ti ti-layout-dashboard"></i>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li>
              <span class="sidebar-divider lg"></span>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Monitoring</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('kepsek.monitoring*') ? 'active' : '' }}" href="{{ route('kepsek.monitoring') }}" aria-expanded="false">
                <i class="ti ti-eye"></i>
                <span class="hide-menu">Monitoring Pelanggaran</span>
              </a>
            </li>
            <li>
              <span class="sidebar-divider lg"></span>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">Laporan</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link {{ request()->routeIs('kepsek.laporan*') ? 'active' : '' }}" href="{{ route('kepsek.laporan') }}" aria-expanded="false">
                <i class="ti ti-file-text"></i>
                <span class="hide-menu">Laporan Pelanggaran</span>
              </a>
            </li>
            <li>
              <span class="sidebar-divider lg"></span>
            </li>
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
              <span class="hide-menu">System</span>
            </li>
            <li class="sidebar-item">
              <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <a class="sidebar-link" href="#" onclick="event.preventDefault(); this.closest('form').submit();" aria-expanded="false">
                  <i class="ti ti-logout"></i>
                  <span class="hide-menu">Logout</span>
                </a>
              </form>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
    </aside>
    
    <!-- Main wrapper -->
    <div class="body-wrapper">
      <!-- Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="{{ asset('assets/images/profile/user-1.jpg') }}" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">{{ auth()->user()->name }}</p>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-outline-primary mx-3 mt-2 d-block w-100">Logout</button>
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Header End -->
      
      @yield('content')
    </div>
  </div>

  <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
  @stack('scripts')
</body>
</html>
