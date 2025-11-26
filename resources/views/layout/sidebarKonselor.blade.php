<!-- Sidebar navigation-->
<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
  <ul id="sidebarnav">
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Dashboard</span>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('konselor.dashboard') }}" aria-expanded="false">
        <i class="ti ti-layout-dashboard"></i>
        <span class="hide-menu">Dashboard</span>
      </a>
    </li>

    <li>
      <span class="sidebar-divider lg"></span>
    </li>
    <li class="nav-small-cap">
      <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4"></iconify-icon>
      <span class="hide-menu">Bimbingan Konseling</span>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('konselor.bimbingan.index') }}" aria-expanded="false">
        <i class="ti ti-file-text"></i>
        <span class="hide-menu">Data Bimbingan</span>
      </a>
    </li>
    
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('konselor.bimbingan.create') }}" aria-expanded="false">
        <i class="ti ti-plus"></i>
        <span class="hide-menu">Input Bimbingan</span>
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
      <a class="sidebar-link" href="{{ route('konselor.laporan.index') }}" aria-expanded="false">
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
