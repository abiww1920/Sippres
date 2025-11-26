<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $totalPelanggaran = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->count();
        
        $totalPrestasi = $siswa->prestasi()->count();
        
        $totalPoin = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        $pelanggaranTerbaru = $siswa->pelanggaran()
            ->with(['jenisPelanggaran'])
            ->where('status_verifikasi', 'diverifikasi')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        $prestasiTerbaru = $siswa->prestasi()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('ortu.dashboard', compact(
            'siswa',
            'totalPelanggaran',
            'totalPrestasi',
            'totalPoin',
            'pelanggaranTerbaru',
            'prestasiTerbaru'
        ));
    }
    
    public function pelanggaran()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $pelanggaran = $siswa->pelanggaran()
            ->with(['jenisPelanggaran'])
            ->where('status_verifikasi', 'diverifikasi')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('ortu.pelanggaran', compact('siswa', 'pelanggaran'));
    }
    
    public function prestasi()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $prestasi = $siswa->prestasi()
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('ortu.prestasi', compact('siswa', 'prestasi'));
    }
    
    public function profil()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $totalPelanggaran = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->count();
        
        $totalPrestasi = $siswa->prestasi()->count();
        
        $totalPoin = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        return view('ortu.profil', compact('siswa', 'totalPelanggaran', 'totalPrestasi', 'totalPoin'));
    }
}
