@extends('mainAdmin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-alert-circle text-danger" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-danger mb-1 mt-3">Total Pelanggaran</p>
                        <h5 class="fw-semibold text-danger mb-0">{{ $stats['total_pelanggaran'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-trophy text-success" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-success mb-1 mt-3">Total Prestasi</p>
                        <h5 class="fw-semibold text-success mb-0">{{ $stats['total_prestasi'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-0 zoom-in bg-warning-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-calendar text-warning" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-warning mb-1 mt-3">Pelanggaran Bulan Ini</p>
                        <h5 class="fw-semibold text-warning mb-0">{{ $stats['pelanggaran_bulan_ini'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-0 zoom-in bg-info-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-star text-info" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-info mb-1 mt-3">Prestasi Bulan Ini</p>
                        <h5 class="fw-semibold text-info mb-0">{{ $stats['prestasi_bulan_ini'] }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                        <div class="mb-3 mb-sm-0">
                            <h4 class="card-title fw-semibold">Grafik Pelanggaran</h4>
                            <p class="card-subtitle mb-0">Statistik Tahun Ini</p>
                        </div>
                    </div>
                    <div style="height: 300px;">
                        <canvas id="chartPelanggaranBulan"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-4">Pelanggaran Per Kategori</h4>
                    <div style="height: 300px;">
                        <canvas id="chartPelanggaranKategori"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-4">
            <div class="card hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger-subtle rounded me-3 p-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-file-text text-danger fs-6"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold mb-0">Laporan Pelanggaran</h5>
                            <p class="fs-3 mb-0 text-muted">Export PDF/Excel</p>
                        </div>
                    </div>
                    <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#laporanPelanggaranModal">
                        <i class="ti ti-download"></i> Generate Laporan
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-success-subtle rounded me-3 p-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-award text-success fs-6"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold mb-0">Laporan Prestasi</h5>
                            <p class="fs-3 mb-0 text-muted">Export PDF</p>
                        </div>
                    </div>
                    <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#laporanPrestasiModal">
                        <i class="ti ti-download"></i> Generate Laporan
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-info-subtle rounded me-3 p-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-chart-bar text-info fs-6"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold mb-0">Rekap Bulanan</h5>
                            <p class="fs-3 mb-0 text-muted">Per Kelas & Periode</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.laporan.rekap-bulanan') }}" class="btn btn-info w-100">
                        <i class="ti ti-eye"></i> Lihat Rekap
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="laporanPelanggaranModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.laporan.pelanggaran') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Laporan Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Format</label>
                        <select name="type" class="form-control">
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="laporanPrestasiModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.laporan.prestasi') }}" method="GET">
                <div class="modal-header">
                    <h5 class="modal-title">Filter Laporan Prestasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Format</label>
                        <select name="type" class="form-control">
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Generate</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.zoom-in {
    transition: transform 0.3s ease;
}
.zoom-in:hover {
    transform: scale(1.05);
}
.hover-shadow {
    transition: box-shadow 0.3s ease;
}
.hover-shadow:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
console.log('Data Stats:', @json($stats));
console.log('Data Pelanggaran Per Bulan:', @json($pelanggaranPerBulan));
console.log('Data Pelanggaran Per Kategori:', @json($pelanggaranPerKategori));

// Chart Pelanggaran Per Bulan
const ctxBulan = document.getElementById('chartPelanggaranBulan');
if (!ctxBulan) {
    console.error('Canvas chartPelanggaranBulan tidak ditemukan!');
} else {
    const dataBulan = @json($pelanggaranPerBulan);
    const labelsBulan = dataBulan.map(item => {
    const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return bulan[item.bulan - 1];
});
const valuesBulan = dataBulan.map(item => item.total);

new Chart(ctxBulan, {
    type: 'line',
    data: {
        labels: labelsBulan,
        datasets: [{
            label: 'Jumlah Pelanggaran',
            data: valuesBulan,
            borderColor: 'rgb(220, 53, 69)',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
}

// Chart Pelanggaran Per Kategori
const ctxKategori = document.getElementById('chartPelanggaranKategori');
if (!ctxKategori) {
    console.error('Canvas chartPelanggaranKategori tidak ditemukan!');
} else {
    const dataKategori = @json($pelanggaranPerKategori);
const labelsKategori = dataKategori.map(item => item.kategori);
const valuesKategori = dataKategori.map(item => item.total);

new Chart(ctxKategori, {
    type: 'doughnut',
    data: {
        labels: labelsKategori,
        datasets: [{
            data: valuesKategori,
            backgroundColor: [
                'rgba(255, 193, 7, 0.8)',
                'rgba(255, 152, 0, 0.8)',
                'rgba(244, 67, 54, 0.8)',
                'rgba(183, 28, 28, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                position: 'bottom',
                labels: {
                    padding: 10,
                    font: { size: 12 }
                }
            }
        }
    }
});
}
</script>
@endpush
