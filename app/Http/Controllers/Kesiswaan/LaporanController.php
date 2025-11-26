<?php

namespace App\Http\Controllers\Kesiswaan;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();
        return view('kesiswaan.laporan.index', compact('kelas'));
    }

    public function generatePDF(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'createdBy']);
        
        if ($request->kelas_id) {
            $query->whereHas('siswa', function($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            });
        }
        
        if ($request->tanggal_dari && $request->tanggal_sampai) {
            $query->whereBetween('created_at', [$request->tanggal_dari, $request->tanggal_sampai]);
        }
        
        $pelanggarans = $query->orderBy('created_at', 'desc')->get();
        
        $pdf = Pdf::loadView('kesiswaan.laporan.pdf', [
            'pelanggarans' => $pelanggarans,
            'filter' => $request->all()
        ]);
        
        return $pdf->download('laporan-pelanggaran-kesiswaan.pdf');
    }
}
