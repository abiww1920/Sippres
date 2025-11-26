@extends('mainOrtu')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data Pelanggaran Anak</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('ortu.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data Pelanggaran</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Pelanggaran {{ $siswa->nama_siswa }}</h5>
      
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Keterangan</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($pelanggaran as $index => $p)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $pelanggaran->firstItem() + $index }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->jenisPelanggaran->nama_pelanggaran }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->created_at->format('d M Y') }}</p></td>
              <td><span class="badge bg-danger fs-4">{{ $p->poin }} Poin</span></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $p->keterangan }}</p></td>
            </tr>
            @empty
            <tr>
              <td colspan="5" class="text-center py-4">
                <span class="text-muted">Tidak ada data pelanggaran</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $pelanggaran->firstItem() ?? 0 }}-{{ $pelanggaran->lastItem() ?? 0 }} dari {{ $pelanggaran->total() }} data</p>
        <nav aria-label="Page navigation">
          {{ $pelanggaran->links() }}
        </nav>
      </div>
    </div>
  </div>
</div>
@endsection
