@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Jurusan</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Jurusan</li>
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
        <h5 class="card-title fw-semibold mb-0">Data Jurusan</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJurusan">
          <i class="ti ti-plus fs-4"></i> Tambah Jurusan
        </button>
      </div>
      
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kode Jurusan</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Jurusan</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Keterangan</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($jurusan as $index => $j)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $jurusan->firstItem() + $index }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $j->kode_jurusan }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $j->nama_jurusan }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $j->keterangan ?? '-' }}</p></td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $j->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editJurusan({{ $j->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteJurusan({{ $j->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4">
                <span class="text-muted">Belum ada data jurusan</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $jurusan->firstItem() ?? 0 }}-{{ $jurusan->lastItem() ?? 0 }} dari {{ $jurusan->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($jurusan->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $jurusan->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($jurusan->getUrlRange(1, $jurusan->lastPage()) as $page => $url)
              @if ($page == $jurusan->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($jurusan->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $jurusan->nextPageUrl() }}">Next</a>
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

<!-- Modal Tambah Jurusan -->
<div class="modal fade" id="modalTambahJurusan" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.jurusan.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="kode_jurusan" class="form-label">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" id="kode_jurusan" class="form-control" placeholder="Contoh: RPL" required>
          </div>
          <div class="mb-3">
            <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" id="nama_jurusan" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Keterangan jurusan (opsional)"></textarea>
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

<!-- Modal Edit Jurusan -->
<div class="modal fade" id="modalEditJurusan" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditJurusan" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Kode Jurusan</label>
            <input type="text" name="kode_jurusan" id="edit_kode_jurusan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Nama Jurusan</label>
            <input type="text" name="nama_jurusan" id="edit_nama_jurusan" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" id="edit_keterangan" class="form-control" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Detail Jurusan -->
<div class="modal fade" id="modalDetailJurusan" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Jurusan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailContent">
        <!-- Content will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function showDetail(id) {
    fetch(`/admin/jurusan/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = `
                <p><strong>Kode Jurusan:</strong> ${data.kode_jurusan}</p>
                <p><strong>Nama Jurusan:</strong> ${data.nama_jurusan}</p>
                <p><strong>Keterangan:</strong> ${data.keterangan || '-'}</p>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailJurusan')).show();
        });
}

function editJurusan(id) {
    fetch(`/admin/jurusan/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_kode_jurusan').value = data.kode_jurusan;
            document.getElementById('edit_nama_jurusan').value = data.nama_jurusan;
            document.getElementById('edit_keterangan').value = data.keterangan || '';
            document.getElementById('formEditJurusan').action = `/admin/jurusan/${id}`;
            new bootstrap.Modal(document.getElementById('modalEditJurusan')).show();
        });
}

function deleteJurusan(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data jurusan ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/jurusan/${id}`;
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