@extends('mainSiswa')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Riwayat Pelanggaran</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('siswa.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Pelanggaran</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body">
      @if($pelanggaran->count() > 0)
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Jenis Pelanggaran</th>
              <th>Keterangan</th>
              <th>Poin</th>
              <th>Status</th>
              <th>Dilaporkan Oleh</th>
            </tr>
          </thead>
          <tbody>
            @foreach($pelanggaran as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $item->created_at ? $item->created_at->format('d/m/Y') : '-' }}</td>
              <td>{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
              <td>{{ $item->keterangan }}</td>
              <td>
                <span class="badge bg-danger">{{ $item->poin }}</span>
              </td>
              <td>
                @if($item->status_verifikasi == 'diverifikasi')
                  <span class="badge bg-success">Diverifikasi</span>
                @elseif($item->status_verifikasi == 'ditolak')
                  <span class="badge bg-danger">Ditolak</span>
                @else
                  <span class="badge bg-warning">Menunggu Verifikasi</span>
                @endif
              </td>
              <td>{{ $item->createdBy->username ?? '-' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <div class="text-center py-5">
        <i class="ti ti-clipboard-check fs-1 text-muted"></i>
        <h5 class="mt-3">Tidak Ada Pelanggaran</h5>
        <p class="text-muted">Anda belum memiliki catatan pelanggaran.</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection