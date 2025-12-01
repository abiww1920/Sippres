<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;
        
        if (!$guru) {
            // Jika tidak ada data guru, buat data dummy atau redirect ke halaman yang sesuai
            $kelasWali = collect();
            $kelasIds = collect();
            $totalSiswa = 0;
            $totalPelanggaran = 0;
            $pelanggaranBulanIni = 0;
            $totalPrestasi = 0;
            $prestasiBulanIni = 0;
            $pelanggaranTerbaru = collect();
            $prestasiTerbaru = collect();
            $chartData = [];
            
            return view('wali_kelas.dashboard', compact(
                'kelasWali',
                'totalSiswa',
                'totalPelanggaran',
                'pelanggaranBulanIni',
                'totalPrestasi',
                'prestasiBulanIni',
                'pelanggaranTerbaru',
                'prestasiTerbaru',
                'chartData'
            ));
        }
        
        // Ambil kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::with('siswa')->where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        // Statistik siswa di kelas yang diampu
        $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();
        
        // Statistik pelanggaran siswa di kelas yang diampu
        $totalPelanggaran = Pelanggaran::whereHas('siswa', function($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->count();
        
        $pelanggaranBulanIni = Pelanggaran::whereHas('siswa', function($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->whereMonth('created_at', Carbon::now()->month)
          ->whereYear('created_at', Carbon::now()->year)
          ->count();
        
        // Statistik prestasi siswa di kelas yang diampu
        $totalPrestasi = Prestasi::whereHas('siswa', function($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->count();
        
        $prestasiBulanIni = Prestasi::whereHas('siswa', function($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->whereMonth('created_at', Carbon::now()->month)
          ->whereYear('created_at', Carbon::now()->year)
          ->count();
        
        // Pelanggaran terbaru di kelas yang diampu
        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->whereHas('siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Prestasi terbaru di kelas yang diampu
        $prestasiTerbaru = Prestasi::with(['siswa.kelas'])
            ->whereHas('siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Data untuk chart - pelanggaran per bulan (6 bulan terakhir)
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $count = Pelanggaran::whereHas('siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })->whereMonth('created_at', $date->month)
              ->whereYear('created_at', $date->year)
              ->count();
            
            $chartData[] = [
                'bulan' => $date->format('M Y'),
                'pelanggaran' => $count
            ];
        }
        
        // Alert counts untuk dashboard
        $alertCounts = $this->getAlertCounts($kelasIds);
        
        return view('wali_kelas.dashboard', compact(
            'guru',
            'kelasWali',
            'totalSiswa',
            'totalPelanggaran',
            'pelanggaranBulanIni',
            'totalPrestasi',
            'prestasiBulanIni',
            'pelanggaranTerbaru',
            'prestasiTerbaru',
            'chartData',
            'alertCounts'
        ));
    }
    
    private function getAlertCounts($kelasIds)
    {
        // Siswa dengan poin kritis (75+)
        $siswaKritis = Siswa::whereIn('kelas_id', $kelasIds)
            ->with(['pelanggaran.jenisPelanggaran'])
            ->get()
            ->filter(function($siswa) {
                $totalPoin = $siswa->pelanggaran
                    ->where('status_verifikasi', 'diverifikasi')
                    ->sum(function($p) {
                        return $p->jenisPelanggaran->poin ?? 0;
                    });
                return $totalPoin >= 75;
            })->count();
        
        // Siswa dengan sanksi baru (7 hari terakhir)
        $siswaSanksiBaru = \DB::table('sanksi')
            ->join('pelanggaran', 'sanksi.pelanggaran_id', '=', 'pelanggaran.id')
            ->join('siswa', 'pelanggaran.siswa_id', '=', 'siswa.id')
            ->whereIn('siswa.kelas_id', $kelasIds)
            ->where('sanksi.created_at', '>=', now()->subDays(7))
            ->distinct('siswa.id')
            ->count('siswa.id');
        
        // Siswa yang perlu panggilan orang tua (poin 50-74)
        $siswaPanggilanOrtu = Siswa::whereIn('kelas_id', $kelasIds)
            ->with(['pelanggaran.jenisPelanggaran'])
            ->get()
            ->filter(function($siswa) {
                $totalPoin = $siswa->pelanggaran
                    ->where('status_verifikasi', 'diverifikasi')
                    ->sum(function($p) {
                        return $p->jenisPelanggaran->poin ?? 0;
                    });
                return $totalPoin >= 50 && $totalPoin < 75;
            })->count();
        
        return [
            'siswa_kritis' => $siswaKritis,
            'sanksi_baru' => $siswaSanksiBaru,
            'panggilan_ortu' => $siswaPanggilanOrtu
        ];
    }
}
