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
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Gunakan relasi user->guru
        $guru = $user->guru;
        
        // Jika tidak ada relasi, coba cari berdasarkan NIP
        if (!$guru) {
            $guru = Guru::where('nip', $user->username)->first();
        }
        
        if (!$guru) {
            $kelasWali = collect();
            $totalSiswa = 0;
            $totalPelanggaran = 0;
            $totalPrestasi = 0;
            $siswaList = collect();
            
            return view('wali_kelas.laporan.index', compact(
                'kelasWali',
                'totalSiswa',
                'totalPelanggaran',
                'totalPrestasi',
                'siswaList'
            ))->with('error', 'Data guru tidak ditemukan. Silakan hubungi administrator.');
        }
        
        // Ambil kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->with('siswa')->get();
        $kelasIds = $kelasWali->pluck('id');
        
        // Ambil semua siswa di kelas yang diampu
        $siswaList = collect();
        if ($kelasIds->isNotEmpty()) {
            $siswaList = Siswa::whereIn('kelas_id', $kelasIds)
                ->with('kelas')
                ->orderBy('nama_siswa')
                ->get();
        }
        
        // Data untuk laporan
        $totalSiswa = $siswaList->count();
        $totalPelanggaran = 0;
        $totalPrestasi = 0;
        
        if ($kelasIds->isNotEmpty()) {
            $totalPelanggaran = Pelanggaran::whereHas('siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })->where('status_verifikasi', 'diverifikasi')->count();
            
            $totalPrestasi = Prestasi::whereHas('siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })->count();
        }
        
        return view('wali_kelas.laporan.index', compact(
            'kelasWali',
            'totalSiswa',
            'totalPelanggaran',
            'totalPrestasi',
            'siswaList'
        ));
    }
    
    public function exportExcel()
    {
        // Implementation for Excel export
        return response()->json(['message' => 'Export Excel akan diimplementasikan']);
    }
    
    public function exportPdf(Request $request)
    {
        $user = Auth::user();
        
        // Gunakan relasi user->guru
        $guru = $user->guru;
        
        // Jika tidak ada relasi, coba cari berdasarkan NIP
        if (!$guru) {
            $guru = Guru::where('nip', $user->username)->first();
        }
        
        if (!$guru) {
            return redirect()->back()->with('error', 'Data guru tidak ditemukan. Tidak dapat menggenerate laporan.');
        }
        
        $isPreview = $request->has('preview');
        
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        $type = $request->get('type', 'bulanan');
        
        switch ($type) {
            case 'bulanan':
                return $this->generateLaporanBulanan($request, $guru, $kelasWali, $kelasIds, $isPreview);
            case 'persiswa':
                return $this->generateLaporanPerSiswa($request, $guru, $kelasWali, $kelasIds, $isPreview);
            case 'sanksi':
                return $this->generateLaporanSanksi($request, $guru, $kelasWali, $kelasIds, $isPreview);
            case 'semester':
                return $this->generateLaporanSemester($request, $guru, $kelasWali, $kelasIds, $isPreview);
            case 'sikap':
                return $this->generateLaporanSikap($request, $guru, $kelasWali, $kelasIds, $isPreview);
            default:
                return $this->generateLaporanBulanan($request, $guru, $kelasWali, $kelasIds, $isPreview);
        }
    }
    
    private function generateLaporanBulanan($request, $guru, $kelasWali, $kelasIds, $isPreview = false)
    {
        $bulan = $request->get('bulan', date('n'));
        $tahun = $request->get('tahun', date('Y'));
        $konten = $request->get('konten', ['pelanggaran', 'prestasi', 'sanksi', 'grafik']);
        
        // Ambil data pelanggaran
        $pelanggarans = collect();
        if (!empty($kelasIds)) {
            $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
                ->whereHas('siswa', function($query) use ($kelasIds) {
                    $query->whereIn('kelas_id', $kelasIds);
                })
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->where('status_verifikasi', 'diverifikasi')
                ->orderBy('created_at', 'desc')
                ->get();
        }
            
        // Ambil data prestasi
        $prestasis = collect();
        if (!empty($kelasIds)) {
            $prestasis = Prestasi::with(['siswa.kelas'])
                ->whereHas('siswa', function($query) use ($kelasIds) {
                    $query->whereIn('kelas_id', $kelasIds);
                })
                ->whereMonth('created_at', $bulan)
                ->whereYear('created_at', $tahun)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        // Ambil data siswa untuk statistik
        $siswaList = Siswa::whereIn('kelas_id', $kelasIds)->with('kelas')->get();
        
        $data = [
            'pelanggarans' => $pelanggarans,
            'prestasis' => $prestasis,
            'siswaList' => $siswaList,
            'kelasWali' => $kelasWali,
            'guru' => $guru,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'konten' => $konten,
            'namaBulan' => \DateTime::createFromFormat('!m', $bulan)->format('F')
        ];
        
        $pdf = Pdf::loadView('wali_kelas.laporan.bulanan_pdf', $data);
        
        if ($isPreview) {
            return $pdf->stream('laporan-bulanan-' . $bulan . '-' . $tahun . '.pdf');
        }
        
        return $pdf->download('laporan-bulanan-' . $bulan . '-' . $tahun . '.pdf');
    }
    
    private function generateLaporanPerSiswa($request, $guru, $kelasWali, $kelasIds, $isPreview = false)
    {
        $siswaId = $request->get('siswa_id');
        $dariTanggal = $request->get('dari_tanggal');
        $sampaiTanggal = $request->get('sampai_tanggal');
        $format = $request->get('format', 'pdf');
        
        $query = Siswa::whereIn('kelas_id', $kelasIds);
        if ($siswaId && $siswaId !== 'all') {
            $query->where('id', $siswaId);
        }
        
        $siswaList = $query->with(['pelanggaran.jenisPelanggaran', 'prestasi', 'kelas'])->get();
        
        if ($format === 'excel') {
            // Return Excel format
            return response()->json(['message' => 'Excel export akan diimplementasikan']);
        }
        
        $pdf = Pdf::loadView('wali_kelas.laporan.persiswa_pdf', [
            'siswaList' => $siswaList,
            'kelasWali' => $kelasWali,
            'guru' => $guru,
            'dariTanggal' => $dariTanggal,
            'sampaiTanggal' => $sampaiTanggal
        ]);
        
        return $pdf->download('laporan-per-siswa.pdf');
    }
    
    private function generateLaporanSanksi($request, $guru, $kelasWali, $kelasIds, $isPreview = false)
    {
        $statusSanksi = $request->get('status_sanksi', 'all');
        $dariTanggal = $request->get('dari_tanggal');
        $sampaiTanggal = $request->get('sampai_tanggal');
        
        // Implementation for sanksi report
        $pdf = Pdf::loadView('wali_kelas.laporan.sanksi_pdf', [
            'kelasWali' => $kelasWali,
            'guru' => $guru,
            'statusSanksi' => $statusSanksi
        ]);
        
        return $pdf->download('laporan-sanksi.pdf');
    }
    
    private function generateLaporanSemester($request, $guru, $kelasWali, $kelasIds, $isPreview = false)
    {
        $semester = $request->get('semester', '1');
        $tahunAjaran = $request->get('tahun_ajaran');
        $format = $request->get('format', 'pdf');
        
        // Implementation for semester report
        $pdf = Pdf::loadView('wali_kelas.laporan.semester_pdf', [
            'kelasWali' => $kelasWali,
            'guru' => $guru,
            'semester' => $semester,
            'tahunAjaran' => $tahunAjaran
        ]);
        
        return $pdf->download('laporan-semester-' . $semester . '.pdf');
    }
    
    private function generateLaporanSikap($request, $guru, $kelasWali, $kelasIds, $isPreview = false)
    {
        $periode = $request->get('periode', 'semester1');
        $formatSikap = $request->get('format_sikap', 'lengkap');
        $includeRekomendasi = $request->has('include_rekomendasi');
        $format = $request->get('format', 'pdf');
        
        // Implementation for sikap report
        $pdf = Pdf::loadView('wali_kelas.laporan.sikap_pdf', [
            'kelasWali' => $kelasWali,
            'guru' => $guru,
            'periode' => $periode,
            'formatSikap' => $formatSikap,
            'includeRekomendasi' => $includeRekomendasi
        ]);
        
        return $pdf->download('laporan-penilaian-sikap.pdf');
    }
}