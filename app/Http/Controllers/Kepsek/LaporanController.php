<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran']);

        if ($request->dari && $request->sampai) {
            $query->whereBetween('created_at', [
                $request->dari . ' 00:00:00',
                $request->sampai . ' 23:59:59'
            ]);
        }

        if ($request->kelas) {
            $query->whereHas('siswa', function ($q) {
                $q->where('kelas_id', request('kelas'));
            });
        }

        if ($request->kategori) {
            $query->whereHas('jenisPelanggaran', function ($q) {
                $q->where('kategori', request('kategori'));
            });
        }

        $pelanggaranList = $query->latest()->paginate(20);

        $totalPelanggaran = $query->count();
        $rataRataPoin = $query->avg('poin') ?? 0;
        $siswaTerlibat = $query->distinct('siswa_id')->count('siswa_id');
        $verifikasiPending = Pelanggaran::where('status_verifikasi', 'menunggu')->count();

        $trendData = Pelanggaran::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy(DB::raw('MONTH(created_at)'))
            ->get()
            ->map(function ($item) {
                $bulanNama = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                $item->bulan = $bulanNama[$item->bulan] ?? '';
                return $item;
            });

        $categoryData = Pelanggaran::select('jenis_pelanggaran.kategori', DB::raw('COUNT(*) as total'))
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->groupBy('jenis_pelanggaran.kategori')
            ->get();

        $kelas = Kelas::all();

        return view('kepsek.laporan', [
            'pelanggaranList' => $pelanggaranList,
            'totalPelanggaran' => $totalPelanggaran,
            'rataRataPoin' => $rataRataPoin,
            'siswaTerlibat' => $siswaTerlibat,
            'verifikasiPending' => $verifikasiPending,
            'trendData' => $trendData,
            'categoryData' => $categoryData,
            'kelas' => $kelas,
        ]);
    }

    public function exportExcel(Request $request)
    {
        return response()->json(['message' => 'Export Excel']);
    }

    public function exportPdf(Request $request)
    {
        return response()->json(['message' => 'Export PDF']);
    }
}
