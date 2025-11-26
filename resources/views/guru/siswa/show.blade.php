@extends('mainGuru')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h4 class="fw-semibold">Detail Siswa</h4>
        <p class="text-muted mb-0">Informasi lengkap dan rekam jejak siswa</p>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($siswa->foto)
                    <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="rounded-circle mb-3" width="150" height="150" style="object-fit: cover;">
                    @else
                    <div class="rounded-circle bg-primary-subtle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                        <i class="ti ti-user" style="font-size: 80px;"></i>
                    </div>
                    @endif
                    <h5 class="fw-semibold">{{ $siswa->nama_siswa }}</h5>
                    <p class="text-muted">{{ $siswa->nis }}</p>
                    <span class="badge bg-primary">{{ $siswa->kelas->nama_kelas }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Informasi Siswa</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="200" class="fw-semibold">NIS</td>
                            <td>: {{ $siswa->nis }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Nama Lengkap</td>
                            <td>: {{ $siswa->nama_siswa }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Kelas</td>
                            <td>: {{ $siswa->kelas->nama_kelas }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Jenis Kelamin</td>
                            <td>: {{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Total Pelanggaran</td>
                            <td>: <span class="badge bg-danger">{{ $siswa->pelanggaran->count() }}</span></td>
                        </tr>
                        <tr>
                            <td class="fw-semibold">Total Prestasi</td>
                            <td>: <span class="badge bg-success">{{ $siswa->prestasi->count() }}</span></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Riwayat Pelanggaran</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Pelanggaran</th>
                                    <th>Poin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->pelanggaran->take(10) as $p)
                                <tr>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                                    <td><span class="badge bg-danger">{{ $p->jenisPelanggaran->poin }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada pelanggaran</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Riwayat Prestasi</h5>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Prestasi</th>
                                    <th>Tingkat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswa->prestasi->take(10) as $p)
                                <tr>
                                    <td>{{ $p->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $p->jenisPrestasi->nama_prestasi }}</td>
                                    <td><span class="badge bg-success">{{ $p->jenisPrestasi->tingkat }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Tidak ada prestasi</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('guru.siswa') }}" class="btn btn-secondary">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
