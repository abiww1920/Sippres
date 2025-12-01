@extends('mainWaliKelas')

@section('content')
<div class="container-fluid">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="ti ti-alert-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Generate Laporan Kelas</h5>
            
            <div class="alert alert-info">
                <i class="ti ti-info-circle"></i> Pilih jenis laporan yang ingin dibuat untuk kelas yang Anda ampu sebagai wali kelas.
            </div>
            


            <!-- Kelas yang Diampu -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-semibold">Kelas yang Diampu</h6>
                            <p class="mb-0">
                                @if($kelasWali->count() > 0)
                                    {{ $kelasWali->pluck('nama_kelas')->join(', ') }}
                                @else
                                    <em class="text-muted">Tidak ada kelas yang diampu</em>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik Ringkas -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-primary">{{ $totalSiswa }}</h3>
                            <p class="mb-0">Total Siswa</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-danger">{{ $totalPelanggaran }}</h3>
                            <p class="mb-0">Total Pelanggaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h3 class="text-success">{{ $totalPrestasi }}</h3>
                            <p class="mb-0">Total Prestasi</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($kelasWali->count() > 0)
                <!-- Jenis Laporan -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="fw-semibold mb-3">Jenis Laporan yang Tersedia:</h6>
                        
                        <!-- Tab Navigation -->
                        <ul class="nav nav-tabs" id="laporanTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="bulanan-tab" data-bs-toggle="tab" data-bs-target="#bulanan" type="button" role="tab">
                                    <i class="ti ti-calendar-month"></i> Laporan Bulanan
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="persiswa-tab" data-bs-toggle="tab" data-bs-target="#persiswa" type="button" role="tab">
                                    <i class="ti ti-user"></i> Per Siswa
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sanksi-tab" data-bs-toggle="tab" data-bs-target="#sanksi" type="button" role="tab">
                                    <i class="ti ti-shield-check"></i> Sanksi
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="semester-tab" data-bs-toggle="tab" data-bs-target="#semester" type="button" role="tab">
                                    <i class="ti ti-calendar-time"></i> Semester
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="sikap-tab" data-bs-toggle="tab" data-bs-target="#sikap" type="button" role="tab">
                                    <i class="ti ti-award"></i> Penilaian Sikap
                                </button>
                            </li>
                        </ul>

                        <!-- Tab Content -->
                        <div class="tab-content mt-3" id="laporanTabsContent">
                            <!-- Laporan Bulanan -->
                            <div class="tab-pane fade show active" id="bulanan" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Laporan Bulanan Kelas</h6>
                                        <p class="text-muted">Ringkasan pelanggaran dan prestasi kelas per bulan, statistik kedisiplinan, daftar siswa bermasalah, dan rekomendasi tindak lanjut.</p>
                                        
                                        <form action="{{ route('walikelas.laporan.pdf') }}" method="GET">
                                            <input type="hidden" name="type" value="bulanan">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Bulan</label>
                                                    <select class="form-select" name="bulan">
                                                        @for($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}" {{ $i == date('n') ? 'selected' : '' }}>
                                                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tahun</label>
                                                    <select class="form-select" name="tahun">
                                                        @for($y = date('Y')-2; $y <= date('Y')+1; $y++)
                                                            <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Konten Laporan</label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="konten[]" value="pelanggaran" checked>
                                                    <label class="form-check-label">Data Pelanggaran</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="konten[]" value="prestasi" checked>
                                                    <label class="form-check-label">Data Prestasi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="konten[]" value="sanksi" checked>
                                                    <label class="form-check-label">Data Sanksi</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="konten[]" value="grafik" checked>
                                                    <label class="form-check-label">Grafik/Visualisasi</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="ti ti-file-type-pdf"></i> Download PDF
                                            </button>
                                            <button type="button" class="btn btn-outline-primary" onclick="previewLaporan('bulanan')">
                                                <i class="ti ti-eye"></i> Preview
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Laporan Per Siswa -->
                            <div class="tab-pane fade" id="persiswa" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Laporan Per Siswa</h6>
                                        <p class="text-muted">Profil lengkap siswa, riwayat pelanggaran dan prestasi, grafik perkembangan, dan catatan pembinaan.</p>
                                        
                                        <form action="{{ route('walikelas.laporan.pdf') }}" method="GET">
                                            <input type="hidden" name="type" value="persiswa">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Siswa</label>
                                                <select class="form-select" name="siswa_id">
                                                    <option value="all">Semua Siswa</option>
                                                    @foreach($siswaList as $siswa)
                                                        <option value="{{ $siswa->id }}">{{ $siswa->nama_siswa }} - {{ $siswa->kelas->nama_kelas ?? 'Tanpa Kelas' }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Dari Tanggal</label>
                                                    <input type="date" class="form-control" name="dari_tanggal" value="{{ date('Y-m-01') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Sampai Tanggal</label>
                                                    <input type="date" class="form-control" name="sampai_tanggal" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="ti ti-file-type-pdf"></i> Download PDF
                                            </button>
                                            <button type="submit" name="format" value="excel" class="btn btn-success me-2">
                                                <i class="ti ti-file-type-xls"></i> Download Excel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Laporan Sanksi -->
                            <div class="tab-pane fade" id="sanksi" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Laporan Sanksi</h6>
                                        <p class="text-muted">Daftar sanksi yang telah dilaksanakan, status pelaksanaan sanksi, dan evaluasi efektivitas sanksi.</p>
                                        
                                        <form action="{{ route('walikelas.laporan.pdf') }}" method="GET">
                                            <input type="hidden" name="type" value="sanksi">
                                            <div class="mb-3">
                                                <label class="form-label">Status Sanksi</label>
                                                <select class="form-select" name="status_sanksi">
                                                    <option value="all">Semua Status</option>
                                                    <option value="belum_dilaksanakan">Belum Dilaksanakan</option>
                                                    <option value="sedang_dilaksanakan">Sedang Dilaksanakan</option>
                                                    <option value="selesai">Selesai</option>
                                                </select>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Dari Tanggal</label>
                                                    <input type="date" class="form-control" name="dari_tanggal" value="{{ date('Y-m-01') }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Sampai Tanggal</label>
                                                    <input type="date" class="form-control" name="sampai_tanggal" value="{{ date('Y-m-d') }}">
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="ti ti-file-type-pdf"></i> Download PDF
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Laporan Semester -->
                            <div class="tab-pane fade" id="semester" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Laporan Semester</h6>
                                        <p class="text-muted">Rekap satu semester, perbandingan antar bulan, analisis tren, dan rekomendasi untuk semester depan.</p>
                                        
                                        <form action="{{ route('walikelas.laporan.pdf') }}" method="GET">
                                            <input type="hidden" name="type" value="semester">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Semester</label>
                                                    <select class="form-select" name="semester">
                                                        <option value="1" {{ date('n') <= 6 ? 'selected' : '' }}>Semester 1 (Juli - Desember)</option>
                                                        <option value="2" {{ date('n') > 6 ? 'selected' : '' }}>Semester 2 (Januari - Juni)</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tahun Ajaran</label>
                                                    <select class="form-select" name="tahun_ajaran">
                                                        <option value="{{ date('Y') }}/{{ date('Y')+1 }}">{{ date('Y') }}/{{ date('Y')+1 }}</option>
                                                        <option value="{{ date('Y')-1 }}/{{ date('Y') }}">{{ date('Y')-1 }}/{{ date('Y') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="ti ti-file-type-pdf"></i> Download PDF
                                            </button>
                                            <button type="submit" name="format" value="word" class="btn btn-info me-2">
                                                <i class="ti ti-file-type-doc"></i> Download Word
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Laporan Penilaian Sikap -->
                            <div class="tab-pane fade" id="sikap" role="tabpanel">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Laporan Penilaian Sikap</h6>
                                        <p class="text-muted">Untuk rapor/penilaian sikap berdasarkan akumulasi data pelanggaran dan prestasi dengan penilaian kualitatif.</p>
                                        
                                        <form action="{{ route('walikelas.laporan.pdf') }}" method="GET">
                                            <input type="hidden" name="type" value="sikap">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Periode Penilaian</label>
                                                    <select class="form-select" name="periode">
                                                        <option value="semester1">Semester 1</option>
                                                        <option value="semester2">Semester 2</option>
                                                        <option value="tahunan">Tahunan</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Format Output</label>
                                                    <select class="form-select" name="format_sikap">
                                                        <option value="grade">Grade (A, B, C, D)</option>
                                                        <option value="deskriptif">Deskriptif Kualitatif</option>
                                                        <option value="lengkap">Lengkap (Grade + Deskriptif)</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="include_rekomendasi" checked>
                                                    <label class="form-check-label">Sertakan Rekomendasi Perbaikan</label>
                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary me-2">
                                                <i class="ti ti-file-type-pdf"></i> Download PDF
                                            </button>
                                            <button type="submit" name="format" value="excel" class="btn btn-success me-2">
                                                <i class="ti ti-file-type-xls"></i> Download Excel
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-warning">
                    <i class="ti ti-alert-triangle"></i> Tidak dapat menggenerate laporan karena tidak ada kelas yang diampu.
                </div>
            @endif
        </div>
    </div>

    <!-- Tips Card -->
    @if($kelasWali->count() > 0)
    <div class="card mt-4">
        <div class="card-body">
            <h6 class="card-title"><i class="ti ti-bulb"></i> Tips Membuat Laporan yang Baik</h6>
            <div class="row">
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li><i class="ti ti-check text-success"></i> Rutin dan konsisten setiap akhir bulan</li>
                        <li><i class="ti ti-check text-success"></i> Objektif dan faktual berdasarkan data</li>
                        <li><i class="ti ti-check text-success"></i> Lengkapi dengan visualisasi grafik</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-unstyled">
                        <li><i class="ti ti-check text-success"></i> Berikan analisis mendalam dan insight</li>
                        <li><i class="ti ti-check text-success"></i> Sertakan rekomendasi yang actionable</li>
                        <li><i class="ti ti-check text-success"></i> Simpan sebagai arsip dokumentasi</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
function previewLaporan(type) {
    const form = document.querySelector(`#${type} form`);
    const formData = new FormData(form);
    const params = new URLSearchParams(formData);
    params.set('preview', '1');
    
    const url = `{{ route('walikelas.laporan.pdf') }}?${params.toString()}`;
    window.open(url, '_blank', 'width=800,height=600,scrollbars=yes');
}
</script>
@endsection