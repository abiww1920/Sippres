@extends('mainKepsek')
@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-semibold mb-2">Monitoring Pelanggaran</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="{{ route('kepsek.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Monitoring Pelanggaran</li>
            </ol>
        </nav>
    </div>

    <!-- Monitoring Table -->
    <div class="card">
        <div class="card-body">
            <div class="d-md-flex align-items-center mb-4">
                <div>
                    <h4 class="card-title">Daftar Pelanggaran</h4>
                    <p class="card-subtitle">
                        Data pelanggaran yang perlu dipantau
                    </p>
                </div>
                <div class="ms-auto mt-3 mt-md-0">
                    <form method="GET" class="d-flex gap-2">
                        <select name="kelas_id" class="form-select theme-select border-0" style="width: auto;">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                        <select name="status" class="form-select theme-select border-0" style="width: auto;">
                            <option value="">Semua Status</option>
                            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
                            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}" style="width: 200px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-search fs-4"></i>
                        </button>
                    </form>
                </div>
            </div>
            <div class="table-responsive mt-4">
                <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggaranList as $index => $pelanggaran)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($pelanggaran->siswa->foto && file_exists(public_path('uploads/siswa/' . $pelanggaran->siswa->foto)))
                                        <img src="{{ asset('uploads/siswa/' . $pelanggaran->siswa->foto) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/siswa/' . $pelanggaran->siswa->foto) }}', '{{ $pelanggaran->siswa->nama_siswa }}')">
                                    @else
                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $pelanggaran->siswa->nama_siswa }}</h6>
                                        <span class="fw-normal">NIS: {{ $pelanggaran->siswa->nis }}</span>
                                    </div>
                                </div>
                            </td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->siswa->kelas->nama_kelas }}</p></td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p></td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->created_at->format('d M Y') }}</p></td>
                            <td>
                                @if($pelanggaran->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                                @endif
                            </td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->poin }}</p></td>
                            <td>
                                <div class="dropdown dropstart">
                                    <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical fs-6"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('kepsek.monitoring.show', $pelanggaran->id) }}"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <span class="text-muted">Tidak ada data pelanggaran</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>
</div>

<!-- Modal Photo Viewer -->
<div class="modal fade" id="modalPhotoViewer" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalTitle">Foto Siswa</h5>
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
function showPhotoModal(photoUrl, studentName) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = `Foto ${studentName}`;
    new bootstrap.Modal(document.getElementById('modalPhotoViewer')).show();
}
</script>
@endpush

@endsection
