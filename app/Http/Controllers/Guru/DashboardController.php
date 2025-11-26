<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $guruId = auth()->user()->guru_id;
        
        $totalPelanggaran = Pelanggaran::where('guru_pencatat', $guruId)->count();
        $pelanggaranBulanIni = Pelanggaran::where('guru_pencatat', $guruId)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        $totalSiswa = Siswa::count();
        $siswaBaik = Siswa::whereDoesntHave('pelanggaran')->count();
        
        $pelanggaranTerbaru = Pelanggaran::where('guru_pencatat', $guruId)
            ->with(['siswa.kelas', 'jenisPelanggaran'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        $pelanggaranPerKategori = Pelanggaran::where('guru_pencatat', $guruId)
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->select('jenis_pelanggaran.kategori', DB::raw('count(*) as total'))
            ->groupBy('jenis_pelanggaran.kategori')
            ->get();
        
        return view('guru.dashboard', compact(
            'totalPelanggaran',
            'pelanggaranBulanIni',
            'totalSiswa',
            'siswaBaik',
            'pelanggaranTerbaru',
            'pelanggaranPerKategori'
        ));
    }
}