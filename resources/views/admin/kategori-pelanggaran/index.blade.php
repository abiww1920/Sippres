@extends('mainAdmin')
@section('content')

<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Kategori Pelanggaran</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="#">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Kategori Pelanggaran</li>
      </ol>
    </nav>
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
  </div>

<script>
    // Auto-suggest poin based on kategori
    document.getElementById('tingkatPelanggaran').addEventListener('change', function() {
      const poinInput = document.getElementById('poinPelanggaran');
      const kategori = this.value;
      
      switch(kategori) {
        case 'ringan':
          poinInput.value = 5;
          break;
        case 'sedang':
          poinInput.value = 15;
          break;
        case 'berat':
          poinInput.value = 30;
          break;
        case 'sangat_berat':
          poinInput.value = 50;
          break;
        default:
          poinInput.value = '';
      }
    });
    
    // Show modal if there are validation errors
    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('tambahKategoriModal'));
            modal.show();
        });
    @endif
    
    // Show detail function
    function showDetail(id) {
        fetch(`/admin/kategori-pelanggaran/${id}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('detailKategoriContent').innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama Pelanggaran:</strong> ${data.nama_pelanggaran}</p>
                            <p><strong>Kategori:</strong> <span class="badge bg-info">${data.kategori}</span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Poin:</strong> ${data.poin}</p>
                            <p><strong>Dibuat:</strong> ${new Date(data.created_at).toLocaleDateString('id-ID')}</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <p><strong>Sanksi Rekomendasi:</strong></p>
                            <p>${data.sanksi_rekomendasi || 'Tidak ada sanksi rekomendasi'}</p>
                        </div>
                    </div>
                `;
                new bootstrap.Modal(document.getElementById('modalDetailKategori')).show();
            });
    }
    
    // Edit kategori function
    function editKategori(id) {
        fetch(`/admin/kategori-pelanggaran/${id}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editNamaKategori').value = data.nama_pelanggaran;
                document.getElementById('editTingkatPelanggaran').value = data.kategori;
                document.getElementById('editPoinPelanggaran').value = data.poin;
                document.getElementById('editDeskripsiKategori').value = data.sanksi_rekomendasi || '';
                document.getElementById('formEditKategori').action = `/admin/kategori-pelanggaran/${id}`;
                new bootstrap.Modal(document.getElementById('modalEditKategori')).show();
            });
    }
    
    function deleteKategori(id) {
        if (confirm('Apakah Anda yakin ingin menghapus kategori pelanggaran ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/kategori-pelanggaran/${id}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }
  </script>

  <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="card-title fw-semibold mb-0">Kategori Pelanggaran</h5>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                  <i class="ti ti-plus fs-4"></i> Tambah Kategori
                </button>
              </div>
              
              <!-- Filter Section -->
              <form method="GET" class="row mb-3">
                <div class="col-md-4">
                  <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <option value="ringan" {{ request('kategori') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                    <option value="sedang" {{ request('kategori') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="berat" {{ request('kategori') == 'berat' ? 'selected' : '' }}>Berat</option>
                    <option value="sangat_berat" {{ request('kategori') == 'sangat_berat' ? 'selected' : '' }}>Sangat Berat</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <input type="text" name="search" class="form-control" placeholder="Cari kategori pelanggaran..." value="{{ request('search') }}">
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
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">No</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Nama Kategori</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Kategori</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Poin</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Sanksi Rekomendasi</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                      </th>
                      <th>
                        <h6 class="fs-4 fw-semibold mb-0">Aksi</h6>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($jenisPelanggaran as $index => $jp)
                    <tr>
                      <td><p class="mb-0 fw-normal fs-4">{{ $jenisPelanggaran->firstItem() + $index }}</p></td>
                      <td><h6 class="fs-4 fw-semibold mb-0">{{ $jp->nama_pelanggaran }}</h6></td>
                      <td>
                        @if($jp->kategori == 'ringan')
                          <span class="badge bg-success-subtle text-success">Ringan</span>
                        @elseif($jp->kategori == 'sedang')
                          <span class="badge bg-warning-subtle text-warning">Sedang</span>
                        @elseif($jp->kategori == 'berat')
                          <span class="badge bg-danger-subtle text-danger">Berat</span>
                        @elseif($jp->kategori == 'sangat_berat')
                          <span class="badge bg-primary-subtle text-dark">Sangat Berat</span>
                        @else
                          <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst($jp->kategori) }}</span>
                        @endif
                      </td>
                      <td><p class="mb-0 fw-normal fs-4">{{ $jp->poin }}</p></td>
                      <td><p class="mb-0 fw-normal fs-4">{{ Str::limit($jp->sanksi_rekomendasi ?? '-', 50) }}</p></td>
                      <td><span class="badge bg-success-subtle text-success">Aktif</span></td>
                      <td>
                        <div class="dropdown dropstart">
                          <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical fs-6"></i>
                          </a>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $jp->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="editKategori({{ $jp->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteKategori({{ $jp->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                          </ul>
                        </div>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="7" class="text-center py-4">
                        <span class="text-muted">Tidak ada data kategori pelanggaran</span>
                      </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>

              <!-- Pagination -->
              <div class="d-flex align-items-center justify-content-between mt-4">
                <p class="mb-0 fw-normal fs-4">Menampilkan {{ $jenisPelanggaran->firstItem() ?? 0 }}-{{ $jenisPelanggaran->lastItem() ?? 0 }} dari {{ $jenisPelanggaran->total() }} data</p>
                <nav aria-label="Page navigation">
                  <ul class="pagination mb-0">
                    @if ($jenisPelanggaran->onFirstPage())
                      <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)">Previous</a>
                      </li>
                    @else
                      <li class="page-item">
                        <a class="page-link" href="{{ $jenisPelanggaran->previousPageUrl() }}">Previous</a>
                      </li>
                    @endif
                    
                    @foreach ($jenisPelanggaran->getUrlRange(1, $jenisPelanggaran->lastPage()) as $page => $url)
                      @if ($page == $jenisPelanggaran->currentPage())
                        <li class="page-item active">
                          <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                        </li>
                      @else
                        <li class="page-item">
                          <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                      @endif
                    @endforeach
                    
                    @if ($jenisPelanggaran->hasMorePages())
                      <li class="page-item">
                        <a class="page-link" href="{{ $jenisPelanggaran->nextPageUrl() }}">Next</a>
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
</div>
        <!-- Modal Tambah Kategori -->
  <div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header d-flex align-items-center">
          <h4 class="modal-title" id="tambahKategoriModalLabel">
            Tambah Kategori Pelanggaran
          </h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formTambahKategori" action="{{ route('admin.kategori-pelanggaran.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="namaKategori" class="form-label">Nama Kategori:</label>
              <input type="text" class="form-control @error('nama_pelanggaran') is-invalid @enderror" id="namaKategori" name="nama_pelanggaran" placeholder="Masukkan nama kategori" value="{{ old('nama_pelanggaran') }}" required>
              @error('nama_pelanggaran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="tingkatPelanggaran" class="form-label">Kategori:</label>
              <select class="form-select @error('kategori') is-invalid @enderror" id="tingkatPelanggaran" name="kategori" required>
                <option value="">Pilih Kategori</option>
                <option value="ringan" {{ old('kategori') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                <option value="sedang" {{ old('kategori') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="berat" {{ old('kategori') == 'berat' ? 'selected' : '' }}>Berat</option>
                <option value="sangat_berat" {{ old('kategori') == 'sangat_berat' ? 'selected' : '' }}>Sangat Berat</option>
              </select>
              @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="poinPelanggaran" class="form-label">Poin Pelanggaran:</label>
              <input type="number" class="form-control @error('poin') is-invalid @enderror" id="poinPelanggaran" name="poin" placeholder="Masukkan poin" min="1" max="100" value="{{ old('poin') }}" required>
              @error('poin')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="deskripsiKategori" class="form-label">Sanksi Rekomendasi:</label>
              <textarea class="form-control @error('sanksi_rekomendasi') is-invalid @enderror" id="deskripsiKategori" name="sanksi_rekomendasi" rows="3" placeholder="Masukkan sanksi rekomendasi">{{ old('sanksi_rekomendasi') }}</textarea>
              @error('sanksi_rekomendasi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="submit" form="formTambahKategori" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4"></i> Simpan
          </button>
        </div>
      </div>
    </div>
  </div>

<!-- Modal Detail Kategori -->
<div class="modal fade" id="modalDetailKategori" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Kategori Pelanggaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailKategoriContent">
        <!-- Content will be loaded here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit Kategori -->
<div class="modal fade" id="modalEditKategori" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kategori Pelanggaran</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditKategori" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nama Kategori:</label>
            <input type="text" class="form-control" id="editNamaKategori" name="nama_pelanggaran" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Kategori:</label>
            <select class="form-select" id="editTingkatPelanggaran" name="kategori" required>
              <option value="">Pilih Kategori</option>
              <option value="ringan">Ringan</option>
              <option value="sedang">Sedang</option>
              <option value="berat">Berat</option>
              <option value="sangat_berat">Sangat Berat</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Poin Pelanggaran:</label>
            <input type="number" class="form-control" id="editPoinPelanggaran" name="poin" min="1" max="100" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Sanksi Rekomendasi:</label>
            <textarea class="form-control" id="editDeskripsiKategori" name="sanksi_rekomendasi" rows="3"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

  @endsection