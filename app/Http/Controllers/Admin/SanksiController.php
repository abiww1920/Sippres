<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sanksi;
use App\Models\JeniSanksi;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class SanksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Sanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran']);
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by student name
        if ($request->filled('search')) {
            $query->whereHas('pelanggaran.siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }
        
        $sanksi = $query->orderBy('created_at', 'desc')->paginate(10);
        $jenisSanksi = JeniSanksi::all();
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])
                                 ->where('status_verifikasi', 'diverifikasi')
                                 ->get();
        
        return view('admin.sanksi.index', compact('sanksi', 'jenisSanksi', 'pelanggaran'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_sanksi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);
        
        Sanksi::create($request->all());
        
        return redirect()->route('admin.sanksi')->with('success', 'Sanksi berhasil ditambahkan');
    }
    
    public function show($id)
    {
        $sanksi = Sanksi::with(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran'])->findOrFail($id);
        return response()->json($sanksi);
    }
    
    public function edit($id)
    {
        $sanksi = Sanksi::findOrFail($id);
        return response()->json($sanksi);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'pelanggaran_id' => 'required|exists:pelanggaran,id',
            'jenis_sanksi' => 'required|string',
            'deskripsi_sanksi' => 'required|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:direncanakan,berjalan,selesai,dibatalkan',
        ]);
        
        $sanksi = Sanksi::findOrFail($id);
        $sanksi->update($request->all());
        
        return redirect()->route('admin.sanksi')->with('success', 'Sanksi berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $sanksi = Sanksi::findOrFail($id);
        $sanksi->delete();
        
        return redirect()->route('admin.sanksi')->with('success', 'Sanksi berhasil dihapus');
    }
}