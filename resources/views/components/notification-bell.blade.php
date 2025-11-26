<div class="dropdown">
    <a class="nav-link position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ti ti-bell fs-6"></i>
        @if(auth()->user()->unreadNotifications->count() > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ auth()->user()->unreadNotifications->count() }}
        </span>
        @endif
    </a>
    <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="notificationDropdown" style="width: 300px; max-height: 400px; overflow-y: auto;">
        <li class="dropdown-header d-flex justify-content-between align-items-center">
            <span>Notifikasi</span>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.read-all') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none">Tandai Semua</button>
            </form>
            @endif
        </li>
        <li><hr class="dropdown-divider"></li>
        
        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
        <li>
            <a class="dropdown-item {{ $notification->read_at ? '' : 'bg-light' }}" href="{{ route('notifications.index') }}">
                <div class="d-flex">
                    <div class="flex-grow-1">
                        <strong class="d-block">{{ $notification->data['title'] ?? 'Notifikasi' }}</strong>
                        <small class="text-muted">{{ Str::limit($notification->data['message'] ?? '', 50) }}</small>
                        <br>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </a>
        </li>
        @empty
        <li class="dropdown-item text-center text-muted">Tidak ada notifikasi</li>
        @endforelse
        
        <li><hr class="dropdown-divider"></li>
        <li>
            <a class="dropdown-item text-center" href="{{ route('notifications.index') }}">Lihat Semua Notifikasi</a>
        </li>
    </ul>
</div>
