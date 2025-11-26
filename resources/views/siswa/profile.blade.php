@extends('mainSiswa')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Profil Saya</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('siswa.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Profil</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Data Pribadi</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">NIS</label>
              <p class="form-control-plaintext">{{ $siswa->nis }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Nama Lengkap</label>
              <p class="form-control-plaintext">{{ $siswa->nama_siswa }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Kelas</label>
              <p class="form-control-plaintext">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Jurusan</label>
              <p class="form-control-plaintext">{{ $siswa->jurusan->nama_jurusan ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Jenis Kelamin</label>
              <p class="form-control-plaintext">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Status</label>
              <span class="badge bg-success">{{ ucfirst($siswa->status) }}</span>
            </div>
            @if($siswa->alamat)
            <div class="col-12 mb-3">
              <label class="form-label">Alamat</label>
              <p class="form-control-plaintext">{{ $siswa->alamat }}</p>
            </div>
            @endif
            @if($siswa->no_hp)
            <div class="col-md-6 mb-3">
              <label class="form-label">No. HP</label>
              <p class="form-control-plaintext">{{ $siswa->no_hp }}</p>
            </div>
            @endif
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Foto Profil</h5>
        </div>
        <div class="card-body text-center">
          @if($siswa->foto && file_exists(public_path('uploads/siswa/' . $siswa->foto)))
            <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="img-fluid rounded" alt="Foto {{ $siswa->nama_siswa }}" style="max-height: 300px;">
          @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
              <i class="ti ti-user fs-1 text-muted"></i>
            </div>
            <p class="text-muted mt-2 mb-0">Foto belum tersedia</p>
          @endif
        </div>
      </div>
      
      <div class="card mt-3">
        <div class="card-header">
          <h5 class="card-title mb-0">Statistik</h5>
        </div>
        <div class="card-body">
          <div class="d-flex justify-content-between mb-2">
            <span>Total Pelanggaran:</span>
            <span class="badge bg-warning">{{ $siswa->pelanggaran->count() }}</span>
          </div>
          <div class="d-flex justify-content-between">
            <span>Total Prestasi:</span>
            <span class="badge bg-success">{{ $siswa->prestasi->count() }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection