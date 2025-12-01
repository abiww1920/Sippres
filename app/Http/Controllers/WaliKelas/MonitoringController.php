<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Sanksi;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $guru = $user->guru;
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        // Ambil kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        // Alert 1: Siswa dengan poin kritis (75+)
        $siswaKritis = Siswa::whereIn('kelas_id', $kelasIds)
            ->with(['pelanggaran.jenisPelanggaran', 'kelas'])
            ->get()
            ->filter(function($siswa) {
                $totalPoin = $siswa->pelanggaran
                    ->where('status_verifikasi', 'diverifikasi')
                    ->sum(function($p) {
                        return $p->jenisPelanggaran->poin ?? 0;
                    });
                return $totalPoin >= 75;
            });
        
        // Alert 2: Siswa dengan sanksi baru (7 hari terakhir)
        $siswaSanksiBaru = Siswa::whereIn('kelas_id', $kelasIds)
            ->whereHas('sanksi', function($query) {
                $query->where('created_at', '>=', now()->subDays(7));
            })
            ->with(['sanksi' => function($query) {
                $query->where('created_at', '>=', now()->subDays(7))
                      ->with('jenisSanksi');
            }, 'kelas'])
            ->get();
        
        // Alert 3: Siswa yang perlu panggilan orang tua (poin 50+)
        $siswaPanggilanOrtu = Siswa::whereIn('kelas_id', $kelasIds)
            ->with(['pelanggaran.jenisPelanggaran', 'kelas'])
            ->get()
            ->filter(function($siswa) {
                $totalPoin = $siswa->pelanggaran
                    ->where('status_verifikasi', 'diverifikasi')
                    ->sum(function($p) {
                        return $p->jenisPelanggaran->poin ?? 0;
                    });
                return $totalPoin >= 50 && $totalPoin < 75;
            });
        
        // Alert 4: Siswa dengan pelanggaran berulang (3+ dalam 30 hari)
        $siswaPelanggaranBerulang = Siswa::whereIn('kelas_id', $kelasIds)
            ->whereHas('pelanggaran', function($query) {
                $query->where('created_at', '>=', now()->subDays(30))
                      ->where('status_verifikasi', 'diverifikasi');
            })
            ->withCount(['pelanggaran as pelanggaran_count' => function($query) {
                $query->where('created_at', '>=', now()->subDays(30))
                      ->where('status_verifikasi', 'diverifikasi');
            }])
            ->with('kelas')
            ->having('pelanggaran_count', '>=', 3)
            ->get();
        
        // Statistik monitoring
        $stats = [
            'total_siswa_kritis' => $siswaKritis->count(),
            'total_sanksi_baru' => $siswaSanksiBaru->count(),
            'total_panggilan_ortu' => $siswaPanggilanOrtu->count(),
            'total_pelanggaran_berulang' => $siswaPelanggaranBerulang->count()
        ];
        
        return view('wali_kelas.monitoring.index', compact(
            'kelasWali',
            'siswaKritis',
            'siswaSanksiBaru', 
            'siswaPanggilanOrtu',
            'siswaPelanggaranBerulang',
            'stats'
        ));
    }
    
    public function detail($id)
    {
        $user = Auth::user();
        $guru = $user->guru;
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan');
        }
        
        $kelasIds = Kelas::where('wali_kelas_id', $guru->id)->pluck('id');
        
        $siswa = Siswa::whereIn('kelas_id', $kelasIds)
            ->with(['kelas', 'pelanggaran.jenisPelanggaran', 'prestasi', 'sanksi.jenisSanksi'])
            ->findOrFail($id);
        
        // Hitung total poin
        $totalPoinPelanggaran = $siswa->pelanggaran
            ->where('status_verifikasi', 'diverifikasi')
            ->sum(function($p) {
                return $p->jenisPelanggaran->poin ?? 0;
            });
        
        $totalPoinPrestasi = $siswa->prestasi->sum('poin');
        $poinBersih = $totalPoinPrestasi - $totalPoinPelanggaran;
        
        // Status siswa
        $status = $this->getStatusSiswa($totalPoinPelanggaran, $poinBersih);
        
        return view('wali_kelas.monitoring.detail', compact(
            'siswa',
            'totalPoinPelanggaran',
            'totalPoinPrestasi', 
            'poinBersih',
            'status'
        ));
    }
    
    private function getStatusSiswa($totalPoinPelanggaran, $poinBersih)
    {
        if ($totalPoinPelanggaran >= 100) {
            return ['level' => 'Sangat Bermasalah', 'class' => 'danger', 'icon' => 'ti-alert-circle'];
        } elseif ($totalPoinPelanggaran >= 75) {
            return ['level' => 'Kritis', 'class' => 'danger', 'icon' => 'ti-alert-triangle'];
        } elseif ($totalPoinPelanggaran >= 50) {
            return ['level' => 'Perhatian Khusus', 'class' => 'warning', 'icon' => 'ti-alert-triangle'];
        } elseif ($poinBersih < 0) {
            return ['level' => 'Perlu Bimbingan', 'class' => 'warning', 'icon' => 'ti-info-circle'];
        } else {
            return ['level' => 'Baik', 'class' => 'success', 'icon' => 'ti-check-circle'];
        }
    }
}