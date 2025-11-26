<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\BimbinganKonseling;
use App\Models\Sanksi;
use App\Models\JeniPelanggaran;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik dasar
        $totalSiswa = Siswa::count();
        $totalPelanggaran = Pelanggaran::where('status_verifikasi', 'diverifikasi')->count();
        $totalPrestasi = Prestasi::count();
        $kasusBKAktif = BimbinganKonseling::whereIn('status', ['diproses', 'tindak_lanjut'])->count();
        $sanksiAktif = Sanksi::where('status', 'berjalan')->count();
        
        // Status verifikasi
        $statusVerifikasi = [
            'menunggu' => Pelanggaran::where('status_verifikasi', 'menunggu')->count(),
            'diverifikasi' => $totalPelanggaran,
            'ditolak' => Pelanggaran::where('status_verifikasi', 'ditolak')->count(),
            'revisi' => Pelanggaran::where('status_verifikasi', 'revisi')->count()
        ];
        
        // Pelanggaran terbaru
        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Data untuk chart - pelanggaran per kategori
        $pelanggaranPerKategori = DB::table('pelanggaran as p')
            ->join('jenis_pelanggaran as jp', 'p.jenis_pelanggaran_id', '=', 'jp.id')
            ->select('jp.nama_pelanggaran', DB::raw('count(*) as total'))
            ->where('p.status_verifikasi', 'diverifikasi')
            ->groupBy('jp.id', 'jp.nama_pelanggaran')
            ->get();
            
        // Pelanggaran hari ini
        $pelanggaranHariIni = Pelanggaran::whereDate('created_at', today())->count();
        
        // Siswa yang terlibat pelanggaran (unique)
        $siswaTerlibat = Pelanggaran::distinct('siswa_id')->count('siswa_id');
        
        // Data untuk chart - pelanggaran dan prestasi per bulan (6 bulan terakhir)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $bulan = $date->format('M Y');
            
            $pelanggaranCount = Pelanggaran::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->where('status_verifikasi', 'diverifikasi')
                ->count();
                
            $prestasiCount = Prestasi::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
            
            $chartData[] = [
                'bulan' => $bulan,
                'pelanggaran' => $pelanggaranCount,
                'prestasi' => $prestasiCount
            ];
        }
        
        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalPelanggaran', 
            'totalPrestasi',
            'kasusBKAktif',
            'sanksiAktif',
            'statusVerifikasi',
            'pelanggaranTerbaru',
            'pelanggaranPerKategori',
            'pelanggaranHariIni',
            'siswaTerlibat',
            'chartData'
        ));
    }
}