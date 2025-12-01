<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::with(['kelas', 'jurusan', 'pelanggaran.jenisPelanggaran', 'prestasi'])
            ->where('id', $user->siswa_id)
            ->firstOrFail();
        
        return view('siswa.profile', compact('siswa'));
    }
}