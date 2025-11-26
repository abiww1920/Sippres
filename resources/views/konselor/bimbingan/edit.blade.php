@extends('mainKonselor')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Edit Bimbingan Konseling</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.bimbingan.index') }}">Data Bimbingan</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Edit</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('konselor.bimbingan.update', $bimbingan->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
              <label for="siswa_id" class="form-label">Siswa <span class="text-danger">*</span></label>
              <select class="form-select @error('siswa_id') is-invalid @enderror" id="siswa_id" name="siswa_id" required>
                <option value="">-- Pilih Siswa --</option>
                @foreach($siswa ?? [] as $s)
                  <option value="{{ $s->id }}" {{ $bimbingan->siswa_id == $s->id ? 'selected' : '' }}>
                    {{ $s->nama_siswa }} - {{ $s->kelas->nama_kelas ?? '' }}
                  </option>
                @endforeach
              </select>
              @error('siswa_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="topik" class="form-label">Topik Bimbingan <span class="text-danger">*</span></label>
              <input type="text" class="form-control @error('topik') is-invalid @enderror" id="topik" name="topik" 
                placeholder="Masukkan topik bimbingan" value="{{ $bimbingan->topik }}" required>
              @error('topik')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
              <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" 
                value="{{ $bimbingan->tanggal->format('Y-m-d') }}" required>
              @error('tanggal')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="waktu" class="form-label">Waktu <span class="text-danger">*</span></label>
              <input type="time" class="form-control @error('waktu') is-invalid @enderror" id="waktu" name="waktu" 
                value="{{ $bimbingan->waktu }}" required>
              @error('waktu')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="deskripsi" class="form-label">Deskripsi <span class="text-danger">*</span></label>
              <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" 
                rows="4" placeholder="Masukkan deskripsi bimbingan" required>{{ $bimbingan->deskripsi }}</textarea>
              @error('deskripsi')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                <option value="">-- Pilih Status --</option>
                <option value="terjadwal" {{ $bimbingan->status == 'terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                <option value="proses" {{ $bimbingan->status == 'proses' ? 'selected' : '' }}>Proses</option>
                <option value="selesai" {{ $bimbingan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
              </select>
              @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary">
                <i class="ti ti-check"></i> Simpan
              </button>
              <a href="{{ route('konselor.bimbingan.index') }}" class="btn btn-secondary">
                <i class="ti ti-x"></i> Batal
              </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
