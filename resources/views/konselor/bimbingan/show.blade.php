@extends('mainKonselor')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Detail Bimbingan Konseling</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.bimbingan.index') }}">Data Bimbingan</a>
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
            <h5 class="fw-semibold">Informasi Siswa</h5>
            <div class="row mt-3">
              <div class="col-md-6">
                <p class="text-muted mb-1">Nama Siswa</p>
                <p class="fw-semibold">{{ $bimbingan->siswa->nama_siswa ?? '-' }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1">Kelas</p>
                <p class="fw-semibold">{{ $bimbingan->siswa->kelas->nama_kelas ?? '-' }}</p>
              </div>
            </div>
          </div>

          <hr>

          <div class="mb-4">
            <h5 class="fw-semibold">Informasi Bimbingan</h5>
            <div class="row mt-3">
              <div class="col-md-6">
                <p class="text-muted mb-1">Topik</p>
                <p class="fw-semibold">{{ $bimbingan->topik ?? '-' }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1">Tanggal</p>
                <p class="fw-semibold">{{ $bimbingan->tanggal ? $bimbingan->tanggal->format('d/m/Y') : '-' }}</p>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-6">
                <p class="text-muted mb-1">Waktu</p>
                <p class="fw-semibold">{{ $bimbingan->waktu ?? '-' }}</p>
              </div>
              <div class="col-md-6">
                <p class="text-muted mb-1">Status</p>
                <p>
                  @if($bimbingan->status == 'selesai')
                    <span class="badge bg-success">Selesai</span>
                  @elseif($bimbingan->status == 'proses')
                    <span class="badge bg-warning">Proses</span>
                  @else
                    <span class="badge bg-info">Terjadwal</span>
                  @endif
                </p>
              </div>
            </div>
          </div>

          <hr>

          <div class="mb-4">
            <h5 class="fw-semibold">Deskripsi</h5>
            <p class="mt-3">{{ $bimbingan->deskripsi ?? '-' }}</p>
          </div>

          <div class="d-flex gap-2">
            <a href="{{ route('konselor.bimbingan.edit', $bimbingan->id) }}" class="btn btn-warning">
              <i class="ti ti-pencil"></i> Edit
            </a>
            <form action="{{ route('konselor.bimbingan.destroy', $bimbingan->id) }}" method="POST" style="display:inline;">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                <i class="ti ti-trash"></i> Hapus
              </button>
            </form>
            <a href="{{ route('konselor.bimbingan.index') }}" class="btn btn-secondary">
              <i class="ti ti-arrow-left"></i> Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
