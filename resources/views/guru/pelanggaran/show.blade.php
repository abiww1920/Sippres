@extends('mainGuru')
@section('content')
<div class="container-fluid">
  <div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
      <h4 class="fw-semibold mb-2">Detail Pelanggaran</h4>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">
            <a class="text-muted text-decoration-none" href="{{ route('guru.dashboard') }}">Home</a>
          </li>
          <li class="breadcrumb-item">
            <a class="text-muted text-decoration-none" href="{{ route('guru.pelanggaran') }}">Data Pelanggaran</a>
          </li>
          <li class="breadcrumb-item" aria-current="page">Detail</li>
        </ol>
      </nav>
    </div>
    <div class="d-flex gap-2">
      <button onclick="window.print()" class="btn btn-info">
        <i class="ti ti-printer"></i> Print
      </button>
      <a href="{{ route('guru.pelanggaran') }}" class="btn btn-primary">
        <i class="ti ti-arrow-left"></i> Kembali
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Informasi Pelanggaran</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Nama Siswa</label>
              <p class="form-control-plaintext">{{ $pelanggaran->siswa->nama_siswa }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">NIS</label>
              <p class="form-control-plaintext">{{ $pelanggaran->siswa->nis }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Kelas</label>
              <p class="form-control-plaintext">{{ $pelanggaran->siswa->kelas->nama_kelas }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Jenis Pelanggaran</label>
              <p class="form-control-plaintext">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Kategori</label>
              @php
                $kategori = $pelanggaran->jenisPelanggaran->kategori;
                $badgeClass = match($kategori) {
                  'ringan' => 'bg-success',
                  'sedang' => 'bg-warning',
                  'berat' => 'bg-danger',
                  'sangat_berat' => 'bg-primary',
                  default => 'bg-secondary'
                };
              @endphp
              <p><span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $kategori)) }}</span></p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Poin</label>
              <p class="form-control-plaintext"><span class="badge bg-danger fs-5">{{ $pelanggaran->poin }} Poin</span></p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Status Verifikasi</label>
              <p>
                @if($pelanggaran->status_verifikasi == 'menunggu')
                  <span class="badge bg-warning">Menunggu</span>
                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                  <span class="badge bg-success">Diverifikasi</span>
                @elseif($pelanggaran->status_verifikasi == 'ditolak')
                  <span class="badge bg-danger">Ditolak</span>
                @else
                  <span class="badge bg-info">Revisi</span>
                @endif
              </p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Tanggal Pelanggaran</label>
              <p class="form-control-plaintext">{{ $pelanggaran->created_at->format('d F Y, H:i') }} WIB</p>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label fw-semibold">Guru Pencatat</label>
              <p class="form-control-plaintext">{{ $pelanggaran->guruPencatat->nama_guru ?? '-' }}</p>
            </div>
            <div class="col-12 mb-3">
              <label class="form-label fw-semibold">Keterangan/Kronologi</label>
              <div class="border rounded p-3 bg-light">
                <p class="mb-0">{{ $pelanggaran->keterangan }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card mt-3">
        <div class="card-header">
          <h5 class="card-title mb-0">Sanksi Rekomendasi</h5>
        </div>
        <div class="card-body">
          <p class="mb-0">{{ $pelanggaran->jenisPelanggaran->sanksi_rekomendasi }}</p>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Foto Siswa</h5>
        </div>
        <div class="card-body text-center">
          @if($pelanggaran->siswa->foto && file_exists(public_path('uploads/siswa/' . $pelanggaran->siswa->foto)))
            <img src="{{ asset('uploads/siswa/' . $pelanggaran->siswa->foto) }}" 
                 class="img-fluid rounded" 
                 alt="Foto {{ $pelanggaran->siswa->nama_siswa }}" 
                 style="max-height: 300px;">
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
          <h5 class="card-title mb-0">Foto Bukti Pelanggaran</h5>
        </div>
        <div class="card-body text-center">
          @if($pelanggaran->foto_bukti && file_exists(public_path('uploads/pelanggaran/' . $pelanggaran->foto_bukti)))
            <img src="{{ asset('uploads/pelanggaran/' . $pelanggaran->foto_bukti) }}" 
                 class="img-fluid rounded border border-danger" 
                 alt="Bukti Pelanggaran" 
                 style="max-height: 300px; cursor: pointer;"
                 onclick="showFullImage('{{ asset('uploads/pelanggaran/' . $pelanggaran->foto_bukti) }}')">
            <p class="text-muted mt-2 mb-0"><small>Klik foto untuk memperbesar</small></p>
          @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
              <i class="ti ti-photo-off fs-1 text-muted"></i>
            </div>
            <p class="text-muted mt-2 mb-0">Foto bukti tidak tersedia</p>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalFullImage" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Foto Bukti Pelanggaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="fullImage" src="" class="img-fluid" alt="Foto Bukti">
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function showFullImage(imageUrl) {
    document.getElementById('fullImage').src = imageUrl;
    new bootstrap.Modal(document.getElementById('modalFullImage')).show();
}
</script>
@endpush
@endsection
