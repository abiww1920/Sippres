<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sanksi;
use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Support\Facades\Auth;

class SanksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->guru_id) {
            return redirect()->route('login')->with('error', 'Akun Anda belum terhubung dengan data guru. Hubungi admin.');
        }
        
        $guru = Guru::find($user->guru_id);
        
        // Ambil kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        // Ambil sanksi siswa di kelas yang diampu
        $sanksi = Sanksi::with(['pelanggaran.siswa.kelas', 'jenisSanksi', 'pelaksanaanSanksi'])
            ->whereHas('pelanggaran.siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('wali_kelas.sanksi.index', compact('sanksi', 'kelasWali'));
    }

    public function show($id)
    {
        $user = Auth::user();
        $guru = Guru::find($user->guru_id);
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        $sanksi = Sanksi::with([
            'pelanggaran.siswa.kelas', 
            'pelanggaran.jenisPelanggaran',
            'jenisSanksi', 
            'pelaksanaanSanksi'
        ])
        ->whereHas('pelanggaran.siswa', function($query) use ($kelasIds) {
            $query->whereIn('kelas_id', $kelasIds);
        })
        ->findOrFail($id);
        
        // Ambil semua pelanggaran siswa untuk menghitung total poin
        $siswa = $sanksi->pelanggaran->siswa;
        $pelanggaranSiswa = $siswa->pelanggaran()->with('jenisPelanggaran')
            ->where('status_verifikasi', 'diverifikasi')
            ->get();
        
        $totalPoin = $pelanggaranSiswa->sum(function($p) {
            return $p->jenisPelanggaran->poin ?? 0;
        });
        
        return view('wali_kelas.sanksi.show', compact('sanksi', 'pelanggaranSiswa', 'totalPoin'));
    }
}