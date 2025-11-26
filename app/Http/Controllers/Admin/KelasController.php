<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(Request $request)
    {
        $query = Kelas::with(['waliKelas', 'siswa']);
        
        if ($request->filled('search')) {
            $query->where('nama_kelas', 'like', '%' . $request->search . '%')
                  ->orWhere('jurusan', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('jurusan')) {
            $query->where('jurusan', $request->jurusan);
        }
        
        $kelas = $query->paginate(10);
        $guru = Guru::all();
        $jurusanData = Jurusan::all();
        $jurusanList = Kelas::select('jurusan')->distinct()->pluck('jurusan');
        
        return view('admin.kelas.index', compact('kelas', 'guru', 'jurusanList', 'jurusanData'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas',
            'jurusan' => 'required|string|max:100',
            'wali_kelas_id' => 'nullable|exists:guru,id'
        ]);
        
        Kelas::create($request->all());
        
        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil ditambahkan');
    }
    
    public function show($id)
    {
        $kelas = Kelas::with(['waliKelas', 'siswa'])->findOrFail($id);
        return response()->json($kelas);
    }
    
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);
        return response()->json($kelas);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:50|unique:kelas,nama_kelas,' . $id,
            'jurusan' => 'required|string|max:100',
            'wali_kelas_id' => 'nullable|exists:guru,id'
        ]);
        
        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());
        
        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        if ($kelas->siswa()->count() > 0) {
            return redirect()->route('admin.kelas')->with('error', 'Kelas tidak dapat dihapus karena masih memiliki siswa');
        }
        
        $kelas->delete();
        
        return redirect()->route('admin.kelas')->with('success', 'Data kelas berhasil dihapus');
    }
}
