@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Pelanggaran</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
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
  
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="ti ti-alert-circle fs-4 me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0">Data Pelanggaran Siswa</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggaran">
          <i class="ti ti-plus fs-4"></i> Tambah Pelanggaran
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
            <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="diverifikasi" {{ request('status') == 'diverifikasi' ? 'selected' : '' }}>Diverifikasi</option>
            <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
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
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Foto Bukti</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
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
              <td>
                @if($p->foto_bukti && file_exists(public_path('uploads/pelanggaran/' . $p->foto_bukti)))
                  <img src="{{ asset('uploads/pelanggaran/' . $p->foto_bukti) }}" class="rounded" width="40" height="40" style="object-fit: cover; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/pelanggaran/' . $p->foto_bukti) }}', 'Bukti Pelanggaran')">
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->created_at->format('d M Y') }}</p></td>
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
                    <li><a class="dropdown-item" href="{{ route('admin.pelanggaran.show', $p->id) }}"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editPelanggaran({{ $p->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deletePelanggaran({{ $p->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
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

      <!-- Pagination -->
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

<!-- Modal Tambah Pelanggaran -->
<div class="modal fade" id="modalTambahPelanggaran" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pelanggaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="siswa_id" class="form-label">Nama Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
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
                <label for="jenis_pelanggaran_id" class="form-label">Jenis Pelanggaran</label>
                <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" class="form-select @error('jenis_pelanggaran_id') is-invalid @enderror" required>
                  <option value="">Pilih Jenis Pelanggaran</option>
                  @php
                    $jenisPelanggaran = \App\Models\JeniPelanggaran::all();
                  @endphp
                  @foreach($jenisPelanggaran as $jp)
                    <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">
                      {{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="guru_pencatat" class="form-label">Guru Pencatat</label>
                <select name="guru_pencatat" id="guru_pencatat" class="form-select @error('guru_pencatat') is-invalid @enderror" required>
                  <option value="">Pilih Guru</option>
                  @php
                    $guru = \App\Models\Guru::all();
                  @endphp
                  @foreach($guru as $g)
                    <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="poin_display" class="form-label">Poin Pelanggaran</label>
                <input type="text" id="poin_display" class="form-control" readonly placeholder="Auto-fill">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Masukkan keterangan detail pelanggaran..." required>{{ old('keterangan') }}</textarea>
            @error('keterangan')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="mb-3">
            <label for="foto_bukti" class="form-label">Foto Bukti Pelanggaran <span class="text-danger">*</span></label>
            <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*" required>
            <small class="text-muted">Format: JPG, PNG, JPEG (Max: 2MB)</small>
            @error('foto_bukti')
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

<!-- Modal Detail Pelanggaran -->
<div class="modal fade" id="modalDetailPelanggaran" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Pelanggaran</h5>
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

<!-- Modal Edit Pelanggaran -->
<div class="modal fade" id="modalEditPelanggaran" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Pelanggaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditPelanggaran" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
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
                <label class="form-label">Jenis Pelanggaran</label>
                <select name="jenis_pelanggaran_id" id="edit_jenis_pelanggaran_id" class="form-select" required>
                  <option value="">Pilih Jenis Pelanggaran</option>
                  @foreach($jenisPelanggaran as $jp)
                    <option value="{{ $jp->id }}" data-poin="{{ $jp->poin }}">
                      {{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Guru Pencatat</label>
                <select name="guru_pencatat" id="edit_guru_pencatat" class="form-select" required>
                  <option value="">Pilih Guru</option>
                  @foreach($guru as $g)
                    <option value="{{ $g->id }}">{{ $g->nama_guru }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Poin Pelanggaran</label>
                <input type="text" id="edit_poin_display" class="form-control" readonly>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" id="edit_keterangan" rows="3" class="form-control" required></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Foto Bukti Pelanggaran</label>
            <input type="file" name="foto_bukti" id="edit_foto_bukti" class="form-control" accept="image/*">
            <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. Format: JPG, PNG, JPEG (Max: 2MB)</small>
            <div id="current_foto_preview" class="mt-2"></div>
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
document.getElementById('jenis_pelanggaran_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const poin = selectedOption.getAttribute('data-poin');
    document.getElementById('poin_display').value = poin ? poin + ' poin' : '';
});

// Show modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('modalTambahPelanggaran'));
        modal.show();
    });
@endif

// Edit pelanggaran auto-fill poin
document.getElementById('edit_jenis_pelanggaran_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const poin = selectedOption.getAttribute('data-poin');
    document.getElementById('edit_poin_display').value = poin ? poin + ' poin' : '';
});

// Show photo modal
function showPhotoModal(photoUrl, studentName) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = `Foto ${studentName}`;
    new bootstrap.Modal(document.getElementById('modalPhotoViewer')).show();
}

// Show detail function
function showDetail(id) {
    fetch(`/admin/pelanggaran/${id}`)
        .then(response => response.json())
        .then(data => {
            const photoHtml = data.siswa.foto ? 
                `<div class="text-center mb-3">
                    <img src="/uploads/siswa/${data.siswa.foto}" class="img-thumbnail" style="max-width: 150px; cursor: pointer;" onclick="showPhotoModal('/uploads/siswa/${data.siswa.foto}', '${data.siswa.nama_siswa}')">
                </div>` : '';
            
            const fotoBukti = data.foto_bukti ? 
                `<div class="row mb-3">
                    <div class="col-12">
                        <p><strong>Foto Bukti:</strong></p>
                        <a href="/uploads/pelanggaran/${data.foto_bukti}" target="_blank" class="btn btn-sm btn-primary"><i class="ti ti-photo"></i> Lihat Foto</a>
                    </div>
                </div>` : '';
            
            document.getElementById('detailContent').innerHTML = `
                ${photoHtml}
                ${fotoBukti}
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama Siswa:</strong> ${data.siswa.nama_siswa}</p>
                        <p><strong>NIS:</strong> ${data.siswa.nis}</p>
                        <p><strong>Kelas:</strong> ${data.siswa.kelas.nama_kelas}</p>
                        <p><strong>Jenis Pelanggaran:</strong> ${data.jenis_pelanggaran.nama_pelanggaran}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Poin:</strong> ${data.poin}</p>
                        <p><strong>Status:</strong> <span class="badge bg-${data.status_verifikasi == 'diverifikasi' ? 'success' : data.status_verifikasi == 'menunggu' ? 'warning' : 'danger'}">${data.status_verifikasi}</span></p>
                        <p><strong>Guru Pencatat:</strong> ${data.guru_pencatat ? data.guru_pencatat.nama_guru : 'Tidak diketahui'}</p>
                        <p><strong>Tanggal:</strong> ${new Date(data.created_at).toLocaleDateString('id-ID')}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p><strong>Keterangan:</strong></p>
                        <p>${data.keterangan}</p>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailPelanggaran')).show();
        });
}

// Edit pelanggaran function
function editPelanggaran(id) {
    fetch(`/admin/pelanggaran/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_siswa_id').value = data.siswa_id;
            document.getElementById('edit_jenis_pelanggaran_id').value = data.jenis_pelanggaran_id;
            document.getElementById('edit_guru_pencatat').value = data.guru_pencatat;
            document.getElementById('edit_keterangan').value = data.keterangan;
            document.getElementById('edit_poin_display').value = data.poin + ' poin';
            document.getElementById('formEditPelanggaran').action = `/admin/pelanggaran/${id}`;
            new bootstrap.Modal(document.getElementById('modalEditPelanggaran')).show();
        });
}

// Delete pelanggaran function
function deletePelanggaran(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data pelanggaran ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/pelanggaran/${id}`;
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