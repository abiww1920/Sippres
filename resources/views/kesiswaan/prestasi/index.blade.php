@extends('mainKesiswaan')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Prestasi</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('kesiswaan.dashboard') }}">Home</a></li>
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
      
      <form method="GET" class="row mb-3">
        <div class="col-md-4">
          <select name="kelas_id" class="form-select">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
              <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-outline-secondary w-100"><i class="ti ti-search fs-4"></i> Cari</button>
        </div>
      </form>

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
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($prestasi as $index => $p)
            <tr>
              <td>{{ $prestasi->firstItem() + $index }}</td>
              <td>{{ $p->siswa->nama_siswa }}</td>
              <td>{{ $p->siswa->kelas->nama_kelas }}</td>
              <td>{{ $p->nama_prestasi }}</td>
              <td><span class="badge bg-info-subtle text-info">{{ ucfirst($p->tingkat) }}</span></td>
              <td>{{ $p->juara }}</td>
              <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown"><i class="ti ti-dots-vertical fs-6"></i></a>
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
              <td colspan="8" class="text-center py-4"><span class="text-muted">Tidak ada data prestasi</span></td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $prestasi->firstItem() ?? 0 }}-{{ $prestasi->lastItem() ?? 0 }} dari {{ $prestasi->total() }} data</p>
        {{ $prestasi->links() }}
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="modalTambahPrestasi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Prestasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('kesiswaan.prestasi.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <select name="siswa_id" class="form-select" required>
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
                <label class="form-label">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Tingkat</label>
                <select name="tingkat" class="form-select" required>
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
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Juara</label>
                <input type="text" name="juara" class="form-control" placeholder="Contoh: Juara 1" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" rows="3" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy fs-4"></i> Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Detail -->
<div class="modal fade" id="modalDetailPrestasi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Prestasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="detailContent"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Edit -->
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
                <label class="form-label">Nama Prestasi</label>
                <input type="text" name="nama_prestasi" id="edit_nama_prestasi" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Tingkat</label>
                <select name="tingkat" id="edit_tingkat" class="form-select" required>
                  <option value="sekolah">Sekolah</option>
                  <option value="kecamatan">Kecamatan</option>
                  <option value="kabupaten">Kabupaten</option>
                  <option value="provinsi">Provinsi</option>
                  <option value="nasional">Nasional</option>
                  <option value="internasional">Internasional</option>
                </select>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Juara</label>
                <input type="text" name="juara" id="edit_juara" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Keterangan</label>
            <textarea name="keterangan" id="edit_keterangan" rows="3" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary"><i class="ti ti-device-floppy fs-4"></i> Update</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
function showDetail(id) {
    fetch(`/kesiswaan/prestasi/${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('detailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Nama Siswa:</strong> ${data.siswa.nama_siswa}</p>
                        <p><strong>Kelas:</strong> ${data.siswa.kelas.nama_kelas}</p>
                        <p><strong>Prestasi:</strong> ${data.nama_prestasi}</p>
                        <p><strong>Tingkat:</strong> ${data.tingkat}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Juara:</strong> ${data.juara}</p>
                        <p><strong>Tanggal:</strong> ${new Date(data.tanggal).toLocaleDateString('id-ID')}</p>
                        <p><strong>Keterangan:</strong> ${data.keterangan || '-'}</p>
                    </div>
                </div>
            `;
            new bootstrap.Modal(document.getElementById('modalDetailPrestasi')).show();
        });
}

function editPrestasi(id) {
    fetch(`/kesiswaan/prestasi/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_siswa_id').value = data.siswa_id;
            document.getElementById('edit_nama_prestasi').value = data.nama_prestasi;
            document.getElementById('edit_tingkat').value = data.tingkat;
            document.getElementById('edit_juara').value = data.juara;
            document.getElementById('edit_tanggal').value = data.tanggal;
            document.getElementById('edit_keterangan').value = data.keterangan || '';
            document.getElementById('formEditPrestasi').action = `/kesiswaan/prestasi/${id}`;
            new bootstrap.Modal(document.getElementById('modalEditPrestasi')).show();
        });
}

function deletePrestasi(id) {
    if (confirm('Apakah Anda yakin ingin menghapus data prestasi ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/kesiswaan/prestasi/${id}`;
        form.innerHTML = `@csrf @method('DELETE')`;
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
@endsection
