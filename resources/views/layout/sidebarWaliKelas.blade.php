<div class="scroll-sidebar">
  <nav class="sidebar-nav">
    <ul id="sidebarnav">
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Home</span>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('walikelas.dashboard') }}" aria-expanded="false">
          <span>
            <i class="ti ti-layout-dashboard"></i>
          </span>
          <span class="hide-menu">Dashboard</span>
        </a>
      </li>
      <li class="nav-small-cap">
        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
        <span class="hide-menu">Data</span>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
          <span class="d-flex">
            <i class="ti ti-alert-triangle"></i>
          </span>
          <span class="hide-menu">Pelanggaran</span>
        </a>
        <ul aria-expanded="false" class="collapse first-level">
          <li class="sidebar-item">
            <a href="{{ route('walikelas.pelanggaran.create') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Input Pelanggaran</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="{{ route('walikelas.pelanggaran') }}" class="sidebar-link">
              <div class="round-16 d-flex align-items-center justify-content-center">
                <i class="ti ti-circle"></i>
              </div>
              <span class="hide-menu">Data Pelanggaran</span>
            </a>
          </li>
        </ul>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('walikelas.sanksi') }}" aria-expanded="false">
          <span>
            <i class="ti ti-shield-check"></i>
          </span>
          <span class="hide-menu">Monitoring Sanksi</span>
        </a>
      </li>
      <li class="sidebar-item">
        <a class="sidebar-link" href="{{ route('walikelas.laporan') }}" aria-expanded="false">
          <span>
            <i class="ti ti-file-text"></i>
          </span>
          <span class="hide-menu">Laporan</span>
        </a>
      </li>
    </ul>
  </nav>
</div>