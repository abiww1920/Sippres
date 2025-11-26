@extends('mainKepsek')
@section('content')
<div class="container-fluid" style="padding-top: 1.5rem;">
    <!-- Header -->
    <div class="mb-4">
        <h4 class="fw-semibold mb-2">Laporan Pelanggaran</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="{{ route('kepsek.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Laporan Pelanggaran</li>
            </ol>
        </nav>
    </div>

    <!-- Filter & Export -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="d-md-flex align-items-center mb-3">
                <div>
                    <h4 class="card-title">Filter & Export</h4>
                    <p class="card-subtitle">Filter data dan ekspor laporan</p>
                </div>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Dari Tanggal</label>
                    <input type="date" class="form-control" id="filterDari">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Sampai Tanggal</label>
                    <input type="date" class="form-control" id="filterSampai">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Kelas</label>
                    <select class="form-select theme-select border-0" id="filterKelas">
                        <option value="">Semua Kelas</option>
                        @foreach($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Kategori</label>
                    <select class="form-select theme-select border-0" id="filterKategori">
                        <option value="">Semua Kategori</option>
                        <option value="Ringan">Ringan</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Berat">Berat</option>
                        <option value="Sangat Berat">Sangat Berat</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <button class="btn btn-primary me-2" id="btnFilter">
                        <i class="ti ti-search"></i> Filter
                    </button>
                    <button class="btn btn-success me-2" id="btnExcelPelanggaran">
                        <i class="ti ti-file-spreadsheet"></i> Excel
                    </button>
                    <button class="btn btn-danger" id="btnPdfPelanggaran">
                        <i class="ti ti-file-pdf"></i> PDF
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-subtitle mb-2">Total Pelanggaran</p>
                    <h3 class="fw-semibold mb-0">{{ $totalPelanggaran }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-subtitle mb-2">Rata-rata Poin</p>
                    <h3 class="fw-semibold mb-0">{{ number_format($rataRataPoin, 1) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-subtitle mb-2">Siswa Terlibat</p>
                    <h3 class="fw-semibold mb-0">{{ $siswaTerlibat }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <p class="card-subtitle mb-2">Verifikasi Pending</p>
                    <h3 class="fw-semibold mb-0">{{ $verifikasiPending }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Tren Pelanggaran</h4>
                    <div id="trendChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Distribusi Kategori</h4>
                    <div id="categoryChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Detail Pelanggaran</h4>
            <p class="card-subtitle mb-4">Data lengkap pelanggaran siswa</p>
            <div class="table-responsive">
                <table class="table mb-0 text-nowrap varient-table align-middle fs-3" id="laporanTable">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Siswa</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Kategori</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggaranList as $pelanggaran)
                        <tr>
                            <td><p class="mb-0 fw-normal fs-4">{{ $loop->iteration }}</p></td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->created_at->format('d M Y') }}</p></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($pelanggaran->siswa->foto && file_exists(public_path('uploads/siswa/' . $pelanggaran->siswa->foto)))
                                        <img src="{{ asset('uploads/siswa/' . $pelanggaran->siswa->foto) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    @else
                                        <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                                    @endif
                                    <div class="ms-3">
                                        <h6 class="fs-4 fw-semibold mb-0">{{ $pelanggaran->siswa->nama_siswa }}</h6>
                                        <span class="fw-normal">NIS: {{ $pelanggaran->siswa->nis }}</span>
                                    </div>
                                </div>
                            </td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->siswa->kelas->nama_kelas }}</p></td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</p></td>
                            <td>
                                @php
                                    $kategori = $pelanggaran->jenisPelanggaran->kategori;
                                    $badgeClass = match($kategori) {
                                        'ringan' => 'bg-success-subtle text-success',
                                        'sedang' => 'bg-warning-subtle text-warning',
                                        'berat' => 'bg-danger-subtle text-danger',
                                        'sangat_berat' => 'bg-primary-subtle text-primary',
                                        default => 'bg-secondary-subtle text-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $kategori)) }}</span>
                            </td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->poin }}</p></td>
                            <td>
                                @if($pelanggaran->status_verifikasi == 'menunggu')
                                    <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                                @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                                    <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <span class="text-muted">Tidak ada data pelanggaran</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('btnFilter').addEventListener('click', function() {
    const dari = document.getElementById('filterDari').value;
    const sampai = document.getElementById('filterSampai').value;
    const kelas = document.getElementById('filterKelas').value;
    const kategori = document.getElementById('filterKategori').value;
    
    const params = new URLSearchParams();
    if (dari) params.append('dari', dari);
    if (sampai) params.append('sampai', sampai);
    if (kelas) params.append('kelas', kelas);
    if (kategori) params.append('kategori', kategori);
    
    window.location.href = `/kepsek/laporan?${params.toString()}`;
});

document.getElementById('btnExcelPelanggaran').addEventListener('click', function() {
    window.location.href = '/kepsek/laporan/export-excel';
});

document.getElementById('btnPdfPelanggaran').addEventListener('click', function() {
    window.location.href = '/kepsek/laporan/export-pdf';
});

document.addEventListener('DOMContentLoaded', function() {
    var trendData = @json($trendData ?? []);
    var categoryData = @json($categoryData ?? []);
    
    if (trendData.length > 0) {
        var trendOptions = {
            series: [{
                name: 'Pelanggaran',
                data: trendData.map(item => item.total)
            }],
            chart: {
                type: 'line',
                height: 300,
                fontFamily: 'inherit',
                toolbar: { show: false }
            },
            colors: ['#5D87FF'],
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: trendData.map(item => item.bulan),
                axisBorder: { show: false }
            },
            grid: { borderColor: '#e0e0e0' }
        };
        new ApexCharts(document.querySelector('#trendChart'), trendOptions).render();
    }
    
    if (categoryData.length > 0) {
        var categoryOptions = {
            series: categoryData.map(item => item.total),
            chart: { type: 'pie', height: 300, fontFamily: 'inherit' },
            labels: categoryData.map(item => item.kategori),
            colors: ['#13DEB9', '#FFAE1F', '#FA896B', '#8B5CF6']
        };
        new ApexCharts(document.querySelector('#categoryChart'), categoryOptions).render();
    }
});
</script>
@endpush

@endsection
