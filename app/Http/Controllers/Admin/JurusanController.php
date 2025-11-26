<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function index()
    {
        $jurusan = Jurusan::paginate(10);
        return view('admin.jurusan.index', compact('jurusan'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan',
            'nama_jurusan' => 'required|string|max:100',
            'keterangan' => 'nullable|string'
        ]);
        
        Jurusan::create($request->all());
        
        return redirect()->route('admin.jurusan')->with('success', 'Data jurusan berhasil ditambahkan');
    }
    
    public function show($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }
    
    public function edit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return response()->json($jurusan);
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_jurusan' => 'required|string|max:10|unique:jurusan,kode_jurusan,' . $id,
            'nama_jurusan' => 'required|string|max:100',
            'keterangan' => 'nullable|string'
        ]);
        
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->update($request->all());
        
        return redirect()->route('admin.jurusan')->with('success', 'Data jurusan berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        $jurusan->delete();
        
        return redirect()->route('admin.jurusan')->with('success', 'Data jurusan berhasil dihapus');
    }
}
