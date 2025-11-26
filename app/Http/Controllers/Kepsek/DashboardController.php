<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Sanksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggaran = Pelanggaran::count();
        $totalPrestasi = Prestasi::count();
        $siswaTerlibat = Pelanggaran::distinct('siswa_id')->count('siswa_id');
        $sanksiAktif = Sanksi::count();

        $statusVerifikasi = [
            'menunggu' => Pelanggaran::where('status_verifikasi', 'menunggu')->count(),
            'diverifikasi' => Pelanggaran::where('status_verifikasi', 'diverifikasi')->count(),
            'ditolak' => Pelanggaran::where('status_verifikasi', 'ditolak')->count(),
            'revisi' => Pelanggaran::where('status_verifikasi', 'revisi')->count(),
        ];

        $pelanggaranTerbaru = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->latest()
            ->limit(5)
            ->get() ?? collect([]);

        $monitoringPrioritas = collect([]);

        $pelanggaranPerKategori = Pelanggaran::select('jenis_pelanggaran.nama_pelanggaran', DB::raw('COUNT(*) as total'))
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->groupBy('jenis_pelanggaran.nama_pelanggaran')
            ->get()->toArray();

        $kategoriCount = Pelanggaran::select('jenis_pelanggaran.kategori', DB::raw('COUNT(*) as total'))
            ->join('jenis_pelanggaran', 'pelanggaran.jenis_pelanggaran_id', '=', 'jenis_pelanggaran.id')
            ->groupBy('jenis_pelanggaran.kategori')
            ->pluck('total', 'kategori')
            ->toArray();
        
        if (empty($kategoriCount)) {
            $kategoriCount = ['Ringan' => 0, 'Sedang' => 0, 'Berat' => 0, 'Sangat Berat' => 0];
        }

        $trendPelanggaran = Pelanggaran::select(
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
            })->toArray();

        return view('kepsek.dashboard', [
            'totalPelanggaran' => $totalPelanggaran,
            'totalPrestasi' => $totalPrestasi,
            'siswaTerlibat' => $siswaTerlibat,
            'sanksiAktif' => $sanksiAktif,
            'statusVerifikasi' => $statusVerifikasi,
            'pelanggaranTerbaru' => $pelanggaranTerbaru,
            'monitoringPrioritas' => $monitoringPrioritas,
            'pelanggaranPerKategori' => $pelanggaranPerKategori ?? [],
            'kategoriCount' => $kategoriCount,
            'trendPelanggaran' => $trendPelanggaran ?? [],
        ]);
    }
}
