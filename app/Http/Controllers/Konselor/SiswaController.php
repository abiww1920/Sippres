<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use App\Models\Siswa;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = Siswa::with('kelas', 'jurusan')->paginate(10);
        return view('konselor.siswa.index', ['siswa' => $siswa]);
    }

    public function show(Siswa $siswa)
    {
        $siswa->load('kelas', 'jurusan', 'bimbinganKonseling');
        return view('konselor.siswa.show', ['siswa' => $siswa]);
    }
}
