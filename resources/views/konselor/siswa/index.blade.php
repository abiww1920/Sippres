@extends('mainKonselor')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Daftar Siswa</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('konselor.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Daftar Siswa</li>
      </ol>
    </nav>
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
                  <th scope="col" class="px-0 text-muted">Nama Siswa</th>
                  <th scope="col" class="px-0 text-muted">NIS</th>
                  <th scope="col" class="px-0 text-muted">Kelas</th>
                  <th scope="col" class="px-0 text-muted">Jurusan</th>
                  <th scope="col" class="px-0 text-muted">Email</th>
                  <th scope="col" class="px-0 text-muted text-end">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($siswa ?? [] as $item)
                <tr>
                  <td class="px-0">{{ $loop->iteration }}</td>
                  <td class="px-0">
                    <div class="d-flex align-items-center">
                      <img src="{{ asset('assets/images/profile/user-3.jpg') }}" class="rounded-circle" width="40" alt="siswa" />
                      <div class="ms-3">
                        <h6 class="mb-0 fw-bolder">{{ $item->nama_siswa }}</h6>
                      </div>
                    </div>
                  </td>
                  <td class="px-0">{{ $item->nis }}</td>
                  <td class="px-0">{{ $item->kelas->nama_kelas ?? '-' }}</td>
                  <td class="px-0">{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
                  <td class="px-0">{{ $item->email ?? '-' }}</td>
                  <td class="px-0 text-end">
                    <a href="{{ route('konselor.siswa.show', $item->id) }}" class="btn btn-sm btn-primary" title="Lihat">
                      <i class="ti ti-eye"></i>
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7" class="text-center py-4">
                    <span class="text-muted">Tidak ada data siswa</span>
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
