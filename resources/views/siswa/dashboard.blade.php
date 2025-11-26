@extends('mainSiswa')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Dashboard Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="#">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
      </ol>
    </nav>
  </div>

  @if($siswa)
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              @if($siswa->foto)
                <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="rounded-circle" width="60" height="60" alt="Foto">
              @else
                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                  <i class="ti ti-user text-white fs-4"></i>
                </div>
              @endif
            </div>
            <div>
              <h5 class="mb-1">{{ $siswa->nama_siswa }}</h5>
              <p class="text-muted mb-0">{{ $siswa->nis }} - {{ $siswa->kelas->nama_kelas ?? '' }} {{ $siswa->jurusan->nama_jurusan ?? '' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endif

  <div class="row">
    <div class="col-lg-6 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="ti ti-alert-triangle fs-1 text-warning"></i>
            </div>
            <div>
              <h5 class="card-title mb-0">{{ $totalPelanggaran }}</h5>
              <p class="card-text text-muted">Total Pelanggaran</p>
              <a href="{{ route('siswa.pelanggaran') }}" class="btn btn-sm btn-outline-warning">Lihat Detail</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-6 col-md-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="me-3">
              <i class="ti ti-trophy fs-1 text-success"></i>
            </div>
            <div>
              <h5 class="card-title mb-0">{{ $totalPrestasi }}</h5>
              <p class="card-text text-muted">Total Prestasi</p>
              <a href="{{ route('siswa.prestasi') }}" class="btn btn-sm btn-outline-success">Lihat Detail</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection