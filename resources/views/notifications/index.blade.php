@extends('mainAdmin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">Notifikasi</h1>
        <form action="{{ route('notifications.read-all') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fas fa-check-double"></i> Tandai Semua Dibaca
            </button>
        </form>
    </div>

    <div class="card shadow">
        <div class="card-body">
            @forelse($notifications as $notification)
            <div class="alert {{ $notification->read_at ? 'alert-secondary' : 'alert-info' }} d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $notification->data['title'] ?? 'Notifikasi' }}</strong>
                    <p class="mb-0">{{ $notification->data['message'] ?? '' }}</p>
                    <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                </div>
                @if(!$notification->read_at)
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success">
                        <i class="fas fa-check"></i> Tandai Dibaca
                    </button>
                </form>
                @endif
            </div>
            @empty
            <p class="text-center text-muted">Tidak ada notifikasi</p>
            @endforelse

            <div class="mt-3">
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
