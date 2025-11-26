<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        $userRole = $user->level;
        
        // Admin bisa akses semua halaman
        if ($userRole === 'admin') {
            return $next($request);
        }
        
        // Validasi orang tua harus punya siswa_id
        if ($userRole === 'orang_tua' && !$user->siswa_id) {
            abort(403, 'Data siswa tidak ditemukan. Hubungi administrator.');
        }
        
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access. Your role: ' . $userRole . ', Required: ' . implode(', ', $roles));
        }

        return $next($request);
    }
}
