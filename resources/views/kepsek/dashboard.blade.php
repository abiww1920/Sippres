@extends('mainKepsek')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Dashboard Kepala Sekolah</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="#">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Dashboard</li>
      </ol>
    </nav>
  </div>

  <!-- Row 1 -->
  <div class="row">
    <div class="col-lg-8">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-md-flex align-items-center">
            <div>
              <h4 class="card-title">Tren Pelanggaran Bulanan</h4>
              <p class="card-subtitle">Data pelanggaran per bulan</p>
            </div>
          </div>
          <div id="sales-overview" class="mt-4 mx-n6"></div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="card overflow-hidden">
        <div class="card-body pb-0">
          <div class="d-flex align-items-start">
            <div>
              <h4 class="card-title">Status Verifikasi</h4>
              <p class="card-subtitle">Data terbaru</p>
            </div>
          </div>
          <div class="mt-4 pb-3 d-flex align-items-center">
            <span class="btn btn-warning rounded-circle round-48 hstack justify-content-center">
              <i class="ti ti-clock fs-6"></i>
            </span>
            <div class="ms-3">
              <h5 class="mb-0 fw-bolder fs-4">Menunggu</h5>
              <span class="text-muted fs-3">{{ $statusVerifikasi['menunggu'] }} Data</span>
            </div>
          </div>
          <div class="py-3 d-flex align-items-center">
            <span class="btn btn-success rounded-circle round-48 hstack justify-content-center">
              <i class="ti ti-check fs-6"></i>
            </span>
            <div class="ms-3">
              <h5 class="mb-0 fw-bolder fs-4">Diverifikasi</h5>
              <span class="text-muted fs-3">{{ $statusVerifikasi['diverifikasi'] }} Data</span>
            </div>
          </div>
          <div class="py-3 d-flex align-items-center">
            <span class="btn btn-danger rounded-circle round-48 hstack justify-content-center">
              <i class="ti ti-x fs-6"></i>
            </span>
            <div class="ms-3">
              <h5 class="mb-0 fw-bolder fs-4">Ditolak</h5>
              <span class="text-muted fs-3">{{ $statusVerifikasi['ditolak'] }} Data</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pie Chart Section -->
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Distribusi Kategori Pelanggaran</h4>
          <p class="card-subtitle mb-4">Persentase pelanggaran berdasarkan kategori</p>
          <div id="chart-pie-simple"></div>
        </div>
      </div>
    </div>

    <!-- Quick Stats -->
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Statistik Cepat</h4>
          <p class="card-subtitle mb-4">Ringkasan data pelanggaran</p>
          
          <div class="row">
            <div class="col-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-primary rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-alert-triangle fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Total Pelanggaran</h6>
                  <span class="text-muted fs-3">{{ $totalPelanggaran }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-warning rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-users fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Siswa Terlibat</h6>
                  <span class="text-muted fs-3">{{ $siswaTerlibat }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-info rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-clock fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Menunggu Verifikasi</h6>
                  <span class="text-muted fs-3">{{ $statusVerifikasi['menunggu'] }}</span>
                </div>
              </div>
            </div>
            
            <div class="col-6 mb-3">
              <div class="d-flex align-items-center">
                <div class="btn btn-danger rounded-circle round-40 hstack justify-content-center">
                  <i class="ti ti-gavel fs-5"></i>
                </div>
                <div class="ms-3">
                  <h6 class="mb-0 fw-bolder">Sanksi Aktif</h6>
                  <span class="text-muted fs-3">{{ $sanksiAktif ?? 0 }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="d-md-flex align-items-center">
            <div>
              <h4 class="card-title">Pelanggaran Terbaru</h4>
              <p class="card-subtitle">Data pelanggaran yang perlu ditindaklanjuti</p>
            </div>
          </div>
          <div class="table-responsive mt-4">
            <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
              <thead>
                <tr>
                  <th scope="col" class="px-0 text-muted">Siswa</th>
                  <th scope="col" class="px-0 text-muted">Jenis Pelanggaran</th>
                  <th scope="col" class="px-0 text-muted">Status</th>
                  <th scope="col" class="px-0 text-muted text-end">Poin</th>
                </tr>
              </thead>
              <tbody>
                @forelse($pelanggaranTerbaru as $pelanggaran)
                <tr>
                  <td class="px-0">
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('assets/images/profile/user-3.jpg') }}" class="rounded-circle" width="40" alt="siswa" />
                      <div class="ms-3">
                        <h6 class="mb-0 fw-bolder">{{ $pelanggaran->siswa->nama_siswa }}</h6>
                        <span class="text-muted">{{ $pelanggaran->siswa->kelas->nama_kelas }}</span>
                      </div>
                    </div>
                  </td>
                  <td class="px-0">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran }}</td>
                  <td class="px-0">
                    @if($pelanggaran->status_verifikasi == 'menunggu')
                      <span class="badge bg-warning">Menunggu</span>
                    @elseif($pelanggaran->status_verifikasi == 'diverifikasi')
                      <span class="badge bg-success">Diverifikasi</span>
                    @elseif($pelanggaran->status_verifikasi == 'ditolak')
                      <span class="badge bg-danger">Ditolak</span>
                    @else
                      <span class="badge bg-info">Revisi</span>
                    @endif
                  </td>
                  <td class="px-0 text-dark fw-medium text-end">{{ $pelanggaran->poin }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center py-4">
                    <span class="text-muted">Tidak ada data pelanggaran</span>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
var pelanggaranData = @json($pelanggaranPerKategori);
window.dynamicPieChart = true;

document.addEventListener('DOMContentLoaded', function() {
    // Line Chart
    var trendData = @json($trendPelanggaran ?? []);
    
    if (trendData && trendData.length > 0) {
        var lineOptions = {
            series: [{
                name: 'Pelanggaran',
                data: trendData.map(item => parseInt(item.total))
            }],
            chart: {
                type: 'line',
                height: 300,
                fontFamily: 'inherit',
                toolbar: { show: false }
            },
            colors: ['#5D87FF'],
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: trendData.map(item => item.bulan),
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                title: { text: 'Jumlah Pelanggaran' }
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 3
            },
            tooltip: {
                theme: 'light',
                style: { fontSize: '12px', fontFamily: 'inherit' }
            }
        };
        
        var lineChart = new ApexCharts(document.querySelector('#sales-overview'), lineOptions);
        lineChart.render();
    }

    // Pie Chart
    if (pelanggaranData && pelanggaranData.length > 0) {
        var pieOptions = {
            series: pelanggaranData.map(item => parseInt(item.total)),
            chart: {
                type: 'pie',
                height: 300,
                fontFamily: 'inherit'
            },
            labels: pelanggaranData.map(item => item.nama_pelanggaran),
            colors: ['#5D87FF', '#49BEFF', '#13DEB9', '#FFAE1F', '#FA896B', '#8B5CF6'],
            legend: {
                position: 'bottom',
                fontSize: '13px',
                fontFamily: 'inherit',
                markers: {
                    width: 8,
                    height: 8
                }
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    fontFamily: 'inherit',
                    fontWeight: 500
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '0%'
                    }
                }
            },
            tooltip: {
                style: {
                    fontSize: '12px',
                    fontFamily: 'inherit'
                }
            }
        };
        
        var pieChart = new ApexCharts(document.querySelector('#chart-pie-simple'), pieOptions);
        pieChart.render();
    }
});
</script>
@endpush

@endsection
