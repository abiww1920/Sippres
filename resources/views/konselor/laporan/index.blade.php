@extends('mainKonselor')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Laporan Bimbingan Konseling</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Laporan</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="mb-4">
            <h5 class="fw-semibold">Filter Laporan</h5>
            <form method="GET" class="row g-3 mt-1">
              <div class="col-md-4">
                <label for="bulan" class="form-label">Bulan</label>
                <input type="month" class="form-control" id="bulan" name="bulan" value="{{ request('bulan') }}">
              </div>
              <div class="col-md-4">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status">
                  <option value="">-- Semua Status --</option>
                  <option value="terjadwal" {{ request('status') == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                  <option value="proses" {{ request('status') == 'proses' ? 'selected' : '' }}>Proses</option>
                  <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
              </div>
              <div class="col-md-4 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                  <i class="ti ti-search"></i> Filter
                </button>
                <a href="{{ route('konselor.laporan.index') }}" class="btn btn-secondary">
                  <i class="ti ti-refresh"></i> Reset
                </a>
              </div>
            </form>
          </div>

          <hr>

          <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="fw-semibold">Data Bimbingan</h5>
              <div class="gap-2 d-flex">
                <a href="{{ route('konselor.laporan.export-excel') }}" class="btn btn-success btn-sm">
                  <i class="ti ti-file-spreadsheet"></i> Export Excel
                </a>
                <a href="{{ route('konselor.laporan.export-pdf') }}" class="btn btn-danger btn-sm">
                  <i class="ti ti-file-pdf"></i> Export PDF
                </a>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                <thead>
                  <tr>
                    <th scope="col" class="px-0 text-muted">No</th>
                    <th scope="col" class="px-0 text-muted">Siswa</th>
                    <th scope="col" class="px-0 text-muted">Kelas</th>
                    <th scope="col" class="px-0 text-muted">Topik</th>
                    <th scope="col" class="px-0 text-muted">Tanggal</th>
                    <th scope="col" class="px-0 text-muted">Status</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($laporan ?? [] as $item)
                  <tr>
                    <td class="px-0">{{ $loop->iteration }}</td>
                    <td class="px-0">{{ $item->siswa->nama_siswa ?? '-' }}</td>
                    <td class="px-0">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="px-0">{{ $item->topik ?? '-' }}</td>
                    <td class="px-0">{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                    <td class="px-0">
                      @if($item->status == 'selesai')
                        <span class="badge bg-success">Selesai</span>
                      @elseif($item->status == 'proses')
                        <span class="badge bg-warning">Proses</span>
                      @else
                        <span class="badge bg-info">Terjadwal</span>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="6" class="text-center py-4">
                      <span class="text-muted">Tidak ada data laporan</span>
                    </td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
