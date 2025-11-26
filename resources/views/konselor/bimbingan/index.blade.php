@extends('mainKonselor')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <div class="d-flex justify-content-between align-items-center">
      <div>
        <h4 class="fw-semibold mb-2">Data Bimbingan Konseling</h4>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a class="text-muted text-decoration-none" href="{{ route('konselor.dashboard') }}">Home</a>
            </li>
            <li class="breadcrumb-item" aria-current="page">Data Bimbingan</li>
          </ol>
        </nav>
      </div>
      <a href="{{ route('konselor.bimbingan.create') }}" class="btn btn-primary">
        <i class="ti ti-plus"></i> Tambah Bimbingan
      </a>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
              <thead>
                <tr>
                  <th scope="col" class="px-0 text-muted">No</th>
                  <th scope="col" class="px-0 text-muted">Siswa</th>
                  <th scope="col" class="px-0 text-muted">Kelas</th>
                  <th scope="col" class="px-0 text-muted">Topik</th>
                  <th scope="col" class="px-0 text-muted">Tanggal</th>
                  <th scope="col" class="px-0 text-muted">Status</th>
                  <th scope="col" class="px-0 text-muted text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($bimbingan ?? [] as $item)
                <tr>
                  <td class="px-0">{{ $loop->iteration }}</td>
                  <td class="px-0">
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('assets/images/profile/user-3.jpg') }}" class="rounded-circle" width="40" alt="siswa" />
                      <div class="ms-3">
                        <h6 class="mb-0 fw-bolder">{{ $item->siswa->nama_siswa ?? '-' }}</h6>
                      </div>
                    </div>
                  </td>
                  <td class="px-0">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                  <td class="px-0">{{ $item->topik ?? '-' }}</td>
                  <td class="px-0">{{ $item->tanggal ? $item->tanggal->format('d/m/Y') : '-' }}</td>
                  <td class="px-0">
                    @if($item->status == 'selesai')
                      <span class="badge bg-success">Selesai</span>
                    @elseif($item->status == 'proses')
                      <span class="badge bg-warning">Proses</span>
                    @else
                      <span class="badge bg-info">Terjadwal</span>
                    @endif
                  </td>
                  <td class="px-0 text-end">
                    <a href="{{ route('konselor.bimbingan.show', $item->id ?? '#') }}" class="btn btn-sm btn-primary" title="Lihat">
                      <i class="ti ti-eye"></i>
                    </a>
                    <a href="{{ route('konselor.bimbingan.edit', $item->id ?? '#') }}" class="btn btn-sm btn-warning" title="Edit">
                      <i class="ti ti-pencil"></i>
                    </a>
                    <form action="{{ route('konselor.bimbingan.destroy', $item->id ?? '#') }}" method="POST" style="display:inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Yakin ingin menghapus?')">
                        <i class="ti ti-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4">
                    <span class="text-muted">Tidak ada data bimbingan</span>
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
@endsection
