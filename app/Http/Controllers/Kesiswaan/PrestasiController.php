<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Prestasi;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;

class PrestasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Prestasi::with(['siswa.kelas'])
            ->where('created_by', Auth::id());
        
        if ($request->filled('kelas_id')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        if ($request->filled('search')) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%');
            });
        }
        
        $prestasi = $query->orderBy('created_at', 'desc')->paginate(10);
        $kelas = Kelas::with('siswa')->get();
        
        return view('kesiswaan.prestasi.index', compact('prestasi', 'kelas'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nama_prestasi' => 'required|string',
            'tingkat' => 'required|in:sekolah,kecamatan,kabupaten,provinsi,nasional,internasional',
            'juara' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);
        
        Prestasi::create([
            'siswa_id' => $request->siswa_id,
            'nama_prestasi' => $request->nama_prestasi,
            'tingkat' => $request->tingkat,
            'juara' => $request->juara,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'created_by' => Auth::id()
        ]);
        
        return redirect()->route('kesiswaan.prestasi')->with('success', 'Data prestasi berhasil ditambahkan');
    }
    
    public function show($id)
    {
        $prestasi = Prestasi::with(['siswa.kelas'])
            ->where('created_by', Auth::id())
            ->findOrFail($id);
        return response()->json($prestasi);
    }
    
    public function edit($id)
    {
        $prestasi = Prestasi::where('created_by', Auth::id())->findOrFail($id);
        return response()->json($prestasi);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'nama_prestasi' => 'required|string',
            'tingkat' => 'required|in:sekolah,kecamatan,kabupaten,provinsi,nasional,internasional',
            'juara' => 'required|string',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);
        
        $prestasi = Prestasi::where('created_by', Auth::id())->findOrFail($id);
        
        $prestasi->update([
            'siswa_id' => $request->siswa_id,
            'nama_prestasi' => $request->nama_prestasi,
            'tingkat' => $request->tingkat,
            'juara' => $request->juara,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan
        ]);
        
        return redirect()->route('kesiswaan.prestasi')->with('success', 'Data prestasi berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $prestasi = Prestasi::where('created_by', Auth::id())->findOrFail($id);
        $prestasi->delete();
        
        return redirect()->route('kesiswaan.prestasi')->with('success', 'Data prestasi berhasil dihapus');
    }
}
