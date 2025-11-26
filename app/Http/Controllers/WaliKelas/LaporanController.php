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
        $guru = Guru::where('nip', $user->username)->first();
        
        if (!$guru) {
            return redirect()->route('login')->with('error', 'Data guru tidak ditemukan');
        }
        
        // Ambil kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        // Data untuk laporan
        $totalSiswa = Siswa::whereIn('kelas_id', $kelasIds)->count();
        $totalPelanggaran = Pelanggaran::whereHas('siswa', function($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->count();
        $totalPrestasi = Prestasi::whereHas('siswa', function($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })->count();
        
        return view('wali_kelas.laporan.index', compact(
            'kelasWali',
            'totalSiswa',
            'totalPelanggaran',
            'totalPrestasi'
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
        $guru = Guru::where('nip', $user->username)->first();
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        $pelanggarans = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'createdBy'])
            ->whereHas('siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        $pdf = Pdf::loadView('wali_kelas.laporan.pdf', [
            'pelanggarans' => $pelanggarans,
            'kelasWali' => $kelasWali,
            'guru' => $guru
        ]);
        
        return $pdf->download('laporan-wali-kelas.pdf');
    }
}