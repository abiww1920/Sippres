@extends('mainAdmin')
@section('content')
<div class="container-fluid">
  <div class="mb-4">
    <h4 class="fw-semibold mb-2">Data User</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a class="text-muted text-decoration-none" href="{{ route('admin.dashboard') }}">Home</a>
        </li>
        <li class="breadcrumb-item" aria-current="page">Data User</li>
      </ol>
    </nav>
  </div>

  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <i class="ti ti-check-circle fs-4 me-2"></i>{{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="ti ti-alert-circle fs-4 me-2"></i>{{ session('error') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  @endif
  
  <div class="card">
    <div class="card-body">
      <div class="d-flex align-items-center justify-content-between mb-4">
        <h5 class="card-title fw-semibold mb-0">Data User Sistem</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
          <i class="ti ti-plus fs-4"></i> Tambah User
        </button>
      </div>
      
      <!-- Filter Section -->
      <form method="GET" class="row mb-3">
        <div class="col-md-3">
          <select name="role" class="form-select">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            <option value="kesiswaan" {{ request('role') == 'kesiswaan' ? 'selected' : '' }}>Kesiswaan</option>
            <option value="guru" {{ request('role') == 'guru' ? 'selected' : '' }}>Guru</option>
            <option value="wali_kelas" {{ request('role') == 'wali_kelas' ? 'selected' : '' }}>Wali Kelas</option>
            <option value="konselor" {{ request('role') == 'konselor' ? 'selected' : '' }}>Konselor</option>
            <option value="kepala_sekolah" {{ request('role') == 'kepala_sekolah' ? 'selected' : '' }}>Kepala Sekolah</option>
            <option value="siswa" {{ request('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
            <option value="orang_tua" {{ request('role') == 'orang_tua' ? 'selected' : '' }}>Orang Tua</option>
          </select>
        </div>
        <div class="col-md-6">
          <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
          <button type="submit" class="btn btn-outline-secondary">
            <i class="ti ti-search fs-4"></i> Cari
          </button>
          <a href="{{ route('admin.users') }}" class="btn btn-outline-secondary ms-1">
            <i class="ti ti-refresh fs-4"></i>
          </a>
        </div>
      </form>

      <!-- Table Section -->
      <div class="table-responsive">
        <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
          <thead class="text-dark fs-4">
            <tr>
              <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Nama</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Email</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Role</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Dibuat</h6></th>
              <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $index => $user)
            <tr>
              <td><p class="mb-0 fw-normal fs-4">{{ $users->firstItem() + $index }}</p></td>
              <td>
                <div class="d-flex align-items-center">
                  <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40" style="object-fit: cover;">
                  <div class="ms-3">
                    <h6 class="fs-4 fw-semibold mb-0">{{ $user->username }}</h6>
                    <span class="fw-normal">{{ $user->email }}</span>
                  </div>
                </div>
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $user->email }}</p></td>
              <td>
                @if($user->level == 'admin')
                  <span class="badge bg-danger-subtle text-danger">Admin</span>
                @elseif($user->level == 'kesiswaan')
                  <span class="badge bg-primary-subtle text-primary">Kesiswaan</span>
                @elseif($user->level == 'guru')
                  <span class="badge bg-info-subtle text-info">Guru</span>
                @elseif($user->level == 'wali_kelas')
                  <span class="badge bg-warning-subtle text-warning">Wali Kelas</span>
                @elseif($user->level == 'konselor')
                  <span class="badge bg-success-subtle text-success">Konselor</span>
                @elseif($user->level == 'kepala_sekolah')
                  <span class="badge bg-dark-subtle text-dark">Kepala Sekolah</span>
                @elseif($user->level == 'siswa')
                  <span class="badge bg-light-subtle text-muted">Siswa</span>
                @elseif($user->level == 'orang_tua')
                  <span class="badge bg-secondary-subtle text-secondary">Orang Tua</span>
                @else
                  <span class="badge bg-secondary-subtle text-secondary">{{ ucfirst(str_replace('_', ' ', $user->level)) }}</span>
                @endif
              </td>
              <td><p class="mb-0 fw-normal fs-4">{{ $user->created_at->format('d M Y') }}</p></td>
              <td>
                <div class="dropdown dropstart">
                  <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
                    <i class="ti ti-dots-vertical fs-6"></i>
                  </a>
                  <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="editUser({{ $user->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
                    @if($user->id != auth()->id())
                    <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteUser({{ $user->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
                    @endif
                  </ul>
                </div>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center py-4">
                <span class="text-muted">Tidak ada data user</span>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="d-flex align-items-center justify-content-between mt-4">
        <p class="mb-0 fw-normal fs-4">Menampilkan {{ $users->firstItem() ?? 0 }}-{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data</p>
        <nav aria-label="Page navigation">
          <ul class="pagination mb-0">
            @if ($users->onFirstPage())
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Previous</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
              </li>
            @endif
            
            @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
              @if ($page == $users->currentPage())
                <li class="page-item active">
                  <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
              @endif
            @endforeach
            
            @if ($users->hasMorePages())
              <li class="page-item">
                <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
              </li>
            @else
              <li class="page-item disabled">
                <a class="page-link" href="javascript:void(0)">Next</a>
              </li>
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" required>
                @error('username')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                @error('email')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="level" class="form-label">Role</label>
                <select name="level" id="level" class="form-select @error('level') is-invalid @enderror" required onchange="toggleGuruField()">
                  <option value="">Pilih Role</option>
                  <option value="admin">Admin</option>
                  <option value="kesiswaan">Kesiswaan</option>
                  <option value="guru">Guru</option>
                  <option value="wali_kelas">Wali Kelas</option>
                  <option value="konselor">Konselor</option>
                  <option value="kepala_sekolah">Kepala Sekolah</option>
                  <option value="siswa">Siswa</option>
                  <option value="orang_tua">Orang Tua</option>
                </select>
                @error('level')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row" id="guruFieldContainer" style="display: none;">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="guru_id" class="form-label">Pilih Guru</label>
                <select name="guru_id" id="guru_id" class="form-select @error('guru_id') is-invalid @enderror">
                  <option value="">Pilih Guru</option>
                  @php
                    $guruList = \App\Models\Guru::all();
                  @endphp
                  @foreach($guruList as $g)
                    <option value="{{ $g->id }}">{{ $g->nama_guru }} - {{ $g->nip }}</option>
                  @endforeach
                </select>
                @error('guru_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row" id="siswaFieldContainer" style="display: none;">
            <div class="col-md-12">
              <div class="mb-3">
                <label for="siswa_id" class="form-label">Pilih Siswa</label>
                <select name="siswa_id" id="siswa_id" class="form-select @error('siswa_id') is-invalid @enderror">
                  <option value="">Pilih Siswa</option>
                  @php
                    $siswaList = \App\Models\Siswa::with('kelas')->get();
                  @endphp
                  @foreach($siswaList as $s)
                    <option value="{{ $s->id }}">{{ $s->nama_siswa }} - {{ $s->nis }} ({{ $s->kelas->nama_kelas }})</option>
                  @endforeach
                </select>
                @error('siswa_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit User -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editUserForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" id="edit_username" class="form-control" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Password (kosongkan jika tidak diubah)</label>
                <input type="password" name="password" class="form-control">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="level" id="edit_level" class="form-select" required>
                  <option value="admin">Admin</option>
                  <option value="kesiswaan">Kesiswaan</option>
                  <option value="guru">Guru</option>
                  <option value="wali_kelas">Wali Kelas</option>
                  <option value="konselor">Konselor</option>
                  <option value="kepala_sekolah">Kepala Sekolah</option>
                  <option value="siswa">Siswa</option>
                  <option value="orang_tua">Orang Tua</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy fs-4"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@push('scripts')
<script>
// Setup CSRF token for all AJAX requests
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Show modal if there are validation errors
@if($errors->any())
    document.addEventListener('DOMContentLoaded', function() {
        var modal = new bootstrap.Modal(document.getElementById('addUserModal'));
        modal.show();
    });
@endif

// Edit user function
function editUser(id) {
    fetch(`/admin/users/${id}/edit`, {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_username').value = data.username;
            document.getElementById('edit_email').value = data.email;
            document.getElementById('edit_level').value = data.level;
            document.getElementById('editUserForm').action = `/admin/users/${id}`;
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengambil data user');
        });
}

// Delete user function
function deleteUser(id) {
    if (confirm('Apakah Anda yakin ingin menghapus user ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/users/${id}`;
        
        // Create CSRF token input
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Create method input
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}

// Toggle guru and siswa field based on role selection
function toggleGuruField() {
    const level = document.getElementById('level').value;
    const guruFieldContainer = document.getElementById('guruFieldContainer');
    const guruIdField = document.getElementById('guru_id');
    const siswaFieldContainer = document.getElementById('siswaFieldContainer');
    const siswaIdField = document.getElementById('siswa_id');
    
    // Reset all fields
    guruFieldContainer.style.display = 'none';
    guruIdField.required = false;
    guruIdField.value = '';
    siswaFieldContainer.style.display = 'none';
    siswaIdField.required = false;
    siswaIdField.value = '';
    
    // Show appropriate field based on role
    if (level === 'guru' || level === 'wali_kelas') {
        guruFieldContainer.style.display = 'block';
        guruIdField.required = true;
    } else if (level === 'siswa' || level === 'orang_tua') {
        siswaFieldContainer.style.display = 'block';
        siswaIdField.required = true;
    }
}

// Refresh CSRF token periodically to prevent expiration
setInterval(function() {
    fetch('/csrf-token')
        .then(response => response.json())
        .then(data => {
            document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
            document.querySelectorAll('input[name="_token"]').forEach(input => {
                input.value = data.token;
            });
        })
        .catch(error => {
            console.error('Failed to refresh CSRF token:', error);
        });
}, 600000);
</script>
@endpush

@endsection