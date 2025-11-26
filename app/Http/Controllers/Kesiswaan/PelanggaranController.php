<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Kelas;
use App\Models\JeniPelanggaran;
use App\Models\User;
use App\Notifications\PelanggaranNotification;
use Illuminate\Support\Facades\Auth;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat']);
        
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }
        
        if ($request->filled('search')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }
        
        $pelanggaran = $query->orderBy('created_at', 'desc')->paginate(10);
        $kelas = Kelas::with('siswa')->get();
        $jenisPelanggaran = JeniPelanggaran::all();
        $guru = \App\Models\Guru::all();
        
        return view('kesiswaan.pelanggaran.index', compact('pelanggaran', 'kelas', 'jenisPelanggaran', 'guru'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'guru_pencatat' => 'required|exists:guru,id',
            'keterangan' => 'required|string'
        ]);
        
        $jenisPelanggaran = JeniPelanggaran::find($request->jenis_pelanggaran_id);
        
        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'guru_pencatat' => $request->guru_pencatat,
            'tahun_ajaran_id' => 1,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan,
            'status_verifikasi' => 'menunggu',
            'created_by' => Auth::id()
        ]);
        
        $orangTua = User::where('level', 'orang_tua')
            ->whereHas('siswa', function($q) use ($request) {
                $q->where('id', $request->siswa_id);
            })->get();
        
        foreach ($orangTua as $user) {
            $user->notify(new PelanggaranNotification($pelanggaran));
        }
        
        return redirect()->route('kesiswaan.pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan');
    }
    
    public function show($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->findOrFail($id);
        return view('kesiswaan.pelanggaran.detail', compact('pelanggaran'));
    }
    
    public function edit($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        return response()->json($pelanggaran);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'guru_pencatat' => 'required|exists:guru,id',
            'keterangan' => 'required|string'
        ]);
        
        $pelanggaran = Pelanggaran::findOrFail($id);
        $jenisPelanggaran = JeniPelanggaran::find($request->jenis_pelanggaran_id);
        
        $pelanggaran->update([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'guru_pencatat' => $request->guru_pencatat,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect()->route('kesiswaan.pelanggaran')->with('success', 'Data pelanggaran berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();
        
        return redirect()->route('kesiswaan.pelanggaran')->with('success', 'Data pelanggaran berhasil dihapus');
    }
}
