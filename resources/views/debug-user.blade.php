<!DOCTYPE html>
<html>
<head>
    <title>Debug User Info</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .info { background: #f0f0f0; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <h1>Debug User Information</h1>
    
    @auth
        <div class="info success">
            <h2>✓ User is Authenticated</h2>
            <p><strong>ID:</strong> {{ auth()->id() }}</p>
            <p><strong>Username:</strong> {{ auth()->user()->username }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
            <p><strong>Level:</strong> {{ auth()->user()->level }}</p>
            <p><strong>Can Verify:</strong> {{ auth()->user()->can_verify ? 'Yes' : 'No' }}</p>
        </div>
        
        <div class="info">
            <h3>Available Dashboards for Your Role:</h3>
            @if(auth()->user()->level === 'admin')
                <p>✓ <a href="/admin/dashboard">Admin Dashboard</a></p>
            @elseif(auth()->user()->level === 'kesiswaan')
                <p>✓ <a href="/kesiswaan/dashboard">Kesiswaan Dashboard</a></p>
            @elseif(auth()->user()->level === 'guru')
                <p>✓ <a href="/guru/dashboard">Guru Dashboard</a></p>
            @elseif(auth()->user()->level === 'wali_kelas')
                <p>✓ <a href="/walikelas/dashboard">Wali Kelas Dashboard</a></p>
            @elseif(auth()->user()->level === 'konselor')
                <p>✓ <a href="/konselor/dashboard">Konselor Dashboard</a></p>
            @elseif(auth()->user()->level === 'kepala_sekolah')
                <p>✓ <a href="/kepsek/dashboard">Kepala Sekolah Dashboard</a></p>
            @elseif(auth()->user()->level === 'siswa')
                <p>✓ <a href="/siswa/dashboard">Siswa Dashboard</a></p>
            @elseif(auth()->user()->level === 'orang_tua')
                <p>✓ <a href="/ortu/dashboard">Orang Tua Dashboard</a></p>
            @endif
        </div>
        
        <div class="info">
            <form action="/logout" method="POST">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    @else
        <div class="info error">
            <h2>✗ User is NOT Authenticated</h2>
            <p><a href="/login">Go to Login</a></p>
        </div>
    @endauth
</body>
</html>
