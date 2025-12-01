@extends('mainOrtu')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Notifikasi</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('ortu.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Notifikasi</li>
      </ol>
    </nav>
  </div>

  <!-- Filter Notifikasi -->
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title">Filter Notifikasi</h5>
      <form method="GET" class="row g-3">
        <div class="col-md-3">
          <select name="type" class="form-select">
            <option value="">Semua Notifikasi</option>
            <option value="pelanggaran" {{ request('type') == 'pelanggaran' ? 'selected' : '' }}>Pelanggaran</option>
            <option value="prestasi" {{ request('type') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
          </select>
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-primary">Filter</button>
          <a href="{{ route('ortu.notifikasi') }}" class="btn btn-secondary">Reset</a>
        </div>
      </form>
    </div>
  </div>

  <!-- Daftar Notifikasi -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Semua Notifikasi</h5>
      
      @if(count($notifikasi) > 0)
        @foreach($notifikasi as $notif)
        <div class="d-flex align-items-start mb-4 pb-4 border-bottom">
          <div class="btn btn-{{ $notif['color'] }} rounded-circle round-48 hstack justify-content-center me-3">
            <i class="{{ $notif['icon'] }} fs-6"></i>
          </div>
          <div class="flex-grow-1">
            <h6 class="mb-1 fw-bold">{{ $notif['title'] }}</h6>
            <p class="mb-2 text-muted">{{ $notif['message'] }}</p>
            <small class="text-muted">{{ $notif['time'] }}</small>
          </div>
          <div class="ms-auto">
            <span class="badge bg-{{ $notif['color'] }}">{{ ucfirst($notif['type']) }}</span>
          </div>
        </div>
        @endforeach
      @else
        <div class="text-center py-5">
          <i class="ti ti-bell fs-1 text-muted"></i>
          <h5 class="mt-3">Tidak Ada Notifikasi</h5>
          <p class="text-muted">Belum ada notifikasi untuk ditampilkan.</p>
        </div>
      @endif
    </div>
  </div>
</div>
@endsection