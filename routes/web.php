<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Kesiswaan\DashboardController as KesiswaanDashboard;
use App\Http\Controllers\Guru\DashboardController as GuruDashboard;
use App\Http\Controllers\GuruBK\DashboardController as GuruBKDashboard;
use App\Http\Controllers\WaliKelas\DashboardController as WaliKelasDashboard;
use App\Http\Controllers\Kepsek\DashboardController as KepsekDashboard;
use App\Http\Controllers\Kepsek\MonitoringController as KepsekMonitoring;
use App\Http\Controllers\Kepsek\LaporanController as KepsekLaporan;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboard;
use App\Http\Controllers\Ortu\DashboardController as OrtuDashboard;
use App\Http\Controllers\Konselor\DashboardController as KonselorDashboard;
use App\Http\Controllers\Konselor\BimbinganController as KonselorBimbingan;
use App\Http\Controllers\Konselor\SiswaController as KonselorSiswa;
use App\Http\Controllers\Konselor\LaporanController as KonselorLaporan;
use App\Http\Controllers\PelanggaranController;
use App\Http\Controllers\Admin\KategoriPelanggaranController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\JurusanController;

// Redirect root ke login
Route::get('/', function () {
    return redirect('/login');
});

// Routes untuk guest (belum login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

// Debug route
Route::get('/debug-user', function () {
    return view('debug-user');
});

Route::get('/debug/pelanggaran', function () {
    $data = [
        'total_pelanggaran' => \App\Models\Pelanggaran::count(),
        'total_siswa' => \App\Models\Siswa::count(),
        'total_kelas' => \App\Models\Kelas::count(),
        'total_jenis_pelanggaran' => \App\Models\JeniPelanggaran::count(),
        'pelanggaran_list' => \App\Models\Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran'])->get()->toArray(),
    ];
    return response()->json($data);
});

