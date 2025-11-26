@extends('mainOrtu')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Dashboard Orang Tua</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="#">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <!-- Info Anak -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Informasi Anak</h5>
          <div class="d-flex align-items-center">
            @if($siswa->foto && file_exists(public_path('uploads/siswa/' . $siswa->foto)))
              <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="rounded-circle" width="80" height="80" style="object-fit: cover;">
            @else
              <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80">
            @endif
            <div class="ms-4">
              <h4 class="mb-1">{{ $siswa->nama_siswa }}</h4>
              <p class="mb-1 text-muted">NIS: {{ $siswa->nis }}</p>
              <p class="mb-0 text-muted">Kelas: {{ $siswa->kelas->nama_kelas }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Statistik -->
      <div class="row mt-3">
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="btn btn-danger rounded-circle round-48 hstack justify-content-center">
                  <i class="ti ti-alert-triangle fs-6"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Total Pelanggaran</h6>
                  <span class="text-muted fs-3">{{ $totalPelanggaran }} Kasus</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="btn btn-success rounded-circle round-48 hstack justify-content-center">
                  <i class="ti ti-trophy fs-6"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Total Prestasi</h6>
                  <span class="text-muted fs-3">{{ $totalPrestasi }} Prestasi</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="btn btn-warning rounded-circle round-48 hstack justify-content-center">
                  <i class="ti ti-star fs-6"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Total Poin</h6>
                  <span class="text-muted fs-3">{{ $totalPoin }} Poin</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Pelanggaran Terbaru -->
      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Pelanggaran Terbaru</h5>
          <div class="table-responsive">
            <table class="table mb-0 text-nowrap align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
                  <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
                  <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
                </tr>
              </thead>
              <tbody>
                @forelse($pelanggaranTerbaru as $p)
                <tr>
                  <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                  <td>{{ $p->created_at->format('d M Y') }}</td>
                  <td><span class="badge bg-danger">{{ $p->poin }} Poin</span></td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="text-center py-4">
                    <span class="text-muted">Tidak ada pelanggaran</span>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Prestasi Terbaru -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Prestasi Terbaru</h5>
          @forelse($prestasiTerbaru as $pr)
          <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
            <div class="btn btn-success rounded-circle round-40 hstack justify-content-center">
              <i class="ti ti-trophy fs-5"></i>
            </div>
            <div class="ms-3">
              <h6 class="mb-0 fw-bolder">{{ $pr->nama_prestasi }}</h6>
              <span class="text-muted fs-3">{{ $pr->juara }} - {{ ucfirst($pr->tingkat) }}</span>
              <p class="mb-0 text-muted fs-2">{{ $pr->tanggal->format('d M Y') }}</p>
            </div>
          </div>
          @empty
          <div class="text-center py-4">
            <span class="text-muted">Belum ada prestasi</span>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
