@extends('mainAdmin')
@section('content')
<div class="container-fluid">
          <div class="mb-4">
            <h4 class="fw-semibold mb-2">Dashboard</h4>
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a class="text-muted text-decoration-none" href="#">Home</a>
                </li>
                <li class="breadcrumb-item" aria-current="page">Dashboard</li>
              </ol>
            </nav>
          </div>
          <!--  Row 1 -->
          <div class="row">
            <div class="col-lg-8">
              <div class="card w-100">
                <div class="card-body">
                  <div class="d-md-flex align-items-center">
                    <div>
                      <h4 class="card-title">Statistik Pelanggaran</h4>
                      <p class="card-subtitle">
                        Data pelanggaran per bulan
                      </p>
                    </div>
                    <div class="ms-auto">
                      <ul class="list-unstyled mb-0">
                        <li class="list-inline-item text-primary">
                          <span class="round-8 text-bg-primary rounded-circle me-1 d-inline-block"></span>
                          Pelanggaran
                        </li>
                        <li class="list-inline-item text-info">
                          <span class="round-8 text-bg-info rounded-circle me-1 d-inline-block"></span>
                          Prestasi
                        </li>
                      </ul>
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
                    <div class="ms-auto">
                      <div class="dropdown">
                        <a href="javascript:void(0)" class="text-muted" id="year1-dropdown" data-bs-toggle="dropdown"
                          aria-expanded="false">
                          <i class="ti ti-dots fs-7"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="year1-dropdown">
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Hari Ini</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Minggu Ini</a>
                          </li>
                          <li>
                            <a class="dropdown-item" href="javascript:void(0)">Bulan Ini</a>
                          </li>
                        </ul>
                      </div>
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
                    <div class="ms-auto">
                      <span class="badge bg-secondary-subtle text-muted">+15%</span>
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
                    <div class="ms-auto">
                      <span class="badge bg-secondary-subtle text-muted">+68%</span>
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
                    <div class="ms-auto">
                      <span class="badge bg-secondary-subtle text-muted">+2%</span>
                    </div>
                  </div>
                  <div class="pt-3 mb-7 d-flex align-items-center">
                    <span class="btn btn-info rounded-circle round-48 hstack justify-content-center">
                      <i class="ti ti-edit fs-6"></i>
                    </span>
                    <div class="ms-3">
                      <h5 class="mb-0 fw-bolder fs-4">Revisi</h5>
                      <span class="text-muted fs-3">{{ $statusVerifikasi['revisi'] }} Data</span>
                    </div>
                    <div class="ms-auto">
                      <span class="badge bg-secondary-subtle text-muted">+5%</span>
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
                  <p class="card-subtitle mb-4">Ringkasan data hari ini</p>
                  
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
                        <div class="btn btn-success rounded-circle round-40 hstack justify-content-center">
                          <i class="ti ti-trophy fs-5"></i>
                        </div>
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bolder">Total Prestasi</h6>
                          <span class="text-muted fs-3">{{ $totalPrestasi }}</span>
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
                          <i class="ti ti-calendar fs-5"></i>
                        </div>
                        <div class="ms-3">
                          <h6 class="mb-0 fw-bolder">Hari Ini</h6>
                          <span class="text-muted fs-3">{{ $pelanggaranHariIni }}</span>
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
                      <p class="card-subtitle">
                        Data pelanggaran yang perlu ditindaklanjuti
                      </p>
                    </div>
                    <div class="ms-auto mt-3 mt-md-0">
                      <select class="form-select theme-select border-0" aria-label="Default select example">
                        <option value="1">Hari Ini</option>
                        <option value="2">Minggu Ini</option>
                        <option value="3">Bulan Ini</option>
                      </select>
                    </div>
                  </div>
                  <div class="table-responsive mt-4">
                    <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
                    <thead class="text-dark fs-4">
                        <tr>
                          <th><h6 class="fs-4 fw-semibold mb-0">Nama Siswa</h6></th>
                          <th><h6 class="fs-4 fw-semibold mb-0">Kelas</h6></th>
                          <th><h6 class="fs-4 fw-semibold mb-0">Jenis Pelanggaran</h6></th>
                          <th><h6 class="fs-4 fw-semibold mb-0">Tanggal</h6></th>
                          <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
                          <th><h6 class="fs-4 fw-semibold mb-0">Poin</h6></th>
                          <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
                        </tr>
                      </thead>
                      <tbody>
                        @forelse($pelanggaranTerbaru as $p)
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              @if($p->siswa->foto && file_exists(public_path('uploads/siswa/' . $p->siswa->foto)))
                                <img src="{{ asset('uploads/siswa/' . $p->siswa->foto) }}" class="rounded-circle foto-siswa" width="40" height="40" style="object-fit: cover; cursor: pointer;" onclick="showPhotoModal('{{ asset('uploads/siswa/' . $p->siswa->foto) }}', '{{ $p->siswa->nama_siswa }}')">
                              @else
                                <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                              @endif
                              <div class="ms-3">
                                <h6 class="fs-4 fw-semibold mb-0">{{ $p->siswa->nama_siswa }}</h6>
                                <span class="fw-normal">NIS: {{ $p->siswa->nis }}</span>
                              </div>
                            </div>
                          </td>
                          <td><p class="mb-0 fw-normal fs-4">{{ $p->siswa->kelas->nama_kelas }}</p></td>
                          <td><p class="mb-0 fw-normal fs-4">{{ $p->jenisPelanggaran->nama_pelanggaran }}</p></td>
                          <td><p class="mb-0 fw-normal fs-4">{{ $p->created_at->format('d M Y') }}</p></td>
                          <td>
                            @if($p->status_verifikasi == 'menunggu')
                              <span class="badge bg-warning-subtle text-warning">Menunggu</span>
                            @elseif($p->status_verifikasi == 'diverifikasi')
                              <span class="badge bg-success-subtle text-success">Diverifikasi</span>
                            @elseif($p->status_verifikasi == 'ditolak')
                              <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                            @else
                              <span class="badge bg-info-subtle text-info">Revisi</span>
                            @endif
                          </td>
                          <td><p class="mb-0 fw-normal fs-4">{{ $p->poin }}</p></td>
                          <td>
                            <div class="dropdown dropstart">
                              <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                                <i class="ti ti-dots-vertical fs-6"></i>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('admin.pelanggaran.show', $p->id) }}"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
                              </ul>
                            </div>
                          </td>
                        </tr>
                        @empty
                        <tr>
                          <td colspan="7" class="text-center py-4">
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
</div>

