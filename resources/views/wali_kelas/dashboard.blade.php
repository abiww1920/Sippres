@extends('mainWaliKelas')

@section('title', 'Dashboard Wali Kelas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Dashboard Wali Kelas</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Menu Utama</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('walikelas.pelanggaran.create') }}" class="btn btn-danger btn-block mb-2">
                                <i class="mdi mdi-alert-circle"></i> Input Pelanggaran
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('walikelas.pelanggaran') }}" class="btn btn-info btn-block mb-2">
                                <i class="mdi mdi-eye"></i> Lihat Data Pelanggaran
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{ route('walikelas.laporan') }}" class="btn btn-success btn-block mb-2">
                                <i class="mdi mdi-file-export"></i> Export Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Siswa</h5>
                            <h3 class="my-2 py-1">{{ $totalSiswa }}</h3>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="campaign-sent-chart" data-colors="#727cf5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Pelanggaran</h5>
                            <h3 class="my-2 py-1">{{ $totalPelanggaran }}</h3>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="campaign-opened-chart" data-colors="#e3eaef"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Pelanggaran Bulan Ini</h5>
                            <h3 class="my-2 py-1">{{ $pelanggaranBulanIni }}</h3>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="campaign-clicked-chart" data-colors="#727cf5"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <h5 class="text-muted fw-normal mt-0 text-truncate">Total Prestasi</h5>
                            <h3 class="my-2 py-1">{{ $totalPrestasi }}</h3>
                        </div>
                        <div class="col-6">
                            <div class="text-end">
                                <div id="campaign-unsubscribed-chart" data-colors="#0acf97"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kelas yang Diampu -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Kelas yang Diampu</h4>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>Nama Kelas</th>
                                    <th>Jurusan</th>
                                    <th>Jumlah Siswa</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kelasWali as $kelas)
                                <tr>
                                    <td>{{ $kelas->nama_kelas }}</td>
                                    <td>{{ $kelas->jurusan ?? '-' }}</td>
                                    <td>{{ $kelas->siswa->count() }}</td>
                                    <td>
                                        <a href="{{ route('walikelas.pelanggaran') }}" class="btn btn-sm btn-primary">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Pelanggaran Terbaru</h4>
                    @foreach($pelanggaranTerbaru as $pelanggaran)
                    <div class="timeline-alt pb-2">
                        <div class="timeline-item">
                            <i class="mdi mdi-circle bg-danger-lighten text-danger timeline-icon"></i>
                            <div class="timeline-item-info">
                                <h5 class="mt-0 mb-1">{{ $pelanggaran->siswa->nama_siswa }}</h5>
                                <p class="font-14">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? 'N/A' }}</p>
                                <p class="text-muted font-12 mb-0">{{ $pelanggaran->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Prestasi Terbaru</h4>
                    @foreach($prestasiTerbaru as $prestasi)
                    <div class="timeline-alt pb-2">
                        <div class="timeline-item">
                            <i class="mdi mdi-circle bg-success-lighten text-success timeline-icon"></i>
                            <div class="timeline-item-info">
                                <h5 class="mt-0 mb-1">{{ $prestasi->siswa->nama_siswa }}</h5>
                                <p class="font-14">{{ $prestasi->jenisPrestasi->nama_prestasi ?? 'N/A' }}</p>
                                <p class="text-muted font-12 mb-0">{{ $prestasi->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection