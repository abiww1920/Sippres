<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Prestasi;
use App\Models\Sanksi;

class VerifikasiController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'pelanggaran');
        
        if ($type == 'pelanggaran') {
            $data = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
                ->where('status_verifikasi', 'menunggu')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        } else {
            $data = Prestasi::with(['siswa.kelas'])
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        
        return view('kesiswaan.verifikasi.index', compact('data', 'type'));
    }
    
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diverifikasi,ditolak',
            'catatan' => 'nullable|string'
        ]);
        
        $pelanggaran = Pelanggaran::with('jenisPelanggaran')->findOrFail($id);
        $pelanggaran->update([
            'status_verifikasi' => $request->status,
            'catatan_verifikasi' => $request->catatan
        ]);
        
        // AUTO-CREATE SANKSI jika diverifikasi
        if ($request->status == 'diverifikasi') {
            $this->autoCreateSanksi($pelanggaran);
        }
        
        return redirect()->route('kesiswaan.verifikasi')->with('success', 'Data berhasil diverifikasi & sanksi otomatis dibuat');
    }
    
    /**
     * Auto-create sanksi berdasarkan poin pelanggaran
     */
    private function autoCreateSanksi($pelanggaran)
    {
        // Cek apakah sudah ada sanksi untuk pelanggaran ini
        $existingSanksi = Sanksi::where('pelanggaran_id', $pelanggaran->id)->first();
        if ($existingSanksi) {
            return; // Sudah ada sanksi, skip
        }
        
        $poin = $pelanggaran->poin;
        $jenisSanksi = $this->getJenisSanksiByPoin($poin);
        $durasi = $this->getDurasiSanksiByPoin($poin);
        
        Sanksi::create([
            'pelanggaran_id' => $pelanggaran->id,
            'jenis_sanksi' => $jenisSanksi,
            'deskripsi_sanksi' => $pelanggaran->jenisPelanggaran->sanksi_rekomendasi ?? 'Sanksi sesuai kategori pelanggaran',
            'tanggal_mulai' => now()->toDateString(),
            'tanggal_selesai' => now()->addDays($durasi)->toDateString(),
            'status' => 'direncanakan'
        ]);
    }
    
    /**
     * Tentukan jenis sanksi berdasarkan poin
     */
    private function getJenisSanksiByPoin($poin)
    {
        if ($poin <= 15) {
            return 'Teguran Lisan';
        } elseif ($poin <= 30) {
            return 'Teguran Tertulis';
        } elseif ($poin <= 50) {
            return 'Skorsing';
        } else {
            return 'Skorsing Berat';
        }
    }
    
    /**
     * Tentukan durasi sanksi berdasarkan poin (dalam hari)
     */
    private function getDurasiSanksiByPoin($poin)
    {
        if ($poin <= 15) {
            return 1; // 1 hari
        } elseif ($poin <= 30) {
            return 3; // 3 hari
        } elseif ($poin <= 50) {
            return 5; // 5 hari
        } else {
            return 7; // 7 hari
        }
    }
}
