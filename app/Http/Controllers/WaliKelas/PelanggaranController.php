<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\JeniPelanggaran;
use App\Models\Guru;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PelanggaranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user->guru_id) {
            return redirect()->route('login')->with('error', 'Akun Anda belum terhubung dengan data guru. Hubungi admin.');
        }
        
        $guru = Guru::find($user->guru_id);
        
        // Ambil kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        // Ambil pelanggaran siswa di kelas yang diampu
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->whereHas('siswa', function($query) use ($kelasIds) {
                $query->whereIn('kelas_id', $kelasIds);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('wali_kelas.pelanggaran.index', compact('pelanggaran', 'kelasWali'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if (!$user->guru_id) {
            return redirect()->back()->with('error', 'Akun Anda belum terhubung dengan data guru. Hubungi admin.');
        }
        
        $guru = Guru::find($user->guru_id);
        
        // Ambil kelas yang diampu sebagai wali kelas
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->get();
        $kelasIds = $kelasWali->pluck('id');
        
        // Ambil siswa di kelas yang diampu
        $siswa = Siswa::with('kelas')->whereIn('kelas_id', $kelasIds)->get();
        $jenisPelanggaran = JeniPelanggaran::all();
        
        return view('wali_kelas.pelanggaran.create', compact('siswa', 'jenisPelanggaran', 'kelasWali'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'jenis_pelanggaran_id' => 'required|exists:jenis_pelanggaran,id',
            'tanggal_pelanggaran' => 'required|date',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $user = Auth::user();
        
        if (!$user->guru_id) {
            return redirect()->back()->with('error', 'Akun Anda belum terhubung dengan data guru. Hubungi admin.');
        }
        
        $guru = Guru::find($user->guru_id);
        
        // Validasi siswa ada di kelas yang diampu
        $siswa = Siswa::find($request->siswa_id);
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->pluck('id');
        
        if (!$kelasWali->contains($siswa->kelas_id)) {
            return redirect()->back()->with('error', 'Anda hanya dapat menginput pelanggaran untuk siswa di kelas yang Anda ampu');
        }

        $data = $request->all();
        $data['guru_pencatat'] = $guru->id;
        $data['created_by'] = $user->id;
        $data['status_verifikasi'] = 'menunggu';

        // Handle foto upload
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $filename = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('uploads/pelanggaran'), $filename);
            $data['foto'] = $filename;
        }

        Pelanggaran::create($data);

        return redirect()->route('walikelas.pelanggaran')->with('success', 'Data pelanggaran berhasil ditambahkan');
    }

    public function show($id)
    {
        $user = Auth::user();
        
        if (!$user->guru_id) {
            return redirect()->back()->with('error', 'Akun Anda belum terhubung dengan data guru. Hubungi admin.');
        }
        
        $guru = Guru::find($user->guru_id);
        
        $pelanggaran = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'guruPencatat'])
            ->findOrFail($id);
        
        // Validasi pelanggaran ada di kelas yang diampu
        $kelasWali = Kelas::where('wali_kelas_id', $guru->id)->pluck('id');
        
        if (!$kelasWali->contains($pelanggaran->siswa->kelas_id)) {
            return redirect()->route('walikelas.pelanggaran')->with('error', 'Anda tidak memiliki akses ke data ini');
        }
        
        return view('wali_kelas.pelanggaran.show', compact('pelanggaran'));
    }
}