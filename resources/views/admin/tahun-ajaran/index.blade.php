@extends('mainAdmin')

@section('content')
<div class="container-fluid">
  <!-- Header Section -->
  <div class="d-flex align-items-center justify-content-between mb-4">
    <div>
      <h5 class="card-title fw-semibold mb-1">Kelola Tahun Ajaran</h5>
      <p class="card-subtitle mb-0">Kelola data tahun ajaran dan semester</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTahunAjaran">
      <i class="ti ti-plus fs-4 me-2"></i>Tambah Tahun Ajaran
    </button>
  </div>

  <!-- Alert Messages -->
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="ti ti-check fs-4 me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="ti ti-x fs-4 me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <!-- Main Card -->
  <div class="card">
    <div class="card-body">
      <!-- Filter Section -->
      <form method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
          <select name="semester" class="form-select">
            <option value="">Semua Semester</option>
            <option value="ganjil" {{ request('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
            <option value="genap" {{ request('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
          </select>
        </div>
        <div class="col-md-3">
          <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non-Aktif</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" name="search" class="form-control" placeholder="Cari tahun ajaran..." value="{{ request('search') }}">
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
              <th><h6 class="fs-4 fw-semibold mb-0">Tahun Ajaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Semester</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Dibuat</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($tahunAjaran as $index => $ta)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $tahunAjaran->firstItem() + $index }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="ms-0">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $ta->tahun_ajaran }}</h6>
                    <span class="fw-normal text-muted">Periode Akademik</span>
                  </div>
                </div>
              </td>
              <td>
                <span class="badge bg-{{ $ta->semester == 'ganjil' ? 'primary' : 'info' }}-subtle text-{{ $ta->semester == 'ganjil' ? 'primary' : 'info' }}">
                  {{ ucfirst($ta->semester) }}
                </span>
              </td>
              <td>
                @if($ta->status_aktif)
                  <span class="badge bg-success-subtle text-success">
                    <i class="ti ti-check fs-3 me-1"></i>Aktif
                  </span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary">Non-Aktif</span>
                @endif
              </td>
              <td>
                <p class="mb-0 fw-normal fs-4">{{ $ta->created_at->format('d M Y') }}</p>
                <small class="text-muted">{{ $ta->created_at->format('H:i') }}</small>
              </td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $ta->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                    @if(!$ta->status_aktif)
                      <li><a class="dropdown-item text-success" href="javascript:void(0)" onclick="setActive({{ $ta->id }})"><i class="ti ti-check fs-4 me-2"></i>Aktifkan</a></li>
                    @endif
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editTahunAjaran({{ $ta->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteTahunAjaran({{ $ta->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4">
                <div class="d-flex flex-column align-items-center">
                  <i class="ti ti-calendar-off fs-1 text-muted mb-2"></i>
                  <span class="text-muted">Tidak ada data tahun ajaran</span>
                </div>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $tahunAjaran->firstItem() ?? 0 }}-{{ $tahunAjaran->lastItem() ?? 0 }} dari {{ $tahunAjaran->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($tahunAjaran->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $tahunAjaran->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($tahunAjaran->getUrlRange(1, $tahunAjaran->lastPage()) as $page => $url)
              @if ($page == $tahunAjaran->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($tahunAjaran->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $tahunAjaran->nextPageUrl() }}">Next</a>
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

@include('admin.tahun-ajaran.modals')

@push('scripts')
<script>
// Show modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahTahunAjaran'));
        modal.show();
    });
@endif

// Show detail function
function showDetail(id) {
    fetch(`/admin/tahun-ajaran/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Tahun Ajaran:</strong> ${data.tahun_ajaran}</p>
                        <p><strong>Semester:</strong> <span class="badge bg-${data.semester == 'ganjil' ? 'primary' : 'info'}">${data.semester.charAt(0).toUpperCase() + data.semester.slice(1)}</span></p>
                        <p><strong>Status:</strong> <span class="badge bg-${data.status_aktif ? 'success' : 'secondary'}">${data.status_aktif ? 'Aktif' : 'Non-Aktif'}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Jumlah Pelanggaran:</strong> ${data.jumlah_pelanggaran} data</p>
                        <p><strong>Jumlah Prestasi:</strong> ${data.jumlah_prestasi} data</p>
                        <p><strong>Dibuat:</strong> ${data.created_at}</p>
                        <p><strong>Diperbarui:</strong> ${data.updated_at}</p>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailTahunAjaran')).show();
        });
}

// Edit tahun ajaran function
function editTahunAjaran(id) {
    fetch(`/admin/tahun-ajaran/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_tahun_ajaran').value = data.tahun_ajaran;
            document.getElementById('edit_semester').value = data.semester;
            document.getElementById('edit_status_aktif').checked = data.status_aktif;
            new bootstrap.Modal(document.getElementById('modalEditTahunAjaran')).show();
        });
}

// Delete tahun ajaran function
function deleteTahunAjaran(id) {
    if (confirm('Apakah Anda yakin ingin menghapus tahun ajaran ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/tahun-ajaran/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Set active function
function setActive(id) {
    if (confirm('Apakah Anda yakin ingin mengaktifkan tahun ajaran ini? Tahun ajaran yang aktif sebelumnya akan dinonaktifkan.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/tahun-ajaran/${id}/set-active`;
        form.innerHTML = `
            @csrf
            @method('PATCH')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection