@extends('mainKesiswaan')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Monitoring Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a class="text-muted text-decoration-none" href="{{ route('kesiswaan.dashboard') }}">Home</a></li>
        <li class="breadcrumb-item" aria-current="page">Monitoring</li>
      </ol>
    </nav>
  </div>
  
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Monitoring Data Siswa</h5>
      
      <form method="GET" class="row mb-3">
        <div class="col-md-4">
          <select name="kelas_id" class="form-select">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
              <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
            @endforeach
          </select>
        </div>
        <div class="col-md-6">
          <input type="text" name="search" class="form-control" placeholder="Cari nama siswa..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-outline-secondary w-100"><i class="ti ti-search fs-4"></i> Cari</button>
        </div>
      </form>

      <div class="table-responsive">
        <table class="table mb-0 text-nowrap align-middle">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">NIS</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Total Pelanggaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Total Poin</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Total Prestasi</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($siswa as $index => $s)
            @php
              $totalPoin = $s->pelanggaran->where('status_verifikasi', 'diverifikasi')->sum('poin');
              $totalPelanggaran = $s->pelanggaran->where('status_verifikasi', 'diverifikasi')->count();
              $totalPrestasi = $s->prestasi->count();
            @endphp
            <tr>
              <td>{{ $siswa->firstItem() + $index }}</td>
              <td>{{ $s->nis }}</td>
              <td>
                <div class="d-flex align-items-center">
                  @if($s->foto && file_exists(public_path('uploads/siswa/' . $s->foto)))
                    <img src="{{ asset('uploads/siswa/' . $s->foto) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @else
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40">
                  @endif
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $s->nama_siswa }}</h6>
                  </div>
                </div>
              </td>
              <td>{{ $s->kelas->nama_kelas }}</td>
              <td>
                @if($totalPelanggaran > 0)
                  <span class="badge bg-danger-subtle text-danger">{{ $totalPelanggaran }}</span>
                @else
                  <span class="badge bg-success-subtle text-success">0</span>
                @endif
              </td>
              <td>
                @if($totalPoin > 0)
                  <span class="badge bg-warning-subtle text-warning">{{ $totalPoin }} poin</span>
                @else
                  <span class="badge bg-success-subtle text-success">0 poin</span>
                @endif
              </td>
              <td>
                @if($totalPrestasi > 0)
                  <span class="badge bg-info-subtle text-info">{{ $totalPrestasi }}</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary">0</span>
                @endif
              </td>
              <td>
                <a href="{{ route('kesiswaan.monitoring.detail', $s->id) }}" class="btn btn-sm btn-primary">
                  <i class="ti ti-eye"></i> Detail
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4"><span class="text-muted">Tidak ada data siswa</span></td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $siswa->firstItem() ?? 0 }}-{{ $siswa->lastItem() ?? 0 }} dari {{ $siswa->total() }} data</p>
        {{ $siswa->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