<!-- Modal Photo Viewer -->
<div class="modal fade" id="modalPhotoViewer" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="photoModalTitle">Foto Siswa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="photoModalImage" src="" class="img-fluid rounded" style="max-height: 400px;">
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
// Data untuk pie chart kategori pelanggaran
var pelanggaranData = @json($pelanggaranPerKategori);
var chartData = @json($chartData);
window.dynamicPieChart = true; // Flag to prevent default chart

document.addEventListener('DOMContentLoaded', function() {
    // Render pie chart dengan data dari database
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
    } else {
        // Jika tidak ada data, tampilkan pesan
        document.querySelector('#chart-pie-simple').innerHTML = '<div class="text-center py-4"><span class="text-muted">Tidak ada data pelanggaran</span></div>';
    }
});

// Set flag to prevent default chart from dashboard.js
window.dynamicChartRendered = true;

// Render bar chart statistik pelanggaran per bulan
if (chartData && chartData.length > 0) {
    var barOptions = {
        series: [
            {
                name: 'Pelanggaran',
                data: chartData.map(item => item.pelanggaran)
            },
            {
                name: 'Prestasi',
                data: chartData.map(item => item.prestasi)
            }
        ],
        chart: {
            type: 'bar',
            height: 275,
            fontFamily: 'inherit',
            toolbar: {
                show: false
            },
            foreColor: '#adb0bb',
            sparkline: {
                enabled: false
            }
        },
        colors: ['var(--bs-primary)', 'var(--bs-secondary)'],
        dataLabels: {
            enabled: false
        },
        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: '25%',
                endingShape: 'rounded',
                borderRadius: 5
            }
        },
        stroke: {
            show: true,
            width: 5,
            lineCap: 'butt',
            colors: ['transparent']
        },
        xaxis: {
            type: 'category',
            categories: chartData.map(item => item.bulan),
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            show: true,
            tickAmount: 3
        },
        grid: {
            show: false,
            borderColor: 'transparent',
            padding: {
                left: 0,
                right: 0,
                bottom: 0
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            theme: 'dark'
        },
        legend: {
            show: false
        }
    };
    
    var barChart = new ApexCharts(document.querySelector('#sales-overview'), barOptions);
    barChart.render();
}

// Function to show photo modal
function showPhotoModal(photoUrl, studentName) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = `Foto ${studentName}`;
    new bootstrap.Modal(document.getElementById('modalPhotoViewer')).show();
}

// Debug info
console.log('Dashboard data loaded:', {
    totalPelanggaran: {{ $totalPelanggaran }},
    totalPrestasi: {{ $totalPrestasi }},
    pelanggaranPerKategori: pelanggaranData,
    chartData: chartData
});
</script>
@endpush

@endsection