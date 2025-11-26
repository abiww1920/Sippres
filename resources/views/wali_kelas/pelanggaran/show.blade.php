@extends('mainWaliKelas')
@section('content')
<div class="container-fluid">
  <div class="mb-4 d-flex align-items-center justify-content-between">
    <div>
      <h4 class="fw-semibold mb-2">Detail Pelanggaran</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a class="text-muted text-decoration-none" href="{{ route('walikelas.dashboard') }}">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a class="text-muted text-decoration-none" href="{{ route('walikelas.pelanggaran') }}">Pelanggaran</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">Detail</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex gap-2">
      <button onclick="window.print()" class="btn btn-secondary">
        <i class="ti ti-printer fs-4"></i> Print
      </button>
      <a href="{{ route('walikelas.pelanggaran') }}" class="btn btn-primary">
        <i class="ti ti-arrow-left fs-4"></i> Kembali
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <!-- Informasi Pelanggaran -->
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">Informasi Pelanggaran</h5>
        </div>
        <div class="card-body">
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">Nama Siswa</label>
              <p class="fs-4">{{ $pelanggaran->siswa->nama_siswa }}</p>
            </div>
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">NIS</label>
              <p class="fs-4">{{ $pelanggaran->siswa->nis }}</p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">Kelas</label>
              <p class="fs-4">{{ $pelanggaran->siswa->kelas->nama_kelas }}</p>
            </div>
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">Jenis Pelanggaran</label>
              <p class="fs-4">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">Kategori</label>
              <p class="fs-4">
                @if($pelanggaran->jenisPelanggaran->kategori == 'ringan')
                  <span class="badge bg-info-subtle text-info">Ringan</span>
                @elseif($pelanggaran->jenisPelanggaran->kategori == 'sedang')
                  <span class="badge bg-warning-subtle text-warning">Sedang</span>
                @elseif($pelanggaran->jenisPelanggaran->kategori == 'berat')
                  <span class="badge bg-danger-subtle text-danger">Berat</span>
                @else
                  <span class="badge bg-dark-subtle text-dark">Sangat Berat</span>
                @endif
              </p>
            </div>
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">Poin Pelanggaran</label>
              <p class="fs-4"><span class="badge bg-danger fs-4">{{ $pelanggaran->poin }} Poin</span></p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">Tanggal Pelanggaran</label>
              <p class="fs-4">{{ $pelanggaran->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <div class="col-md-6">
              <label class="fw-semibold text-muted mb-1">Status Verifikasi</label>
              <p class="fs-4">
                @if($pelanggaran->status_verifikasi == 'menunggu')
                  <span class="badge bg-warning-subtle text-warning">Menunggu Verifikasi</span>
                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                  <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                @elseif($pelanggaran->status_verifikasi == 'ditolak')
                  <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                @else
                  <span class="badge bg-info-subtle text-info">Revisi</span>
                @endif
              </p>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-12">
              <label class="fw-semibold text-muted mb-1">Guru Pencatat</label>
              <p class="fs-4">{{ $pelanggaran->guruPencatat->nama_guru }}</p>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <label class="fw-semibold text-muted mb-1">Deskripsi Pelanggaran</label>
              <p class="fs-4">{{ $pelanggaran->keterangan }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Sanksi Rekomendasi -->
      <div class="card mt-3">
        <div class="card-header bg-warning text-dark">
          <h5 class="mb-0">Sanksi Rekomendasi</h5>
        </div>
        <div class="card-body">
          <p class="mb-2"><strong>Berdasarkan poin pelanggaran ({{ $pelanggaran->poin }} poin), sanksi yang direkomendasikan:</strong></p>
          @if($pelanggaran->poin >= 1 && $pelanggaran->poin <= 15)
            <div class="alert alert-info mb-0">
              <i class="ti ti-info-circle me-2"></i>
              <strong>Sanksi Ringan:</strong> Teguran Lisan atau sejenisnya (Durasi: 1 hari)
            </div>
          @elseif($pelanggaran->poin >= 16 && $pelanggaran->poin <= 30)
            <div class="alert alert-warning mb-0">
              <i class="ti ti-alert-triangle me-2"></i>
              <strong>Sanksi Sedang:</strong> Teguran Tertulis, Kerja Sosial, atau sejenisnya (Durasi: 3 hari)
            </div>
          @elseif($pelanggaran->poin >= 31 && $pelanggaran->poin <= 50)
            <div class="alert alert-danger mb-0">
              <i class="ti ti-alert-circle me-2"></i>
              <strong>Sanksi Berat:</strong> Skorsing atau sejenisnya (Durasi: 5 hari)
            </div>
          @else
            <div class="alert alert-dark mb-0">
              <i class="ti ti-ban me-2"></i>
              <strong>Sanksi Sangat Berat:</strong> Skorsing Berat, Kemungkinan DO, atau sejenisnya (Durasi: 7 hari)
            </div>
          @endif
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Foto Siswa -->
      <div class="card">
        <div class="card-header bg-light">
          <h5 class="mb-0">Foto Siswa</h5>
        </div>
        <div class="card-body text-center">
          @if($pelanggaran->siswa->foto && file_exists(public_path('uploads/siswa/' . $pelanggaran->siswa->foto)))
            <img src="{{ asset('uploads/siswa/' . $pelanggaran->siswa->foto) }}" class="img-fluid rounded" style="max-width: 100%; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/siswa/' . $pelanggaran->siswa->foto) }}', '{{ $pelanggaran->siswa->nama_siswa }}')">
          @else
            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="img-fluid rounded" style="max-width: 100%;">
          @endif
          <p class="mt-3 mb-0 fw-semibold">{{ $pelanggaran->siswa->nama_siswa }}</p>
          <p class="text-muted">{{ $pelanggaran->siswa->nis }}</p>
        </div>
      </div>

      <!-- Foto Bukti Pelanggaran -->
      @if($pelanggaran->foto_bukti && file_exists(public_path('uploads/pelanggaran/' . $pelanggaran->foto_bukti)))
      <div class="card mt-3">
        <div class="card-header bg-light">
          <h5 class="mb-0">Foto Bukti Pelanggaran</h5>
        </div>
        <div class="card-body text-center">
          <img src="{{ asset('uploads/pelanggaran/' . $pelanggaran->foto_bukti) }}" class="img-fluid rounded" style="max-width: 100%; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/pelanggaran/' . $pelanggaran->foto_bukti) }}', 'Foto Bukti Pelanggaran')">
          <p class="mt-2 mb-0 text-muted small">Klik foto untuk memperbesar</p>
        </div>
      </div>
      @endif
    </div>
  </div>
</div>

<!-- Modal Photo Viewer -->
<div class="modal fade" id="modalPhotoViewer" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalTitle">Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="photoModalImage" src="" class="img-fluid rounded" style="max-height: 500px;">
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function showPhotoModal(photoUrl, title) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = title;
    new bootstrap.Modal(document.getElementById('modalPhotoViewer')).show();
}
</script>
@endpush

@endsection