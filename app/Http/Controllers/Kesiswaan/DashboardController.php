<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Pelanggaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalPelanggaran = Pelanggaran::count();
        $siswaAktif = Siswa::where('status', 'aktif')->count();

        return view('kesiswaan.dashboard', compact(
            'totalSiswa',
            'totalKelas', 
            'totalPelanggaran',
            'siswaAktif'
        ));
    }
}