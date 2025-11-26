@extends('mainGuru')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="card border-0 zoom-in bg-danger-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-alert-circle text-danger" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-danger mb-1 mt-3">Total Pelanggaran</p>
                        <h5 class="fw-semibold text-danger mb-0">{{ $totalPelanggaran }}</h5>
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
                        <h5 class="fw-semibold text-warning mb-0">{{ $pelanggaranBulanIni }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-0 zoom-in bg-primary-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-users text-primary" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-primary mb-1 mt-3">Total Siswa</p>
                        <h5 class="fw-semibold text-primary mb-0">{{ $totalSiswa }}</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card border-0 zoom-in bg-success-subtle shadow-none">
                <div class="card-body">
                    <div class="text-center">
                        <i class="ti ti-check text-success" style="font-size: 50px;"></i>
                        <p class="fw-semibold fs-3 text-success mb-1 mt-3">Siswa Tanpa Pelanggaran</p>
                        <h5 class="fw-semibold text-success mb-0">{{ $siswaBaik }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-4">Pelanggaran yang Saya Catat</h4>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Siswa</th>
                                    <th>Kelas</th>
                                    <th>Jenis Pelanggaran</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pelanggaranTerbaru as $p)
                                <tr>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $p->siswa->nama_siswa }}</td>
                                    <td>{{ $p->siswa->kelas->nama_kelas }}</td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                                    <td><span class="badge bg-danger">{{ $p->jenisPelanggaran->poin }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada data pelanggaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title fw-semibold mb-4">Pelanggaran Per Kategori</h4>
                    <div class="d-flex justify-content-center">
                        <canvas id="chartKategori" style="max-height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger-subtle rounded me-3 p-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-file-plus text-danger fs-6"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold mb-0">Input Pelanggaran</h5>
                            <p class="fs-3 mb-0 text-muted">Catat pelanggaran siswa</p>
                        </div>
                    </div>
                    <a href="{{ route('guru.pelanggaran') }}" class="btn btn-danger w-100">
                        <i class="ti ti-plus"></i> Input Pelanggaran
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card hover-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary-subtle rounded me-3 p-3 d-flex align-items-center justify-content-center">
                            <i class="ti ti-users text-primary fs-6"></i>
                        </div>
                        <div>
                            <h5 class="fw-semibold mb-0">Data Siswa</h5>
                            <p class="fs-3 mb-0 text-muted">Lihat data siswa</p>
                        </div>
                    </div>
                    <a href="{{ route('guru.siswa') }}" class="btn btn-primary w-100">
                        <i class="ti ti-eye"></i> Lihat Data Siswa
                    </a>
                </div>
            </div>
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
const ctxKategori = document.getElementById('chartKategori').getContext('2d');
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
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
@endpush