// Routes untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard per role dengan middleware
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');
        
        // Data Kelas - hanya admin
        Route::get('/admin/kelas', [KelasController::class, 'index'])->name('admin.kelas');
        Route::post('/admin/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
        Route::get('/admin/kelas/{id}', [KelasController::class, 'show'])->name('admin.kelas.show');
        Route::get('/admin/kelas/{id}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit');
        Route::put('/admin/kelas/{id}', [KelasController::class, 'update'])->name('admin.kelas.update');
        Route::delete('/admin/kelas/{id}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');
        
        // Data Jurusan - hanya admin
        Route::get('/admin/jurusan', [JurusanController::class, 'index'])->name('admin.jurusan');
        Route::post('/admin/jurusan', [JurusanController::class, 'store'])->name('admin.jurusan.store');
        Route::get('/admin/jurusan/{id}', [JurusanController::class, 'show'])->name('admin.jurusan.show');
        Route::get('/admin/jurusan/{id}/edit', [JurusanController::class, 'edit'])->name('admin.jurusan.edit');
        Route::put('/admin/jurusan/{id}', [JurusanController::class, 'update'])->name('admin.jurusan.update');
        Route::delete('/admin/jurusan/{id}', [JurusanController::class, 'destroy'])->name('admin.jurusan.destroy');
        
        // Data User - hanya admin
        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
    
    Route::middleware('role:kesiswaan')->group(function () {
        Route::get('/kesiswaan/dashboard', [KesiswaanDashboard::class, 'index'])->name('kesiswaan.dashboard');
        
        // Pelanggaran
        Route::get('/kesiswaan/pelanggaran', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'index'])->name('kesiswaan.pelanggaran');
        Route::post('/kesiswaan/pelanggaran', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'store'])->name('kesiswaan.pelanggaran.store');
        Route::get('/kesiswaan/pelanggaran/{id}', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'show'])->name('kesiswaan.pelanggaran.show');
        Route::get('/kesiswaan/pelanggaran/{id}/edit', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'edit'])->name('kesiswaan.pelanggaran.edit');
        Route::put('/kesiswaan/pelanggaran/{id}', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'update'])->name('kesiswaan.pelanggaran.update');
        Route::delete('/kesiswaan/pelanggaran/{id}', [\App\Http\Controllers\Kesiswaan\PelanggaranController::class, 'destroy'])->name('kesiswaan.pelanggaran.destroy');
        
        // Prestasi
        Route::get('/kesiswaan/prestasi', [\App\Http\Controllers\Kesiswaan\PrestasiController::class, 'index'])->name('kesiswaan.prestasi');
        Route::post('/kesiswaan/prestasi', [\App\Http\Controllers\Kesiswaan\PrestasiController::class, 'store'])->name('kesiswaan.prestasi.store');
        Route::get('/kesiswaan/prestasi/{id}', [\App\Http\Controllers\Kesiswaan\PrestasiController::class, 'show'])->name('kesiswaan.prestasi.show');
        Route::get('/kesiswaan/prestasi/{id}/edit', [\App\Http\Controllers\Kesiswaan\PrestasiController::class, 'edit'])->name('kesiswaan.prestasi.edit');
        Route::put('/kesiswaan/prestasi/{id}', [\App\Http\Controllers\Kesiswaan\PrestasiController::class, 'update'])->name('kesiswaan.prestasi.update');
        Route::delete('/kesiswaan/prestasi/{id}', [\App\Http\Controllers\Kesiswaan\PrestasiController::class, 'destroy'])->name('kesiswaan.prestasi.destroy');
        
        // Verifikasi
        Route::get('/kesiswaan/verifikasi', [\App\Http\Controllers\Kesiswaan\VerifikasiController::class, 'index'])->name('kesiswaan.verifikasi');
        Route::post('/kesiswaan/verifikasi/{id}', [\App\Http\Controllers\Kesiswaan\VerifikasiController::class, 'verifikasi'])->name('kesiswaan.verifikasi.submit');
        
        // Monitoring
        Route::get('/kesiswaan/monitoring', [\App\Http\Controllers\Kesiswaan\MonitoringController::class, 'index'])->name('kesiswaan.monitoring');
        Route::get('/kesiswaan/monitoring/{id}', [\App\Http\Controllers\Kesiswaan\MonitoringController::class, 'detail'])->name('kesiswaan.monitoring.detail');
        
        // Laporan
        Route::get('/kesiswaan/laporan', [\App\Http\Controllers\Kesiswaan\LaporanController::class, 'index'])->name('kesiswaan.laporan');
        Route::get('/kesiswaan/laporan/pdf', [\App\Http\Controllers\Kesiswaan\LaporanController::class, 'generatePDF'])->name('kesiswaan.laporan.pdf');
    });
    
    Route::middleware('role:guru')->group(function () {
        Route::get('/guru/dashboard', [GuruDashboard::class, 'index'])->name('guru.dashboard');
        
        // Pelanggaran
        Route::get('/guru/pelanggaran', [\App\Http\Controllers\Guru\PelanggaranController::class, 'index'])->name('guru.pelanggaran');
        Route::get('/guru/pelanggaran/create', [\App\Http\Controllers\Guru\PelanggaranController::class, 'create'])->name('guru.pelanggaran.create');
        Route::post('/guru/pelanggaran', [\App\Http\Controllers\Guru\PelanggaranController::class, 'store'])->name('guru.pelanggaran.store');
        Route::get('/guru/pelanggaran/{id}', [\App\Http\Controllers\Guru\PelanggaranController::class, 'show'])->name('guru.pelanggaran.show');
        
        // Siswa
        Route::get('/guru/siswa', [\App\Http\Controllers\Guru\SiswaController::class, 'index'])->name('guru.siswa');
        Route::get('/guru/siswa/{id}', [\App\Http\Controllers\Guru\SiswaController::class, 'show'])->name('guru.siswa.show');
    });
    
    Route::middleware('role:konselor')->group(function () {
        Route::get('/konselor/dashboard', [KonselorDashboard::class, 'index'])->name('konselor.dashboard');
        
        // Bimbingan
        Route::get('/konselor/bimbingan', [KonselorBimbingan::class, 'index'])->name('konselor.bimbingan.index');
        Route::get('/konselor/bimbingan/create', [KonselorBimbingan::class, 'create'])->name('konselor.bimbingan.create');
        Route::post('/konselor/bimbingan', [KonselorBimbingan::class, 'store'])->name('konselor.bimbingan.store');
        Route::get('/konselor/bimbingan/{bimbingan}', [KonselorBimbingan::class, 'show'])->name('konselor.bimbingan.show');
        Route::get('/konselor/bimbingan/{bimbingan}/edit', [KonselorBimbingan::class, 'edit'])->name('konselor.bimbingan.edit');
        Route::put('/konselor/bimbingan/{bimbingan}', [KonselorBimbingan::class, 'update'])->name('konselor.bimbingan.update');
        Route::delete('/konselor/bimbingan/{bimbingan}', [KonselorBimbingan::class, 'destroy'])->name('konselor.bimbingan.destroy');
        
        // Siswa
        Route::get('/konselor/siswa', [KonselorSiswa::class, 'index'])->name('konselor.siswa.index');
        Route::get('/konselor/siswa/{siswa}', [KonselorSiswa::class, 'show'])->name('konselor.siswa.show');
        
        // Laporan
        Route::get('/konselor/laporan', [KonselorLaporan::class, 'index'])->name('konselor.laporan.index');
        Route::get('/konselor/laporan/export-excel', [KonselorLaporan::class, 'exportExcel'])->name('konselor.laporan.export-excel');
        Route::get('/konselor/laporan/export-pdf', [KonselorLaporan::class, 'exportPdf'])->name('konselor.laporan.export-pdf');
    });
    
    Route::middleware('role:wali_kelas')->group(function () {
        Route::get('/walikelas/dashboard', [WaliKelasDashboard::class, 'index'])->name('walikelas.dashboard');
        
        // Pelanggaran - wali kelas bisa input dan view data sendiri
        Route::get('/walikelas/pelanggaran', [\App\Http\Controllers\WaliKelas\PelanggaranController::class, 'index'])->name('walikelas.pelanggaran');
        Route::get('/walikelas/pelanggaran/create', [\App\Http\Controllers\WaliKelas\PelanggaranController::class, 'create'])->name('walikelas.pelanggaran.create');
        Route::post('/walikelas/pelanggaran', [\App\Http\Controllers\WaliKelas\PelanggaranController::class, 'store'])->name('walikelas.pelanggaran.store');
        Route::get('/walikelas/pelanggaran/{id}', [\App\Http\Controllers\WaliKelas\PelanggaranController::class, 'show'])->name('walikelas.pelanggaran.show');
        
        // Monitoring Sanksi
        Route::get('/walikelas/sanksi', [\App\Http\Controllers\WaliKelas\SanksiController::class, 'index'])->name('walikelas.sanksi');
        
        // Export Laporan - sesuai privilege PDF
        Route::get('/walikelas/laporan', [\App\Http\Controllers\WaliKelas\LaporanController::class, 'index'])->name('walikelas.laporan');
        Route::get('/walikelas/laporan/pdf', [\App\Http\Controllers\WaliKelas\LaporanController::class, 'exportPdf'])->name('walikelas.laporan.pdf');
    });
    
    Route::middleware('role:kepala_sekolah')->group(function () {
        Route::get('/kepsek/dashboard', [KepsekDashboard::class, 'index'])->name('kepsek.dashboard');
        
        // Monitoring
        Route::get('/kepsek/monitoring', [KepsekMonitoring::class, 'index'])->name('kepsek.monitoring');
        Route::get('/kepsek/monitoring/{id}', [KepsekMonitoring::class, 'show'])->name('kepsek.monitoring.show');
        Route::put('/kepsek/monitoring/{id}', [KepsekMonitoring::class, 'update'])->name('kepsek.monitoring.update');
        
        // Laporan
        Route::get('/kepsek/laporan', [KepsekLaporan::class, 'index'])->name('kepsek.laporan');
        Route::get('/kepsek/laporan/export-excel', [KepsekLaporan::class, 'exportExcel'])->name('kepsek.laporan.export-excel');
        Route::get('/kepsek/laporan/export-pdf', [KepsekLaporan::class, 'exportPdf'])->name('kepsek.laporan.export-pdf');
    });
    
    Route::middleware('role:siswa')->group(function () {
        Route::get('/siswa/dashboard', [SiswaDashboard::class, 'index'])->name('siswa.dashboard');
        Route::get('/siswa/profile', [SiswaDashboard::class, 'profile'])->name('siswa.profile');
        Route::get('/siswa/pelanggaran', [SiswaDashboard::class, 'pelanggaran'])->name('siswa.pelanggaran');
        Route::get('/siswa/prestasi', [SiswaDashboard::class, 'prestasi'])->name('siswa.prestasi');
        
        // Laporan
        Route::get('/siswa/laporan', [\App\Http\Controllers\Siswa\LaporanController::class, 'index'])->name('siswa.laporan');
        Route::get('/siswa/laporan/pdf', [\App\Http\Controllers\Siswa\LaporanController::class, 'generatePDF'])->name('siswa.laporan.pdf');
    });
    
    Route::middleware('role:orang_tua')->group(function () {
        Route::get('/ortu/dashboard', [OrtuDashboard::class, 'index'])->name('ortu.dashboard');
        Route::get('/ortu/pelanggaran', [OrtuDashboard::class, 'pelanggaran'])->name('ortu.pelanggaran');
        Route::get('/ortu/prestasi', [OrtuDashboard::class, 'prestasi'])->name('ortu.prestasi');
        Route::get('/ortu/profil', [OrtuDashboard::class, 'profil'])->name('ortu.profil');
        
        // Laporan
        Route::get('/ortu/laporan', [\App\Http\Controllers\Ortu\LaporanController::class, 'index'])->name('ortu.laporan');
        Route::get('/ortu/laporan/pdf', [\App\Http\Controllers\Ortu\LaporanController::class, 'generatePDF'])->name('ortu.laporan.pdf');
    });
    
    // Data Pelanggaran - accessible by admin, kesiswaan, konselor
    Route::middleware('role:admin,kesiswaan,konselor')->group(function () {
        Route::get('/admin/pelanggaran', [PelanggaranController::class, 'index'])->name('admin.pelanggaran');
        Route::post('/admin/pelanggaran', [PelanggaranController::class, 'store'])->name('admin.pelanggaran.store');
        Route::get('/admin/pelanggaran/{id}', [PelanggaranController::class, 'show'])->name('admin.pelanggaran.show');
        Route::get('/admin/pelanggaran/{id}/edit', [PelanggaranController::class, 'edit'])->name('admin.pelanggaran.edit');
        Route::put('/admin/pelanggaran/{id}', [PelanggaranController::class, 'update'])->name('admin.pelanggaran.update');
        Route::delete('/admin/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])->name('admin.pelanggaran.destroy');
        Route::get('/admin/kategori-pelanggaran', [KategoriPelanggaranController::class, 'index'])->name('admin.kategori-pelanggaran');
        Route::post('/admin/kategori-pelanggaran', [KategoriPelanggaranController::class, 'store'])->name('admin.kategori-pelanggaran.store');
        Route::get('/admin/kategori-pelanggaran/{id}', [KategoriPelanggaranController::class, 'show'])->name('admin.kategori-pelanggaran.show');
        Route::get('/admin/kategori-pelanggaran/{id}/edit', [KategoriPelanggaranController::class, 'edit'])->name('admin.kategori-pelanggaran.edit');
        Route::put('/admin/kategori-pelanggaran/{id}', [KategoriPelanggaranController::class, 'update'])->name('admin.kategori-pelanggaran.update');
        Route::delete('/admin/kategori-pelanggaran/{id}', [KategoriPelanggaranController::class, 'destroy'])->name('admin.kategori-pelanggaran.destroy');
    });
    
    // Data Prestasi
    Route::get('/admin/prestasi', [\App\Http\Controllers\Admin\PrestasiController::class, 'index'])->name('admin.prestasi');
    Route::post('/admin/prestasi', [\App\Http\Controllers\Admin\PrestasiController::class, 'store'])->name('admin.prestasi.store');
    Route::get('/admin/prestasi/{id}', [\App\Http\Controllers\Admin\PrestasiController::class, 'show'])->name('admin.prestasi.show');
    Route::get('/admin/prestasi/{id}/edit', [\App\Http\Controllers\Admin\PrestasiController::class, 'edit'])->name('admin.prestasi.edit');
    Route::put('/admin/prestasi/{id}', [\App\Http\Controllers\Admin\PrestasiController::class, 'update'])->name('admin.prestasi.update');
    Route::delete('/admin/prestasi/{id}', [\App\Http\Controllers\Admin\PrestasiController::class, 'destroy'])->name('admin.prestasi.destroy');
    
    // Data Guru
    Route::get('/admin/guru', [GuruController::class, 'index'])->name('admin.guru');
    Route::post('/admin/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::get('/admin/guru/{id}', [GuruController::class, 'show'])->name('admin.guru.show');
    Route::get('/admin/guru/{id}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    Route::put('/admin/guru/{id}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('/admin/guru/{id}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');
    
    // Data Siswa
    Route::get('/admin/siswa', [SiswaController::class, 'index'])->name('admin.siswa');
    Route::post('/admin/siswa', [SiswaController::class, 'store'])->name('admin.siswa.store');
    Route::get('/admin/siswa/{id}', [SiswaController::class, 'show'])->name('admin.siswa.show');
    Route::get('/admin/siswa/{id}/edit', [SiswaController::class, 'edit'])->name('admin.siswa.edit');
    Route::put('/admin/siswa/{id}', [SiswaController::class, 'update'])->name('admin.siswa.update');
    Route::delete('/admin/siswa/{id}', [SiswaController::class, 'destroy'])->name('admin.siswa.destroy');
    

    
    // Data Sanksi
    Route::get('/admin/sanksi', [\App\Http\Controllers\Admin\SanksiController::class, 'index'])->name('admin.sanksi');
    Route::post('/admin/sanksi', [\App\Http\Controllers\Admin\SanksiController::class, 'store'])->name('admin.sanksi.store');
    Route::get('/admin/sanksi/{id}', [\App\Http\Controllers\Admin\SanksiController::class, 'show'])->name('admin.sanksi.show');
    Route::get('/admin/sanksi/{id}/edit', [\App\Http\Controllers\Admin\SanksiController::class, 'edit'])->name('admin.sanksi.edit');
    Route::put('/admin/sanksi/{id}', [\App\Http\Controllers\Admin\SanksiController::class, 'update'])->name('admin.sanksi.update');
    Route::delete('/admin/sanksi/{id}', [\App\Http\Controllers\Admin\SanksiController::class, 'destroy'])->name('admin.sanksi.destroy');
    
    // Data Tahun Ajaran
    Route::get('/admin/tahun-ajaran', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'index'])->name('admin.tahun-ajaran');
    Route::post('/admin/tahun-ajaran', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'store'])->name('admin.tahun-ajaran.store');
    Route::get('/admin/tahun-ajaran/{id}', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'show'])->name('admin.tahun-ajaran.show');
    Route::get('/admin/tahun-ajaran/{id}/edit', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'edit'])->name('admin.tahun-ajaran.edit');
    Route::put('/admin/tahun-ajaran/{id}', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'update'])->name('admin.tahun-ajaran.update');
    Route::delete('/admin/tahun-ajaran/{id}', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'destroy'])->name('admin.tahun-ajaran.destroy');
    Route::patch('/admin/tahun-ajaran/{id}/set-active', [\App\Http\Controllers\Admin\TahunAjaranController::class, 'setActive'])->name('admin.tahun-ajaran.set-active');
    
    // Laporan
    Route::get('/admin/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('admin.laporan');
    Route::get('/admin/laporan/pelanggaran', [\App\Http\Controllers\Admin\LaporanController::class, 'pelanggaran'])->name('admin.laporan.pelanggaran');
    Route::get('/admin/laporan/prestasi', [\App\Http\Controllers\Admin\LaporanController::class, 'prestasi'])->name('admin.laporan.prestasi');
    Route::get('/admin/laporan/siswa/{id}', [\App\Http\Controllers\Admin\LaporanController::class, 'siswa'])->name('admin.laporan.siswa');
    Route::get('/admin/laporan/rekap-bulanan', [\App\Http\Controllers\Admin\LaporanController::class, 'rekapBulanan'])->name('admin.laporan.rekap-bulanan');
    Route::get('/admin/laporan/grafik-data', [\App\Http\Controllers\Admin\LaporanController::class, 'grafikData'])->name('admin.laporan.grafik-data');
    Route::get('/admin/laporan/export-prestasi-excel', [\App\Http\Controllers\Admin\LaporanController::class, 'exportPrestasiExcel'])->name('admin.laporan.export-prestasi-excel');
    
    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications/unread', [\App\Http\Controllers\NotificationController::class, 'getUnread'])->name('notifications.unread');
    
    // CSRF Token refresh
    Route::get('/csrf-token', function() {
        return response()->json(['token' => csrf_token()]);
    })->name('csrf.token');
});