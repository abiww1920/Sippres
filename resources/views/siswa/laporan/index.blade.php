@extends('mainSiswa')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Generate Laporan Pelanggaran Saya</h5>
            
            <div class="alert alert-info">
                <i class="ti ti-info-circle"></i> Laporan ini berisi data pelanggaran Anda beserta status sanksi berdasarkan total poin.
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="fw-semibold">Data Saya</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $siswa->nama_siswa }}</p>
                            <p class="mb-1"><strong>NIS:</strong> {{ $siswa->nis }}</p>
                            <p class="mb-0"><strong>Kelas:</strong> {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('siswa.laporan.pdf') }}" method="GET">
                <button type="submit" class="btn btn-danger">
                    <i class="ti ti-file-download"></i> Download Laporan PDF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
