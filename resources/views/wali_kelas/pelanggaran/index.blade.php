@extends('mainWaliKelas')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Pelanggaran</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('walikelas.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Pelanggaran</li>
      </ol>
    </nav>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="ti ti-check-circle fs-4 me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0">Data Pelanggaran Siswa</h5>
        <a href="{{ route('walikelas.pelanggaran.create') }}" class="btn btn-primary">
          <i class="ti ti-plus fs-4"></i> Tambah Pelanggaran
        </a>
      </div>

      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Foto Bukti</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($pelanggaran as $index => $p)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->firstItem() + $index }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  @if($p->siswa->foto && file_exists(public_path('uploads/siswa/' . $p->siswa->foto)))
                    <img src="{{ asset('uploads/siswa/' . $p->siswa->foto) }}" class="rounded-circle foto-siswa" width="40" height="40" style="object-fit: cover; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/siswa/' . $p->siswa->foto) }}', '{{ $p->siswa->nama_siswa }}')">
                  @else
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @endif
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $p->siswa->nama_siswa }}</h6>
                    <span class="fw-normal">NIS: {{ $p->siswa->nis }}</span>
                  </div>
                </div>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->siswa->kelas->nama_kelas }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->jenisPelanggaran->nama_pelanggaran }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->created_at->format('d M Y') }}</p></td>
              <td>
                @if($p->foto_bukti && file_exists(public_path('uploads/pelanggaran/' . $p->foto_bukti)))
                  <img src="{{ asset('uploads/pelanggaran/' . $p->foto_bukti) }}" class="rounded foto-bukti" width="40" height="40" style="object-fit: cover; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/pelanggaran/' . $p->foto_bukti) }}', 'Foto Bukti Pelanggaran')">
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td>
                @if($p->status_verifikasi == 'menunggu')
                  <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                @elseif($p->status_verifikasi == 'diverifikasi')
                  <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                @elseif($p->status_verifikasi == 'ditolak')
                  <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                @else
                  <span class="badge bg-info-subtle text-info">Revisi</span>
                @endif
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->poin }}</p></td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('walikelas.pelanggaran.show', $p->id) }}"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="9" class="text-center py-4">
                <span class="text-muted">Tidak ada data pelanggaran</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $pelanggaran->firstItem() ?? 0 }}-{{ $pelanggaran->lastItem() ?? 0 }} dari {{ $pelanggaran->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($pelanggaran->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $pelanggaran->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($pelanggaran->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
              @if ($page == $pelanggaran->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($pelanggaran->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $pelanggaran->nextPageUrl() }}">Next</a>
              </li>
            @else
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Next</a>
              </li>
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Modal Photo Viewer -->
<div class="modal fade" id="modalPhotoViewer" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalTitle">Foto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="photoModalImage" src="" class="img-fluid rounded" style="max-height: 400px;">
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