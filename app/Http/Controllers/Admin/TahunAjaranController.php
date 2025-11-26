<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahunAjaranController extends Controller
{
    public function index(Request $request)
    {
        $query = TahunAjaran::query();

        // Search functionality
        if ($request->filled('search')) {
            $query->where('tahun_ajaran', 'like', '%' . $request->search . '%');
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status == 'aktif' ? 1 : 0);
        }

        $tahunAjaran = $query->orderBy('tahun_ajaran', 'desc')
                           ->orderBy('semester', 'desc')
                           ->paginate(10);

        return view('admin.tahun-ajaran.index', compact('tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20|regex:/^\d{4}\/\d{4}$/',
            'semester' => 'required|in:ganjil,genap',
            'status_aktif' => 'boolean'
        ], [
            'tahun_ajaran.regex' => 'Format tahun ajaran harus YYYY/YYYY (contoh: 2024/2025)'
        ]);

        // Check for duplicate
        $exists = TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran)
                            ->where('semester', $request->semester)
                            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Tahun ajaran dan semester tersebut sudah ada')->withInput();
        }

        DB::beginTransaction();
        try {
            // If this is being set as active, deactivate all others
            if ($request->status_aktif) {
                TahunAjaran::where('status_aktif', true)->update(['status_aktif' => false]);
            }

            TahunAjaran::create([
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'status_aktif' => $request->status_aktif ?? false
            ]);

            DB::commit();
            return redirect()->route('admin.tahun-ajaran')->with('success', 'Tahun ajaran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menambahkan tahun ajaran: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $tahunAjaran = TahunAjaran::with(['pelanggaran', 'prestasi'])->findOrFail($id);
        
        return response()->json([
            'id' => $tahunAjaran->id,
            'tahun_ajaran' => $tahunAjaran->tahun_ajaran,
            'semester' => $tahunAjaran->semester,
            'status_aktif' => $tahunAjaran->status_aktif,
            'jumlah_pelanggaran' => $tahunAjaran->pelanggaran->count(),
            'jumlah_prestasi' => $tahunAjaran->prestasi->count(),
            'created_at' => $tahunAjaran->created_at->format('d M Y H:i'),
            'updated_at' => $tahunAjaran->updated_at->format('d M Y H:i')
        ]);
    }

    public function edit($id)
    {
        $tahunAjaran = TahunAjaran::findOrFail($id);
        return response()->json($tahunAjaran);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:20|regex:/^\d{4}\/\d{4}$/',
            'semester' => 'required|in:ganjil,genap',
            'status_aktif' => 'boolean'
        ], [
            'tahun_ajaran.regex' => 'Format tahun ajaran harus YYYY/YYYY (contoh: 2024/2025)'
        ]);

        // Check for duplicate (excluding current record)
        $exists = TahunAjaran::where('tahun_ajaran', $request->tahun_ajaran)
                            ->where('semester', $request->semester)
                            ->where('id', '!=', $id)
                            ->exists();
        
        if ($exists) {
            return redirect()->back()->with('error', 'Tahun ajaran dan semester tersebut sudah ada');
        }

        DB::beginTransaction();
        try {
            $tahunAjaran = TahunAjaran::findOrFail($id);

            // If this is being set as active, deactivate all others
            if ($request->status_aktif && !$tahunAjaran->status_aktif) {
                TahunAjaran::where('status_aktif', true)->update(['status_aktif' => false]);
            }

            $tahunAjaran->update([
                'tahun_ajaran' => $request->tahun_ajaran,
                'semester' => $request->semester,
                'status_aktif' => $request->status_aktif ?? false
            ]);

            DB::commit();
            return redirect()->route('admin.tahun-ajaran')->with('success', 'Tahun ajaran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal memperbarui tahun ajaran: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $tahunAjaran = TahunAjaran::findOrFail($id);
            
            // Check if this academic year has related data
            if ($tahunAjaran->pelanggaran()->count() > 0 || $tahunAjaran->prestasi()->count() > 0) {
                return redirect()->back()->with('error', 'Tidak dapat menghapus tahun ajaran yang memiliki data pelanggaran atau prestasi');
            }

            $tahunAjaran->delete();
            return redirect()->route('admin.tahun-ajaran')->with('success', 'Tahun ajaran berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus tahun ajaran: ' . $e->getMessage());
        }
    }

    public function setActive($id)
    {
        DB::beginTransaction();
        try {
            // Deactivate all academic years
            TahunAjaran::where('status_aktif', true)->update(['status_aktif' => false]);
            
            // Activate the selected one
            $tahunAjaran = TahunAjaran::findOrFail($id);
            $tahunAjaran->update(['status_aktif' => true]);

            DB::commit();
            return redirect()->route('admin.tahun-ajaran')->with('success', 'Tahun ajaran berhasil diaktifkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal mengaktifkan tahun ajaran: ' . $e->getMessage());
        }
    }
}