@extends('mainOrtu')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Dashboard Orang Tua</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="#">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
      </ol>
    </nav>
  </div>

  <div class="row">
    <div class="col-lg-8">
      <!-- Info Anak -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Informasi Anak</h5>
          <div class="d-flex align-items-center">
            @if($siswa->foto && file_exists(public_path('uploads/siswa/' . $siswa->foto)))
              <img src="{{ asset('uploads/siswa/' . $siswa->foto) }}" class="rounded-circle" width="80" height="80" style="object-fit: cover;">
            @else
              <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="80" height="80">
            @endif
            <div class="ms-4">
              <h4 class="mb-1">{{ $siswa->nama_siswa }}</h4>
              <p class="mb-1 text-muted">NIS: {{ $siswa->nis }}</p>
              <p class="mb-1 text-muted">Kelas: {{ $siswa->kelas->nama_kelas }}</p>
              <div class="mt-2">
                <span class="badge bg-{{ $statusKedisiplinan['color'] }} fs-3">
                  {{ $statusKedisiplinan['icon'] }} {{ $statusKedisiplinan['status'] }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Statistik Poin -->
      <div class="row mt-3">
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="btn btn-danger rounded-circle round-48 hstack justify-content-center">
                  <i class="ti ti-alert-triangle fs-6"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Poin Pelanggaran</h6>
                  <span class="text-danger fs-3 fw-bold">{{ $totalPoinPelanggaran }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="btn btn-success rounded-circle round-48 hstack justify-content-center">
                  <i class="ti ti-trophy fs-6"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Poin Prestasi</h6>
                  <span class="text-success fs-3 fw-bold">{{ $totalPoinPrestasi }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="btn btn-{{ $poinBersih >= 0 ? 'success' : 'warning' }} rounded-circle round-48 hstack justify-content-center">
                  <i class="ti ti-star fs-6"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Poin Bersih</h6>
                  <span class="text-{{ $poinBersih >= 0 ? 'success' : 'warning' }} fs-3 fw-bold">{{ $poinBersih }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <div class="btn btn-info rounded-circle round-48 hstack justify-content-center">
                  <i class="ti ti-chart-line fs-6"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Total Kasus</h6>
                  <span class="text-muted fs-3">{{ $totalPelanggaran + $totalPrestasi }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Grafik Tren -->
      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Grafik Perkembangan (6 Bulan Terakhir)</h5>
          <canvas id="trendChart" height="100"></canvas>
        </div>
      </div>

      <!-- Pelanggaran Terbaru -->
      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Pelanggaran Terbaru</h5>
          <div class="table-responsive">
            <table class="table mb-0 text-nowrap align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
                  <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
                  <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
                </tr>
              </thead>
              <tbody>
                @forelse($pelanggaranTerbaru as $p)
                <tr>
                  <td>{{ $p->jenisPelanggaran->nama_pelanggaran }}</td>
                  <td>{{ $p->created_at->format('d M Y') }}</td>
                  <td><span class="badge bg-danger">{{ $p->poin }} Poin</span></td>
                </tr>
                @empty
                <tr>
                  <td colspan="3" class="text-center py-4">
                    <span class="text-muted">Tidak ada pelanggaran</span>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <!-- Notifikasi Penting -->
      <div class="card">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Notifikasi Penting</h5>
          @forelse($notifikasi as $notif)
          <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
            <div class="btn btn-{{ $notif['color'] }} rounded-circle round-40 hstack justify-content-center">
              <i class="{{ $notif['icon'] }} fs-5"></i>
            </div>
            <div class="ms-3">
              <p class="mb-1 fw-bold fs-3">{{ $notif['message'] }}</p>
              <span class="text-muted fs-2">{{ $notif['time'] }}</span>
            </div>
          </div>
          @empty
          <div class="text-center py-4">
            <i class="ti ti-bell fs-1 text-muted"></i>
            <p class="text-muted mt-2">Tidak ada notifikasi</p>
          </div>
          @endforelse
          
          @if(count($notifikasi) > 0)
          <div class="text-center mt-3">
            <a href="{{ route('ortu.notifikasi') }}" class="btn btn-outline-primary btn-sm">
              Lihat Semua Notifikasi
            </a>
          </div>
          @endif
        </div>
      </div>
      
      <!-- Prestasi Terbaru -->
      <div class="card mt-3">
        <div class="card-body">
          <h5 class="card-title fw-semibold mb-4">Prestasi Terbaru</h5>
          @forelse($prestasiTerbaru as $pr)
          <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
            <div class="btn btn-success rounded-circle round-40 hstack justify-content-center">
              <i class="ti ti-trophy fs-5"></i>
            </div>
            <div class="ms-3">
              <h6 class="mb-0 fw-bolder">{{ $pr->nama_prestasi }}</h6>
              <span class="text-muted fs-3">{{ $pr->juara }} - {{ ucfirst($pr->tingkat) }}</span>
              <p class="mb-0 text-muted fs-2">{{ date('d M Y', strtotime($pr->tanggal)) }}</p>
            </div>
          </div>
          @empty
          <div class="text-center py-4">
            <span class="text-muted">Belum ada prestasi</span>
          </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Tren Perkembangan
const ctx = document.getElementById('trendChart').getContext('2d');
const trendChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($trendData['months']) !!},
        datasets: [{
            label: 'Pelanggaran',
            data: {!! json_encode($trendData['pelanggaran']) !!},
            borderColor: 'rgb(220, 53, 69)',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            tension: 0.4
        }, {
            label: 'Prestasi',
            data: {!! json_encode($trendData['prestasi']) !!},
            borderColor: 'rgb(25, 135, 84)',
            backgroundColor: 'rgba(25, 135, 84, 0.1)',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            },
            title: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>
@endsection
