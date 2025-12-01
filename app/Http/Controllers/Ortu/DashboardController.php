<?php

namespace App\Http\Controllers\Ortu;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        // Hitung poin pelanggaran
        $totalPoinPelanggaran = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        // Hitung poin prestasi
        $totalPoinPrestasi = $siswa->prestasi()->sum('poin');
        
        // Poin bersih = prestasi - pelanggaran
        $poinBersih = $totalPoinPrestasi - $totalPoinPelanggaran;
        
        // Status kedisiplinan berdasarkan poin pelanggaran
        $statusKedisiplinan = $this->getStatusKedisiplinan($totalPoinPelanggaran);
        
        $totalPelanggaran = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->count();
        
        $totalPrestasi = $siswa->prestasi()->count();
        
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
        
        // Data untuk grafik tren bulanan (6 bulan terakhir)
        $trendData = $this->getTrendData($siswa);
        
        // Notifikasi terbaru
        $notifikasi = $this->getNotifikasi($siswa);
        
        return view('ortu.dashboard', compact(
            'siswa',
            'totalPelanggaran',
            'totalPrestasi',
            'totalPoinPelanggaran',
            'totalPoinPrestasi',
            'poinBersih',
            'statusKedisiplinan',
            'pelanggaranTerbaru',
            'prestasiTerbaru',
            'trendData',
            'notifikasi'
        ));
    }
    
    private function getStatusKedisiplinan($poin)
    {
        if ($poin >= 75) {
            return ['status' => 'Kritis', 'color' => 'danger', 'icon' => '🔴'];
        } elseif ($poin >= 50) {
            return ['status' => 'Peringatan', 'color' => 'warning', 'icon' => '🟠'];
        } elseif ($poin >= 25) {
            return ['status' => 'Perhatian', 'color' => 'info', 'icon' => '🟡'];
        } else {
            return ['status' => 'Baik', 'color' => 'success', 'icon' => '🟢'];
        }
    }
    
    private function getTrendData($siswa)
    {
        $months = [];
        $pelanggaranData = [];
        $prestasiData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M Y');
            
            $pelanggaranCount = $siswa->pelanggaran()
                ->where('status_verifikasi', 'diverifikasi')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $prestasiCount = $siswa->prestasi()
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            
            $pelanggaranData[] = $pelanggaranCount;
            $prestasiData[] = $prestasiCount;
        }
        
        return [
            'months' => $months,
            'pelanggaran' => $pelanggaranData,
            'prestasi' => $prestasiData
        ];
    }
    
    private function getNotifikasi($siswa)
    {
        $notifikasi = [];
        
        // Pelanggaran baru (7 hari terakhir)
        $pelanggaranBaru = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();
        
        if ($pelanggaranBaru > 0) {
            $notifikasi[] = [
                'type' => 'pelanggaran',
                'message' => "$pelanggaranBaru pelanggaran baru telah diverifikasi",
                'time' => 'Minggu ini',
                'icon' => 'ti-alert-triangle',
                'color' => 'danger'
            ];
        }
        
        // Prestasi baru (7 hari terakhir)
        $prestasiBaru = $siswa->prestasi()
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->count();
        
        if ($prestasiBaru > 0) {
            $notifikasi[] = [
                'type' => 'prestasi',
                'message' => "$prestasiBaru prestasi baru telah dicatat",
                'time' => 'Minggu ini',
                'icon' => 'ti-trophy',
                'color' => 'success'
            ];
        }
        
        return $notifikasi;
    }
    
    public function pelanggaran(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $query = $siswa->pelanggaran()
            ->with(['jenisPelanggaran', 'createdBy'])
            ->where('status_verifikasi', 'diverifikasi');
        
        // Filter berdasarkan kategori
        if ($request->kategori) {
            $query->whereHas('jenisPelanggaran', function($q) use ($request) {
                $q->where('tingkat', $request->kategori);
            });
        }
        
        // Filter berdasarkan periode
        if ($request->periode) {
            switch($request->periode) {
                case 'minggu_ini':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'semester_ini':
                    $query->where('created_at', '>=', Carbon::now()->subMonths(6));
                    break;
            }
        }
        
        $pelanggaran = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('ortu.pelanggaran', compact('siswa', 'pelanggaran'));
    }
    
    public function prestasi(Request $request)
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $query = $siswa->prestasi()->with('createdBy');
        
        // Filter berdasarkan tingkat
        if ($request->tingkat) {
            $query->where('tingkat', $request->tingkat);
        }
        
        // Filter berdasarkan periode
        if ($request->periode) {
            switch($request->periode) {
                case 'minggu_ini':
                    $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                    break;
                case 'bulan_ini':
                    $query->whereMonth('created_at', Carbon::now()->month);
                    break;
                case 'semester_ini':
                    $query->where('created_at', '>=', Carbon::now()->subMonths(6));
                    break;
            }
        }
        
        $prestasi = $query->orderBy('created_at', 'desc')->paginate(10);
        
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
        
        $totalPoinPelanggaran = $siswa->pelanggaran()
            ->where('status_verifikasi', 'diverifikasi')
            ->sum('poin');
        
        $totalPoinPrestasi = $siswa->prestasi()->sum('poin');
        
        $poinBersih = $totalPoinPrestasi - $totalPoinPelanggaran;
        
        $statusKedisiplinan = $this->getStatusKedisiplinan($totalPoinPelanggaran);
        
        return view('ortu.profil', compact(
            'siswa', 
            'totalPelanggaran', 
            'totalPrestasi', 
            'totalPoinPelanggaran',
            'totalPoinPrestasi',
            'poinBersih',
            'statusKedisiplinan'
        ));
    }
    
    public function notifikasi()
    {
        $user = Auth::user();
        $siswa = $user->siswa;
        
        $notifikasi = [];
        
        // Pelanggaran terbaru (30 hari)
        $pelanggaranTerbaru = $siswa->pelanggaran()
            ->with('jenisPelanggaran')
            ->where('status_verifikasi', 'diverifikasi')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach($pelanggaranTerbaru as $p) {
            $notifikasi[] = [
                'type' => 'pelanggaran',
                'title' => 'Pelanggaran Diverifikasi',
                'message' => "Pelanggaran '{$p->jenisPelanggaran->nama_pelanggaran}' telah diverifikasi. Poin +{$p->poin}",
                'time' => $p->created_at->diffForHumans(),
                'icon' => 'ti-alert-triangle',
                'color' => 'danger'
            ];
        }
        
        // Prestasi terbaru (30 hari)
        $prestasiTerbaru = $siswa->prestasi()
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();
        
        foreach($prestasiTerbaru as $pr) {
            $notifikasi[] = [
                'type' => 'prestasi',
                'title' => 'Prestasi Baru',
                'message' => "Anak Anda meraih {$pr->juara} {$pr->nama_prestasi} tingkat {$pr->tingkat}",
                'time' => $pr->created_at->diffForHumans(),
                'icon' => 'ti-trophy',
                'color' => 'success'
            ];
        }
        
        // Sort berdasarkan waktu terbaru
        usort($notifikasi, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return view('ortu.notifikasi', compact('notifikasi'));
    }
}
