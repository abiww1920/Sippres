<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    public function index()
    {
        // Hanya tampilkan bimbingan yang dibuat oleh konselor ini
        $bimbingan = BimbinganKonseling::with('siswa.kelas')
            ->where('created_by', auth()->id())
            ->latest()->paginate(10);
        return view('konselor.bimbingan.index', ['bimbingan' => $bimbingan]);
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')->get();
        return view('konselor.bimbingan.create', ['siswa' => $siswa]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'topik' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'deskripsi' => 'required|string',
            'status' => 'required|in:terjadwal,proses,selesai',
        ]);

        $validated['created_by'] = auth()->id();
        BimbinganKonseling::create($validated);
        return redirect()->route('konselor.bimbingan.index')->with('success', 'Bimbingan berhasil ditambahkan');
    }

    public function show(BimbinganKonseling $bimbingan)
    {
        return view('konselor.bimbingan.show', ['bimbingan' => $bimbingan]);
    }

    public function edit(BimbinganKonseling $bimbingan)
    {
        $siswa = Siswa::with('kelas')->get();
        return view('konselor.bimbingan.edit', ['bimbingan' => $bimbingan, 'siswa' => $siswa]);
    }

    public function update(Request $request, BimbinganKonseling $bimbingan)
    {
        $validated = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'topik' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'deskripsi' => 'required|string',
            'status' => 'required|in:terjadwal,proses,selesai',
        ]);

        $bimbingan->update($validated);
        return redirect()->route('konselor.bimbingan.index')->with('success', 'Bimbingan berhasil diperbarui');
    }

    public function destroy(BimbinganKonseling $bimbingan)
    {
        $bimbingan->delete();
        return redirect()->route('konselor.bimbingan.index')->with('success', 'Bimbingan berhasil dihapus');
    }
}
