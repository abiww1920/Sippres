@extends('mainKesiswaan')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Verifikasi Data</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('kesiswaan.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Verifikasi Data</li>
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
      <ul class="nav nav-tabs mb-3" role="tablist">
        <li class="nav-item">
          <a class="nav-link {{ $type == 'pelanggaran' ? 'active' : '' }}" href="?type=pelanggaran">
            <i class="ti ti-alert-triangle me-2"></i>Pelanggaran
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link {{ $type == 'prestasi' ? 'active' : '' }}" href="?type=prestasi">
            <i class="ti ti-trophy me-2"></i>Prestasi
          </a>
        </li>
      </ul>

      @if($type == 'pelanggaran')
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap align-middle">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $index => $d)
            <tr>
              <td>{{ $data->firstItem() + $index }}</td>
              <td>{{ $d->siswa->nama_siswa }}</td>
              <td>{{ $d->siswa->kelas->nama_kelas }}</td>
              <td>{{ $d->jenisPelanggaran->nama_pelanggaran }}</td>
              <td>{{ $d->poin }}</td>
              <td>{{ $d->created_at->format('d M Y') }}</td>
              <td>
                @if($d->status_verifikasi == 'menunggu')
                  <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                @elseif($d->status_verifikasi == 'diverifikasi')
                  <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                @else
                  <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                @endif
              </td>
              <td>
                @if($d->status_verifikasi == 'menunggu')
                <button class="btn btn-sm btn-success" onclick="verifikasi({{ $d->id }}, 'diverifikasi')">
                  <i class="ti ti-check"></i> Verifikasi
                </button>
                <button class="btn btn-sm btn-danger" onclick="verifikasi({{ $d->id }}, 'ditolak')">
                  <i class="ti ti-x"></i> Tolak
                </button>
                @else
                <span class="text-muted">-</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4"><span class="text-muted">Tidak ada data yang perlu diverifikasi</span></td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @else
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap align-middle">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Prestasi</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tingkat</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Juara</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($data as $index => $d)
            <tr>
              <td>{{ $data->firstItem() + $index }}</td>
              <td>{{ $d->siswa->nama_siswa }}</td>
              <td>{{ $d->siswa->kelas->nama_kelas }}</td>
              <td>{{ $d->nama_prestasi }}</td>
              <td><span class="badge bg-info-subtle text-info">{{ ucfirst($d->tingkat) }}</span></td>
              <td>{{ $d->juara }}</td>
              <td>{{ \Carbon\Carbon::parse($d->tanggal)->format('d M Y') }}</td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4"><span class="text-muted">Tidak ada data prestasi</span></td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @endif

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $data->firstItem() ?? 0 }}-{{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data</p>
        {{ $data->appends(['type' => $type])->links() }}
      </div>
    </div>
  </div>
</div>

<!-- Modal Verifikasi -->
<div class="modal fade" id="modalVerifikasi" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Verifikasi Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formVerifikasi" method="POST">
        @csrf
        <input type="hidden" name="status" id="verifikasi_status">
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Catatan (Opsional)</label>
            <textarea name="catatan" rows="3" class="form-control" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
function verifikasi(id, status) {
    document.getElementById('verifikasi_status').value = status;
    document.getElementById('formVerifikasi').action = `/kesiswaan/verifikasi/${id}`;
    new bootstrap.Modal(document.getElementById('modalVerifikasi')).show();
}
</script>
@endpush
@endsection
