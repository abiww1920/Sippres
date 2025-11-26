<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Siswa;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }
        
        $totalPelanggaran = Pelanggaran::where('siswa_id', $siswa->id)->count();
        $totalPrestasi = Prestasi::where('siswa_id', $siswa->id)->count();
        
        return view('siswa.dashboard', compact('siswa', 'totalPelanggaran', 'totalPrestasi'));
    }
    
    public function profile()
    {
        $user = auth()->user();
        $siswa = $user->siswa;
            
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }
        
        $siswa->load(['kelas', 'jurusan']);
            
        return view('siswa.profile', compact('siswa'));
    }
    
    public function pelanggaran()
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }
        
        $pelanggaran = Pelanggaran::with(['jenisPelanggaran', 'createdBy'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('siswa.pelanggaran', compact('pelanggaran'));
    }
    
    public function prestasi()
    {
        $user = auth()->user();
        $siswa = $user->siswa;
        
        if (!$siswa) {
            return redirect()->route('login')->with('error', 'Data siswa tidak ditemukan');
        }
        
        $prestasi = Prestasi::with(['createdBy'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('siswa.prestasi', compact('prestasi'));
    }
}