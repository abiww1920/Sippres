<!-- Sidebar navigation-->
<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
  <ul id="sidebarnav">
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Dashboard</span>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('kesiswaan.dashboard') }}" aria-expanded="false">
        <i class="ti ti-layout-dashboard"></i>
        <span class="hide-menu">Dashboard</span>
      </a>
    </li>

    <li>
      <span class="sidebar-divider lg"></span>
    </li>
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Data Siswa</span>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('kesiswaan.pelanggaran') }}" aria-expanded="false">
        <i class="ti ti-alert-triangle"></i>
        <span class="hide-menu">Data Pelanggaran</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('kesiswaan.prestasi') }}" aria-expanded="false">
        <i class="ti ti-trophy"></i>
        <span class="hide-menu">Data Prestasi</span>
      </a>
    </li>

    <li>
      <span class="sidebar-divider lg"></span>
    </li>
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Verifikasi & Monitoring</span>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('kesiswaan.verifikasi') }}" aria-expanded="false">
        <i class="ti ti-checkbox"></i>
        <span class="hide-menu">Verifikasi Data</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('kesiswaan.monitoring') }}" aria-expanded="false">
        <i class="ti ti-eye"></i>
        <span class="hide-menu">Monitoring</span>
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
      <a class="sidebar-link" href="{{ route('kesiswaan.laporan') }}" aria-expanded="false">
        <i class="ti ti-file-download"></i>
        <span class="hide-menu">Generate Laporan</span>
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
      <a class="sidebar-link" href="#" aria-expanded="false">
        <i class="ti ti-settings"></i>
        <span class="hide-menu">Pengaturan</span>
      </a>
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