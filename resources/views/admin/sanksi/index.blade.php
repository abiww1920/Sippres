@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Kelola Sanksi</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Kelola Sanksi</li>
      </ol>
    </nav>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="ti ti-check-circle fs-4 me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="ti ti-alert-circle fs-4 me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0">Data Sanksi Siswa</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSanksi">
          <i class="ti ti-plus fs-4"></i> Tambah Sanksi
        </button>
      </div>
      
      <!-- Filter Section -->
      <form method="GET" class="row mb-3">
        <div class="col-md-3">
          <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="direncanakan" {{ request('status') == 'direncanakan' ? 'selected' : '' }}>Direncanakan</option>
            <option value="berjalan" {{ request('status') == 'berjalan' ? 'selected' : '' }}>Berjalan</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
          </select>
        </div>
        <div class="col-md-7">
          <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-outline-secondary w-100">
            <i class="ti ti-search fs-4"></i> Cari
          </button>
        </div>
      </form>

      <!-- Table Section -->
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Sanksi</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Periode</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($sanksi as $index => $s)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $sanksi->firstItem() + $index }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  @if($s->pelanggaran->siswa->foto && file_exists(public_path('uploads/siswa/' . $s->pelanggaran->siswa->foto)))
                    <img src="{{ asset('uploads/siswa/' . $s->pelanggaran->siswa->foto) }}" class="rounded-circle foto-siswa" width="40" height="40" style="object-fit: cover; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/siswa/' . $s->pelanggaran->siswa->foto) }}', '{{ $s->pelanggaran->siswa->nama_siswa }}')">
                  @else
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @endif
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $s->pelanggaran->siswa->nama_siswa }}</h6>
                    <span class="fw-normal">NIS: {{ $s->pelanggaran->siswa->nis }}</span>
                  </div>
                </div>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->pelanggaran->siswa->kelas->nama_kelas }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->jenis_sanksi }}</p></td>
              <td>
                <p class="mb-0 fw-normal fs-4">{{ $s->tanggal_mulai->format('d M Y') }}</p>
                <small class="text-muted">s/d {{ $s->tanggal_selesai->format('d M Y') }}</small>
              </td>
              <td>
                @if($s->status == 'direncanakan')
                  <span class="badge bg-info-subtle text-info">Direncanakan</span>
                @elseif($s->status == 'berjalan')
                  <span class="badge bg-warning-subtle text-warning">Berjalan</span>
                @elseif($s->status == 'selesai')
                  <span class="badge bg-success-subtle text-success">Selesai</span>
                @else
                  <span class="badge bg-danger-subtle text-danger">Dibatalkan</span>
                @endif
              </td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $s->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editSanksi({{ $s->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteSanksi({{ $s->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <span class="text-muted">Tidak ada data sanksi</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $sanksi->firstItem() ?? 0 }}-{{ $sanksi->lastItem() ?? 0 }} dari {{ $sanksi->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($sanksi->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $sanksi->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($sanksi->getUrlRange(1, $sanksi->lastPage()) as $page => $url)
              @if ($page == $sanksi->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($sanksi->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $sanksi->nextPageUrl() }}">Next</a>
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

@include('admin.sanksi.modals')

@push('scripts')
<script>
// Show modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahSanksi'));
        modal.show();
    });
@endif

// Show photo modal
function showPhotoModal(photoUrl, studentName) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = `Foto ${studentName}`;
    new bootstrap.Modal(document.getElementById('modalPhotoViewer')).show();
}

// Show detail function
function showDetail(id) {
    fetch(`/admin/sanksi/${id}`)
        .then(response => response.json())
        .then(data => {
            const photoHtml = data.pelanggaran.siswa.foto ? 
                `<div class="text-center mb-3">
                    <img src="/uploads/siswa/${data.pelanggaran.siswa.foto}" class="img-thumbnail" style="max-width: 150px; cursor: pointer;" onclick="showPhotoModal('/uploads/siswa/${data.pelanggaran.siswa.foto}', '${data.pelanggaran.siswa.nama_siswa}')">
                </div>` : '';
            
            document.getElementById('detailContent').innerHTML = `
                ${photoHtml}
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama Siswa:</strong> ${data.pelanggaran.siswa.nama_siswa}</p>
                        <p><strong>NIS:</strong> ${data.pelanggaran.siswa.nis}</p>
                        <p><strong>Kelas:</strong> ${data.pelanggaran.siswa.kelas.nama_kelas}</p>
                        <p><strong>Pelanggaran:</strong> ${data.pelanggaran.jenis_pelanggaran.nama_pelanggaran}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Jenis Sanksi:</strong> ${data.jenis_sanksi}</p>
                        <p><strong>Status:</strong> <span class="badge bg-${data.status == 'selesai' ? 'success' : data.status == 'berjalan' ? 'warning' : data.status == 'direncanakan' ? 'info' : 'danger'}">${data.status}</span></p>
                        <p><strong>Tanggal Mulai:</strong> ${new Date(data.tanggal_mulai).toLocaleDateString('id-ID')}</p>
                        <p><strong>Tanggal Selesai:</strong> ${new Date(data.tanggal_selesai).toLocaleDateString('id-ID')}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Deskripsi Sanksi:</strong></p>
                        <p>${data.deskripsi_sanksi}</p>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailSanksi')).show();
        });
}

// Edit sanksi function
function editSanksi(id) {
    fetch(`/admin/sanksi/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_pelanggaran_id').value = data.pelanggaran_id;
            document.getElementById('edit_jenis_sanksi').value = data.jenis_sanksi;
            document.getElementById('edit_tanggal_mulai').value = data.tanggal_mulai;
            document.getElementById('edit_tanggal_selesai').value = data.tanggal_selesai;
            document.getElementById('edit_status').value = data.status;
            document.getElementById('edit_deskripsi_sanksi').value = data.deskripsi_sanksi;
            document.getElementById('formEditSanksi').action = `/admin/sanksi/${id}`;
            new bootstrap.Modal(document.getElementById('modalEditSanksi')).show();
        });
}

// Delete sanksi function
function deleteSanksi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data sanksi ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/sanksi/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

@endsection