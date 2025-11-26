<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran', 'prestasi'])
            ->orderBy('nama_siswa')
            ->paginate(20);
        
        return view('guru.siswa.index', compact('siswa'));
    }

    public function show($id)
    {
        $siswa = Siswa::with(['kelas', 'pelanggaran.jenisPelanggaran', 'prestasi.jenisPrestasi'])
            ->findOrFail($id);
        
        return view('guru.siswa.show', compact('siswa'));
    }
}
