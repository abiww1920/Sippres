<!-- Modal Tambah Sanksi -->
<div class="modal fade" id="modalTambahSanksi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Sanksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.sanksi.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="pelanggaran_id" class="form-label">Pelanggaran</label>
                <select name="pelanggaran_id" id="pelanggaran_id" class="form-select @error('pelanggaran_id') is-invalid @enderror" required>
                  <option value="">Pilih Pelanggaran</option>
                  @foreach($pelanggaran as $p)
                    <option value="{{ $p->id }}">
                      {{ $p->siswa->nama_siswa }} - {{ $p->jenisPelanggaran->nama_pelanggaran }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="jenis_sanksi" class="form-label">Jenis Sanksi</label>
                <select name="jenis_sanksi" id="jenis_sanksi" class="form-select @error('jenis_sanksi') is-invalid @enderror" required>
                  <option value="">Pilih Jenis Sanksi</option>
                  @foreach($jenisSanksi as $js)
                    <option value="{{ $js->nama_sanksi }}">{{ $js->nama_sanksi }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" required>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="deskripsi_sanksi" class="form-label">Deskripsi Sanksi</label>
            <textarea name="deskripsi_sanksi" id="deskripsi_sanksi" rows="3" class="form-control @error('deskripsi_sanksi') is-invalid @enderror" placeholder="Masukkan deskripsi detail sanksi..." required>{{ old('deskripsi_sanksi') }}</textarea>
            @error('deskripsi_sanksi')
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

<!-- Modal Detail Sanksi -->
<div class="modal fade" id="modalDetailSanksi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Sanksi</h5>
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

<!-- Modal Edit Sanksi -->
<div class="modal fade" id="modalEditSanksi" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Sanksi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditSanksi" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Pelanggaran</label>
                <select name="pelanggaran_id" id="edit_pelanggaran_id" class="form-select" required>
                  <option value="">Pilih Pelanggaran</option>
                  @foreach($pelanggaran as $p)
                    <option value="{{ $p->id }}">
                      {{ $p->siswa->nama_siswa }} - {{ $p->jenisPelanggaran->nama_pelanggaran }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Jenis Sanksi</label>
                <select name="jenis_sanksi" id="edit_jenis_sanksi" class="form-select" required>
                  <option value="">Pilih Jenis Sanksi</option>
                  @foreach($jenisSanksi as $js)
                    <option value="{{ $js->nama_sanksi }}">{{ $js->nama_sanksi }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Tanggal Mulai</label>
                <input type="date" name="tanggal_mulai" id="edit_tanggal_mulai" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Tanggal Selesai</label>
                <input type="date" name="tanggal_selesai" id="edit_tanggal_selesai" class="form-control" required>
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" id="edit_status" class="form-select" required>
                  <option value="direncanakan">Direncanakan</option>
                  <option value="berjalan">Berjalan</option>
                  <option value="selesai">Selesai</option>
                  <option value="dibatalkan">Dibatalkan</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Deskripsi Sanksi</label>
            <textarea name="deskripsi_sanksi" id="edit_deskripsi_sanksi" rows="3" class="form-control" required></textarea>
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