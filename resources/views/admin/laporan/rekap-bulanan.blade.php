@extends('layout.main')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Rekap Bulanan - {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}</h5>
            <div>
                <a href="{{ route('admin.laporan.rekap-bulanan', ['bulan' => $bulan, 'tahun' => $tahun, 'type' => 'pdf']) }}" class="btn btn-danger btn-sm">
                    <i class="ti ti-file-pdf"></i> Export PDF
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label>Bulan</label>
                    <select name="bulan" class="form-select">
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ $bulan == $i ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Tahun</label>
                    <select name="tahun" class="form-select">
                        @for($i = date('Y'); $i >= date('Y') - 5; $i--)
                            <option value="{{ $i }}" {{ $tahun == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block">Filter</button>
                </div>
            </form>

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h3>{{ $pelanggaran->count() }}</h3>
                            <p class="mb-0">Total Pelanggaran</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h3>{{ $prestasi->count() }}</h3>
                            <p class="mb-0">Total Prestasi</p>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="mb-3">Rekap Per Kelas</h6>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Total Pelanggaran</th>
                            <th>Total Prestasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rekapPerKelas as $kelas)
                        <tr>
                            <td>{{ $kelas->nama_kelas }}</td>
                            <td><span class="badge bg-danger">{{ $kelas->total_pelanggaran }}</span></td>
                            <td><span class="badge bg-success">{{ $kelas->total_prestasi }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
