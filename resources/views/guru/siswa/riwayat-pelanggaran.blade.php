@extends('mainGuru')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-semibold">Riwayat Pelanggaran - {{ $siswa->nama_siswa }}</h4>
        <p class="text-muted mb-0">NIS: {{ $siswa->nis }} | Kelas: {{ $siswa->kelas->nama_kelas }}</p>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title fw-semibold mb-3">Filter Riwayat Pelanggaran</h5>
            <form method="GET" action="{{ route('guru.siswa.riwayat-pelanggaran', $siswa->id) }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" name="start_date" value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date" value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jenis Pelanggaran</label>
                        <select class="form-select" name="jenis_pelanggaran">
                            <option value="">Semua Jenis</option>
                            @foreach(\App\Models\JeniPelanggaran::orderBy('nama_pelanggaran')->get() as $jp)
                                <option value="{{ $jp->id }}" {{ request('jenis_pelanggaran') == $jp->id ? 'selected' : '' }}>
                                    {{ $jp->nama_pelanggaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="ti ti-search"></i> Filter
                            </button>
                            <a href="{{ route('guru.siswa.riwayat-pelanggaran', $siswa->id) }}" class="btn btn-outline-secondary btn-sm">
                                <i class="ti ti-refresh"></i> Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Riwayat Pelanggaran -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h5 class="card-title fw-semibold mb-0">Riwayat Pelanggaran</h5>
                @if(request()->hasAny(['start_date', 'end_date', 'jenis_pelanggaran']))
                    <small class="text-muted">
                        Hasil filter: 
                        @if(request('start_date')) Dari: {{ request('start_date') }} @endif
                        @if(request('end_date')) Sampai: {{ request('end_date') }} @endif
                        @if(request('jenis_pelanggaran')) 
                            Jenis: {{ \App\Models\JeniPelanggaran::find(request('jenis_pelanggaran'))->nama_pelanggaran ?? '' }}
                        @endif
                    </small>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                    <thead class="text-dark fs-4">
                        <tr>
                            <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Tingkat</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Keterangan</h6></th>
                            <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggaran as $index => $p)
                        <tr>
                            <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->firstItem() + $index }}</p></td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $p->created_at->format('d/m/Y H:i') }}</p></td>
                            <td><p class="mb-0 fw-normal fs-4">{{ $p->jenisPelanggaran->nama_pelanggaran }}</p></td>
                            <td>
                                @php
                                    $tingkat = $p->jenisPelanggaran->tingkat;
                                    $badgeClass = match($tingkat) {
                                        'Ringan' => 'bg-info-subtle text-info',
                                        'Sedang' => 'bg-warning-subtle text-warning',
                                        'Berat' => 'bg-danger-subtle text-danger',
                                        'Sangat Berat' => 'bg-dark-subtle text-dark',
                                        default => 'bg-secondary-subtle text-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $tingkat }}</span>
                            </td>
                            <td><span class="badge bg-danger">{{ $p->jenisPelanggaran->poin }}</span></td>
                            <td>
                                <p class="mb-0 fw-normal fs-4" style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" 
                                   title="{{ $p->keterangan }}">
                                    {{ $p->keterangan }}
                                </p>
                            </td>
                            <td>
                                @php
                                    $statusClass = match($p->status_verifikasi) {
                                        'diverifikasi' => 'bg-success-subtle text-success',
                                        'menunggu' => 'bg-warning-subtle text-warning',
                                        'ditolak' => 'bg-danger-subtle text-danger',
                                        'revisi' => 'bg-info-subtle text-info',
                                        default => 'bg-secondary-subtle text-secondary'
                                    };
                                    $statusText = match($p->status_verifikasi) {
                                        'diverifikasi' => 'Diverifikasi',
                                        'menunggu' => 'Menunggu Verifikasi',
                                        'ditolak' => 'Ditolak',
                                        'revisi' => 'Revisi',
                                        default => ucfirst($p->status_verifikasi)
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ $statusText }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <span class="text-muted">Tidak ada data pelanggaran</span>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex align-items-center justify-content-between mt-4">
                <p class="mb-0 fw-normal fs-4">
                    Menampilkan {{ $pelanggaran->firstItem() ?? 0 }}-{{ $pelanggaran->lastItem() ?? 0 }} 
                    dari {{ $pelanggaran->total() }} data
                </p>
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        @if ($pelanggaran->onFirstPage())
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0)">Previous</a>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $pelanggaran->appends(request()->query())->previousPageUrl() }}">Previous</a>
                            </li>
                        @endif
                        
                        @foreach ($pelanggaran->appends(request()->query())->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
                            @if ($page == $pelanggaran->currentPage())
                                <li class="page-item active">
                                    <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach
                        
                        @if ($pelanggaran->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $pelanggaran->appends(request()->query())->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <a class="page-link" href="javascript:void(0)">Next</a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('guru.siswa.show', $siswa->id) }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali ke Detail Siswa
        </a>
        <a href="{{ route('guru.siswa') }}" class="btn btn-outline-secondary">
            <i class="ti ti-list"></i> Daftar Siswa
        </a>
    </div>
</div>
@endsection