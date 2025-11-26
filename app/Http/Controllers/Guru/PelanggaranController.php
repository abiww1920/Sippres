<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JeniPelanggaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PelanggaranController extends Controller
{
    public function index()
    {
        $pelanggarans = Pelanggaran::where('guru_pencatat', auth()->user()->guru_id)
            ->with(['siswa.kelas', 'jenisPelanggaran'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('guru.pelanggaran.index', compact('pelanggarans'));
    }

    public function create()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama_siswa')->get();
        $jenisPelanggaran = JeniPelanggaran::orderBy('kategori')->orderBy('nama_pelanggaran')->get();
        
        return view('guru.pelanggaran.create', compact('siswa', 'jenisPelanggaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'deskripsi' => 'required|string',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Check if user has guru_id
        if (!auth()->user()->guru_id) {
            return redirect()->back()->with('error', 'Akun Anda belum terhubung dengan data guru. Hubungi admin.');
        }

        $jenisPelanggaran = JeniPelanggaran::findOrFail($request->jenis_pelanggaran_id);
        $tahunAjaran = TahunAjaran::where('status_aktif', 1)->first();

        if (!$tahunAjaran) {
            return redirect()->back()->with('error', 'Tidak ada tahun ajaran aktif. Hubungi admin.');
        }

        $data = [
            'siswa_id' => $request->siswa_id,
            'jenis_pelanggaran_id' => $request->jenis_pelanggaran_id,
            'poin' => $jenisPelanggaran->poin,
            'keterangan' => $request->deskripsi,
            'guru_pencatat' => auth()->user()->guru_id,
            'tahun_ajaran_id' => $tahunAjaran->id,
            'created_by' => auth()->id()
        ];

        if ($request->hasFile('foto_bukti')) {
            $file = $request->file('foto_bukti');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/pelanggaran'), $filename);
            $data['foto_bukti'] = $filename;
        }

        Pelanggaran::create($data);

        return redirect()->route('guru.pelanggaran')->with('success', 'Pelanggaran berhasil dicatat');
    }

    public function show($id)
    {
        $pelanggaran = Pelanggaran::where('guru_pencatat', auth()->user()->guru_id)
            ->with(['siswa.kelas', 'jenisPelanggaran', 'sanksi'])
            ->findOrFail($id);
        
        return view('guru.pelanggaran.show', compact('pelanggaran'));
    }
}
