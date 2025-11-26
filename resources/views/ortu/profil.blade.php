@extends('mainOrtu')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Profil Anak</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('ortu.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Profil Anak</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Data Siswa</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">NIS</label>
              <p class="fs-4">{{ $siswa->nis }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">Nama Lengkap</label>
              <p class="fs-4">{{ $siswa->nama_siswa }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">Kelas</label>
              <p class="fs-4">{{ $siswa->kelas->nama_kelas }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">Jurusan</label>
              <p class="fs-4">{{ $siswa->jurusan->nama_jurusan ?? '-' }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">Jenis Kelamin</label>
              <p class="fs-4">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">No HP</label>
              <p class="fs-4">{{ $siswa->no_hp ?? '-' }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12 mb-3">
              <label class="fw-semibold text-muted mb-1">Alamat</label>
              <p class="fs-4">{{ $siswa->alamat ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Data Orang Tua</h5>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">Nama Orang Tua</label>
              <p class="fs-4">{{ $siswa->nama_ortu ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="fw-semibold text-muted mb-1">No HP Orang Tua</label>
              <p class="fs-4">{{ $siswa->no_hp_ortu ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="card-title fw-semibold mb-4">Foto Siswa</h5>
          @if($siswa->foto && file_exists(public_path('uploads/siswa/' . $siswa->foto)))
            <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="img-fluid rounded" style="max-width: 100%;">
          @else
            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="img-fluid rounded" style="max-width: 100%;">
          @endif
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Statistik</h5>
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex align-items-center">
              <div class="btn btn-danger rounded-circle round-40 hstack justify-content-center">
                <i class="ti ti-alert-triangle fs-5"></i>
              </div>
              <div class="ms-3">
                <h6 class="mb-0 fw-bolder">Total Pelanggaran</h6>
                <span class="text-muted fs-3">{{ $totalPelanggaran }} Kasus</span>
              </div>
            </div>
          </div>
          <div class="mb-3 pb-3 border-bottom">
            <div class="d-flex align-items-center">
              <div class="btn btn-success rounded-circle round-40 hstack justify-content-center">
                <i class="ti ti-trophy fs-5"></i>
              </div>
              <div class="ms-3">
                <h6 class="mb-0 fw-bolder">Total Prestasi</h6>
                <span class="text-muted fs-3">{{ $totalPrestasi }} Prestasi</span>
              </div>
            </div>
          </div>
          <div class="mb-0">
            <div class="d-flex align-items-center">
              <div class="btn btn-warning rounded-circle round-40 hstack justify-content-center">
                <i class="ti ti-star fs-5"></i>
              </div>
              <div class="ms-3">
                <h6 class="mb-0 fw-bolder">Total Poin</h6>
                <span class="text-muted fs-3">{{ $totalPoin }} Poin</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
