<!-- Modal Tambah Tahun Ajaran -->
<div class="modal fade" id="modalTambahTahunAjaran" tabindex="-1" aria-labelledby="modalTambahTahunAjaranLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTambahTahunAjaranLabel">
          <i class="ti ti-plus fs-4 me-2"></i>Tambah Tahun Ajaran
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.tahun-ajaran.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="mb-3">
            <label for="tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" 
                   id="tahun_ajaran" name="tahun_ajaran" 
                   placeholder="Contoh: 2024/2025" 
                   pattern="\d{4}/\d{4}"
                   title="Format harus YYYY/YYYY"
                   value="{{ old('tahun_ajaran') }}" required>
            @error('tahun_ajaran')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">Format: YYYY/YYYY (contoh: 2024/2025)</div>
          </div>

          <div class="mb-3">
            <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
            <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
              <option value="">Pilih Semester</option>
              <option value="ganjil" {{ old('semester') == 'ganjil' ? 'selected' : '' }}>Ganjil</option>
              <option value="genap" {{ old('semester') == 'genap' ? 'selected' : '' }}>Genap</option>
            </select>
            @error('semester')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="status_aktif" name="status_aktif" value="1" {{ old('status_aktif') ? 'checked' : '' }}>
              <label class="form-check-label" for="status_aktif">
                Aktifkan tahun ajaran ini
              </label>
            </div>
            <div class="form-text">Jika dicentang, tahun ajaran lain akan dinonaktifkan secara otomatis</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4 me-2"></i>Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit Tahun Ajaran -->
<div class="modal fade" id="modalEditTahunAjaran" tabindex="-1" aria-labelledby="modalEditTahunAjaranLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditTahunAjaranLabel">
          <i class="ti ti-edit fs-4 me-2"></i>Edit Tahun Ajaran
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="formEditTahunAjaran" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit_id" name="id">
        <div class="modal-body">
          <div class="mb-3">
            <label for="edit_tahun_ajaran" class="form-label">Tahun Ajaran <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="edit_tahun_ajaran" name="tahun_ajaran" 
                   placeholder="Contoh: 2024/2025" 
                   pattern="\d{4}/\d{4}"
                   title="Format harus YYYY/YYYY"
                   required>
            <div class="form-text">Format: YYYY/YYYY (contoh: 2024/2025)</div>
          </div>

          <div class="mb-3">
            <label for="edit_semester" class="form-label">Semester <span class="text-danger">*</span></label>
            <select class="form-select" id="edit_semester" name="semester" required>
              <option value="">Pilih Semester</option>
              <option value="ganjil">Ganjil</option>
              <option value="genap">Genap</option>
            </select>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="edit_status_aktif" name="status_aktif" value="1">
              <label class="form-check-label" for="edit_status_aktif">
                Aktifkan tahun ajaran ini
              </label>
            </div>
            <div class="form-text">Jika dicentang, tahun ajaran lain akan dinonaktifkan secara otomatis</div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4 me-2"></i>Perbarui
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Detail Tahun Ajaran -->
<div class="modal fade" id="modalDetailTahunAjaran" tabindex="-1" aria-labelledby="modalDetailTahunAjaranLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalDetailTahunAjaranLabel">
          <i class="ti ti-eye fs-4 me-2"></i>Detail Tahun Ajaran
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="detailContent">
          <!-- Content will be loaded here -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
// Update form action when editing
document.addEventListener('DOMContentLoaded', function() {
    const editModal = document.getElementById('modalEditTahunAjaran');
    editModal.addEventListener('show.bs.modal', function() {
        const id = document.getElementById('edit_id').value;
        const form = document.getElementById('formEditTahunAjaran');
        form.action = `/admin/tahun-ajaran/${id}`;
    });
});
</script>