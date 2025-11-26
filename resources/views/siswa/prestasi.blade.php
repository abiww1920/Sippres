@extends('mainSiswa')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Riwayat Prestasi</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('siswa.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Prestasi</li>
      </ol>
    </nav>
  </div>

  <div class="card">
    <div class="card-body">
      @if($prestasi->count() > 0)
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>No</th>
              <th>Tanggal</th>
              <th>Nama Prestasi</th>
              <th>Tingkat</th>
              <th>Juara</th>
              <th>Keterangan</th>
              <th>Dicatat Oleh</th>
            </tr>
          </thead>
          <tbody>
            @foreach($prestasi as $index => $item)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
              <td>{{ $item->nama_prestasi ?? '-' }}</td>
              <td>
                <span class="badge bg-info">{{ ucfirst($item->tingkat ?? '-') }}</span>
              </td>
              <td>
                <span class="badge bg-warning">{{ $item->juara ?? '-' }}</span>
              </td>
              <td>{{ $item->keterangan ?? '-' }}</td>
              <td>{{ $item->createdBy->username ?? '-' }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
      <div class="text-center py-5">
        <i class="ti ti-trophy fs-1 text-muted"></i>
        <h5 class="mt-3">Belum Ada Prestasi</h5>
        <p class="text-muted">Anda belum memiliki catatan prestasi.</p>
      </div>
      @endif
    </div>
  </div>
</div>
@endsection