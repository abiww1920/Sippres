@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Kelas</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Kelas</li>
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
        <h5 class="card-title fw-semibold mb-0">Data Kelas</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
          <i class="ti ti-plus fs-4"></i> Tambah Kelas
        </button>
      </div>
      
      <!-- Filter Section -->
      <form method="GET" class="row mb-3">
        <div class="col-md-4">
          <select name="jurusan" class="form-select">
            <option value="">Semua Jurusan</option>
            @foreach($jurusanList as $j)
              <option value="{{ $j }}" {{ request('jurusan') == $j ? 'selected' : '' }}>
                {{ $j }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <input type="text" name="search" class="form-control" placeholder="Cari nama kelas atau jurusan..." value="{{ request('search') }}">
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
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jurusan</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Wali Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jumlah Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($kelas as $index => $k)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $kelas->firstItem() + $index }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $k->nama_kelas }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $k->jurusan }}</p></td>
              <td>
                @if($k->waliKelas)
                  <div class="d-flex align-items-center">
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                    <div class="ms-3">
                      <h6 class="fs-4 fw-semibold mb-0">{{ $k->waliKelas->nama_guru }}</h6>
                      <span class="fw-normal">NIP: {{ $k->waliKelas->nip }}</span>
                    </div>
                  </div>
                @else
                  <span class="badge bg-warning-subtle text-warning">Belum Ada</span>
                @endif
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $k->siswa->count() }} Siswa</p></td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $k->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editKelas({{ $k->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteKelas({{ $k->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4">
                <span class="text-muted">Tidak ada data kelas</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $kelas->firstItem() ?? 0 }}-{{ $kelas->lastItem() ?? 0 }} dari {{ $kelas->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($kelas->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $kelas->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($kelas->getUrlRange(1, $kelas->lastPage()) as $page => $url)
              @if ($page == $kelas->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($kelas->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $kelas->nextPageUrl() }}">Next</a>
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

<!-- Modal Tambah Kelas -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.kelas.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="nama_kelas" class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" id="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror" placeholder="Contoh: X RPL 1" value="{{ old('nama_kelas') }}" required>
            @error('nama_kelas')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <select name="jurusan" id="jurusan" class="form-select @error('jurusan') is-invalid @enderror" required>
              <option value="">Pilih Jurusan</option>
              @foreach($jurusanData as $j)
                <option value="{{ $j->nama_jurusan }}" {{ old('jurusan') == $j->nama_jurusan ? 'selected' : '' }}>
                  {{ $j->nama_jurusan }}
                </option>
              @endforeach
            </select>
            @error('jurusan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="wali_kelas_id" class="form-label">Wali Kelas</label>
            <select name="wali_kelas_id" id="wali_kelas_id" class="form-select @error('wali_kelas_id') is-invalid @enderror">
              <option value="">Pilih Wali Kelas (Opsional)</option>
              @foreach($guru as $g)
                <option value="{{ $g->id }}" {{ old('wali_kelas_id') == $g->id ? 'selected' : '' }}>
                  {{ $g->nama_guru }} - {{ $g->nip }}
                </option>
              @endforeach
            </select>
            @error('wali_kelas_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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

<!-- Modal Detail Kelas -->
<div class="modal fade" id="modalDetailKelas" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Kelas</h5>
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

<!-- Modal Edit Kelas -->
<div class="modal fade" id="modalEditKelas" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kelas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditKelas" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Kelas</label>
            <input type="text" name="nama_kelas" id="edit_nama_kelas" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jurusan</label>
            <select name="jurusan" id="edit_jurusan" class="form-select" required>
              <option value="">Pilih Jurusan</option>
              @foreach($jurusanData as $j)
                <option value="{{ $j->nama_jurusan }}">{{ $j->nama_jurusan }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Wali Kelas</label>
            <select name="wali_kelas_id" id="edit_wali_kelas_id" class="form-select">
              <option value="">Pilih Wali Kelas (Opsional)</option>
              @foreach($guru as $g)
                <option value="{{ $g->id }}">{{ $g->nama_guru }} - {{ $g->nip }}</option>
              @endforeach
            </select>
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

@push('scripts')
<script>
// Show modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahKelas'));
        modal.show();
    });
@endif

// Show detail function
function showDetail(id) {
    fetch(`/admin/kelas/${id}`)
        .then(response => response.json())
        .then(data => {
            const waliKelasHtml = data.wali_kelas ? 
                `<p><strong>Wali Kelas:</strong> ${data.wali_kelas.nama_guru} (NIP: ${data.wali_kelas.nip})</p>` : 
                '<p><strong>Wali Kelas:</strong> <span class="badge bg-warning">Belum Ada</span></p>';
            
            const siswaList = data.siswa.length > 0 ? 
                data.siswa.map((s, i) => `<li>${i+1}. ${s.nama_siswa} (NIS: ${s.nis})</li>`).join('') :
                '<li class="text-muted">Belum ada siswa</li>';
            
            document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama Kelas:</strong> ${data.nama_kelas}</p>
                        <p><strong>Jurusan:</strong> ${data.jurusan}</p>
                        ${waliKelasHtml}
                    </div>
                    <div class="col-md-6">
                        <p><strong>Jumlah Siswa:</strong> ${data.siswa.length} Siswa</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <p><strong>Daftar Siswa:</strong></p>
                        <ol class="ps-3">${siswaList}</ol>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailKelas')).show();
        });
}

// Edit kelas function
function editKelas(id) {
    fetch(`/admin/kelas/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_nama_kelas').value = data.nama_kelas;
            document.getElementById('edit_jurusan').value = data.jurusan;
            document.getElementById('edit_wali_kelas_id').value = data.wali_kelas_id || '';
            document.getElementById('formEditKelas').action = `/admin/kelas/${id}`;
            new bootstrap.Modal(document.getElementById('modalEditKelas')).show();
        });
}

// Delete kelas function
function deleteKelas(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data kelas ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/kelas/${id}`;
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
