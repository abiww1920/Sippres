<?php

namespace App\Http\Controllers\Konselor;

use App\Http\Controllers\Controller;
use App\Models\BimbinganKonseling;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Hanya laporan bimbingan yang dibuat oleh konselor ini
        $query = BimbinganKonseling::with('siswa.kelas')
            ->where('created_by', auth()->id());

        if ($request->bulan) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporan = $query->latest('tanggal')->paginate(10);
        return view('konselor.laporan.index', ['laporan' => $laporan]);
    }

    public function exportExcel(Request $request)
    {
        // Hanya export data bimbingan yang dibuat oleh konselor ini
        $query = BimbinganKonseling::with('siswa.kelas')
            ->where('created_by', auth()->id());

        if ($request->bulan) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporan = $query->latest('tanggal')->get();
        
        return response()->json([
            'message' => 'Export Excel akan diimplementasikan dengan library Excel',
            'data' => $laporan
        ]);
    }

    public function exportPdf(Request $request)
    {
        $query = BimbinganKonseling::with('siswa.kelas')
            ->where('created_by', auth()->id());

        if ($request->bulan) {
            $query->whereMonth('tanggal', date('m', strtotime($request->bulan)))
                  ->whereYear('tanggal', date('Y', strtotime($request->bulan)));
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $laporan = $query->latest('tanggal')->get();
        
        $pdf = Pdf::loadView('konselor.laporan.pdf', [
            'laporan' => $laporan,
            'filter' => $request->all()
        ]);
        
        return $pdf->download('laporan-bimbingan-konseling.pdf');
    }
}
