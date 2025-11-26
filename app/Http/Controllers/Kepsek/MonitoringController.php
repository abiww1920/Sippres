<?php

namespace App\Http\Controllers\Kepsek;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran']);

        if ($request->status) {
            $query->where('status_verifikasi', $request->status);
        }

        if ($request->kelas_id) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }

        if ($request->search) {
            $query->whereHas('siswa', function ($q) use ($request) {
                $q->where('nama_siswa', 'like', '%' . $request->search . '%')
                  ->orWhere('nis', 'like', '%' . $request->search . '%');
            });
        }

        $pelanggaranList = $query->latest()->paginate(15)->appends($request->all());
        $kelas = Kelas::all();

        return view('kepsek.monitoring', [
            'pelanggaranList' => $pelanggaranList,
            'kelas' => $kelas,
        ]);
    }

    public function show($id)
    {
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])->findOrFail($id);
        
        return view('kepsek.monitoring-detail', [
            'pelanggaran' => $pelanggaran,
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json(['message' => 'Monitoring berhasil diperbarui']);
    }
}
