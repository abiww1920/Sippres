<!-- Sidebar navigation-->
<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
  <ul id="sidebarnav">
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Dashboard</span>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false">
        <i class="ti ti-layout-dashboard"></i>
        <span class="hide-menu">Dashboard</span>
      </a>
    </li>

    <li>
      <span class="sidebar-divider lg"></span>
    </li>
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Data Management</span>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.pelanggaran') }}" aria-expanded="false">
        <i class="ti ti-alert-triangle"></i>
        <span class="hide-menu">Data Pelanggaran</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.kategori-pelanggaran') }}" aria-expanded="false">
        <i class="ti ti-category"></i>
        <span class="hide-menu">Kategori Pelanggaran</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.prestasi') }}" aria-expanded="false">
        <i class="ti ti-trophy"></i>
        <span class="hide-menu">Data Prestasi</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.guru') }}" aria-expanded="false">
        <i class="ti ti-school"></i>
        <span class="hide-menu">Data Guru</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.siswa') }}" aria-expanded="false">
        <i class="ti ti-users"></i>
        <span class="hide-menu">Data Siswa</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.users') }}" aria-expanded="false">
        <i class="ti ti-user-cog"></i>
        <span class="hide-menu">Kelola User</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.sanksi') }}" aria-expanded="false">
        <i class="ti ti-gavel"></i>
        <span class="hide-menu">Kelola Sanksi</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.tahun-ajaran') }}" aria-expanded="false">
        <i class="ti ti-calendar"></i>
        <span class="hide-menu">Tahun Ajaran</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.kelas') }}" aria-expanded="false">
        <i class="ti ti-building"></i>
        <span class="hide-menu">Kelola Kelas</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.jurusan') }}" aria-expanded="false">
        <i class="ti ti-book"></i>
        <span class="hide-menu">Kelola Jurusan</span>
      </a>
    </li>

    <li>
      <span class="sidebar-divider lg"></span>
    </li>
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Laporan & Notifikasi</span>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('admin.laporan') }}" aria-expanded="false">
        <i class="ti ti-file-text"></i>
        <span class="hide-menu">Laporan</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('notifications.index') }}" aria-expanded="false">
        <i class="ti ti-bell"></i>
        <span class="hide-menu">Notifikasi</span>
        @php
          $unreadCount = auth()->user()->unreadNotifications()->count();
        @endphp
        @if($unreadCount > 0)
        <span class="badge bg-danger rounded-pill ms-auto">{{ $unreadCount }}</span>
        @endif
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