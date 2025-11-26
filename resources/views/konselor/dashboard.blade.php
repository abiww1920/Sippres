@extends('mainKonselor')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Dashboard Konselor</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="#">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
      </ol>
    </nav>
  </div>

  <!-- Row 1 -->
  <div class="row">
    <!-- Quick Stats -->
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Statistik Cepat</h4>
          <p class="card-subtitle mb-4">Ringkasan data bimbingan konseling</p>
          
          <div class="row">
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-primary rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-users fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Total Siswa</h6>
                  <span class="text-muted fs-3">{{ $totalSiswa ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-warning rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-file-text fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Total Bimbingan</h6>
                  <span class="text-muted fs-3">{{ $totalBimbingan ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-info rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-calendar fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Bimbingan Bulan Ini</h6>
                  <span class="text-muted fs-3">{{ $bimbinganBulanIni ?? 0 }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-lg-3 col-md-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-success rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-check fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Selesai</h6>
                  <span class="text-muted fs-3">{{ $bimbinganSelesai ?? 0 }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bimbingan Terbaru -->
    <div class="col-12 mt-4">
      <div class="card">
        <div class="card-body">
          <div class="d-md-flex align-items-center">
            <div>
              <h4 class="card-title">Bimbingan Terbaru</h4>
              <p class="card-subtitle">Data bimbingan konseling terkini</p>
            </div>
          </div>
          <div class="table-responsive mt-4">
            <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
              <thead>
                <tr>
                  <th scope="col" class="px-0 text-muted">Siswa</th>
                  <th scope="col" class="px-0 text-muted">Kelas</th>
                  <th scope="col" class="px-0 text-muted">Topik</th>
                  <th scope="col" class="px-0 text-muted">Tanggal</th>
                  <th scope="col" class="px-0 text-muted">Status</th>
                  <th scope="col" class="px-0 text-muted text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($bimbinganTerbaru ?? [] as $bimbingan)
                <tr>
                  <td class="px-0">
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('assets/images/profile/user-3.jpg') }}" class="rounded-circle" width="40" alt="siswa" />
                      <div class="ms-3">
                        <h6 class="mb-0 fw-bolder">{{ $bimbingan->siswa->nama_siswa ?? '-' }}</h6>
                      </div>
                    </div>
                  </td>
                  <td class="px-0">{{ $bimbingan->siswa->kelas->nama_kelas ?? '-' }}</td>
                  <td class="px-0">{{ $bimbingan->topik ?? '-' }}</td>
                  <td class="px-0">{{ $bimbingan->tanggal ? $bimbingan->tanggal->format('d/m/Y') : '-' }}</td>
                  <td class="px-0">
                    @if($bimbingan->status == 'selesai')
                      <span class="badge bg-success">Selesai</span>
                    @elseif($bimbingan->status == 'proses')
                      <span class="badge bg-warning">Proses</span>
                    @else
                      <span class="badge bg-info">Terjadwal</span>
                    @endif
                  </td>
                  <td class="px-0 text-end">
                    <a href="{{ route('konselor.bimbingan.show', $bimbingan->id ?? '#') }}" class="btn btn-sm btn-primary">
                      <i class="ti ti-eye"></i>
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center py-4">
                    <span class="text-muted">Tidak ada data bimbingan</span>
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
@endsection
