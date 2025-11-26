<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use App\Models\Siswa;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $konselorId = auth()->id();
        
        // Hanya data bimbingan yang dibuat oleh konselor ini
        $totalBimbingan = BimbinganKonseling::where('created_by', $konselorId)->count();
        $bimbinganBulanIni = BimbinganKonseling::where('created_by', $konselorId)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
        $bimbinganSelesai = BimbinganKonseling::where('created_by', $konselorId)
            ->where('status', 'selesai')->count();
        $bimbinganTerbaru = BimbinganKonseling::where('created_by', $konselorId)
            ->latest('tanggal')->take(5)->get();
        
        // Siswa yang pernah dibimbing oleh konselor ini
        $totalSiswa = BimbinganKonseling::where('created_by', $konselorId)
            ->distinct('siswa_id')->count();

        return view('konselor.dashboard', [
            'totalSiswa' => $totalSiswa,
            'totalBimbingan' => $totalBimbingan,
            'bimbinganBulanIni' => $bimbinganBulanIni,
            'bimbinganSelesai' => $bimbinganSelesai,
            'bimbinganTerbaru' => $bimbinganTerbaru,
        ]);
    }
}
