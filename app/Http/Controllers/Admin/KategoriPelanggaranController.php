<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JeniPelanggaran;

class KategoriPelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $query = JeniPelanggaran::query();

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        

        if ($request->filled('search')) {
            $query->where('nama_pelanggaran', 'like', '%' . $request->search . '%');
        }
        
        $jenisPelanggaran = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.kategori-pelanggaran.index', compact('jenisPelanggaran'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string',
            'poin' => 'required|integer|min:1|max:100',
            'sanksi_rekomendasi' => 'nullable|string'
        ]);
        
        JeniPelanggaran::create([
            'nama_pelanggaran' => $request->nama_pelanggaran,
            'kategori' => $request->kategori,
            'poin' => $request->poin,
            'sanksi_rekomendasi' => $request->sanksi_rekomendasi
        ]);
        
        return redirect()->route('admin.kategori-pelanggaran')->with('success', 'Kategori pelanggaran berhasil ditambahkan');
    }
    
    public function show($id)
    {
        $jenisPelanggaran = JeniPelanggaran::findOrFail($id);
        return response()->json($jenisPelanggaran);
    }
    
    public function edit($id)
    {
        $jenisPelanggaran = JeniPelanggaran::findOrFail($id);
        return response()->json($jenisPelanggaran);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_pelanggaran' => 'required|string|max:255',
            'kategori' => 'required|string',
            'poin' => 'required|integer|min:1|max:100',
            'sanksi_rekomendasi' => 'nullable|string'
        ]);
        
        $jenisPelanggaran = JeniPelanggaran::findOrFail($id);
        $jenisPelanggaran->update([
            'nama_pelanggaran' => $request->nama_pelanggaran,
            'kategori' => $request->kategori,
            'poin' => $request->poin,
            'sanksi_rekomendasi' => $request->sanksi_rekomendasi
        ]);
        
        return redirect()->route('admin.kategori-pelanggaran')->with('success', 'Kategori pelanggaran berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $jenisPelanggaran = JeniPelanggaran::findOrFail($id);
        $jenisPelanggaran->delete();
        
        return redirect()->route('admin.kategori-pelanggaran')->with('success', 'Kategori pelanggaran berhasil dihapus');
    }
}