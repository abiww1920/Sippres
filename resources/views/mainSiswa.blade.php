<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Siswa Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
  @stack('styles')
  <style>
    .body-wrapper {
      padding-top: 0 !important;
    }
    .container-fluid {
      padding-top: 1.5rem;
    }
    .left-sidebar {
      top: 0 !important;
    }
    .app-header {
      top: 0 !important;
    }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="{{ route('siswa.dashboard') }}" class="text-nowrap logo-img">
            <img src="{{ asset('assets/images/logos/logo-saya.png') }}" alt="Logo" style="max-width: 180px; height: auto;" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-6"></i>
          </div>
        </div>
       @include('layout.sidebarSiswa')
      </div>
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
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
                <a class="nav-link" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  @if(auth()->user()->siswa && auth()->user()->siswa->foto && file_exists(public_path('uploads/siswa/' . auth()->user()->siswa->foto)))
                    <img src="{{ asset('uploads/siswa/' . auth()->user()->siswa->foto) }}" alt="{{ auth()->user()->siswa->nama_siswa }}" width="35" height="35" class="rounded-circle">
                  @else
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                      <i class="ti ti-user text-white"></i>
                    </div>
                  @endif
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    @if(auth()->user()->siswa)
                    <div class="px-3 py-2 border-bottom">
                      <h6 class="mb-0">{{ auth()->user()->siswa->nama_siswa }}</h6>
                      <small class="text-muted">{{ auth()->user()->siswa->nis }}</small>
                    </div>
                    @endif
                    <a href="{{ route('siswa.profile') }}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">Profil Saya</p>
                    </a>
                    <a href="{{ route('siswa.dashboard') }}" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-dashboard fs-6"></i>
                      <p class="mb-0 fs-3">Dashboard</p>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="px-3 mt-2">
                      @csrf
                      <button type="submit" class="btn btn-outline-primary d-block w-100">Logout</button>
                    </form>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
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