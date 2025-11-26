@extends('mainWaliKelas')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Generate Laporan Pelanggaran Kelas</h5>
            
            <div class="alert alert-info">
                <i class="ti ti-info-circle"></i> Laporan ini berisi data pelanggaran siswa di kelas yang Anda ampu sebagai wali kelas.
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-semibold">Kelas yang Diampu</h6>
                            <p class="mb-0">{{ $kelasWali->pluck('nama_kelas')->join(', ') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
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

            <form action="{{ route('walikelas.laporan.pdf') }}" method="GET">
                <button type="submit" class="btn btn-danger">
                    <i class="ti ti-file-download"></i> Download Laporan PDF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
