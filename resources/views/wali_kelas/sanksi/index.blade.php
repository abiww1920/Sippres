@extends('mainWaliKelas')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Monitoring Sanksi</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('walikelas.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Monitoring Sanksi</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0">Sanksi Siswa Binaan</h5>
        <div class="text-muted">
          <small>Kelas yang diampu: 
            @foreach($kelasWali as $kelas)
              <span class="badge bg-primary-subtle text-primary">{{ $kelas->nama_kelas }}</span>
            @endforeach
          </small>
        </div>
      </div>
      
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Jenis Sanksi</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($sanksi as $index => $s)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $sanksi->firstItem() + $index }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $s->pelanggaran->siswa->nama_siswa }}</h6>
                    <span class="fw-normal">NIS: {{ $s->pelanggaran->siswa->nis }}</span>
                  </div>
                </div>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->pelanggaran->siswa->kelas->nama_kelas }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->jenisSanksi->nama_sanksi }}</p></td>
              <td><p class="mb-0 fw-normal fs-4">{{ $s->created_at->format('d M Y') }}</p></td>
              <td>
                @if($s->pelaksanaanSanksi && $s->pelaksanaanSanksi->status == 'selesai')
                  <span class="badge bg-success-subtle text-success">Selesai</span>
                @elseif($s->pelaksanaanSanksi && $s->pelaksanaanSanksi->status == 'proses')
                  <span class="badge bg-warning-subtle text-warning">Dalam Proses</span>
                @else
                  <span class="badge bg-danger-subtle text-danger">Belum Dilaksanakan</span>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4">
                <span class="text-muted">Tidak ada data sanksi</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $sanksi->firstItem() ?? 0 }}-{{ $sanksi->lastItem() ?? 0 }} dari {{ $sanksi->total() }} data</p>
        {{ $sanksi->links() }}
      </div>
    </div>
  </div>
</div>
@endsection