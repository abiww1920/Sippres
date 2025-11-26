@extends('mainWaliKelas')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Input Pelanggaran</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('walikelas.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('walikelas.pelanggaran') }}">Pelanggaran</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Input Pelanggaran</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Form Input Pelanggaran Siswa</h5>
      
      <form action="{{ route('walikelas.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="siswa_id" class="form-label">Nama Siswa</label>
              <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                <option value="">Pilih Siswa</option>
                @foreach($kelasWali as $kelas)
                  <optgroup label="{{ $kelas->nama_kelas }}">
                    @foreach($siswa->where('kelas_id', $kelas->id) as $s)
                      <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                        {{ $s->nama_siswa }} - {{ $s->nis }}
                      </option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              @error('siswa_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="jenis_pelanggaran_id" class="form-label">Jenis Pelanggaran</label>
              <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" class="form-select @error('jenis_pelanggaran_id') is-invalid @enderror" required>
                <option value="">Pilih Jenis Pelanggaran</option>
                @foreach($jenisPelanggaran->groupBy('kategori') as $kategori => $items)
                  <optgroup label="{{ ucfirst(str_replace('_', ' ', $kategori)) }}">
                    @foreach($items as $jp)
                      <option value="{{ $jp->id }}" {{ old('jenis_pelanggaran_id') == $jp->id ? 'selected' : '' }}>
                        {{ $jp->nama_pelanggaran }} ({{ $jp->poin }} poin)
                      </option>
                    @endforeach
                  </optgroup>
                @endforeach
              </select>
              @error('jenis_pelanggaran_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <label for="tanggal_pelanggaran" class="form-label">Tanggal Pelanggaran</label>
              <input type="date" name="tanggal_pelanggaran" id="tanggal_pelanggaran" class="form-control @error('tanggal_pelanggaran') is-invalid @enderror" value="{{ old('tanggal_pelanggaran', date('Y-m-d')) }}" required>
              @error('tanggal_pelanggaran')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label for="foto_bukti" class="form-label">Foto Bukti Pelanggaran <span class="text-danger">*</span></label>
              <input type="file" name="foto_bukti" id="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*" required>
              <small class="text-muted">Format: JPG, PNG, JPEG (Max: 2MB)</small>
              @error('foto_bukti')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        
        <!-- AUTO-SUGGESTION SANKSI -->
        <div id="sanksi-rekomendasi-box" class="alert alert-warning border-warning mb-3" style="display: none;">
          <div class="d-flex align-items-start">
            <i class="ti ti-alert-triangle fs-4 me-2"></i>
            <div class="flex-grow-1">
              <h6 class="alert-heading mb-2">⚠️ Informasi Pelanggaran & Sanksi</h6>
              <div class="row g-2">
                <div class="col-md-4">
                  <small class="text-muted d-block">Kategori:</small>
                  <span id="info-kategori" class="badge bg-warning">-</span>
                </div>
                <div class="col-md-4">
                  <small class="text-muted d-block">Poin:</small>
                  <strong id="info-poin" class="text-danger">-</strong>
                </div>
              </div>
              <hr class="my-2">
              <small class="text-muted d-block mb-1">Sanksi Rekomendasi:</small>
              <div id="info-sanksi" class="fw-semibold">-</div>
            </div>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi Pelanggaran</label>
          <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Jelaskan detail pelanggaran yang terjadi..." required>{{ old('deskripsi') }}</textarea>
          @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4"></i> Simpan Pelanggaran
          </button>
          <a href="{{ route('walikelas.pelanggaran') }}" class="btn btn-outline-secondary">
            <i class="ti ti-arrow-left fs-4"></i> Kembali
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-suggestion sanksi saat pilih jenis pelanggaran
    $('#jenis_pelanggaran_id').change(function() {
        let jenisId = $(this).val();
        
        if (!jenisId) {
            $('#sanksi-rekomendasi-box').hide();
            return;
        }
        
        // Ajax get data jenis pelanggaran
        $.ajax({
            url: '/api/jenis-pelanggaran/' + jenisId,
            method: 'GET',
            success: function(data) {
                // Update info
                $('#info-kategori').text(data.kategori_label);
                $('#info-kategori').removeClass('bg-success bg-warning bg-danger bg-dark');
                $('#info-kategori').addClass('bg-' + data.kategori_badge);
                $('#info-poin').text(data.poin + ' poin');
                $('#info-sanksi').text(data.sanksi_rekomendasi || 'Sanksi sesuai kategori');
                
                // Show box dengan animasi
                $('#sanksi-rekomendasi-box').slideDown();
            },
            error: function() {
                $('#sanksi-rekomendasi-box').hide();
            }
        });
    });
});
</script>
@endpush
@endsection