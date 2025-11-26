<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Kelas;
use App\Models\JeniPelanggaran;
use App\Models\User;
use App\Notifications\PelanggaranNotification;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat']);
        
        // Filter berdasarkan kelas
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_verifikasi', $request->status);
        }
        
        // Search berdasarkan nama siswa
        if ($request->filled('search')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }
        
        $pelanggaran = $query->orderBy('created_at', 'desc')->paginate(10);
        $kelas = Kelas::with('siswa')->get();
        
        return view('admin.pelanggaran.index', compact('pelanggaran', 'kelas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'guru_pencatat' => 'required|exists:guru,id',
            'keterangan' => 'required|string',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $jenisPelanggaran = JeniPelanggaran::find($request->jenis_pelanggaran_id);
        
        // Handle upload foto bukti
        $fotoBukti = null;
        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $fotoBukti = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pelanggaran'), $fotoBukti);
        }
        
        $pelanggaran = Pelanggaran::create([
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'guru_pencatat' => $request->guru_pencatat,
            'tahun_ajaran_id' => 1,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan,
            'foto_bukti' => $fotoBukti,
            'status_verifikasi' => 'menunggu',
            'created_by' => auth()->id()
        ]);
        
        return redirect()->route('admin.pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan');
    }
    
    public function show($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])->findOrFail($id);
        
        // Cek apakah request dari AJAX (untuk modal lama)
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($pelanggaran);
        }
        
        // Return view halaman detail terpisah
        return view('admin.pelanggaran.detail', compact('pelanggaran'));
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
            'keterangan' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
        
        $pelanggaran = Pelanggaran::findOrFail($id);
        $jenisPelanggaran = JeniPelanggaran::find($request->jenis_pelanggaran_id);
        
        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'guru_pencatat' => $request->guru_pencatat,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->keterangan
        ];
        
        // Handle upload foto bukti baru
        if ($request->hasFile('foto_bukti')) {
            // Hapus foto lama jika ada
            if ($pelanggaran->foto_bukti && file_exists(public_path('uploads/pelanggaran/' . $pelanggaran->foto_bukti))) {
                unlink(public_path('uploads/pelanggaran/' . $pelanggaran->foto_bukti));
            }
            
            $file = $request->file('foto_bukti');
            $fotoBukti = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pelanggaran'), $fotoBukti);
            $data['foto_bukti'] = $fotoBukti;
        }
        
        $pelanggaran->update($data);
        
        return redirect()->route('admin.pelanggaran')->with('success', 'Data pelanggaran berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $pelanggaran = Pelanggaran::findOrFail($id);
        $pelanggaran->delete();
        
        return redirect()->route('admin.pelanggaran')->with('success', 'Data pelanggaran berhasil dihapus');
    }
}