@extends('mainKonselor')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Detail Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.siswa.index') }}">Daftar Siswa</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Detail</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <div class="mb-4">
            <h5 class="fw-semibold">Informasi Pribadi</h5>
            <div class="row mt-3">
              <div class="col-md-6">
                <p class="text-muted mb-1">Nama Siswa</p>
                <p class="fw-semibold">{{ $siswa->nama_siswa }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1">NIS</p>
                <p class="fw-semibold">{{ $siswa->nis }}</p>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">
                <p class="text-muted mb-1">Email</p>
                <p class="fw-semibold">{{ $siswa->email ?? '-' }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1">No. Telepon</p>
                <p class="fw-semibold">{{ $siswa->no_telepon ?? '-' }}</p>
              </div>
            </div>
          </div>

          <hr>

          <div class="mb-4">
            <h5 class="fw-semibold">Informasi Akademik</h5>
            <div class="row mt-3">
              <div class="col-md-6">
                <p class="text-muted mb-1">Kelas</p>
                <p class="fw-semibold">{{ $siswa->kelas->nama_kelas ?? '-' }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1">Jurusan</p>
                <p class="fw-semibold">{{ $siswa->jurusan->nama_jurusan ?? '-' }}</p>
              </div>
            </div>
          </div>

          <hr>

          <div class="mb-4">
            <h5 class="fw-semibold">Riwayat Bimbingan</h5>
            <div class="table-responsive mt-3">
              <table class="table table-sm">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Topik</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($siswa->bimbinganKonseling ?? [] as $bimbingan)
                  <tr>
                    <td>{{ $bimbingan->tanggal ? $bimbingan->tanggal->format('d/m/Y') : '-' }}</td>
                    <td>{{ $bimbingan->topik ?? '-' }}</td>
                    <td>
                      @if($bimbingan->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                      @elseif($bimbingan->status == 'proses')
                        <span class="badge bg-warning">Proses</span>
                      @else
                        <span class="badge bg-info">Terjadwal</span>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="3" class="text-center text-muted">Tidak ada riwayat bimbingan</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>

          <a href="{{ route('konselor.siswa.index') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
