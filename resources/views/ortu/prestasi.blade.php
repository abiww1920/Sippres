@extends('mainOrtu')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Prestasi Anak</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('ortu.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Prestasi</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Prestasi {{ $siswa->nama_siswa }}</h5>
      
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Prestasi</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tingkat</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Juara</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($prestasi as $index => $pr)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $prestasi->firstItem() + $index }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $pr->nama_prestasi }}</p></td>
              <td><span class="badge bg-success-subtle text-success">{{ ucfirst($pr->tingkat) }}</span></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $pr->juara }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $pr->tanggal ? date('d M Y', strtotime($pr->tanggal)) : '-' }}</p></td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4">
                <span class="text-muted">Belum ada prestasi</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $prestasi->firstItem() ?? 0 }}-{{ $prestasi->lastItem() ?? 0 }} dari {{ $prestasi->total() }} data</p>
        <nav aria-label="Page navigation">
          {{ $prestasi->links() }}
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection
