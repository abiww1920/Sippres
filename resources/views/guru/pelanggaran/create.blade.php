@extends('mainGuru')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-semibold">Input Pelanggaran</h4>
        <p class="text-muted mb-0">Catat pelanggaran siswa</p>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('guru.pelanggaran.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Siswa <span class="text-danger">*</span></label>
                    <select name="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror" required>
                        <option value="">Pilih Siswa</option>
                        @foreach($siswa as $s)
                        <option value="{{ $s->id }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas }}
                        </option>
                        @endforeach
                    </select>
                    @error('siswa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Jenis Pelanggaran <span class="text-danger">*</span></label>
                    <select name="jenis_pelanggaran_id" id="jenis_pelanggaran_id" class="form-select @error('jenis_pelanggaran_id') is-invalid @enderror" required>
                        <option value="">Pilih Jenis Pelanggaran</option>
                        @foreach($jenisPelanggaran->groupBy('kategori') as $kategori => $items)
                        <optgroup label="{{ ucfirst(str_replace('_', ' ', $kategori)) }}">
                            @foreach($items as $jp)
                            <option value="{{ $jp->id }}" {{ old('jenis_pelanggaran_id') == $jp->id ? 'selected' : '' }}>
                                {{ $jp->nama_pelanggaran }} (Poin: {{ $jp->poin }})
                            </option>
                            @endforeach
                        </optgroup>
                        @endforeach
                    </select>
                    @error('jenis_pelanggaran_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- AUTO-SUGGESTION SANKSI -->
                <div id="sanksi-rekomendasi-box" class="alert alert-warning border-warning" style="display: none;">
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
                    <label class="form-label">Deskripsi/Kronologi <span class="text-danger">*</span></label>
                    <textarea name="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Bukti</label>
                    <input type="file" name="foto_bukti" class="form-control @error('foto_bukti') is-invalid @enderror" accept="image/*">
                    <small class="text-muted">Format: JPG, PNG, JPEG (Max: 2MB)</small>
                    @error('foto_bukti')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Simpan
                    </button>
                    <a href="{{ route('guru.pelanggaran') }}" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Kembali
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
