@extends('mainKesiswaan')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Dashboard Kesiswaan</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="#">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="ti ti-users fs-1 text-primary"></i>
            </div>
            <div>
              <h5 class="card-title mb-0">{{ $totalSiswa }}</h5>
              <p class="card-text text-muted">Total Siswa</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="ti ti-school fs-1 text-success"></i>
            </div>
            <div>
              <h5 class="card-title mb-0">{{ $totalKelas }}</h5>
              <p class="card-text text-muted">Total Kelas</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="ti ti-user-check fs-1 text-info"></i>
            </div>
            <div>
              <h5 class="card-title mb-0">{{ $siswaAktif }}</h5>
              <p class="card-text text-muted">Siswa Aktif</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="ti ti-alert-triangle fs-1 text-warning"></i>
            </div>
            <div>
              <h5 class="card-title mb-0">{{ $totalPelanggaran }}</h5>
              <p class="card-text text-muted">Total Pelanggaran</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection