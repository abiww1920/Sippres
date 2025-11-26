@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Prestasi</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Prestasi</li>
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
        <h5 class="card-title fw-semibold mb-0">Data Prestasi Siswa</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPrestasi">
          <i class="ti ti-plus fs-4"></i> Tambah Prestasi
        </button>
      </div>
      
      <!-- Filter Section -->
      <form method="GET" class="row mb-3">
        <div class="col-md-3">
          <select name="kelas_id" class="form-select">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
              <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kelas }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-3">
          <select name="tingkat" class="form-select">
            <option value="">Semua Tingkat</option>
            <option value="sekolah" {{ request('tingkat') == 'sekolah' ? 'selected' : '' }}>Sekolah</option>
            <option value="kecamatan" {{ request('tingkat') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
            <option value="kabupaten" {{ request('tingkat') == 'kabupaten' ? 'selected' : '' }}>Kabupaten</option>
            <option value="provinsi" {{ request('tingkat') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
            <option value="nasional" {{ request('tingkat') == 'nasional' ? 'selected' : '' }}>Nasional</option>
            <option value="internasional" {{ request('tingkat') == 'internasional' ? 'selected' : '' }}>Internasional</option>
          </select>
        </div>
        <div class="col-md-4">
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
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Prestasi</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tingkat</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Juara</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($prestasi as $index => $p)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $prestasi->firstItem() + $index }}</p></td>
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
              <td><p class="mb-0 fw-normal fs-4">{{ $p->nama_prestasi ?: '-' }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->tanggal ? $p->tanggal->format('d M Y') : '-' }}</p></td>
              <td>
                @if($p->tingkat)
                  <span class="badge bg-success-subtle text-success">{{ ucfirst($p->tingkat) }}</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->juara ?: '-' }}</p></td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $p->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editPrestasi({{ $p->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deletePrestasi({{ $p->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <span class="text-muted">Tidak ada data prestasi</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $prestasi->firstItem() ?? 0 }}-{{ $prestasi->lastItem() ?? 0 }} dari {{ $prestasi->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($prestasi->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $prestasi->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($prestasi->getUrlRange(1, $prestasi->lastPage()) as $page => $url)
              @if ($page == $prestasi->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($prestasi->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $prestasi->nextPageUrl() }}">Next</a>
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

<!-- Modal Tambah Prestasi -->
<div class="modal fade" id="modalTambahPrestasi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Prestasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.prestasi.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="siswa_id" class="form-label">Nama Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-select" required>
                  <option value="">Pilih Siswa</option>
                  @foreach($kelas as $k)
                    <optgroup label="{{ $k->nama_kelas }}">
                      @foreach($k->siswa as $s)
                        <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nama_prestasi" class="form-label">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" id="nama_prestasi" class="form-control" placeholder="Masukkan nama prestasi" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="tingkat" class="form-label">Tingkat</label>
                <select name="tingkat" id="tingkat" class="form-select" required>
                  <option value="">Pilih Tingkat</option>
                  <option value="sekolah">Sekolah</option>
                  <option value="kecamatan">Kecamatan</option>
                  <option value="kabupaten">Kabupaten</option>
                  <option value="provinsi">Provinsi</option>
                  <option value="nasional">Nasional</option>
                  <option value="internasional">Internasional</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="juara" class="form-label">Juara</label>
                <input type="text" name="juara" id="juara" class="form-control" placeholder="Contoh: Juara 1, Harapan 1" required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal Prestasi</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Masukkan keterangan detail prestasi..." required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">
            <i class="ti ti-device-floppy fs-4"></i> Simpan
          </button>
        </div>
      </form>
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

<!-- Modal Edit Prestasi -->
<div class="modal fade" id="modalEditPrestasi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Prestasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditPrestasi" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_siswa_id" class="form-label">Nama Siswa</label>
                <select name="siswa_id" id="edit_siswa_id" class="form-select" required>
                  <option value="">Pilih Siswa</option>
                  @foreach($kelas as $k)
                    <optgroup label="{{ $k->nama_kelas }}">
                      @foreach($k->siswa as $s)
                        <option value="{{ $s->id }}">{{ $s->nama_siswa }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_nama_prestasi" class="form-label">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" id="edit_nama_prestasi" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_tingkat" class="form-label">Tingkat</label>
                <select name="tingkat" id="edit_tingkat" class="form-select" required>
                  <option value="">Pilih Tingkat</option>
                  <option value="sekolah">Sekolah</option>
                  <option value="kecamatan">Kecamatan</option>
                  <option value="kabupaten">Kabupaten</option>
                  <option value="provinsi">Provinsi</option>
                  <option value="nasional">Nasional</option>
                  <option value="internasional">Internasional</option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="edit_juara" class="form-label">Juara</label>
                <input type="text" name="juara" id="edit_juara" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="edit_tanggal" class="form-label">Tanggal Prestasi</label>
            <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="edit_keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="edit_keterangan" rows="3" class="form-control" required></textarea>
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

<!-- Modal Detail Prestasi -->
<div class="modal fade" id="modalDetailPrestasi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Prestasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-semibold">Nama Siswa</label>
              <p id="detail_nama_siswa" class="form-control-plaintext">-</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-semibold">Kelas</label>
              <p id="detail_kelas" class="form-control-plaintext">-</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-semibold">Nama Prestasi</label>
              <p id="detail_nama_prestasi" class="form-control-plaintext">-</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-semibold">Tingkat</label>
              <p id="detail_tingkat" class="form-control-plaintext">-</p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-semibold">Juara</label>
              <p id="detail_juara" class="form-control-plaintext">-</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label fw-semibold">Tanggal</label>
              <p id="detail_tanggal" class="form-control-plaintext">-</p>
            </div>
          </div>
        </div>
        <div class="mb-3">
          <label class="form-label fw-semibold">Keterangan</label>
          <p id="detail_keterangan" class="form-control-plaintext">-</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
// Show photo modal
function showPhotoModal(photoUrl, studentName) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = `Foto ${studentName}`;
    new bootstrap.Modal(document.getElementById('modalPhotoViewer')).show();
}

// Show detail prestasi
function showDetail(id) {
    fetch(`/admin/prestasi/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detail_nama_siswa').textContent = data.siswa.nama_siswa;
            document.getElementById('detail_kelas').textContent = data.siswa.kelas.nama_kelas;
            document.getElementById('detail_nama_prestasi').textContent = data.nama_prestasi || '-';
            document.getElementById('detail_tingkat').textContent = data.tingkat ? data.tingkat.charAt(0).toUpperCase() + data.tingkat.slice(1) : '-';
            document.getElementById('detail_juara').textContent = data.juara || '-';
            document.getElementById('detail_tanggal').textContent = data.tanggal ? new Date(data.tanggal).toLocaleDateString('id-ID') : '-';
            document.getElementById('detail_keterangan').textContent = data.keterangan || '-';
            
            new bootstrap.Modal(document.getElementById('modalDetailPrestasi')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat detail prestasi');
        });
}

// Edit prestasi
function editPrestasi(id) {
    fetch(`/admin/prestasi/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_siswa_id').value = data.siswa_id;
            document.getElementById('edit_nama_prestasi').value = data.nama_prestasi;
            document.getElementById('edit_tingkat').value = data.tingkat;
            document.getElementById('edit_juara').value = data.juara;
            document.getElementById('edit_tanggal').value = data.tanggal;
            document.getElementById('edit_keterangan').value = data.keterangan;
            
            document.getElementById('formEditPrestasi').action = `/admin/prestasi/${id}`;
            
            new bootstrap.Modal(document.getElementById('modalEditPrestasi')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal memuat data prestasi');
        });
}

// Delete prestasi
function deletePrestasi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data prestasi ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/prestasi/${id}`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        
        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush

@endsection