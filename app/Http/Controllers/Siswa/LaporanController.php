<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Pelanggaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $siswa = Siswa::find($user->siswa_id);
        
        if (!$siswa) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan');
        }
        
        return view('siswa.laporan.index', compact('siswa'));
    }

    public function generatePDF()
    {
        $user = Auth::user();
        $siswa = Siswa::find($user->siswa_id);
        
        if (!$siswa) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data siswa tidak ditemukan');
        }
        
        $pelanggarans = Pelanggaran::with(['jenisPelanggaran', 'createdBy'])
            ->where('siswa_id', $siswa->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $totalPoin = $pelanggarans->sum('poin');
        
        $statusSanksi = $this->getStatusSanksi($totalPoin);
        
        $pdf = Pdf::loadView('siswa.laporan.pdf', [
            'siswa' => $siswa,
            'pelanggarans' => $pelanggarans,
            'totalPoin' => $totalPoin,
            'statusSanksi' => $statusSanksi
        ]);
        
        return $pdf->download('laporan-pelanggaran-saya.pdf');
    }

    private function getStatusSanksi($totalPoin)
    {
        if ($totalPoin >= 51) {
            return ['status' => 'Sangat Berat', 'sanksi' => 'Kemungkinan DO'];
        } elseif ($totalPoin >= 31) {
            return ['status' => 'Berat', 'sanksi' => 'Skorsing, dll'];
        } elseif ($totalPoin >= 16) {
            return ['status' => 'Sedang', 'sanksi' => 'Kerja sosial, dll'];
        } elseif ($totalPoin >= 1) {
            return ['status' => 'Ringan', 'sanksi' => 'Teguran, dll'];
        }
        return ['status' => 'Tidak Ada', 'sanksi' => '-'];
    }
}
