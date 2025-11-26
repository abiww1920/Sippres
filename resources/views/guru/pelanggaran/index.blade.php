@extends('mainGuru')

@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Pelanggaran</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('guru.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Pelanggaran</li>
      </ol>
    </nav>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="ti ti-check-circle fs-4 me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0">Pelanggaran yang Saya Catat</h5>
        <a href="{{ route('guru.pelanggaran.create') }}" class="btn btn-primary">
          <i class="ti ti-plus fs-4"></i> Input Pelanggaran
        </a>
      </div>

      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kategori</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($pelanggarans as $index => $p)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $pelanggarans->firstItem() + $index }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->created_at->format('d M Y') }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  @if($p->siswa->foto && file_exists(public_path('uploads/siswa/' . $p->siswa->foto)))
                    <img src="{{ asset('uploads/siswa/' . $p->siswa->foto) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @else
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @endif
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $p->siswa->nama_siswa }}</h6>
                    <span class="fw-normal">NIS: {{ $p->siswa->nis }}</span>
                  </div>
                </div>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->siswa->kelas->nama_kelas }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->jenisPelanggaran->nama_pelanggaran }}</p></td>
              <td>
                @php
                  $kategori = $p->jenisPelanggaran->kategori;
                  $badgeClass = match($kategori) {
                    'ringan' => 'bg-success-subtle text-success',
                    'sedang' => 'bg-warning-subtle text-warning',
                    'berat' => 'bg-danger-subtle text-danger',
                    'sangat_berat' => 'bg-primary-subtle text-primary',
                    default => 'bg-secondary-subtle text-secondary'
                  };
                @endphp
                <span class="badge {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $kategori)) }}</span>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->poin }}</p></td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('guru.pelanggaran.show', $p->id) }}"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" class="text-center py-4">
                <span class="text-muted">Belum ada data pelanggaran</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $pelanggarans->firstItem() ?? 0 }}-{{ $pelanggarans->lastItem() ?? 0 }} dari {{ $pelanggarans->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($pelanggarans->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $pelanggarans->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($pelanggarans->getUrlRange(1, $pelanggarans->lastPage()) as $page => $url)
              @if ($page == $pelanggarans->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($pelanggarans->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $pelanggarans->nextPageUrl() }}">Next</a>
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
</div>
@endsection
