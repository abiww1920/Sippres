@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Guru</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Guru</li>
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
        <h5 class="card-title fw-semibold mb-0">Data Guru</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahGuru">
          <i class="ti ti-plus fs-4"></i> Tambah Guru
        </button>
      </div>
      
      <!-- Filter Section -->
      <form method="GET" class="row mb-3">
        <div class="col-md-3">
          <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" name="search" class="form-control" placeholder="Cari nama guru, NIP, atau bidang studi..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-outline-secondary w-100">
            <i class="ti ti-search fs-4"></i> Cari
          </button>
        </div>
      </form>

      <div id="tableContainer">
        @include('admin.guru.table')
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah Guru -->
<div class="modal fade" id="modalTambahGuru" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.guru.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nama_guru" class="form-label">Nama Guru</label>
                <input type="text" name="nama_guru" id="nama_guru" class="form-control @error('nama_guru') is-invalid @enderror" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nip" class="form-label">NIP</label>
                <input type="text" name="nip" id="nip" class="form-control @error('nip') is-invalid @enderror" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="bidang_studi" class="form-label">Bidang Studi</label>
                <input type="text" name="bidang_studi" id="bidang_studi" class="form-control @error('bidang_studi') is-invalid @enderror" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                  <option value="">Pilih Status</option>
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Non Aktif</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Guru -->
<div class="modal fade" id="modalEditGuru" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Guru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditGuru" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Guru</label>
                <input type="text" name="nama_guru" id="edit_nama_guru" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">NIP</label>
                <input type="text" name="nip" id="edit_nip" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Bidang Studi</label>
                <input type="text" name="bidang_studi" id="edit_bidang_studi" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-select" required>
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Non Aktif</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Detail Guru -->
<div class="modal fade" id="modalDetailGuru" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Guru</h5>
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
// Show detail function
function showDetail(id) {
    fetch(`/admin/guru/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama Guru:</strong> ${data.nama_guru}</p>
                        <p><strong>NIP:</strong> ${data.nip}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Bidang Studi:</strong> ${data.bidang_studi}</p>
                        <p><strong>Status:</strong> <span class="badge bg-${data.status == 'aktif' ? 'success' : 'secondary'}">${data.status}</span></p>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailGuru')).show();
        });
}

// Edit guru function
function editGuru(id) {
    fetch(`/admin/guru/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_nama_guru').value = data.nama_guru;
            document.getElementById('edit_nip').value = data.nip;
            document.getElementById('edit_bidang_studi').value = data.bidang_studi;
            document.getElementById('edit_status').value = data.status;
            document.getElementById('formEditGuru').action = `/admin/guru/${id}`;
            new bootstrap.Modal(document.getElementById('modalEditGuru')).show();
        });
}

// Delete guru function
function deleteGuru(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data guru ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/guru/${id}`;
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