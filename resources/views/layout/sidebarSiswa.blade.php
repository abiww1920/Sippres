<!-- Sidebar navigation-->
<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
  <ul id="sidebarnav">
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Dashboard</span>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('siswa.dashboard') }}" aria-expanded="false">
        <i class="ti ti-layout-dashboard"></i>
        <span class="hide-menu">Dashboard</span>
      </a>
    </li>

    <li>
      <span class="sidebar-divider lg"></span>
    </li>
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Data</span>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('siswa.profile') }}" aria-expanded="false">
        <i class="ti ti-user"></i>
        <span class="hide-menu">Profil Saya</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('siswa.pelanggaran') }}" aria-expanded="false">
        <i class="ti ti-alert-triangle"></i>
        <span class="hide-menu">Riwayat Pelanggaran</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('siswa.prestasi') }}" aria-expanded="false">
        <i class="ti ti-trophy"></i>
        <span class="hide-menu">Riwayat Prestasi</span>
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
      <a class="sidebar-link" href="{{ route('siswa.laporan') }}" aria-expanded="false">
        <i class="ti ti-file-download"></i>
        <span class="hide-menu">Generate Laporan</span>
      </a>
    </li>

    <li>
      <span class="sidebar-divider lg"></span>
    </li>
    
    <li class="sidebar-item">
      <form action="{{ route('logout') }}" method="POST" id="logout-form">
        @csrf
        <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
          <i class="ti ti-logout"></i>
          <span class="hide-menu">Logout</span>
        </a>
      </form>
    </li>
  </ul>
</nav>
<!-- End Sidebar navigation -->
