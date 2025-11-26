@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Siswa</li>
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
        <h5 class="card-title fw-semibold mb-0">Data Siswa</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahSiswa">
          <i class="ti ti-plus fs-4"></i> Tambah Siswa
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
          <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
            <option value="tidak_aktif" {{ request('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
          </select>
        </div>
        <div class="col-md-4">
          <input type="text" name="search" class="form-control" placeholder="Cari nama siswa atau NIS..." value="{{ request('search') }}">
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
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Kelamin</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">No HP</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Ortu</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($siswa as $index => $s)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $siswa->firstItem() + $index }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  @if($s->foto && file_exists(public_path('uploads/siswa/' . $s->foto)))
                    <img src="{{ asset('uploads/siswa/' . $s->foto) }}" class="rounded-circle foto-siswa" width="40" height="40" style="object-fit: cover; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/siswa/' . $s->foto) }}', '{{ $s->nama_siswa }}')">
                  @else
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @endif
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $s->nama_siswa }}</h6>
                    <span class="fw-normal">NIS: {{ $s->nis }}</span>
                  </div>
                </div>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->kelas->nama_kelas }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->no_hp ?? '-' }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->nama_ortu }}</p></td>
              <td>
                @if($s->status == 'aktif')
                  <span class="badge bg-success-subtle text-success">Aktif</span>
                @else
                  <span class="badge bg-danger-subtle text-danger">Tidak Aktif</span>
                @endif
              </td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $s->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editSiswa({{ $s->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteSiswa({{ $s->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <span class="text-muted">Tidak ada data siswa</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $siswa->firstItem() ?? 0 }}-{{ $siswa->lastItem() ?? 0 }} dari {{ $siswa->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($siswa->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $siswa->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($siswa->getUrlRange(1, $siswa->lastPage()) as $page => $url)
              @if ($page == $siswa->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($siswa->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $siswa->nextPageUrl() }}">Next</a>
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

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="modalTambahSiswa" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.siswa.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" name="nis" id="nis" class="form-control @error('nis') is-invalid @enderror" value="{{ old('nis') }}" required>
                @error('nis')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nama_siswa" class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" id="nama_siswa" class="form-control @error('nama_siswa') is-invalid @enderror" value="{{ old('nama_siswa') }}" required>
                @error('nama_siswa')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label for="foto" class="form-label">Foto Siswa</label>
                <input type="file" name="foto" id="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*">
                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB</small>
                @error('foto')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="kelas_id" class="form-label">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="form-select @error('kelas_id') is-invalid @enderror" required>
                  <option value="">Pilih Kelas</option>
                  @foreach($kelas as $k)
                    <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                      {{ $k->nama_kelas }}
                    </option>
                  @endforeach
                </select>
                @error('kelas_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                  <option value="">Pilih Jenis Kelamin</option>
                  <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                  <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="no_hp" class="form-label">No HP Siswa</label>
                <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}">
                @error('no_hp')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="nama_ortu" class="form-label">Nama Orang Tua</label>
                <input type="text" name="nama_ortu" id="nama_ortu" class="form-control @error('nama_ortu') is-invalid @enderror" value="{{ old('nama_ortu') }}" required>
                @error('nama_ortu')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="no_hp_ortu" class="form-label">No HP Orang Tua</label>
                <input type="text" name="no_hp_ortu" id="no_hp_ortu" class="form-control @error('no_hp_ortu') is-invalid @enderror" value="{{ old('no_hp_ortu') }}">
                @error('no_hp_ortu')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                  <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                  <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea name="alamat" id="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" placeholder="Masukkan alamat lengkap..." required>{{ old('alamat') }}</textarea>
            @error('alamat')
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

<!-- Modal Detail Siswa -->
<div class="modal fade" id="modalDetailSiswa" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Siswa</h5>
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

<!-- Modal Edit Siswa -->
<div class="modal fade" id="modalEditSiswa" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditSiswa" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">NIS</label>
                <input type="text" name="nis" id="edit_nis" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama_siswa" id="edit_nama_siswa" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <div class="mb-3">
                <label class="form-label">Foto Siswa</label>
                <input type="file" name="foto" id="edit_foto" class="form-control" accept="image/*">
                <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                <div id="current_photo" class="mt-2"></div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Kelas</label>
                <select name="kelas_id" id="edit_kelas_id" class="form-select" required>
                  <option value="">Pilih Kelas</option>
                  @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-select" required>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">No HP Siswa</label>
                <input type="text" name="no_hp" id="edit_no_hp" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Orang Tua</label>
                <input type="text" name="nama_ortu" id="edit_nama_ortu" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">No HP Orang Tua</label>
                <input type="text" name="no_hp_ortu" id="edit_no_hp_ortu" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-select">
                  <option value="aktif">Aktif</option>
                  <option value="tidak_aktif">Tidak Aktif</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Alamat</label>
            <textarea name="alamat" id="edit_alamat" rows="3" class="form-control" required></textarea>
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
// Show modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Validation errors detected, showing modal');
        var modal = new bootstrap.Modal(document.getElementById('modalTambahSiswa'));
        modal.show();
    });
@endif

// Debug form submission
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#modalTambahSiswa form');
    if (form) {
        form.addEventListener('submit', function(e) {
            console.log('Form submitted');
            console.log('Form action:', this.action);
            console.log('Form method:', this.method);
            
            // Log form data
            const formData = new FormData(this);
            console.log('Form data:');
            for (let [key, value] of formData.entries()) {
                console.log(key + ':', value);
            }
        });
    }
});

// Show photo modal
function showPhotoModal(photoUrl, studentName) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = `Foto ${studentName}`;
    new bootstrap.Modal(document.getElementById('modalPhotoViewer')).show();
}

// Show detail function
function showDetail(id) {
    fetch(`/admin/siswa/${id}`)
        .then(response => response.json())
        .then(data => {
            const photoHtml = data.foto ? 
                `<div class="text-center mb-3">
                    <img src="/uploads/siswa/${data.foto}" class="img-thumbnail" style="max-width: 150px; cursor: pointer;" onclick="showPhotoModal('/uploads/siswa/${data.foto}', '${data.nama_siswa}')">
                </div>` : '';
            
            document.getElementById('detailContent').innerHTML = `
                ${photoHtml}
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>NIS:</strong> ${data.nis}</p>
                        <p><strong>Nama Siswa:</strong> ${data.nama_siswa}</p>
                        <p><strong>Kelas:</strong> ${data.kelas.nama_kelas}</p>
                        <p><strong>Jenis Kelamin:</strong> ${data.jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan'}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>No HP Siswa:</strong> ${data.no_hp || '-'}</p>
                        <p><strong>Nama Orang Tua:</strong> ${data.nama_ortu}</p>
                        <p><strong>No HP Orang Tua:</strong> ${data.no_hp_ortu || '-'}</p>
                        <p><strong>Status:</strong> <span class="badge bg-${data.status == 'aktif' ? 'success' : 'danger'}">${data.status == 'aktif' ? 'Aktif' : 'Tidak Aktif'}</span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Alamat:</strong></p>
                        <p>${data.alamat}</p>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailSiswa')).show();
        });
}

// Edit siswa function
function editSiswa(id) {
    fetch(`/admin/siswa/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_nis').value = data.nis;
            document.getElementById('edit_nama_siswa').value = data.nama_siswa;
            document.getElementById('edit_kelas_id').value = data.kelas_id;
            document.getElementById('edit_jenis_kelamin').value = data.jenis_kelamin;
            document.getElementById('edit_no_hp').value = data.no_hp || '';
            document.getElementById('edit_nama_ortu').value = data.nama_ortu;
            document.getElementById('edit_no_hp_ortu').value = data.no_hp_ortu || '';
            document.getElementById('edit_status').value = data.status;
            document.getElementById('edit_alamat').value = data.alamat;
            
            // Show current photo if exists
            const currentPhotoDiv = document.getElementById('current_photo');
            if (data.foto) {
                currentPhotoDiv.innerHTML = `
                    <small class="text-muted">Foto saat ini:</small><br>
                    <img src="/uploads/siswa/${data.foto}" class="img-thumbnail mt-1" style="max-width: 100px; cursor: pointer;" onclick="showPhotoModal('/uploads/siswa/${data.foto}', '${data.nama_siswa}')">
                `;
            } else {
                currentPhotoDiv.innerHTML = '<small class="text-muted">Belum ada foto</small>';
            }
            
            document.getElementById('formEditSiswa').action = `/admin/siswa/${id}`;
            new bootstrap.Modal(document.getElementById('modalEditSiswa')).show();
        });
}

// Delete siswa function
function deleteSiswa(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data siswa ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/siswa/${id}`;
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