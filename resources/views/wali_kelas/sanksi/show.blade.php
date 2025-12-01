@extends('mainWaliKelas')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Detail Sanksi</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('walikelas.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('walikelas.sanksi') }}">Monitoring Sanksi</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Detail Sanksi</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <!-- Detail Sanksi -->
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-3">Informasi Sanksi</h5>
          
          <!-- Jenis Sanksi -->
          <div class="row mb-3">
            <div class="col-sm-3 fw-semibold">Jenis Sanksi:</div>
            <div class="col-sm-9">{{ $sanksi->jenisSanksi->nama_sanksi ?? $sanksi->jenis_sanksi }}</div>
          </div>

          <!-- Periode Sanksi -->
          <div class="row mb-3">
            <div class="col-sm-3 fw-semibold">Tanggal Mulai:</div>
            <div class="col-sm-9">{{ $sanksi->tanggal_mulai->format('d M Y') }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-3 fw-semibold">Tanggal Selesai:</div>
            <div class="col-sm-9">{{ $sanksi->tanggal_selesai->format('d M Y') }}</div>
          </div>
          <div class="row mb-3">
            <div class="col-sm-3 fw-semibold">Durasi:</div>
            <div class="col-sm-9">{{ $sanksi->tanggal_mulai->diffInDays($sanksi->tanggal_selesai) + 1 }} hari</div>
          </div>

          <!-- Status -->
          <div class="row mb-3">
            <div class="col-sm-3 fw-semibold">Status:</div>
            <div class="col-sm-9">
              @php
                $pelaksanaan = $sanksi->pelaksanaanSanksi->first();
              @endphp
              @if($pelaksanaan && $pelaksanaan->status == 'selesai')
                <span class="badge bg-success-subtle text-success">Selesai</span>
              @elseif($pelaksanaan && $pelaksanaan->status == 'proses')
                <span class="badge bg-warning-subtle text-warning">Dalam Proses</span>
              @else
                <span class="badge bg-danger-subtle text-danger">Belum Dilaksanakan</span>
              @endif
            </div>
          </div>

          <!-- Deskripsi -->
          @if($sanksi->deskripsi_sanksi)
          <div class="row mb-3">
            <div class="col-sm-3 fw-semibold">Deskripsi:</div>
            <div class="col-sm-9">{{ $sanksi->deskripsi_sanksi }}</div>
          </div>
          @endif
        </div>
      </div>
    </div>

    <!-- Foto Siswa -->
    <div class="col-md-4">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Foto Siswa</h5>
        </div>
        <div class="card-body text-center">
          @if($sanksi->pelanggaran->siswa->foto && file_exists(public_path('uploads/siswa/' . $sanksi->pelanggaran->siswa->foto)))
            <img src="{{ asset('uploads/siswa/' . $sanksi->pelanggaran->siswa->foto) }}" 
                 class="img-fluid rounded" 
                 alt="Foto {{ $sanksi->pelanggaran->siswa->nama_siswa }}" 
                 style="max-height: 300px;">
          @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
              <i class="ti ti-user fs-1 text-muted"></i>
            </div>
            <p class="text-muted mt-2 mb-0">Foto belum tersedia</p>
          @endif
        </div>
      </div>
      
      <!-- Data Siswa -->
      <div class="card mt-3">
        <div class="card-header">
          <h5 class="card-title mb-0">Data Siswa</h5>
        </div>
        <div class="card-body">
          <table class="table table-borderless">
            <tr>
              <td class="fw-semibold">Nama:</td>
              <td>{{ $sanksi->pelanggaran->siswa->nama_siswa }}</td>
            </tr>
            <tr>
              <td class="fw-semibold">NIS:</td>
              <td>{{ $sanksi->pelanggaran->siswa->nis }}</td>
            </tr>
            <tr>
              <td class="fw-semibold">Kelas:</td>
              <td>{{ $sanksi->pelanggaran->siswa->kelas->nama_kelas }}</td>
            </tr>
          </table>
        </div>
      </div>
    </div>
  </div>

      <!-- Dasar Sanksi -->
      <div class="card mt-3">
        <div class="card-header">
          <h5 class="card-title mb-0">Dasar Sanksi</h5>
        </div>
        <div class="card-body">
          <div class="mb-3">
            <span class="fw-semibold">Total Poin: </span>
            <span class="badge bg-danger">{{ $totalPoin }} Poin</span>
          </div>
          
          <h6 class="fw-semibold mb-2">Daftar Pelanggaran:</h6>
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead class="table-light">
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>Jenis</th>
                  <th>Poin</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pelanggaranSiswa as $index => $p)
                <tr>
                  <td>{{ $index + 1 }}</td>
                  <td>{{ $p->created_at->format('d/m/Y') }}</td>
                  <td>{{ $p->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                  <td><span class="badge bg-warning">{{ $p->jenisPelanggaran->poin ?? 0 }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bukti Pelaksanaan -->
  @if($sanksi->pelaksanaanSanksi->isNotEmpty())
  <div class="row mt-4">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-3">Bukti Pelaksanaan</h5>
          @foreach($sanksi->pelaksanaanSanksi as $pelaksanaan)
          <div class="border rounded p-3 mb-3">
            <div class="row">
              <div class="col-sm-2 fw-semibold">Tanggal:</div>
              <div class="col-sm-10">{{ $pelaksanaan->created_at->format('d M Y H:i') }}</div>
            </div>
            <div class="row">
              <div class="col-sm-2 fw-semibold">Status:</div>
              <div class="col-sm-10">
                @if($pelaksanaan->status == 'selesai')
                  <span class="badge bg-success">Selesai</span>
                @elseif($pelaksanaan->status == 'proses')
                  <span class="badge bg-warning">Dalam Proses</span>
                @else
                  <span class="badge bg-secondary">{{ ucfirst($pelaksanaan->status) }}</span>
                @endif
              </div>
            </div>
            @if($pelaksanaan->keterangan)
            <div class="row">
              <div class="col-sm-2 fw-semibold">Catatan:</div>
              <div class="col-sm-10">{{ $pelaksanaan->keterangan }}</div>
            </div>
            @endif
            @if($pelaksanaan->bukti_foto)
            <div class="row">
              <div class="col-sm-2 fw-semibold">Bukti Foto:</div>
              <div class="col-sm-10">
                <img src="{{ asset('storage/bukti_sanksi/' . $pelaksanaan->bukti_foto) }}" 
                     class="img-thumbnail" style="max-width: 200px;">
              </div>
            </div>
            @endif
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif

  <div class="mt-4">
    <a href="{{ route('walikelas.sanksi') }}" class="btn btn-secondary">
      <i class="ti ti-arrow-left"></i> Kembali
    </a>
  </div>
</div>
@endsection