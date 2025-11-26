@extends('mainKesiswaan')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-4">Generate Laporan Pelanggaran</h5>
            
            <div class="alert alert-info">
                <i class="ti ti-info-circle"></i> Generate laporan pelanggaran siswa dengan filter kelas dan tanggal.
            </div>

            <form action="{{ route('kesiswaan.laporan.pdf') }}" method="GET">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Kelas (Opsional)</label>
                        <select name="kelas_id" class="form-select">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Dari</label>
                        <input type="date" name="tanggal_dari" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" class="form-control">
                    </div>
                </div>

                <button type="submit" class="btn btn-danger">
                    <i class="ti ti-file-download"></i> Download Laporan PDF
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
