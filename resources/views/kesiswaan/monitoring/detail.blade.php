@extends('mainKesiswaan')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Detail Monitoring Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('kesiswaan.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('kesiswaan.monitoring') }}">Monitoring</a></li>
        <li class="breadcrumb-item" aria-current="page">Detail</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body text-center">
          @if($siswa->foto && file_exists(public_path('uploads/siswa/' . $siswa->foto)))
            <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="rounded-circle mb-3" width="120" height="120" style="object-fit: cover;">
          @else
            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle mb-3" width="120" height="120">
          @endif
          <h5 class="fw-semibold">{{ $siswa->nama_siswa }}</h5>
          <p class="text-muted mb-2">NIS: {{ $siswa->nis }}</p>
          <p class="text-muted">Kelas: {{ $siswa->kelas->nama_kelas }}</p>
          <div class="mt-3">
            <span class="badge bg-danger-subtle text-danger me-2">Total Poin: {{ $totalPoin }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-8">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-3">Riwayat Pelanggaran</h5>
          <div class="table-responsive">
            <table class="table mb-0 text-nowrap">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Jenis Pelanggaran</th>
                  <th>Poin</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswa->pelanggaran as $p)
                <tr>
                  <td>{{ $p->created_at->format('d M Y') }}</td>
                  <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                  <td>{{ $p->poin }}</td>
                  <td>
                    @if($p->status_verifikasi == 'diverifikasi')
                      <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                    @elseif($p->status_verifikasi == 'menunggu')
                      <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                    @else
                      <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                    @endif
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-3"><span class="text-muted">Tidak ada pelanggaran</span></td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-3">Riwayat Prestasi</h5>
          <div class="table-responsive">
            <table class="table mb-0 text-nowrap">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Prestasi</th>
                  <th>Tingkat</th>
                  <th>Juara</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswa->prestasi as $p)
                <tr>
                  <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</td>
                  <td>{{ $p->nama_prestasi }}</td>
                  <td><span class="badge bg-info-subtle text-info">{{ ucfirst($p->tingkat) }}</span></td>
                  <td>{{ $p->juara }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-3"><span class="text-muted">Tidak ada prestasi</span></td>
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
@endsection
