<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
  <ul id="sidebarnav">
    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Menu Guru</span>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('guru.dashboard') }}" aria-expanded="false">
        <span>
          <i class="ti ti-layout-dashboard"></i>
        </span>
        <span class="hide-menu">Dashboard</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('guru.pelanggaran') }}" aria-expanded="false">
        <span>
          <i class="ti ti-alert-circle"></i>
        </span>
        <span class="hide-menu">Input Pelanggaran</span>
      </a>
    </li>
    <li class="sidebar-item">
      <a class="sidebar-link" href="{{ route('guru.siswa') }}" aria-expanded="false">
        <span>
          <i class="ti ti-users"></i>
        </span>
        <span class="hide-menu">Data Siswa</span>
      </a>
    </li>
    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Akun</span>
    </li>
    <li class="sidebar-item">
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="sidebar-link border-0 bg-transparent w-100 text-start">
          <span>
            <i class="ti ti-logout"></i>
          </span>
          <span class="hide-menu">Logout</span>
        </button>
      </form>
    </li>
  </ul>
</nav>
