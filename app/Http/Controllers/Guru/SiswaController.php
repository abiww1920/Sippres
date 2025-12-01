<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'pelanggaran', 'prestasi']);
        
        // Filter pencarian siswa
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_siswa', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%');
            });
        }
        
        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        // Filter berdasarkan jurusan
        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }
        
        // Filter berdasarkan jenis kelamin
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        
        // Urutkan berdasarkan
        if ($request->filled('sort_by')) {
            switch ($request->sort_by) {
                case 'nama':
                    $query->orderBy('nama_siswa', 'asc');
                    break;
                case 'nis':
                    $query->orderBy('nis', 'asc');
                    break;
                case 'poin':
                    $query->withCount(['pelanggaran as total_poin' => function($q) {
                        $q->select(DB::raw('COALESCE(SUM(jenis_pelanggaran.poin), 0)'))
                          ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id');
                    }])->orderBy('total_poin', 'desc');
                    break;
                default:
                    $query->orderBy('nama_siswa', 'asc');
            }
        } else {
            $query->orderBy('nama_siswa', 'asc');
        }
        
        $siswa = $query->paginate(20);
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();
        
        return view('guru.siswa.index', compact('siswa', 'kelas', 'jurusan'));
    }

    public function show($id)
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'prestasi'])
            ->findOrFail($id);
        
        // Data untuk grafik perkembangan
        $chartData = $this->getStudentProgressChart($id);
        
        return view('guru.siswa.show', compact('siswa', 'chartData'));
    }
    
    public function riwayatPelanggaran($id, Request $request)
    {
        $siswa = Siswa::findOrFail($id);
        
        $query = Pelanggaran::with('jenisPelanggaran')
            ->where('siswa_id', $id)
            ->where('status_verifikasi', 'diverifikasi');
        
        // Filter berdasarkan tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        // Filter berdasarkan jenis pelanggaran
        if ($request->filled('jenis_pelanggaran')) {
            $query->where('jenis_pelanggaran_id', $request->jenis_pelanggaran);
        }
        
        $pelanggaran = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('guru.siswa.riwayat-pelanggaran', compact('siswa', 'pelanggaran'));
    }
    
    private function getStudentProgressChart($siswaId)
    {
        // Data pelanggaran per bulan (6 bulan terakhir)
        $pelanggaranData = DB::table('pelanggaran')
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->where('pelanggaran.siswa_id', $siswaId)
            ->where('pelanggaran.status_verifikasi', 'diverifikasi')
            ->where('pelanggaran.created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('MONTH(pelanggaran.created_at) as bulan'),
                DB::raw('YEAR(pelanggaran.created_at) as tahun'),
                DB::raw('COUNT(*) as jumlah_pelanggaran'),
                DB::raw('SUM(jenis_pelanggaran.poin) as total_poin')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();
        
        // Data prestasi per bulan (6 bulan terakhir)
        $prestasiData = DB::table('prestasi')
            ->where('prestasi.siswa_id', $siswaId)
            ->where('prestasi.created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('MONTH(prestasi.created_at) as bulan'),
                DB::raw('YEAR(prestasi.created_at) as tahun'),
                DB::raw('COUNT(*) as jumlah_prestasi')
            )
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun')
            ->orderBy('bulan')
            ->get();
        
        // Format data untuk chart
        $months = [];
        $pelanggaranCount = [];
        $prestasiCount = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthKey = $date->format('n-Y');
            $months[] = $date->format('M Y');
            
            $pelanggaranMonth = $pelanggaranData->where('bulan', $date->month)
                ->where('tahun', $date->year)->first();
            $pelanggaranCount[] = $pelanggaranMonth ? $pelanggaranMonth->jumlah_pelanggaran : 0;
            
            $prestasiMonth = $prestasiData->where('bulan', $date->month)
                ->where('tahun', $date->year)->first();
            $prestasiCount[] = $prestasiMonth ? $prestasiMonth->jumlah_prestasi : 0;
        }
        
        return [
            'months' => $months,
            'pelanggaran' => $pelanggaranCount,
            'prestasi' => $prestasiCount
        ];
    }
}
