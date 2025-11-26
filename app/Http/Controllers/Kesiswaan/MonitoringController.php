<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kelas;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'pelanggaran', 'prestasi']);
        
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        if ($request->filled('search')) {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%');
        }
        
        $siswa = $query->paginate(10);
        $kelas = Kelas::all();
        
        return view('kesiswaan.monitoring.index', compact('siswa', 'kelas'));
    }
    
    public function detail($id)
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'prestasi'])->findOrFail($id);
        $totalPoin = $siswa->pelanggaran->where('status_verifikasi', 'diverifikasi')->sum('poin');
        
        return view('kesiswaan.monitoring.detail', compact('siswa', 'totalPoin'));
    }
}
