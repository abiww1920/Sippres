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
    <!-- Foto Profil -->
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
    </div>
    
    <!-- Data Pribadi -->
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">A. Data Pribadi</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">NIS</label>
              <p class="form-control-plaintext">{{ $siswa->nis }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nama Lengkap</label>
              <p class="form-control-plaintext">{{ $siswa->nama_siswa }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Email</label>
              <p class="form-control-plaintext">{{ $siswa->email ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nomor HP</label>
              <p class="form-control-plaintext">{{ $siswa->no_hp ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Kelas</label>
              <p class="form-control-plaintext">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Jurusan</label>
              <p class="form-control-plaintext">{{ $siswa->jurusan->nama_jurusan ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Jenis Kelamin</label>
              <p class="form-control-plaintext">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Status</label>
              <span class="badge bg-success">{{ ucfirst($siswa->status) }}</span>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label fw-semibold">Alamat Lengkap</label>
              <p class="form-control-plaintext">{{ $siswa->alamat ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nama Orang Tua</label>
              <p class="form-control-plaintext">{{ $siswa->nama_ortu ?? '-' }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nomor HP Orang Tua</label>
              <p class="form-control-plaintext">{{ $siswa->no_hp_ortu ?? '-' }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Ringkasan Poin -->
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">B. Ringkasan Poin</h5>
        </div>
        <div class="card-body">
          @php
            $totalPoinPelanggaran = $siswa->pelanggaran->where('status_verifikasi', 'diverifikasi')->sum(function($p) {
              return $p->jenisPelanggaran->poin ?? 0;
            });
            $totalPoinPrestasi = $siswa->prestasi->sum('poin');
            $poinBersih = $totalPoinPrestasi - $totalPoinPelanggaran;
            
            // Tentukan status berdasarkan poin bersih
            if ($poinBersih >= 50) {
              $status = 'Baik';
              $statusClass = 'success';
              $statusIcon = 'ti-check-circle';
            } elseif ($poinBersih >= 0) {
              $status = 'Perhatian';
              $statusClass = 'warning';
              $statusIcon = 'ti-alert-triangle';
            } else {
              $status = 'Bermasalah';
              $statusClass = 'danger';
              $statusIcon = 'ti-alert-circle';
            }
          @endphp
          
          <div class="row">
            <div class="col-md-3">
              <div class="card bg-danger-subtle border-0">
                <div class="card-body text-center">
                  <i class="ti ti-alert-circle fs-1 text-danger mb-2"></i>
                  <h4 class="fw-semibold text-danger">{{ $totalPoinPelanggaran }}</h4>
                  <p class="mb-0 text-danger">Total Poin Pelanggaran</p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card bg-success-subtle border-0">
                <div class="card-body text-center">
                  <i class="ti ti-trophy fs-1 text-success mb-2"></i>
                  <h4 class="fw-semibold text-success">{{ $totalPoinPrestasi }}</h4>
                  <p class="mb-0 text-success">Total Poin Prestasi</p>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card bg-info-subtle border-0">
                <div class="card-body text-center">
                  <i class="ti ti-calculator fs-1 text-info mb-2"></i>
                  <h4 class="fw-semibold text-info">{{ $poinBersih }}</h4>
                  <p class="mb-0 text-info">Poin Bersih</p>
                  <small class="text-muted">(Prestasi - Pelanggaran)</small>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card bg-{{ $statusClass }}-subtle border-0">
                <div class="card-body text-center">
                  <i class="{{ $statusIcon }} fs-1 text-{{ $statusClass }} mb-2"></i>
                  <h4 class="fw-semibold text-{{ $statusClass }}">{{ $status }}</h4>
                  <p class="mb-0 text-{{ $statusClass }}">Status Siswa</p>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Progress Bar Poin -->
          <div class="mt-4">
            <h6 class="fw-semibold mb-3">Indikator Status:</h6>
            <div class="d-flex align-items-center mb-2">
              <div class="badge bg-success me-2">Baik</div>
              <span class="text-muted">Poin Bersih ≥ 50</span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <div class="badge bg-warning me-2">Perhatian</div>
              <span class="text-muted">Poin Bersih 0 - 49</span>
            </div>
            <div class="d-flex align-items-center">
              <div class="badge bg-danger me-2">Bermasalah</div>
              <span class="text-muted">Poin Bersih < 0</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Riwayat Singkat -->
  <div class="row mt-4">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Riwayat Pelanggaran Terbaru</h5>
        </div>
        <div class="card-body">
          @forelse($siswa->pelanggaran->take(5) as $pelanggaran)
            <div class="d-flex align-items-center mb-3">
              <div class="badge bg-danger me-3">{{ $pelanggaran->jenisPelanggaran->poin ?? 0 }}</div>
              <div>
                <h6 class="mb-1">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</h6>
                <small class="text-muted">{{ $pelanggaran->created_at->format('d/m/Y') }}</small>
              </div>
            </div>
          @empty
            <p class="text-muted text-center">Tidak ada pelanggaran</p>
          @endforelse
        </div>
      </div>
    </div>
    
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Riwayat Prestasi Terbaru</h5>
        </div>
        <div class="card-body">
          @forelse($siswa->prestasi->take(5) as $prestasi)
            <div class="d-flex align-items-center mb-3">
              <div class="badge bg-success me-3">{{ $prestasi->poin ?? 0 }}</div>
              <div>
                <h6 class="mb-1">{{ $prestasi->nama_prestasi }}</h6>
                <small class="text-muted">{{ $prestasi->tingkat }} - {{ $prestasi->juara }}</small>
              </div>
            </div>
          @empty
            <p class="text-muted text-center">Tidak ada prestasi</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection