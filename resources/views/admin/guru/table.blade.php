<!-- Table Section -->
<div class="table-responsive">
  <table class="table mb-0 text-nowrap varient-table align-middle fs-3">
    <thead class="text-dark fs-4">
      <tr>
        <th><h6 class="fs-4 fw-semibold mb-0">No</h6></th>
        <th><h6 class="fs-4 fw-semibold mb-0">Nama Guru</h6></th>
        <th><h6 class="fs-4 fw-semibold mb-0">NIP</h6></th>
        <th><h6 class="fs-4 fw-semibold mb-0">Bidang Studi</h6></th>
        <th><h6 class="fs-4 fw-semibold mb-0">Status</h6></th>
        <th><h6 class="fs-4 fw-semibold mb-0">Aksi</h6></th>
      </tr>
    </thead>
    <tbody>
      @forelse($guru as $index => $item)
      <tr>
        <td><p class="mb-0 fw-normal fs-4">{{ $guru->firstItem() + $index }}</p></td>
        <td>
          <div class="d-flex align-items-center">
            <img src="{{ asset('assets/images/profile/user-1.jpg') }}" class="rounded-circle" width="40" height="40">
            <div class="ms-3">
              <h6 class="fs-4 fw-semibold mb-0">{{ $item->nama_guru }}</h6>
              <span class="fw-normal">NIP: {{ $item->nip }}</span>
            </div>
          </div>
        </td>
        <td><p class="mb-0 fw-normal fs-4">{{ $item->nip }}</p></td>
        <td><p class="mb-0 fw-normal fs-4">{{ $item->bidang_studi }}</p></td>
        <td>
          @if($item->status == 'aktif')
            <span class="badge bg-success-subtle text-success">Aktif</span>
          @else
            <span class="badge bg-secondary-subtle text-secondary">Non Aktif</span>
          @endif
        </td>
        <td>
          <div class="dropdown dropstart">
            <a href="javascript:void(0)" class="text-muted" data-bs-toggle="dropdown">
              <i class="ti ti-dots-vertical fs-6"></i>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="javascript:void(0)" onclick="showDetail({{ $item->id }})"><i class="ti ti-eye fs-4 me-2"></i>Detail</a></li>
              <li><a class="dropdown-item" href="javascript:void(0)" onclick="editGuru({{ $item->id }})"><i class="ti ti-edit fs-4 me-2"></i>Edit</a></li>
              <li><a class="dropdown-item text-danger" href="javascript:void(0)" onclick="deleteGuru({{ $item->id }})"><i class="ti ti-trash fs-4 me-2"></i>Hapus</a></li>
            </ul>
          </div>
        </td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="text-center py-4">
          <span class="text-muted">Tidak ada data guru</span>
        </td>
      </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Pagination -->
<div class="d-flex align-items-center justify-content-between mt-4">
  <p class="mb-0 fw-normal fs-4">Menampilkan {{ $guru->firstItem() ?? 0 }}-{{ $guru->lastItem() ?? 0 }} dari {{ $guru->total() }} data</p>
  <nav aria-label="Page navigation">
    <ul class="pagination mb-0">
      @if ($guru->onFirstPage())
        <li class="page-item disabled">
          <a class="page-link" href="javascript:void(0)">Previous</a>
        </li>
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $guru->previousPageUrl() }}">Previous</a>
        </li>
      @endif
      
      @foreach ($guru->getUrlRange(1, $guru->lastPage()) as $page => $url)
        @if ($page == $guru->currentPage())
          <li class="page-item active">
            <a class="page-link" href="javascript:void(0)">{{ $page }}</a>
          </li>
        @else
          <li class="page-item">
            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
          </li>
        @endif
      @endforeach
      
      @if ($guru->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $guru->nextPageUrl() }}">Next</a>
        </li>
      @else
        <li class="page-item disabled">
          <a class="page-link" href="javascript:void(0)">Next</a>
        </li>
      @endif
    </ul>
  </nav>
</div>