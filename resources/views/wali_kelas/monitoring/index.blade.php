@extends('mainWaliKelas')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-semibold mb-2">Monitoring & Alert Siswa</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a class="text-muted text-decoration-none" href="{{ route('walikelas.dashboard') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Monitoring</li>
            </ol>
        </nav>
    </div>

    <!-- Alert Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-danger-subtle border-0">
                <div class="card-body text-center">
                    <i class="ti ti-alert-circle fs-1 text-danger mb-2"></i>
                    <h3 class="fw-semibold text-danger">{{ $stats['total_siswa_kritis'] }}</h3>
                    <p class="mb-0 text-danger">Siswa Poin Kritis (75+)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning-subtle border-0">
                <div class="card-body text-center">
                    <i class="ti ti-alert-triangle fs-1 text-warning mb-2"></i>
                    <h3 class="fw-semibold text-warning">{{ $stats['total_sanksi_baru'] }}</h3>
                    <p class="mb-0 text-warning">Sanksi Baru (7 hari)</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info-subtle border-0">
                <div class="card-body text-center">
                    <i class="ti ti-phone fs-1 text-info mb-2"></i>
                    <h3 class="fw-semibold text-info">{{ $stats['total_panggilan_ortu'] }}</h3>
                    <p class="mb-0 text-info">Panggilan Orang Tua</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-secondary-subtle border-0">
                <div class="card-body text-center">
                    <i class="ti ti-repeat fs-1 text-secondary mb-2"></i>
                    <h3 class="fw-semibold text-secondary">{{ $stats['total_pelanggaran_berulang'] }}</h3>
                    <p class="mb-0 text-secondary">Pelanggaran Berulang</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Tabs -->
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-tabs" id="alertTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="kritis-tab" data-bs-toggle="tab" data-bs-target="#kritis" type="button" role="tab">
                        <i class="ti ti-alert-circle me-2"></i>Poin Kritis ({{ $siswaKritis->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sanksi-tab" data-bs-toggle="tab" data-bs-target="#sanksi" type="button" role="tab">
                        <i class="ti ti-alert-triangle me-2"></i>Sanksi Baru ({{ $siswaSanksiBaru->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="panggilan-tab" data-bs-toggle="tab" data-bs-target="#panggilan" type="button" role="tab">
                        <i class="ti ti-phone me-2"></i>Panggilan Ortu ({{ $siswaPanggilanOrtu->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="berulang-tab" data-bs-toggle="tab" data-bs-target="#berulang" type="button" role="tab">
                        <i class="ti ti-repeat me-2"></i>Pelanggaran Berulang ({{ $siswaPelanggaranBerulang->count() }})
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="alertTabsContent">
                <!-- Siswa Poin Kritis -->
                <div class="tab-pane fade show active" id="kritis" role="tabpanel">
                    @if($siswaKritis->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Total Poin</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswaKritis as $siswa)
                                        @php
                                            $totalPoin = $siswa->pelanggaran->where('status_verifikasi', 'diverifikasi')->sum(function($p) {
                                                return $p->jenisPelanggaran->poin ?? 0;
                                            });
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($siswa->foto)
                                                        <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="rounded-circle me-3" width="40" height="40">
                                                    @else
                                                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                            <i class="ti ti-user"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $siswa->nama_siswa }}</h6>
                                                        <small class="text-muted">{{ $siswa->nis }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $siswa->kelas->nama_kelas }}</td>
                                            <td><span class="badge bg-danger">{{ $totalPoin }} poin</span></td>
                                            <td><span class="badge bg-danger">KRITIS</span></td>
                                            <td>
                                                <a href="{{ route('walikelas.monitoring.detail', $siswa->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-check-circle fs-1 text-success mb-3"></i>
                            <p class="text-muted">Tidak ada siswa dengan poin kritis</p>
                        </div>
                    @endif
                </div>

                <!-- Siswa Panggilan Orang Tua -->
                <div class="tab-pane fade" id="panggilan" role="tabpanel">
                    @if($siswaPanggilanOrtu->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Siswa</th>
                                        <th>Kelas</th>
                                        <th>Total Poin</th>
                                        <th>Orang Tua</th>
                                        <th>No. HP Ortu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($siswaPanggilanOrtu as $siswa)
                                        @php
                                            $totalPoin = $siswa->pelanggaran->where('status_verifikasi', 'diverifikasi')->sum(function($p) {
                                                return $p->jenisPelanggaran->poin ?? 0;
                                            });
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($siswa->foto)
                                                        <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="rounded-circle me-3" width="40" height="40">
                                                    @else
                                                        <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                            <i class="ti ti-user"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">{{ $siswa->nama_siswa }}</h6>
                                                        <small class="text-muted">{{ $siswa->nis }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $siswa->kelas->nama_kelas }}</td>
                                            <td><span class="badge bg-warning">{{ $totalPoin }} poin</span></td>
                                            <td>{{ $siswa->nama_ortu ?? '-' }}</td>
                                            <td>
                                                @if($siswa->no_hp_ortu)
                                                    <a href="tel:{{ $siswa->no_hp_ortu }}" class="text-decoration-none">
                                                        <i class="ti ti-phone me-1"></i>{{ $siswa->no_hp_ortu }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('walikelas.monitoring.detail', $siswa->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="ti ti-eye"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="ti ti-check-circle fs-1 text-success mb-3"></i>
                            <p class="text-muted">Tidak ada siswa yang perlu panggilan orang tua</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection