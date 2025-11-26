<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\JeniPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $stats = [
            'total_pelanggaran' => Pelanggaran::count(),
            'total_prestasi' => Prestasi::count(),
            'pelanggaran_bulan_ini' => Pelanggaran::whereMonth('created_at', date('m'))->count(),
            'prestasi_bulan_ini' => Prestasi::whereMonth('created_at', date('m'))->count(),
        ];
        
        $pelanggaranPerBulan = Pelanggaran::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();
        
        $pelanggaranPerKategori = JeniPelanggaran::select('kategori', DB::raw('COUNT(pelanggaran.id) as total'))
            ->leftJoin('pelanggaran', 'jenis_pelanggaran.id', '=', 'pelanggaran.jenis_pelanggaran_id')
            ->groupBy('kategori')
            ->get();
        
        $kelas = Kelas::all();
        
        return view('admin.laporan.index', compact('stats', 'pelanggaranPerBulan', 'pelanggaranPerKategori', 'kelas'));
    }

    public function pelanggaran(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran']);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.pelanggaran-pdf', compact('data', 'request'));
            return $pdf->download('laporan-pelanggaran-' . date('Y-m-d') . '.pdf');
        }
        
        if ($request->type === 'excel') {
            return $this->exportPelanggaranExcel($data);
        }
        
        return view('admin.laporan.pelanggaran', compact('data'));
    }

    public function prestasi(Request $request)
    {
        $query = Prestasi::with(['siswa.kelas']);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.prestasi-pdf', compact('data', 'request'));
            return $pdf->download('laporan-prestasi-' . date('Y-m-d') . '.pdf');
        }
        
        return view('admin.laporan.prestasi', compact('data'));
    }

    public function siswa(Request $request, $id)
    {
        $siswa = Siswa::with(['kelas'])->findOrFail($id);
        $pelanggaran = Pelanggaran::with(['jenisPelanggaran'])
            ->where('siswa_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        $prestasi = Prestasi::where('siswa_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.siswa-pdf', compact('siswa', 'pelanggaran', 'prestasi'));
            return $pdf->download('laporan-siswa-' . $siswa->nis . '.pdf');
        }
        
        return view('admin.laporan.siswa', compact('siswa', 'pelanggaran', 'prestasi'));
    }

    public function rekapBulanan(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');
        
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();
        
        $prestasi = Prestasi::with(['siswa.kelas'])
            ->whereMonth('created_at', $bulan)
            ->whereYear('created_at', $tahun)
            ->get();
        
        $rekapPerKelas = Kelas::withCount([
            'siswa as total_pelanggaran' => function($q) use ($bulan, $tahun) {
                $q->join('pelanggaran', 'siswa.id', '=', 'pelanggaran.siswa_id')
                  ->whereMonth('pelanggaran.created_at', $bulan)
                  ->whereYear('pelanggaran.created_at', $tahun);
            },
            'siswa as total_prestasi' => function($q) use ($bulan, $tahun) {
                $q->join('prestasi', 'siswa.id', '=', 'prestasi.siswa_id')
                  ->whereMonth('prestasi.created_at', $bulan)
                  ->whereYear('prestasi.created_at', $tahun);
            }
        ])->get();
        
        if ($request->type === 'pdf') {
            $pdf = Pdf::loadView('admin.laporan.rekap-pdf', compact('pelanggaran', 'prestasi', 'rekapPerKelas', 'bulan', 'tahun'));
            return $pdf->download('rekap-bulanan-' . $bulan . '-' . $tahun . '.pdf');
        }
        
        return view('admin.laporan.rekap-bulanan', compact('pelanggaran', 'prestasi', 'rekapPerKelas', 'bulan', 'tahun'));
    }
    
    public function grafikData(Request $request)
    {
        $type = $request->type ?? 'pelanggaran';
        $periode = $request->periode ?? '6bulan';
        
        if ($type === 'pelanggaran') {
            if ($periode === '6bulan') {
                $data = Pelanggaran::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as periode'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('periode')
                ->orderBy('periode')
                ->get();
            } else {
                $data = Pelanggaran::select(
                    DB::raw('DATE(created_at) as periode'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereMonth('created_at', date('m'))
                ->groupBy('periode')
                ->orderBy('periode')
                ->get();
            }
        } else {
            if ($periode === '6bulan') {
                $data = Prestasi::select(
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m") as periode'),
                    DB::raw('COUNT(*) as total')
                )
                ->where('created_at', '>=', now()->subMonths(6))
                ->groupBy('periode')
                ->orderBy('periode')
                ->get();
            } else {
                $data = Prestasi::select(
                    DB::raw('DATE(created_at) as periode'),
                    DB::raw('COUNT(*) as total')
                )
                ->whereMonth('created_at', date('m'))
                ->groupBy('periode')
                ->orderBy('periode')
                ->get();
            }
        }
        
        return response()->json($data);
    }

    private function exportPelanggaranExcel($data)
    {
        $filename = 'laporan-pelanggaran-' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['No', 'Tanggal', 'NIS', 'Nama Siswa', 'Kelas', 'Jenis Pelanggaran', 'Poin', 'Status']);
        
        foreach ($data as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item->created_at->format('Y-m-d'),
                $item->siswa->nis,
                $item->siswa->nama_siswa,
                $item->siswa->kelas->nama_kelas ?? '-',
                $item->jenisPelanggaran->nama_pelanggaran,
                $item->poin,
                ucfirst($item->status_verifikasi)
            ]);
        }
        
        fclose($output);
        exit;
    }
    
    public function exportPrestasiExcel(Request $request)
    {
        $query = Prestasi::with(['siswa.kelas']);
        
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('created_at', '>=', $request->tanggal_mulai);
        }
        
        if ($request->filled('tanggal_selesai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_selesai);
        }
        
        $data = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'laporan-prestasi-' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        
        $output = fopen('php://output', 'w');
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($output, ['No', 'Tanggal', 'NIS', 'Nama Siswa', 'Kelas', 'Jenis Prestasi', 'Tingkat', 'Peringkat']);
        
        foreach ($data as $index => $item) {
            fputcsv($output, [
                $index + 1,
                $item->created_at->format('Y-m-d'),
                $item->siswa->nis,
                $item->siswa->nama_siswa,
                $item->siswa->kelas->nama_kelas ?? '-',
                $item->jenis_prestasi,
                $item->tingkat,
                $item->peringkat ?? '-'
            ]);
        }
        
        fclose($output);
        exit;
    }
}
