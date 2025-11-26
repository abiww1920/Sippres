<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas']);
        
        // Filter by kelas
        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search by name or NIS
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }
        
        $siswa = $query->paginate(10)->withQueryString();
        $kelas = Kelas::all();
        
        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }
    
    public function store(Request $request)
    {
        try {
            \Log::info('Siswa store request data:', $request->all());
            
            $request->validate([
                'nis' => 'required|unique:siswa,nis',
                'nama_siswa' => 'required|string|max:255',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'kelas_id' => 'required|exists:kelas,id',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'nullable|string|max:15',
                'nama_ortu' => 'required|string|max:255',
                'no_hp_ortu' => 'nullable|string|max:15',
            ]);
            
            \Log::info('Validation passed');
            
            $data = $request->only([
                'nis', 'nama_siswa', 'kelas_id', 'jenis_kelamin', 
                'alamat', 'no_hp', 'nama_ortu', 'no_hp_ortu', 'status'
            ]);
            
            // Set default status if not provided
            if (!isset($data['status'])) {
                $data['status'] = 'aktif';
            }
            
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $filename = time() . '_' . $foto->getClientOriginalName();
                $foto->move(public_path('uploads/siswa'), $filename);
                $data['foto'] = $filename;
                \Log::info('Photo uploaded: ' . $filename);
            }
            
            \Log::info('Data to be inserted:', $data);
            
            $siswa = Siswa::create($data);
            
            \Log::info('Siswa created with ID: ' . $siswa->id);
            
            return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil ditambahkan');
            
        } catch (\Exception $e) {
            \Log::error('Error creating siswa: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage());
        }
    }
    
    public function show($id)
    {
        $siswa = Siswa::with(['kelas'])->findOrFail($id);
        return response()->json($siswa);
    }
    
    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id);
        return response()->json($siswa);
    }
    
    public function update(Request $request, $id)
    {
        $siswa = Siswa::findOrFail($id);
        
        $request->validate([
            'nis' => 'required|unique:siswa,nis,' . $id,
            'nama_siswa' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kelas_id' => 'required|exists:kelas,id',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat' => 'required|string',
            'no_hp' => 'nullable|string|max:15',
            'nama_ortu' => 'required|string|max:255',
            'no_hp_ortu' => 'nullable|string|max:15',
        ]);
        
        $data = $request->all();
        
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($siswa->foto && file_exists(public_path('uploads/siswa/' . $siswa->foto))) {
                unlink(public_path('uploads/siswa/' . $siswa->foto));
            }
            
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/siswa'), $filename);
            $data['foto'] = $filename;
        }
        
        $siswa->update($data);
        
        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil diperbarui');
    }
    
    public function destroy($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();
        
        return redirect()->route('admin.siswa')->with('success', 'Data siswa berhasil dihapus');
    }
}