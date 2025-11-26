@extends('mainGuru')

@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('guru.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Siswa</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0">Daftar Siswa</h5>
      </div>

      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">NIS</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Total Pelanggaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Total Prestasi</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($siswa as $index => $s)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $siswa->firstItem() + $index }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->nis }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  @if($s->foto && file_exists(public_path('uploads/siswa/' . $s->foto)))
                    <img src="{{ asset('uploads/siswa/' . $s->foto) }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @else
                    <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  @endif
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $s->nama_siswa }}</h6>
                  </div>
                </div>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->kelas->nama_kelas }}</p></td>
              <td>
                <span class="badge bg-danger-subtle text-danger">{{ $s->pelanggaran->count() }}</span>
              </td>
              <td>
                <span class="badge bg-success-subtle text-success">{{ $s->prestasi->count() }}</span>
              </td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="{{ route('guru.siswa.show', $s->id) }}"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="text-center py-4">
                <span class="text-muted">Tidak ada data siswa</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $siswa->firstItem() ?? 0 }}-{{ $siswa->lastItem() ?? 0 }} dari {{ $siswa->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($siswa->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $siswa->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($siswa->getUrlRange(1, $siswa->lastPage()) as $page => $url)
              @if ($page == $siswa->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($siswa->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $siswa->nextPageUrl() }}">Next</a>
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
