<?php

use Illuminate\Support\Facades\Route;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\JeniPelanggaran;

Route::get('/debug/pelanggaran', function () {
    $data = [
        'total_pelanggaran' => Pelanggaran::count(),
        'total_siswa' => Siswa::count(),
        'total_kelas' => Kelas::count(),
        'total_jenis_pelanggaran' => JeniPelanggaran::count(),
        'pelanggaran_list' => Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->get(),
    ];
    
    return response()->json($data);
});
